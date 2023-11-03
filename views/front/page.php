<?php

use app\models\BasePage;

/* @var $this yii\web\View */
/* @var $page common\models\Page */
/** @var $data BasePage */

$this->title = $page->getTitle();
$this->registerMetaTag([
    'name' => 'description',
    'content' => $page->meta_description,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $page->meta_keywords,
]);
?>

<?= $this->render($page->templatePath, [
    'page' => $page,
    'data' => $data,
]) ?>
<?= $page->custom_code ?>


