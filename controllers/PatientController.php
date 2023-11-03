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

use app\modules\directory\models\Payment;
use Yii;
use app\models\OrderSearch;
use app\models\Patient;
use app\models\PatientSearch;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use app\models\PaymentForm;
use app\models\User;

/**
 * PatientController implements the CRUD actions for Patient model.
 */
class PatientController extends Controller
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
     * Lists all Patient models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PatientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $payments = Payment::find()->all();
        $items = [];
        foreach($payments as $payment) {
            $items[$payment->id] = $payment->name;
        }
        $model = new PaymentForm();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'items' => $items,
        ]);
    }
    public function actionExcel($payment)
    {
        $query = Patient::find();
        if($payment) {
            $ids = [];
            foreach(Patient::find()->all() as $value) {
                if($value->isPaymentInOrder($payment)) $ids[] = $value->id;
            }
            $query = $query->where(['in', 'id', $ids]);
        }
        $model = $query->all();
        return $this->render('excel', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Patient model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new OrderSearch(['patient_id' => $id]);
        $orderProvider = $searchModel->search([]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'orderProvider' => $orderProvider,
        ]);
    }

    /**
     * Creates a new Patient model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate($from = null)
    {
        $model = new Patient();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($from) {
                return $this->redirect(['order/create', 'patient_id' => $model->id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Patient model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                'model' => $model,
            ]);
    }

    /**
     * @param $term
     * @return array
     * @throws BadRequestHttpException
     */
    public function actionStreets($term)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $results = file_get_contents('http://kladr-api.ru/api.php?cityId=7800000000000&oneString=true&withParent=false&limit=5&query='.$term);
            $results = json_decode($results);
            $response = [];

            foreach ($results->result as $item)
                $response[] = [
                    'id' => $item->name,
                    'value' => $item->name,
                ];

            return $response;
        }

        throw new BadRequestHttpException();
    }

    /**
     * Deletes an existing Patient model.
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

    /**
     * Finds the Patient model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @throws NotFoundHttpException if the model cannot be found
     *
     * @return Patient the loaded model
     */
    protected function findModel($id)
    {
        if (($model = Patient::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
