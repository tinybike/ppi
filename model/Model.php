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
			'sce_hc' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/S_cerevisiae_hc.tar.gz',
				'common' => 'budding yeast',
				'name' => 'S. cerevisiae', 
				'nodes' => 4953,
				'edges' => 43647, 
				'average_k' => 17.624,
				'clustering' => 0.179,
				'modularity' => 0.674, 
				'component' => 42,
				'diameter' => 9,
				'average_l' => 3.255
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
			'dme_hc' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/D_melanogaster_hc.tar.gz',
				'common' => 'fruit fly',
				'name' => 'D. melanogaster', 
				'nodes' => 3665,
				'edges' => 7074, 
				'average_k' => 3.86, 
				'clustering' => 0.046,
				'modularity' => 0.84, 
				'component' => 161,
				'diameter' => 13,
				'average_l' => 5.00
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
			'hsa_hc' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/H_sapiens_hc.tar.gz',
				'common' => 'human',
				'name' => 'H. sapiens', 
				'nodes' => 10107,
				'edges' => 43785, 
				'average_k' => 8.664, 
				'clustering' => 0.257,
				'modularity' => 0.686, 
				'component' => 68,
				'diameter' => 10,
				'average_l' => 2.87
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
			'cel_hc' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/C_elegans_hc.tar.gz',
				'common' => 'worm',
				'name' => 'C. elegans', 
				'nodes' => 2240,
				'edges' => 3348, 
				'average_k' => 2.989, 
				'clustering' => 0.049,
				'modularity' => 0.883,
				'component' => 154,
				'diameter' => 15,
				'average_l' => 5.10
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
			'mmu_hc' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/M_musculus_hc.tar.gz',
				'common' => 'mouse',
				'name' => 'M. musculus', 
				'nodes' => 2834,
				'edges' => 4200, 
				'average_k' => 2.964, 
				'clustering' => 0.204,
				'modularity' => 0.897, 
				'component' => 146,
				'diameter' => 17,
				'average_l' => 5.04
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
			'rno_hc' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/R_norvegicus_hc.tar.gz',
				'common' => 'rat',
				'name' => 'R. norvegicus', 
				'nodes' => 1032,
				'edges' => 1190, 
				'average_k' => 2.306, 
				'clustering' => 0.185,
				'modularity' => 0.879, 
				'component' => 43,
				'diameter' => 13,
				'average_l' => 3.97
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
			'spo_hc' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/S_pombe_hc.tar.gz',
				'common' => 'fission yeast',
				'name' => 'S. pombe', 
				'nodes' => 982,
				'edges' => 1459, 
				'average_k' => 2.971, 
				'clustering' => 0.421,
				'modularity' => 0.917, 
				'component' => 72,
				'diameter' => 18,
				'average_l' => 6.5
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
			'eco_hc' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/E_coli_ss.tar.gz',
				'common' => 'E. coli',
				'name' => 'E. coli', 
				'nodes' => 1869,
				'edges' => 5699, 
				'average_k' => 6.098, 
				'clustering' => 0.141,
				'modularity' => 0.641, 
				'component' => 28,
				'diameter' => 11,
				'average_l' => 3.64
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
			),
			'ath_hc' => array(
				'url' => 'http://hintdb.hgc.jp/htp/download/A_thaliana_hc.tar.gz',
				'common' => 'arabidopsis',
				'name' => 'A. thaliana', 
				'nodes' => 3748,
				'edges' => 7334, 
				'average_k' => 3.914, 
				'clustering' => 0.257,
				'modularity' => 0.838, 
				'component' => 197,
				'diameter' => 16,
				'average_l' => 5.22
			)
		);
		return $summary[$org];
	}

}
