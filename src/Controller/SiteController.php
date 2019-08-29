<?php
namespace App\Controller;

class SiteController extends Controller {

    function actionHome () {
        $this->render("home", [
            'title' => "Welcome"
        ]);
    }

    function actionAbout () {
        $this->render("about", [
            'title' => "About Us"
        ]);
    }

}

?>