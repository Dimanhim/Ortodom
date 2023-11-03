<?php

namespace app\controllers;

use app\models\MenuItem;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * MenuApiController implements the CRUD actions for Page model.
 */
class MenuApiController extends Controller
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
     * @param \yii\base\Action $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    /**
     * @param int $menuId
     * @return array
     */
    public function actionGetTreeChildren($menuId) {
        $result = [];
        /** @var MenuItem $menuItem */
        foreach (MenuItem::find()->where(['menu_id' => $menuId, 'parent_id' => 0])->orderBy('position ASC')->all() as $menuItem) {
            $result = $this->prepareMenuItem($menuItem, $result);
        }
        return $result;
    }

    /**
     * @param MenuItem $menuItem
     * @param array $result
     * @return array
     */
    private function prepareMenuItem($menuItem, $result = []) {
        $isDirectory = count($menuItem->children) > 0;
        $result[] = [
            'id' => $menuItem->id,
            'parent' => $menuItem->parent_id ? $menuItem->parent_id : '#',
            'text' => $menuItem->name,
            'children' => $isDirectory ? [] : false,
            'icon' => $isDirectory ? '' : 'glyphicon glyphicon-file',
            'state' => [
                'opened' => true,
            ],
        ];
        foreach ($menuItem->children as $menuSubItem) {
            $result = $this->prepareMenuItem($menuSubItem, $result);
        }
        return $result;
    }

    /**
     *
     */
    public function actionMoveItems() {
        $items = Yii::$app->request->post('data');
        foreach ($items as $item) {
            $menuItem = MenuItem::findOne($item['id']);
            if (!$menuItem) {
                continue;
            }

            $menuItem->parent_id = $item['parent_id'];
            $menuItem->position = $item['position'];
            $menuItem->save();
        }
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemoveMenuItem($id) {
        $menuItem = MenuItem::findOne($id);
        if ($menuItem) {
            $menuItem->delete();
        }
    }

}
