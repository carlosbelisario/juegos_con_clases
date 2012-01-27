<?php
//namespace JuegosConClase\User;
require_once 'UserManagerInterface.php';
require_once 'User.php';

/**
 * 
 * Class for the user manager
 *
 * @author Carlos Belisario <carlosbelisario.com>
 */
class UserManager implements UserManagerInterface
{
    /**
     *
     * @var PDO $db
     */
    private $db;    
    
    /**
     *
     * @param PDO $db 
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }        
    
    public function editUser(User $user, $id)
    {        
    }
    
    public function delete($user) {        
    }    
    /**
     * 
     * @method login for the auth the user
     * @param User $user
     * @return User 
     */
    public function login(User $user)
    {
        //aca verificamos que el usuario haya escrito en un formato que comience con letras y pueda estar seguido de un punto, guion bajo o guion 
        if(preg_match("/(^[a-z]{1,20})(?!\s)([\w-\.]{0,20}$)/i",  $user->getUser())){            
            try {
                $row = $this->findUserBy(
                    array(
                        'user' => $user->getUser(),
                        'password' => $user->getPassword(),
                 ));
                //verificamos que el usuario exista en la base de datos y la password sea correcta
                if(!empty($row)) {                           
                    $user->setRol($row[0]->rol);
                    /*podemos pasar el estatus para que se haga la verificacion
                    * e ingrese a una pagina para usuarios deshabilitados, 
                    * para darle motivos e incluso donde comunicarse, 
                    *                            
                    */                        
                    $user->setEstatus($row[0]->estatus);
                        
                    /* o podemos incluirlo en los errores, de manera que no haga login
                    if($row->estatus == "habilitado") {
                        $usuario->setRol($row->rol);                                                                 
                    } else {
                        $this->setError ('userEstatus', 'El Usuario no esta habilitado');
                    }*/                          
                    
                } else {
                    $user->setError('errorLogin', 'El Usuario o la Contraseña no es Correcta');
                }                
             } catch(Exception $e) {
                echo "<pre>" . $e->getMessage() . "</pre>";
             }                     
        } else {
            $user->setError('erroFormato', 'Formato de usuario no permitido');
        }   
        return $user;
    }
    
    /**
     *
     * @return Array de Usuarios 
     */
    public function findUser()
    {
        $sql = "SELECT * FROM usuarios";
        try {
            $query = $this->db->prepare($sql);
            $query->execute();
            while($row = $query->fetchObject()) {
                $rowUsuarios[] = $row;
            }
            return $rowUsuarios;
            
        } catch(PDOException $e) {
            echo "<pre>" . $e->getMessage() . "</pre>";
        }            
    }
    
    /**
     *
     * @param Array $criterio
     * @return Array de Usuarios 
     */
    public function findUserBy(array $criterio)
    {
        foreach($criterio as $k => $v) {
            $fields[] = "$k = ?";
            $values[] = $v;
        }
        $sql = "SELECT * FROM usuarios WHERE " . implode(" AND ", $fields);
        try {
            $query = $this->db->prepare($sql);
            $query->execute($values);
            while($row = $query->fetchObject()) {
                $rowUsuarios[] = $row;
            }
        } catch (PDOException $e) {            
            echo "<pre>" . $e->getMessage() . "</pre>";
        }      
        return $rowUsuarios;
    }    
    public function addUser(User $user) {
        try {
            $validador = new ValidateUser($user);
        } catch(Exception $e) {
            
        }
    }
    
}
$userManager = new UserManager(new PDO('mysql:host=localhost; dbname=prueba', 'root', '123'));
$user = new User();
$user->setUser('carlos');
$user->setPassword('123456');
$login = $userManager->login($user);
echo "<pre>";
var_dump($login);
echo "</pre>";
?>