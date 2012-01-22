<?php
error_reporting(E_ALL);
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
     * @var PDO 
     */
    private $db;
    
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
    public function login()
    {
        // aca verificamos que el usuario haya escrito en un formato que comience con letras y pueda estar seguido de un punto, guion bajo o guion 
        if(preg_match("/(^[a-z]{1,20})(?!\s)([\w-\.]{0,20}$)/i",  $this->getUsuario())){
            $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND password = :password";
            try {
                // hacemos la consulta
                $query = $this->db->prepare($sql);            
                $query->bindParam(':usuario', $this->getUsuario());
                $query->bindParam(':password', $this->getPassword());
                $query->execute();
                $row = $query->fetchObject();
                //verificamos que el usuario exista en la base de datos y la password sea correcta
                if(!empty($row)) {                                                                                  
                    $this->setRol($row->rol);
                    /*podemos pasar el estatus para que se haga la verificacion
                    * e ingrese a una pagina para usuarios deshabilitados, 
                    * para darle motivos e incluso donde comunicarse, 
                    *                            
                    */                        
                    $this->setEstatus($row->estatus);
                        
                    /* o podemos incluirlo en los errores, de manera que no haga login
                    if($row->estatus == "habilitado") {
                        $this->setRol($row->rol);                                                                 
                    } else {
                        $this->setError ('userEstatus', 'El Usuario no esta habilitado');
                    }*/                          
                    
                } else {
                    $this->setError('errorLogin', 'El Usuario o la Contraseña no es Correcta');
                }    
            
             } catch( PDOException $e) {
                 $e->getMessage();
             }                     
        } else {
            $this->setError('erroFormato', 'Formato de usuario no permitido');
        }   
    }
}

try {
    $db = new PDO('mysql:host=localhost; dbname=prueba', 'root', '123');   
} catch(PDOException $e) {
   echo $e->getMessage();
}
$class = new Usuarios($db);
$class->setUsuario('carlos');
$class->setPassword('123456');
$class->login();
if(count($class->getError()) == 0) {
    echo "<pre>";
    print_r($class);
    echo "</pre>";
} else {
    print_r($class->getError());
}
?>