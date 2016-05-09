<?php
use frontend\widgets\Files;
use frontend\widgets\EGridView;
use yii\bootstrap\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\Helpers\Html;
use yii\Helpers\Url;

?>
<?= Files::widget([
					'restApiLink' => 'http://yii2.dahuasoft2008.com/frontend/web/index.php/site/fake-api',
					'title' => 'Test title',
				]) ?>
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
<?php //$form_add = ActiveForm::begin(['id' => 'add-form','action' => ['index.php/test/add'],'method' => 'post']); ?>
<?php
echo EGridView::widget([
    'dataProvider' => $dataProvider,
	'add_url' => Url::toRoute('index.php/test/add'),
	'edit_url' => Url::toRoute('index.php/test/edit'),
	'delete_url' => Url::toRoute('index.php/test/delete'),
]);
?>
<?php //ActiveForm::end(); ?>