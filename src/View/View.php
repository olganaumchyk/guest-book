<?php
namespace App\View;

class View
{
    public $viewName;
    public $viewData;
    public $viewPath=__DIR__.'/../../Templates/site/';
    public $layoutPath=__DIR__.'/../../Templates/_layouts/mainLayout.php';

    function __construct()
    {}  
    
    function render($viewName,$viewData=[]){
        $this->viewName=$viewName;
        $this->viewData=$viewData;

        extract($this->viewData);
        include $this->layoutPath;
    }

    function body(){
        extract($this->viewData);
        include $this->viewPath.$this->viewName. '.php';
    }
    function setNewLayoutPath($layoutPath)
    {
        $this->layoutPath=$layoutPath;
        return $this;
    }

    function setNewViewPath($viewPath)
    {
        $this->viewtPath=$viewPath;
        return $this;
    }

}