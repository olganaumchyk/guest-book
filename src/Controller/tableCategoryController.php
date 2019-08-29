<?php

class tableCategoryController extends tableController {

    public $table_name = 'category';

    function __construct($view)
    {
        parent::__construct($view);
        $this->view->setNewLayoutPath('views/layouts/mainLayout.php')->setNewViewPath('views/category/');
    }
    

}

?>