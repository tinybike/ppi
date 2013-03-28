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

}
