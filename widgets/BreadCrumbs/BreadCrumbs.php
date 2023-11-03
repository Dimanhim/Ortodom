<?php
namespace app\widgets\BreadCrumbs;

use app\models\Page;
use Yii;

class BreadCrumbs extends \yii\base\Widget
{
    public $page;
    public $showH1 = true;
    public $show = true;

    public function init()
    {
        return parent::init();
    }

    public function run()
    {
        $breadCrumbItems = $this->getBreadCrumbItems();
        return $this->show ? $this->render('index', [
            'breadCrumbItems' => $breadCrumbItems,
            'page' => $this->page,
            'showH1' => $this->showH1,
        ]) : '';
    }
    /**
     * @return array
     */
    protected function getBreadCrumbItems() {
        $result = [];
        $last = 0;
        if($this->page) {
            $page = $this->page;
            $result[] = [
                'name' => $page->name,
                'url' => $page->getFullUri(),
                'last' => 1,
            ];
            while($page->parent_id != null) {
                $parent = $page->parent;
                $result[] = [
                    'name' => $parent->name,
                    'url' => $parent->getFullUri(),
                    'last' => 0,
                ];
                $page = Page::findOne($parent->id);
                $last++;
            }
            return array_reverse($result);
        } else {
            $controller_name = Yii::$app->controller->id;
            $result[0] = [
                'name' => Yii::$app->controller->view->title,
                'url' => '/'.$controller_name,
                'last' => 1,
            ];
            return $result;
        }
    }
}
