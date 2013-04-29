<?php
include_once('model/Model.php');

/**
* A Controller object is created every time the user navigates to index.php.
* The controller sets up a Model object and calls its methods to retrieve data
* from the database as needed for user requests, then calls the appropriate
* view file to generate HTML visible to the user.
*/
class Controller {
	private $model;
	
	/**
	* Controller constructor creates the Model object, which contains the
	* methods needed to fetch information from the database.
	*/
	public function __construct() {
		$this->model = new Model();
	}
	
	/** 
	* invoke() is called every time the user navigates to index.php.  Depending
	* on which $_POST elements are set, invoke() either:
	*
	* 1) Loads the basic interacto.me layout page (splash.php) for the
	* selected organism and dataset.  The organism and dataset are specified
	* as $_GET['ppi'] and $_GET['d'], respectively.
	*
	* 2) Fetches detailed protein information and/or search query results from
	* the database and sends via AJAX to the appropriate div in splash.php.
	*/
	public function invoke() {
	
		/** 
		* The organism and dataset are specified via GET.  If their $_GET
		* elements have been set, then use them to specify the working graph.
		* Otherwise, default to the small-scale dataset of S. cerevisiae.
		*/
		$org = (isset($_GET['ppi'])) ? $_GET['ppi'] : 'sce';
		$dataset = (isset($_GET['d'])) ? $_GET['d'] : 'ss';
		
		/** 
		* If the user has sent a search request, then $_POST['lookup'] will be
		* set.  Use the lookup string and the working organism name (in $org)
		* to search the database for matching entries.
		*/
		if (isset($_POST['lookup'])) {
			$protein_matches = $this->model->
				protein_search($org, $_POST['lookup']);
			
			// If a single protein was found, then go directly to the detailed
			// view.  Otherwise, show a brief summary of each protein.
			if (count($protein_matches) == 1) {
				list($protein, $ss_links, $hc_links) = $this->model->
					get_protein_info($org, $protein_matches[0]['entry']);
				include 'view/protein_detail.php';
			}
			else {
				include 'view/search_results.php';
			}
		}
		
		/** 
		* If the protein has been specified (either by clicking on search
		* results or by clicking on a node on the graph), then fetch detailed
		* information about the protein and its interactions from the database.
		*/ 
		elseif (isset($_POST['protein_id'])) {
			list($protein, $ss_links, $hc_links) = $this->model->
				get_protein_info($org, $_POST['protein_id']);
			include 'view/protein_detail.php';
		}
		
		/**
		* By default, load the full splash screen for the working organism and
		* dataset ($org and $dataset, respectively).
		*/
		else {
			$summary = $this->model->get_summary($org, $dataset);
			include 'view/splash.php';
		}
	}
}
