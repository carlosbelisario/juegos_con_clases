<?php
namespace session;
/**
 * Class manager for the Session
 *
 * @author Carlos Belisario <carlos.belisario.gonzalez@gmail.com>
 */
class Session 
{
    
    /**
     *
     * @var bool $sessionStatus
     */
    private static $sessionStatus = false;           
    
    public function __construct(){}
    
    /**
     *
     * @param string $name
     * @return void
     */
    public function start($name)
    {           
        if(!session_is_registered($name)) {            
            session_name($name);
            if(!self::$sessionStatus) {
                session_start();               
            } 
        } else{
            return;
        }
    }
    
    /**
     * @method setSession for set the value for a variable of session 
     * @param string $key
     * @param mixed $value 
     */
    public function setSession($key, $value)
    {
        $_SESSION[$key] = serialize($value);        
    }
    
    /**
     *
     * @param string $key to return 
     * @return mixed 
     */
    public function getSession($key)
    {
        if(isset($_SESSION[$key]))
            return unserialize($_SESSION[$key]);
        else {
            die('the session "' . $key .'" has not been created ');
        }
    }    
    
    /**
     * @method unsetSession clean a variable of session
     * @param string $key      
     */    
    public function unsetSession($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * @method __destruct of the class destroy the session 
     */
    public function destroy()
    {       
        session_unset();
        session_destroy();
    }
}