<?php

namespace app\components;

use app\models\BasePage;
use yii\base\Object;
use yii\web\NotFoundHttpException;
use yii\web\UrlRuleInterface;
use app\models\Page;

class CustomUrlRule extends Object implements UrlRuleInterface
{
    public function createUrl($manager, $route, $params)
    {
        return false; // this rule does not apply
    }

    /**
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return array|bool
     * @throws \yii\base\InvalidConfigException
     */
    public function parseRequest($manager, $request)
    {
        $url = $_SERVER['HTTP_HOST'];
        $pathInfo = $request->getPathInfo();
        if(in_array($url, BasePage::getFrontUrls())) {
            $pathParts = explode('/', $pathInfo);
            $lastPart = end($pathParts);
            if (!$lastPart) {
                $lastPart = '/';
            }

            if($lastPart == 'product-content') {
                return ['front/product-content', []];
            }

            $pages = Page::find()->where(['alias' => $lastPart])->all();
            if(!$pages) {
                return ['front/error', []];
                //throw new NotFoundHttpException('Запрошенная страница не существует');
            }

            foreach ($pages as $page) {
                if ($page and $page->getFullUri() == '/'.$pathInfo) {
                    Page::$current = $page;
                    return ['front/page', [
                        'page' => $page,
                    ]];
                }
            }
        }

        return false;
    }
}
