<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\models\Patient;
use app\components\Helpers;
use app\models\Page;
use app\models\User;

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language; ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php echo Html::csrfMetaTags(); ?>
    <title><?php echo Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<body>

<?php $this->beginBody(); ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'ORTODOM',
        'brandUrl' => Yii::$app->homeUrl,
        'innerContainerOptions' => ['class'=>'container-fluid'],
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    if (Yii::$app->user->isGuest) {
        $menuItems = [];
    } else {
        $pages = [];
        foreach (Page::$availableTypes as $pageTypeKey => $pageType) {
            $pages[] = ['label' => $pageType['title'], 'url' => ['/pages/'.$pageTypeKey]];
        }
        $menuItems = [
            !User::disabledAccess('patient') ? ['label' => 'Пациенты', 'url' => ['/patient']] : '',
            !User::disabledAccess('order') ? ['label' => 'Заказы', 'url' => ['/order']] : '',
            !User::disabledAccess('journal') ? ['label' => 'Журнал', 'url' => ['/journal']] : '',
            !User::disabledAccess('config') ? ['label' => 'Конфигуратор', 'url' => ['/config']] : '',
            !User::disabledAccess('visit') ? ['label' => 'Приемы', 'url' => ['/visit']] : '',
            !User::getIsManager() ? ['label' => 'Редактор', 'url' => ['visit/user']] : '',
            !User::getIsManager() ? ['label' => 'Справочник', 'options' => ['class' => 'guides'], 'items' => [
                    ['label' => 'Диагнозы', 'url' => ['/directory/diagnosis/']],
                    ['label' => 'Форма оплаты', 'url' => ['/directory/payment/']],
                    ['label' => 'Вид обуви', 'url' => ['/directory/shoes/']],
                    ['label' => 'Назначение обуви', 'url' => ['/directory/appointment/']],
                    ['label' => 'Возрастная группа', 'url' => ['/directory/age-group/']],
                    //['label' => 'Задники обуви', 'url' => ['/directory/shoes-heel/']],
                    ['label' => 'Модели обуви преж', 'url' => ['/directory/shoes-model/']],
                    ['label' => 'Модели обуви', 'url' => ['/directory/shoes-brand/']],
                    ['label' => 'Материалы верха обуви', 'url' => ['/directory/shoes-material/']],
                    ['label' => 'Цвета обуви', 'url' => ['/directory/shoes-color/']],
                    ['label' => 'Подкладки обуви', 'url' => ['/directory/shoes-lining/']],
                    ['label' => 'Подошвы обуви', 'url' => ['/directory/shoes-sole/']],
                    ['label' => 'Колодки обуви', 'url' => ['/directory/shoes-last/']],
                    ['label' => 'Статусы заказов', 'url' => ['/directory/order-status/']],
                ],
            ] : '',
            !User::getIsManager() ? ['label' => 'Страницы', 'options' => ['class' => 'front-menu'], 'items' => $pages] : '',
            !User::getIsManager() ? ['label' => 'Справочник', 'options' => ['class' => 'guides'], 'items' => [
                ['label' => 'Вопрос-ответ', 'url' => ['/directory/questions-answer/index']],
                ['label' => 'Партнеры', 'url' => ['/directory/partner/index']],
                ['label' => 'Отзывы', 'url' => ['/directory/review/index']],
                ['label' => 'Меню сайта', 'url' => ['/menu/index']],
                ['label' => 'Слайдер', 'url' => ['/slider/index']],
            ],
            ] : '',
            ['label' => 'Выход', 'url' => ['/site/logout']],
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container-fluid<?= Helpers::getContainerClass(Yii::$app->controller->id, Yii::$app->controller->action->id) ?>">
        <?php echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]); ?>
        <?php echo $content; ?>
    </div>
</div>

<footer class="footer">
    <div class="container-fluid">
        <p class="pull-left">&copy; ORTODOM <?php echo date('Y'); ?></p>

        <p class="pull-right"><?php echo Yii::powered(); ?></p>
    </div>
</footer>

<?php $this->endBody(); ?>
<script>




    $('body').on('change', '.search-status', function() {
        var self = $(this);
        var val = self.val();
        $.get('/order/change-status-color?id=' + val, function(res) {
            self.attr('style', res);
        });
    });

</script>
<?php if($patients = Patient::find()->select(['id', 'phone'])->asArray()->all()) : ?>
    <script>
        var object = [
            <?php foreach($patients as $patient) : ?>
            {label:"<?=trim($patient['phone'])?>", value:"<?=$patient['id']?>"},
            <?php endforeach; ?>
        ];
        $('.auto-phone').autocomplete({
            source: object,
            select:function(event,ui) {
                console.log(ui.item.value);
                $.get('/visit/get-field-values?id='+ui.item.value, function(json) {
                    var data = JSON.parse(json);
                    console.log(data);
                    $('#visit-name').val(data.name);
                    $('#visit-phone').val(data.phone);
                    $('#visit-phone').val(data.phone);
                    $('#visit-patient_id').val(data.patient_id);
                });
            }
        });

    </script>
<?php endif; ?>
</body>
</html>
<?php $this->endPage(); ?>
