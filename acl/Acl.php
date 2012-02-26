<?php
require_once '../libs/spyc-0.5/spyc.php';
require_once '../session/Session.php';
require_once '../User/User.php';
use \session\Session as session;
use juegos_con_clase\User\User;

/**
 * Description of Acl
 *
 * @author Carlos Belisario
 */
class Acl 
{
    /**
     *
     * @var array $roles 
     */
    private $roles;
    
    /**
     *
     * @var User $user 
     */
    private $user;
    
    /**
     *
     * @var session
     */
    private $session;
    
    /**
     *
     * @param User $user 
     */
    public function __construct(User $user) 
    {
        $this->roles = Spyc::YAMLLoad('roles.yml');
        $this->session = new session();
        $this->user = $user;        
    }
    
    /**
     * @param string type user
     * @return array  
     */
    public function getRoles()
    {
        return $this->roles[$this->user->getRol()];
    }    
}