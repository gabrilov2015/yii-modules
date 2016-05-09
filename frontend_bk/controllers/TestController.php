<?php
namespace frontend\controllers;

use Yii;
//use app\models\Post;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TestController extends Controller
{
    public function actionIndex()
    {

        return $this->render('index');
    }
}