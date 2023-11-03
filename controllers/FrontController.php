<?php

namespace app\controllers;

use app\models\Page;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class FrontController extends Controller
{
    public $layout = 'front';

    public function actionPage(Page $page) {
        if($page && $page->is_active) {
            return $this->render('page', [
                'page' => $page,
                'data' => $page->dataSource,
            ]);
        }
        return $this->exception();
    }

    public function actionProductContent($page_id)
    {
        if(($page = Page::findOne($page_id)) && $page->is_active) {
            $this->layout = 'null';
            return $this->render('//pages/front/_product_inner_ajax', [
                'page' => $page,
                'data' => $page->dataSource,
            ]);
        }
    }

    public function actionError()
    {
        return $this->exception();
    }

    public function exception()
    {
        $this->view->title = 'Ошибка 404. Страница не найдена';
        return $this->render('error');
    }

    public function actionShowModal()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success'];
    }
}

?>
