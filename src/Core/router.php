<?php
namespace App\Core;

class Router{
    public function __construct()
    {
        $this->controllerName = (isset($_GET["t"]) ? $_GET["t"] : 'site') . 'Controller';
        $this->actionName = 'action' . (isset($_GET["a"]) ? $_GET["a"] : 'home');

    }
    
    public function Run(){
        $className="App\\controller\\{$this->controllerName}";

        if(class_exists($className)){
            $MVC=new $className();
            if(method_exists($MVC,$this->actionName)){
                $MVC->{$this->actionName}();
            }else{
                echo "нет такого метода: $this->actionName";
            }
        }else{
            echo "нет такого класса : $this->controllerName";

        }
    }


}