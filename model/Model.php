<?php
class Model {

	/**
	 * Connect to MySQL database using mysqli, with parameters specified 
	 * in dbparams.php.
	 */
	protected function make_db_connection() {	
		include 'model/dbparams.php';
		$db = new mysqli($db_host, $db_user, $db_pass, $db_name);
		// Check connection
		if ($db->connect_errno) {
			printf("Connect failed: %s\n", $db->connect_error);
			exit();
		}
		return $db;
	}
	
	/**
	 * Check organism three-letter code against pre-defined whitelist to guard
	 * against injection.
	 */
	protected function check_org_list($db, $org) {
		$result = $db->query('SELECT * FROM org_list');
		$org_list = array();
		while ($row = $result->fetch_array()) {
			$org_list[] = $row[0];
		}
		$in_list = (in_array($org, $org_list)) ? TRUE : FALSE;
		return $in_list;
	}
	
	/**
	 * Sanitize user query and search database for protein/gene name matches,
	 * and/or UniProt/SwissProt ID matches.
	 */
	public function protein_search($org, $lookup) {
		$db = $this->make_db_connection();
				
		/* Fetch and return protein matches from database */
		$stmt = $db->stmt_init();
		$stmt->prepare('
			SELECT * FROM uniprot_' . $org .'
			WHERE `entry` LIKE ?
			OR `entry_name` LIKE ?
			OR `protein_names` LIKE ?
			OR `gene_names` LIKE ?
		');
		$lookup = '%' . strtoupper($lookup) . '%';
		$stmt->bind_param('ssss', $lookup, $lookup, $lookup, $lookup);
		$stmt->execute();
		
		$protein_matches = array();
		$result = $stmt->get_result();
		while ($row = $result->fetch_array()) {
			$protein_matches[] = $row;
		}

		$stmt->close();
		$db->close();

		return $protein_matches;
	}
	
	/**
	 * If the protein is specified, fetch detailed information about the
	 * protein, and lists of its small-scale and hi-confidence interaction 
	 * partners.
	 */
	public function get_protein_info($org, $lookup) {
		$db = $this->make_db_connection();

		/* Check organism whitelist to protect query */
		if (!$this->check_org_list($db, $org)) {
			$db->close();
			return NULL;
		}
		
		/* Fetch protein information from database */
		$stmt = $db->stmt_init();
		$stmt->prepare('SELECT * FROM uniprot_' . $org .' WHERE `entry` = ?');
		$lookup = strtoupper($lookup);
		$stmt->bind_param('s', $lookup);
		$stmt->execute();
		$protein = $stmt->get_result()->fetch_array();
		$stmt->close();
		
		/* Fetch small-scale links from database */
		$stmt = $db->stmt_init();
		$stmt->prepare('
			SELECT `swissprot2` FROM ' . $org . '_ss WHERE `swissprot1` = ?
			UNION
			SELECT `swissprot1` FROM ' . $org . '_ss WHERE `swissprot2` = ?
		');
		$stmt->bind_param('ss', $lookup, $lookup);
		$stmt->execute();
		$result = $stmt->get_result();
		$ss_links = array();
		while ($row = $result->fetch_array()) {
			$ss_links[] = $row;
		}
		$stmt->close();
		
		/* Fetch hi-confidence links from database */
		$stmt = $db->stmt_init();
		$stmt->prepare('
			SELECT `swissprot2` FROM ' . $org . '_hc WHERE `swissprot1` = ?
			UNION
			SELECT `swissprot1` FROM ' . $org . '_hc WHERE `swissprot2` = ?
		');
		$stmt->bind_param('ss', $lookup, $lookup);
		$stmt->execute();
		$result = $stmt->get_result();
		$hc_links = array();
		while ($row = $result->fetch_array()) {
			$hc_links[] = $row;
		}
		$stmt->close();

		$db->close();		
		return array($protein, $ss_links, $hc_links);
	}
	
	/**
	 * Fetch basic statistics for the selected organism and dataset (small
	 * scale or hi-confidence).
	 */
	public function get_summary($org, $ss_or_hc) {
		$db = $this->make_db_connection();
		
		/* Fetch and return organism summary from database */
		$dataset = $org . '_' . $ss_or_hc;
		$stmt = $db->stmt_init();
		$stmt->prepare('SELECT * FROM summary WHERE dataset = ?');
		$stmt->bind_param('s', $dataset);
		$stmt->execute();
		$summary = $stmt->get_result()->fetch_array();
		$stmt->close();
		
		$db->close();
		return $summary;
	}

}