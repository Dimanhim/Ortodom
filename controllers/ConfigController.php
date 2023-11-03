<?php

namespace app\controllers;

use app\models\User;
use app\modules\directory\models\Shoes;
use Yii;
use app\models\Config;
use app\models\ConfigSearch;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConfigController implements the CRUD actions for Config model.
 */
class ConfigController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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
     * Lists all Config models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Config model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Config model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Config();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(Yii::$app->request->post('addConfigOrder') && $model->patient_id) {
                return $this->redirect(['order/create', 'patient_id' => $model->patient_id, 'config_id' => $model->id]);
            }
            if(Yii::$app->request->post('addConfigNewPatient') && $model->patient_id) {
                return $this->redirect(['order/create', 'patient_id' => null, 'config_id' => $model->id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Config model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(Yii::$app->request->post('addConfigOrder') && $model->patient_id) {
                return $this->redirect(['order/create', 'patient_id' => $model->patient_id, 'config_id' => $model->id]);
            }
            if(Yii::$app->request->post('addConfigNewPatient') && $model->patient_id) {
                return $this->redirect(['order/create', 'patient_id' => null, 'config_id' => $model->id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Config model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Config model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Config the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Config::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     *      AJAX
     * */

    public function actionChangeColor($material_id)
    {
        $str = '<option value="">Выбрать</option>';
        $options = Config::getOptions();
        if(array_key_exists($material_id, $options['color'])) {
            $optionsArray = $options['color'][$material_id];
            if(!empty($optionsArray)) {
                foreach($optionsArray as $value) {
                    $str .= "<option value='{$value}'>{$value}</option>";
                }
            }
        }
        return $str;
    }

    /**
     * @param $shoes_id
     * @return string
     */
    public function actionGetModels($shoes_id)
    {
        $str = '<option value="">Выбрать</option>';
        $options = Config::getOptions();
        if($models = Shoes::findAll(['parent_id' => $shoes_id])) {
            foreach($models as $value) {
                $str .= "<option value='{$value->id}'>{$value->name}</option>";
            }
        }
        return $str;
    }
}
