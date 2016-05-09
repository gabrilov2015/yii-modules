<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use frontend\models\Keywords;

class TestController extends Controller
{
    public function actionIndex()
    {
		$dataProvider = new ActiveDataProvider([
			'query' => Keywords::find(),
			'pagination' => [
				'pageSize' => 20,
			],
		]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
	
	public function actionAdd()
    {
        $model = new Keywords;
		$postDatas = Yii::$app->request->post();
		$model->type = $postDatas['type'];
		$model->keyword_en = $postDatas['keyword_en'];
		$model->keyword_fr = $postDatas['keyword_fr'];
		if ($model->insert()) {
			return json_encode(['id'=>$model->id,'datas'=>['id'=>$model->id,'type'=>$model->type,'keyword_en'=>$model->keyword_en,'keyword_fr'=>$model->keyword_fr],'status'=>true]);
        }
		return json_encode(['status'=>false]);
    }
	
	public function actionEdit()
    {
		$postDatas = Yii::$app->request->post();
		$id = $postDatas['id'];
        $model = new Keywords;
		$model = $model::findOne($id);
		$model->type = $postDatas['type'];
		$model->keyword_en = $postDatas['keyword_en'];
		$model->keyword_fr = $postDatas['keyword_fr'];
        if ($model->update()) {
			return json_encode(['id'=>$model->id,'datas'=>['id'=>$model->id,'type'=>$model->type,'keyword_en'=>$model->keyword_en,'keyword_fr'=>$model->keyword_fr],'status'=>true]);
        }
		return json_encode(['status'=>false]);
    }
	
	public function actionDelete()
    {
		$postDatas = Yii::$app->request->post();
		$id = $postDatas['id'];
        $model = new Keywords;
		$model = $model::findOne($id);
        if($model->delete()){
			return json_encode(['status'=>true]);
		}
		return json_encode(['status'=>false]);
    }
}
