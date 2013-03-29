<?php
//include_once('model/Model.php');

class Controller {
	private $organism;
	
	public function __construct() {
		$this->organism = (isset($_GET['ppi'])) ? $_GET['ppi'] : 'sce';
	}
	
	public function invoke() {
		$org = $this->organism;
		include 'view/splash.php';
	}
}
