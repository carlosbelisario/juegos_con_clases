<?php
namespace juegos_con_clase\User;
/**
 * 
 * class User for the data of the user
 * @author Carlos Belisario <carlosbelisario.com>
 * @version 1.0
 * 
 */
class User
{
    /**
     * 
     * @var String $user
     */
    private $user;
    
    /**
     * 
     * @var String $password
     */
    private $password;
    
    /**
     * 
     * @var String $rol
     */
    private $rol;
    
    /**
     * 
     * @var String $estatus
     */
    private $estatus;
    
    /**
     * 
     * @var String $securitySalt
     */
    private $securitySalt;

    /**
     *
     * @var String $error
     */
    private $error;


    /**
     *
     * @param PDO $db 
     */
    
    public function __construct() 
    {}

        /**
     * 
     * Getter and Setter
     */
    public function getUser() 
    {
        return $this->user;
    }
    
    public function setUser($user)
    {
        $this->user = $user;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword($password, $salt = true)
    {
        if($salt)
            $this->password = md5($this->getUser().$password.$this->getSecuritySalt());
        else
            $this->password = md5($this->getUser().$password);
    }
    
    public function getSecuritySalt()
    {
        return $this->securitySalt;
    }
    
    public function setSecuritySalt($securitySalt = 'heyntonwgrnkmoamju33mdowm')
    {
        $this->securitySalt = $securitySalt;
    }
    
    public function getRol()
    {
        return $this->rol;
    }
    
    public function setRol($rol)
    {
        $this->rol = $rol;
    }
    
    public function getEstatus()
    {
        return $this->estatus;
    }
    
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;        
    }
    
    public function getError()
    {
        return $this->error;
    }

    public function setError($k, $error)
    {
        $this->error[$k] = $error;
    }    
}
?>