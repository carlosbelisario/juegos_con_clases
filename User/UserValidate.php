<?php
namespace juegos_con_clase\User;
use juegos_con_clase\error\Error as Error;
require_once '../Error.php';
/**
 * Class for the validation of the user
 *
 * @author Carlos Belisario <carlosbelisario.com>
 * 
 */
class UserValidate
{
    /**
     *
     * @var User $user 
     */
    private $user;
    
    /**
     * 
     * @var Error
     */
    private $error;
    
    /**
     *
     * @var array 
     */
    private $rules;
    
    /**
     *
     * @param User $user
     * @param array $rules 
     */
    public function __construct(User $user, array $rules = array())
    {        
        $this->user = $user;               
        $this->error = new \juegos_con_clase\error\Error();        
        $this->rules = $rules;        
    }
    
    public function isValid()
    {
        foreach($this->rules as $rule)
        {
            $this->$rule();
        }
        $error = $this->error->getError();
        if(!empty($error)) {
            return $this->error;
        } else {
            return true;
        }
    }
    
    /**
     * @method validateUserName     
     */
    public function validateUserName()
    {
        if(!preg_match("/(^[a-z]{1,20})(?!\s)([\w-\.]{0,20}$)/i",  $this->user->getUser())){                    
            $this->error->setError('The UserName format is not valid');
        }        
    }
    
    public function validatePassword()
    {
        $password = $this->user->getPassword();
        if(empty($password)) {
            $this->error->setError('the password must not be empty');            
        }
    }
    
    public function validateEstatus()
    {
        $estatus = $this->user->getEstatus();
        if(empty($estatus)) {
            $this->error->setError('the Estatus must not be empty');            
        }         
    }    
    
    public function validateRol()
    {
        $estatus = $this->user->getRol();
        if(empty($estatus)) {
            $this->error->setError('the Rol must not be empty');            
        }         
    }   
    
    /**
     *
     * @return Error 
     */
    public function getError()
    {
        return $this->error;
    }
    
}
?>
