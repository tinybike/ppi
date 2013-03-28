<?php
include_once('model/Model.php');

class Controller {
	private $model;
	private $page;
	
	public function __construct() {
		$this->model = new Model();
		$this->page = (isset($_GET['page'])) ? $_GET['page'] : 'default';
	}
	
	public function invoke() {
		switch ($this->page) {
			// By default, show the splash screen
			default:
				include 'view/splash.php';
				break;
		}
	}
}
