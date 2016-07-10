<?php

class Home extends Controller {
    public function index() {
        if($this->isLogged) {
            $this->template = __DIR__ . "/templates/dashboard_editor.php";
        } else {
            $this->template = __DIR__ . "/template/login_form.php";
        }
        include(__DIR__ . "templates/layout.php");
    }
}