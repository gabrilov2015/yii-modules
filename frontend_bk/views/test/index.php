<?php
use frontend\widgets\Files;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\grid\GridView;
use yii\Helpers\Html;

?>
<?= Files::widget() ?>
<?php $form = ActiveForm::begin(['id' => 'my-form']); ?>
<?= Html::mDropDownList('mdrop_down','Multiple Dropdown',['a'],['b' => '123','a' => 'a123'],['class'=>'multiple-dropdown']) ?>
<?= Html::eDropDownList('edrop_down','Editable Dropdown','',['children', 'child', 'chicken']) ?>
<?= Html::autoCompleteInput('auto_complete','http://yii2.dahuasoft2008.com/frontend/web/index.php/site/fake-api-bis','Auto Complete Tags:') ?>
<?= Breadcrumbs::widget([
    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
    'links' => [
        ['label' => '123', 'url' => ['controller/action']],
        ['label' => '123', 'url' => ['controller/action']],
        ['label' => '456', 'url' => ['controller/action']],
        ['label' => '456', 'url' => ['controller/action']],
    ],
]);
?>
<?= Breadcrumbs::widget([
    'itemTemplate' => "<li><i>{link}</i></li>\n", // template for all links
    'links' => [
        ['label' => 'test', 'url' => ['controller/action']],
        ['label' => 'test', 'url' => ['controller/action']],
        ['label' => 'thing', 'url' => ['controller/action']],
        ['label' => 'thing', 'url' => ['controller/action']],
    ],
]);
?>

<?php ActiveForm::end(); ?>