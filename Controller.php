<?php
namespace MVC;
// require 'vendor/autoload.php';
class Controller {
    public function render($view, $data = []) {
        extract($data);
        // echo $view;
        include "Views/$view.php";
    }
}
