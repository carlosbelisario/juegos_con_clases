<?php
namespace \Juegos_con_clase\Usuarios;

/**
 * Clase para manegar a los Usuarios
 *
 * @author Carlos Belisario <carlosbelisario.com>
 */
class UsuariosManager implements UsuariosManagerInterface
{
    /**
     *
     * @var PDO $db
     */
    private $db;
    
    /**
     * 
     * @var Array $error
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
    
    public function registro(Usuarios $usuario)
    {        
    }
    
    public function editar(Usuarios $usuario)
    {        
    }
    
    public function borrar($usuario)
    {        
    }
    
    /**
     * 
     * @method login para gestionar el login de los usuarios
     * @param Usuarios $usuario
     * @return Usuarios 
     */
    public function login(Usuarios $usuario)
    {
        // aca verificamos que el usuario haya escrito en un formato que comience con letras y pueda estar seguido de un punto, guion bajo o guion 
        if(preg_match("/(^[a-z]{1,20})(?!\s)([\w-\.]{0,20}$)/i",  $this->getUsuario())){            
            try {
                $row = $this->findBy(
                        array('usuario' => $usuario->getUsuario(),
                              'password' => $usuario->getPassword())
                );
                //verificamos que el usuario exista en la base de datos y la password sea correcta
                if(!empty($row)) {                                                                                  
                    $usuario->setRol($row->rol);
                    /*podemos pasar el estatus para que se haga la verificacion
                    * e ingrese a una pagina para usuarios deshabilitados, 
                    * para darle motivos e incluso donde comunicarse, 
                    *                            
                    */                        
                    $usuario->setEstatus($row->estatus);
                        
                    /* o podemos incluirlo en los errores, de manera que no haga login
                    if($row->estatus == "habilitado") {
                        $usuario->setRol($row->rol);                                                                 
                    } else {
                        $this->setError ('userEstatus', 'El Usuario no esta habilitado');
                    }*/                          
                    
                } else {
                    $usuario->setError('errorLogin', 'El Usuario o la Contraseña no es Correcta');
                }                
             } catch(Exception $e) {
                 $e->getMessage();
             }                     
        } else {
            $usuario->setError('erroFormato', 'Formato de usuario no permitido');
        }   
        return $usuario;
    }
    
    /**
     *
     * @return Array de Usuarios 
     */
    public function find()
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
    public function findBy(array $criterio)
    {
        foreach($criterio as $K => $v) {
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
}
?>