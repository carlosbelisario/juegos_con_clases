<?php
namespace \Juegos_con_clase\Usuarios;
/**
 * 
 * clase para gestionar Usuarios
 * @author Carlos Belisario <carlosbelisario.com>
 * @version 1.0
 * 
 */
class Usuarios
{
    /**
     * 
     * @var String $usuario
     */
    private $usuario;
    
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
    
    public function __construct(PDO $db) 
    {
        $this->db = $db;
    }

        /**
     * 
     * Getter and Setter
     */
    public function getUsuario() 
    {
        return $this->usuario;
    }
    
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function setPassword($password, $salt = true)
    {
        if($salt)
            $this->password = md5($this->getUsuario().$password.$this->getSecuritySalt());
        else
            $this->password = md5($this->getUsuario().$password);
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
    
    /**
     * 
     * @method login
     * metodo para autnetificar al usuario
     * 
     */
    
}
?>