<?php
namespace \Juegos_con_clase\Usuarios;

/**
 *
 * interface que gestiona los métodos de los usuarios
 * @author Carlos Belisario <carlosbelisario.com>
 */
interface UsuariosManagerInterface 
{
    /**
     * 
     * @method registro
     * metodo para registrar los usuarios
     * @param Usuarios $usuario
     */
    public function registro(Usuarios $usuario);
    
    /**
     * 
     * @method editar
     * metodo para editar usuario
     * @param Usuarios $usuario
     * @param String $usuario
     */
    public function editar(Usuario $usuario, $id);
    
    /**
     * 
     * @method borrar
     * metodo para borrar usuario
     * @param String $usuario
     */
    public function borrar($usuario); 
    
    /**
     * 
     * @method login 
     * @param Usuario $usuario
     */
    public function login(Usuario $usuario);
    
    /**
     * @method find
     * metodo para buscar usuarios     * 
     */
    public function find();
    
    /**
     * 
     * @method findBy
     * metodo para buscar a un usuario por un criterio
     * @param Array $criterio
     */
    public function findBy(array $criterio);        
    
}
?>
