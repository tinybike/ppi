<?php
class Model {

	protected function full_url() {
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
		$protocol = substr($sp, 0, strpos($sp, "/")) . $s;
		return $protocol . "://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
	}

	protected function base_url() {
		$actual_link = $this->full_url();
		$exploded_link = explode('?', $actual_link);
		$exploded_link_and = explode('&', $actual_link);
		$base_link = $exploded_link[0];
		return $base_link;
	}
	
	public function get_summary($org) {
		// Summary: name, #nodes, #edges, average degree, global clustering 
		// coefficient, modularity, largest component size
		$summary = array(
			'sce' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/S_cerevisiae_ss.tar.gz',
				'common' => 'budding yeast',
				'name' => 'S. cerevisiae', 
				'nodes' => 2324,
				'edges' => 4085, 
				'average_k' => 3.515,
				'clustering' => 0.146,
				'modularity' => 0.716, 
				'component' => 123,
				'diameter' => 17,
				'average_l' => 5.37
			),
			'dme' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/D_melanogaster_ss.tar.gz',
				'common' => 'fruit fly',
				'name' => 'D. melanogaster', 
				'nodes' => 908,
				'edges' => 1175, 
				'average_k' => 1.316, 
				'clustering' => 0.204,
				'modularity' => 0.872, 
				'component' => 86,
				'diameter' => 23,
				'average_l' => 7.68
			),
			'hsa' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/H_sapiens_ss.tar.gz',
				'common' => 'human',
				'name' => 'H. sapiens', 
				'nodes' => 3989,
				'edges' => 7064, 
				'average_k' => 3.542, 
				'clustering' => 0.124,
				'modularity' => 0.694, 
				'component' => 204,
				'diameter' => 17,
				'average_l' => 5.41
			),
			'cel' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/C_elegans_ss.tar.gz',
				'common' => 'worm',
				'name' => 'C. elegans', 
				'nodes' => 379,
				'edges' => 322, 
				'average_k' => 1.699, 
				'clustering' => 0.137,
				'modularity' => 0.931,
				'component' => 85,
				'diameter' => 11,
				'average_l' => 4.94
			),
			'mmu' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/M_musculus_ss.tar.gz',
				'common' => 'mouse',
				'name' => 'M. musculus', 
				'nodes' => 940,
				'edges' => 864, 
				'average_k' => 1.838, 
				'clustering' => 0.188,
				'modularity' => 0.95, 
				'component' => 179,
				'diameter' => 23,
				'average_l' => 9.14
			),
			'rno' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/R_norvegicus_ss.tar.gz',
				'common' => 'rat',
				'name' => 'R. norvegicus', 
				'nodes' => 302,
				'edges' => 259, 
				'average_k' => 1.715, 
				'clustering' => 0.175,
				'modularity' => 0.921, 
				'component' => 68,
				'diameter' => 8,
				'average_l' => 2.93
			),
			'spo' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/S_pombe_ss.tar.gz',
				'common' => 'fission yeast',
				'name' => 'S. pombe', 
				'nodes' => 671,
				'edges' => 813, 
				'average_k' => 2.423, 
				'clustering' => 0.239,
				'modularity' => 0.881, 
				'component' => 82,
				'diameter' => 16,
				'average_l' => 6.64
			),
			'eco' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/E_coli_ss.tar.gz',
				'common' => 'E. coli',
				'name' => 'E. coli', 
				'nodes' => 252,
				'edges' => 194, 
				'average_k' => 1.54, 
				'clustering' => 0.371,
				'modularity' => 0.959, 
				'component' => 89,
				'diameter' => 5,
				'average_l' => 2.01
			),
			'ath' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/A_thaliana_ss.tar.gz',
				'common' => 'arabidopsis',
				'name' => 'A. thaliana', 
				'nodes' => 2189,
				'edges' => 3172, 
				'average_k' => 2.898, 
				'clustering' => 0.257,
				'modularity' => 0.936, 
				'component' => 213,
				'diameter' => 24,
				'average_l' => 9.37
			)
		);
		return $summary[$org];
	}

}
