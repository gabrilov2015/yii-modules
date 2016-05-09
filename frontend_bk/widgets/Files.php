<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Files extends Widget
{
	public $title;
	public $num_of_images;
	public $container_class;
	public $REST_API_link;

    public function init()
    {
        parent::init();
		if ($this->title === null) {
            $this->title = 'Recent Files';
        }
		if ($this->num_of_images === null) {
            $this->num_of_images = 10;
        }
		if ($this->container_class === null) {
            $this->container_class = 'recent-files';
        }
		if ($this->REST_API_link === null) {
            $this->REST_API_link = 'http://yii2.dahuasoft2008.com/frontend/web/index.php/site/fake-api';
        }
    }

    public function run()
    {
		$json = file_get_contents($this->REST_API_link);
		$image_datas = json_decode($json);
		//$image_datas = array('1111','1234','2323','5566','4321','531');
        return $this->render('files', [ 'title' => $this->title, 
										'num_of_images' => $this->num_of_images,
										'container_class' => $this->container_class,
										'image_datas' => $image_datas,
									]
							);
    }
}