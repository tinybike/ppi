<?php
include_once('model/Model.php');

class Controller {
	private $model;
	
	public function __construct() {
		$this->model = new Model();
	}
	
	public function invoke() {
		// Get organism and dataset codes, if specified
		$org = (isset($_GET['ppi'])) ? $_GET['ppi'] : 'sce';
		$dataset = (isset($_GET['d'])) ? $_GET['d'] : 'ss';
		
		// If the user is searching for a protein, send query to database
		if (isset($_POST['lookup'])) {
			$protein_matches = $this->model->protein_search($org, $_POST['lookup']);
			if (count($protein_matches) == 1) {
				$protein = $this->model->get_protein_info($org, $protein_matches[0]['entry']);
				include 'view/protein_detail.php';
			}
			else {
				include 'view/search_results.php';
			}
		}
		
		// If protein is specified, then return detailed information
		elseif (isset($_POST['protein_id'])) {
			$protein = $this->model->get_protein_info($org, $_POST['protein_id']);
			include 'view/protein_detail.php';
		}
		
		// Otherwise, just show the splash screen
		else {
			$summary = $this->model->get_summary($org, $dataset);
			include 'view/splash.php';
		}
	}
}
