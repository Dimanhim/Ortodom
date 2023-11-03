<?php

namespace app\controllers;

use app\models\PagesSearch;
//use common\models\Image;
use app\models\Page;
//use common\models\ProductLinks;
//use common\models\Product;
use app\models\User;
use himiklab\sortablegrid\SortableGridAction;
use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * PagesController implements the CRUD actions for Page model.
 */
class PagesController extends Controller
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
                ]
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

    public function actions()
    {
        return [
            'sort' => [
                'class' => SortableGridAction::className(),
                'modelName' => Page::className(),
            ],
        ];
    }

    /**
     * Lists all Page models.
     * @param string $type
     * @return mixed
     */
    public function actionIndex($type = null)
    {
        $searchModel = new PagesSearch();
        $searchModel->type = $type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type,
        ]);
    }

    public function actionTree() {
        return $this->render('tree');
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param string $type
     * @return mixed
     * @throws BadRequestHttpException
     * @throws \yii\db\Exception
     */
    public function actionCreate($type)
    {
        $page = new Page();
        $page->type = $type;
        $page->is_active = true;

        if (!$page->validateType()) {
            throw new BadRequestHttpException('The requested type does not exist.');
        }

        $model = $page->getModelInstance();

        if ($model->load(Yii::$app->request->post()) && $page->load(Yii::$app->request->post())) {
            if($model->save()) {
                $page->relation_id = $model->id;
                if($page->save()) {
                    return $this->redirect(['update', 'id' => $page->id]);
                }
            }
        }

        return $this->render('create', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $page = $this->findModel($id);
        $model = $page->dataSource;

        if($page->type == 'products') {
            $model->loadProductLinks;
            $model->sortOrder = $page->sortOrder;
        }

        if ($model->load(Yii::$app->request->post()) && $page->load(Yii::$app->request->post())) {
            if($page->type == 'products') {
                $page->sortOrder = $model->sortOrder;
            }
            if(($page->type == 'advices') || ($page->type == 'events')) {
                $model->user_date = strtotime($model->user_date);
            }
            $model->update(false);
            $page->save();
            return $this->redirect(['update', 'id' => $page->id]);
        }

        return $this->render('update', [
            'page' => $page,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $page = $this->findModel($id);
        $type = $page->type;
        $model = $page->dataSource;

        $model->delete();
        $page->delete();

        return $this->redirect(['index', 'type' => $type]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionToggleVisibility($id) {
        $page = $this->findModel($id);
        $page->is_active = !$page->is_active;
        $page->save(false);
        return $this->redirect(['index', 'type' => $page->type]);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
