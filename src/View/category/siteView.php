<?php
class siteView
{
    public $viewName;
    public $viewData;
    public $layoutPath='views/layouts/mainLayout.php';
    public $viewPath='views/site/';

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