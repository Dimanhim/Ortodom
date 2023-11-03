<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace app\controllers;

use app\models\Config;
use app\models\JournalSearch;
use app\models\OrderStatusDate;
use app\models\User;
use app\modules\directory\models\ShoesBrand;
use Yii;
use app\models\Order;
use app\models\OrderSearch;
use app\models\PrintTypes;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function beforeAction($action)
    {
        if(User::disabledAccess($action->controller->id)) {
            throw new HttpException(403, 'У Вас недостаточно прав для посещения данной страницы');
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Order models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Prints Order document.
     *
     * @param int $id
     * @param int $type
     *
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionPrint($id, $data, $new = false)
    {
        $model = $this->findModel($id);
        $viewName = null;
        $data = json_decode($data);
        $view = '';
        $i = 0;
        foreach($data->type as $type) {
            $i++;
            switch ($type) {
                case PrintTypes::RECEIPT:
                    $viewName = 'print/receipt';
                    break;
                case PrintTypes::FORM:
                    $viewName = 'print/form';
                    break;
                case PrintTypes::CASH_RECEIPT_ORDER:
                    $viewName = 'print/cash_receipt_order';
                    break;
                case PrintTypes::WARRANTY_CARD:
                    $viewName = 'print/warranty_card';
                    break;
                case PrintTypes::ACT:
                    $viewName = 'print/act';
                    break;
                case PrintTypes::ACT_LO:
                    $viewName = 'print/act_lo';
                    break;
                case PrintTypes::ACT_LO_2023:
                    $viewName = 'print/act_lo_2023';
                    break;
                case PrintTypes::SALES_RECEIPT:
                    $viewName = 'print/sales_receipt';
                    break;
                case PrintTypes::CONTRACT:
                    $viewName = 'print/contract';
                    break;
                case PrintTypes::CONTRACT_LO:
                    $viewName = 'print/contract_lo';
                    break;
                case PrintTypes::WARRANTY_KSP:
                    $viewName = 'print/warranty_ksp';
                    break;
                case PrintTypes::BARCODES:
                    $viewName = '_barcode_template';
                    break;
            }
            if (!is_null($viewName)) {
                $view .= $this->renderPartial($viewName, ['model' => $model, 'new' => true]);
                $view .= ($i == count($data->type)) ? '' : '<div style="page-break-after: always;"></div>';
            }

        }
        if($view) return $view;
        throw new BadRequestHttpException();
    }

    /**
     * @param $data
     * @return string
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionPrintBarcode($data)
    {
        $data = json_decode($data);
        if($data) {
            $view = '';
            foreach($data->ids as $id) {
                $model = $this->findModel($id);
                $view .= $this->renderPartial('print/_barcode_template', ['model' => $model]);
                $view .= '<div style="margin-top: 20px"></div>';
            }
        }
        if($view) return $view;
        throw new BadRequestHttpException();
    }

    public function actionPrintBarcodesToOrder($id, $count)
    {
        $model = $this->findModel($id);
        $view = '';
        for($i = 0; $i < $count; $i++) {
            $view .= $this->renderPartial('print/_barcode_template', ['model' => $model]);
            $view .= '<div style="margin-top: 20px"></div>';
        }
        if($view) return $view;
        throw new BadRequestHttpException();
    }
    public function actionPrintOrderToSend($data)
    {
        $data = json_decode($data);
        $totalCount = 0;
        if($data) {
            $view = '';
            foreach($data->ids as $id) {
                $qty = 1;
                $model = $this->findModel($id);
                $view .= $this->renderPartial('print/_orders_to_send', ['model' => $model]);
                $view .= '<div style="margin-top: 20px"></div>';
                $totalCount += $qty;
            }
        }
        if($view) {
            $view .= 'Итого: '.$totalCount;
            return $view;
        }
        throw new BadRequestHttpException();
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param $patient_id int|null
     *
     * @return mixed
     */
    public function actionCreate($patient_id = null, $config_id = null)
    {
        $model = new Order(['patient_id' => $patient_id]);
        $model->status_id = 1;

        if($config_id && ($config = Config::findOne($config_id))) {
            $model->attributes = $config->attributes;
            $model->color = null;
            $model->color_id = $config->color;
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->status_date = time();
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $status = $model->status_id;
        $prepaid = $model->prepaid;
        $sms_yandex_review = $model->sms_yandex_review;

        if ($model->load(Yii::$app->request->post()) && $model->yandexSmsRequired()) {
            if($status != $model->status_id) {
                $model->status_date = time();
                $model->updateStatus;
            }
            if($prepaid != $model->prepaid) {
                $model->prepaid_date = time();
            }
            if($sms_yandex_review != $model->sms_yandex_review && $model->sms_yandex_datetime == Order::YANDEX_REVIEW_SMS_SEND_YES) {
                $model->sms_yandex_datetime = time();
            }
            $model->changeStatus;
            $model->save();
            $model->uploadScan();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDeleteScan($id)
    {
        $model = $this->findModel($id);
        $fileName = $model->scan;
        $model->scan = null;
        if($model->update(false)) {
            unlink('images/scan/'.$fileName);
            return true;
        }
        return false;
    }
    public function actionChangeStatusColor($id)
    {
        return Order::statusStylesArray()[$id];
    }

    public function actionChangeStatusPacket($json)
    {
        if($json && Yii::$app->request->isAjax) {
            $data = json_decode($json);
            foreach($data->ids as $id) {
                if($order = Order::findOne($id)) {
                    $oldStatus = $order->status_id;
                    $order->status_id = $data->status;
                    $order->status_date = time();
                    if($oldStatus != $order->status_id) {
                        $order->measureStatusSms();
                    }
                    $order->changeStatus;
                    $order->save();
                }
            }
            Order::updatePacketStatus($data->ids);
            //$order->updatePacketStatus($data->ids);
            return true;
        }
        return false;
    }
    public function actionChangeColorPacket($json)
    {
        if($json && Yii::$app->request->isAjax) {
            $data = json_decode($json);
            foreach($data->ids as $id) {
                if($order = Order::findOne($id)) {
                    $order->color_id = $data->color;
                    $order->update(false);
                }
            }
            return true;
        }
        return false;
    }
    public function actionPrintOutfit()
    {
        $this->layout = 'empty';
        $model = new JournalSearch();
        $searchModel = $model->searchModel(Yii::$app->request->get());

        if(count($searchModel)) {
            $viewId = JournalSearch::TYPE_OUTFIT_FULL;
            switch (Yii::$app->request->get('JournalSearch')['status_id']) {
                case 2 : $viewId = JournalSearch::TYPE_STATUS_READY;
                    break;
                case 9 : $viewId = JournalSearch::TYPE_STATUS_PUFF;
                    break;
                case 7 : $viewId = JournalSearch::TYPE_STATUS_CUT;
                    break;
                case 10 : $viewId = JournalSearch::TYPE_STATUS_PRODUCTION;
                    break;
            }
            $viewPath = $model->outfits[$viewId]['view_template'];
            return $this->render($viewPath, [
                'orders' => $searchModel,
            ]);
        }

        /*if($orders = Order::findAll(['status_id' => $status_id])) {
            $viewId = JournalSearch::TYPE_OUTFIT_FULL;
            switch ($status_id) {
                case 2 : $viewId = JournalSearch::TYPE_STATUS_READY;
                    break;
                case 9 : $viewId = JournalSearch::TYPE_STATUS_PUFF;
                    break;
                case 7 : $viewId = JournalSearch::TYPE_STATUS_CUT;
                    break;
            }
            $viewPath = $model->outfits[$viewId]['view_template'];
            return $this->render($viewPath, [
                'orders' => $orders,
            ]);
        }*/
        Yii::$app->session->setFlash('error', 'Заказов в выбранном статусе не найдено');
        return $this->redirect(Yii::$app->request->referrer);
    }
    /*public function actionPrintOutfit($json)
    {
        $this->layout = 'empty';
        $data = json_decode($json);
        $model = new JournalSearch();
        if($data->type && ($orders = Order::find()->where(['in', 'id', $data->ids])->all())) {
            $viewPath = $model->outfits[$data->type]['view_template'];
            return $this->render($viewPath, [
                'orders' => $orders,
            ]);
        }
        Yii::$app->session->setFlash('Произошла ошибка');
        return $this->redirect(['index']);
    }*/
    public function actionViewModal($data)
    {
        $ids = [];
        if($data = json_decode($data)) {
            foreach ($data->data as $val) {
                $ids[] = $val;
            }
        }
        $orders = Order::find()->where(['in', 'id', $ids])->all();
        return $this->renderPartial('_view_modal', [
            'orders' => $orders,
        ]);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @return Order the loaded model
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetGroup($id)
    {
        $responce = ['result' => false, 'parent_id' => null];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($shoesBrand = ShoesBrand::findOne($id)) {
            if($responce['parent_id'] = $shoesBrand->setAgeGroup()) {
                $responce['result'] = true;
            }
        }
        return $responce;
    }

    public function actionExcel(){
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        $this->render('excel', [
            'models' => $dataProvider,
        ]);
    }

    public function actionSendReadySms()
    {
        return true;
        $date_from = '04.04.2023';
        if($orderStatusDates = OrderStatusDate::find()->where(['status_id' => 3])->andWhere(['>', 'created_at', strtotime($date_from)])->all()) {
            $orderIds = [];
            foreach($orderStatusDates as $orderStatusDate) {
                if($orderStatusDate->order->status_id == 3) {
                    $orderIds[] = $orderStatusDate->order_id;
                }
            }
        }
        Order::updatePacketStatus(array_unique($orderIds));
    }

}
