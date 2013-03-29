<?php
include_once('model/Model.php');

class Controller {
	private $model;
	
	public function __construct() {
		$this->model = new Model();
	}
	
	public function invoke() {
		$org = (isset($_GET['ppi'])) ? $_GET['ppi'] : 'sce';
		$summary = $this->model->get_summary($org);
		include 'view/splash.php';
	}
}
