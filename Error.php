<?php
namespace juegos_con_clase\error;
/**
 * Class manager of the error
 *
 * @author carlos
 */
class Error 
{
    /**
     *
     * @var array 
     */
    private $error;
    
    public function __construct(){}
    
    /**
     *
     * @param String $error 
     */
    public function setError($error)
    {
        $this->error[] = $error;
        return $this;
    }
    
    /**
     *
     * @return array 
     */
    public function getError()
    {
        return $this->error;
    }
    
    /**
     * magic method toString
     */
    public function __toString()
    {        
        $string = implode("<li>", $this->error);
        return $string;
    }
}
?>
