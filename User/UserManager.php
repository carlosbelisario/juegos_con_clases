<?php
namespace juegos_con_clase\User;
use \PDO;
use juegos_con_clase\error\Error as Error;
require_once '../Error.php';
require_once 'UserManagerInterface.php';
require_once 'User.php';
require_once 'UserValidate.php';

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
     * @var Error 
     */
    private $error;

    /**
     *
     * @param PDO $db 
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->error = new Error();
    }        
    
    public function editUser(User $user, $id)
    {       
        try {
            //validamos el formato de usuario y que el objeto este lleno
            $validador = new UserValidate($user, 
                    array('validateUserName',
                          'validatePassword',
                          'validateEstatus',
                          'validateRol',
                    ));            
            if(!is_object($validador->isValid())){                
                $exist = $this->findUserBy(array(
                   'user' => $user->getUser() 
                ));                
                if(count($exist) == 0) {
                    $this->error->setError('The User is not register in the data'); 
                    return $this->error;
                } else {
                    $sql = "UPDATE 
                                usuarios 
                            SET user = ?,
                                password = ?,
                                estatus = ?,
                                rol = ?
                            WHERE 
                                user = ?";
                    $query = $this->db->prepare($sql);
                    $query->execute(array(
                        $user->getUser(),
                        $user->getPassword(),
                        $user->getEstatus(),
                        $user->getRol(),
                        $id
                    ));
                    return true;
                }
            } else {
                return $validador->getError();
            }
        } catch(\PDOException $e) {
            echo "<pre>";
            $e->getMessage();
            echo "</pre>";
        }
    }
     /**
      * @method delete delete the user for the data
      * @param String $user 
      */
    public function delete($user) {        
        try {
            $exist = $this->findUserBy(array(
                'user' => $user
             ));                
            if(count($exist) == 0) {
                $this->error->setError('The User is not register in the data'); 
                return $this->error;
            } else {
                $sql = "DELETE FROM usuarios WHERE user = '$user'";
                $query = $this->db->query($sql);
                $query->execute();
                return true;
            }
        } catch(\PDOException $e) {
            echo "<pre>";
            echo $e->getMessage();
            echo "</pre>";
        }
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
        try {
            $userValidate = new UserValidate($user, array('validateUserName', 'validatePassword'));
            if(!is_object($userValidate->isValid())) {
                $row = $this->findUserBy(
                    array(
                    'user' => $user->getUser(),
                    'password' => $user->getPassword(),
                ));
                //verificamos que el usuario exista en la base de datos y la password sea correcta
               if(!empty($row)) {                           
                   User::$logged = true;
                   $user->setRol($row[0]->rol);
                        /*podemos pasar el estatus para que se haga la verificacion
                        * e ingrese a una pagina para usuarios deshabilitados, 
                        * para darle motivos e incluso donde comunicarse, 
                        *                            
                        */                        
                   $user->setEstatus($row[0]->estatus);                       

                } else {
                   $user->setError('errorLogin', 'El Usuario o la Contraseña no es Correcta');
                }                
            } else {
                return $userValidate->getError();
            }    
        } catch(Exception $e) {
           echo "<pre>" . $e->getMessage() . "</pre>";
        }                             
        return $user;
    }
    
    /**
     * @method findUser list all user of the data
     * @return Array of User
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
     * @method findUserBy list the user for a critery
     * @param Array $criterio
     * @return Array of Users
     */
    public function findUserBy(array $critery)
    {        
        foreach($critery as $k => $v) {
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
  
    /**
     * @method addUser for add the user in the data
     * @param User $user 
     * @return bool/object true if successful / object Error 
     */
    public function addUser(User $user) {
        try {
            //validamos el formato de usuario y que el objeto este lleno
            $validador = new UserValidate($user, 
                    array('validateUserName',
                          'validatePassword',
                          'validateEstatus',
                          'validateRol',
                    ));
            if(!is_object($validador->isValid())){
                //creamos la query para el prepare statement
                $sql = "INSERT INTO usuarios(
                            user, 
                            password, 
                            estatus, 
                            rol)
                         VALUES(?, ?, ?, ?)";                          
                $query = $this->db->prepare($sql);
                $query->execute(
                    array(
                        $user->getUser(),
                        $user->getPassword(),
                        $user->getEstatus(), 
                        $user->getRol(),
                   ));            
                return true;
            } else {
                return $validador->getError();
            }
            
        } catch(\PDOException $e) {
           echo "<pre>";
           echo $e->getMessage();
           echo "</pre>";
        }
    }
    
}
/*
pruebas realizadas sobre las clases, solo back-end el front-end son formularios sencillos
test of the class, only back-end 
 
  $pdo = new PDO('mysql:host=localhost; dbname=prueba', 'root', '123');
 
$userManager = new UserManager($pdo);
 
$user = new User();
$user->setUser('carlos');
$user->setPassword('123456');
$user->setEstatus('habiltado');
$user->setRol('Admin');
$l = $userManager->editUser($user, 'carlos');
//$l = $userManager->addUser($user);
//$login = $userManager->login($user);
echo $l->__toString();
/*echo "<pre>";
var_dump($login);

 * echo "</pre>";
 */
?>