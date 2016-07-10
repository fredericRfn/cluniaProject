<?php

class Cms {
	public function error() {
		$this->template = __DIR__ . "/templates/404.php";
		include(__DIR__ . "/templates/layout.php");
	}

	public function about() {
		$this->template = __DIR__ . "templates/about.php";
		include(__DIR__ . "/templates/layout.php");
	}

	public function contact() {
		$this->template = __DIR__ . "/templates/contact.php";
		include( __DIR__ . "/templates/layout.php");
	}
}