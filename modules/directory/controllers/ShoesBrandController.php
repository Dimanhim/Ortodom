<?php

namespace app\modules\directory\controllers;

use app\models\Image;
use app\models\User;
use app\modules\directory\models\BrandColorImage;
use app\modules\directory\models\ColorImage;
use app\modules\directory\models\ShoesMaterial;
use Yii;
use app\modules\directory\models\ShoesBrand;
use app\modules\directory\models\ShoesBrandSearch;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ShoesBrandController implements the CRUD actions for ShoesBrand model.
 */
class ShoesBrandController extends Controller
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
     * Lists all ShoesBrand models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShoesBrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ShoesBrand model.
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
     * Creates a new ShoesBrand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShoesBrand();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ShoesBrand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ShoesBrand model.
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
     * Finds the ShoesBrand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShoesBrand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShoesBrand::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionImages($id)
    {
        $model = $this->findModel($id);
        if($model->load(Yii::$app->request->post())) {
            $model->uploadImages();
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Изображения загружены успешно');
                return $this->refresh();
            }
        }

        return $this->render('_brand_images', [
            'model' => $model,
        ]);
    }

    public function actionMaterialImages($brand_id, $material_id)
    {
        $model = $this->findModel($brand_id);
        $material = ShoesMaterial::findOne($material_id);
        if($model->load(Yii::$app->request->post())) {
            $model->uploadImages();
            if($model->save()) {
                Yii::$app->session->setFlash('success', 'Изображения загружены успешно');
                return $this->refresh();
            }
        }

        return $this->render('_brand_images', [
            'model' => $model,
            'material' => $material,
        ]);
    }

    public function actionDeleteImage($id)
    {
        if ($image = Image::findOne($id)) {
            BrandColorImage::deleteAll(['image_id' => $image->id]);
            $image->delete();
        }
        return true;
    }

    public function actionSetPages()
    {
        return true;
        $count = 0;
        if($brands = ShoesBrand::find()->all()) {
            foreach($brands as $brand) {
                if($brand->setPage()) $count++;
            }
        }
        return 'Обновлено '.$count.' страниц';
    }

    public function actionColorsForm()
    {
        $response = [
            'result' => false,
            'html' => null,
        ];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if($data = Yii::$app->request->post()) {
            if(($model = ShoesBrand::findOne($data['id'])) && ($materialIds = $data['material_ids'])) {
                $html = $this->renderAjax('_colors_form', [
                    'model' => $model,
                    'materialIds' => $materialIds,
                ]);
                if($html) {
                    $response['result'] = true;
                    $response['html'] = $html;
                }
            }
        }
        return $response;
    }

    public function actionSaveImageSort()
    {
        $response = ['result' => false, 'message' => null];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $sort = Yii::$app->request->post();
        if($sort && $sort['ids'] && ($ids = json_decode($sort['ids'], true))) {
            foreach($ids as $position => $imageId) {
                if($image = Image::findOne($imageId)) {
                    $image->position = $position;
                    $image->save();
                }
            }
            $response['result'] = true;
            $response['message'] = 'Сортировка изображений успешно сохранена';
        }
        return $response;
    }
}
