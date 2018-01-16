<?php

Class Routing{
    private $controller_name;
    private $function_name = 'index';
    private $function_params = array();
    
    public function getControllerName()
    {
            if (isset($this->controller_name))
            {
                    return $this->controller_name;
            }
            else
            {
                    return false;
            }
    }
    
    public function setControllerName($controller_name)
    {    
            $this->controller_name = $controller_name;
    }
        
    public function getFunctionName()
    {
            if (isset($this->function_name))
            {
                    return $this->function_name;
            }
            else
            {
                    return false;
            }
    }
    
    function setFunctionName($function_name) 
    {
            $this->function_name = $function_name;
    }
    
    public function getFunctionParams()
    {
            return $this->function_params;            
    }
    
    function setFunctionParams($function_params) 
    {
            $this->function_params = $function_params;
    }
}