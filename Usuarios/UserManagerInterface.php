<?php
namespace JuegosConClase\User;

/**
 *
 * interface que gestiona los métodos de los usuarios
 * @author Carlos Belisario <carlosbelisario.com>
 */
interface UserManagerInterface 
{
    /**
     * 
     * @method addUser
     * method for add the user 
     * @param User $usuario
     */
    public function addUser(User $usuario);
    
    /**
     * 
     * @method editar
     * method for edit the data of the user register
     * @param Usuarios $usuario
     * @param String $usuario
     */
    public function editUser(User $user, $id);
    
    /**
     * 
     * @method delete
     * method for delete the data of the user
     * @param String $usuario
     */
    public function delete($user); 
    
    /**
     * 
     * @method login 
     * method for login of the user
     * @param Usuario $usuario
     */
    public function login(User $user);
    
    /**
     * @method find
     * method for find all user
     */
    public function findUser();
    
    /**
     * 
     * @method findBy
     * method to search for users by a standard criterion
     * @param Array $criterio
     */
    public function findByUser(array $criterio);        
    
}
?>
