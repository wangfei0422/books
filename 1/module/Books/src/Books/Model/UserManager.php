<?php
//
// +------------------------------------------------------------------------+
// | PHP Version 5                                                          |
// +------------------------------------------------------------------------+
// | ���ߣ�����                                                             |
// +------------------------------------------------------------------------+
// | ���ļ���powerdesigner���ɣ���ԭ�汾��������������������:               |
// | 1 �����������ռ�֧��                                                   |
// | 2 ������settor��gettor֧��                                             |
// +------------------------------------------------------------------------+
// | ʱ�䣺2016��5��                                                       |
// +------------------------------------------------------------------------+
//


/**
* @author       WANGMENG
*/

namespace Books\Model;
use		Zend\Session\Container;


class UserManager{
    
    /**
    * @var      UserManager
    */
    private $container;    
    
        
    
    /**
    * @return   void
    */
    public function __construct(){
     	$this->container=new Container("books");
    }
    
    /**
    * @return   User
    */
    public function getCurrUser(){
		global $g;
		$userTable=$g["App"]->getServiceManager()->get("Books\Model\TableManager")->getTable("User");
		$user=null;
		if(isset($this->container["CurrUser"])){
			$user=$userTable->get($this->container["CurrUser"]);
			if($user==null) $this->container->getManager()->destroy();
		}
		return $user;
    }
    
    /**
    * @param    User $user    
    * @return   boolean
    */
    public function logIn(User $user){
		global $g;
		$pk=$g["App"]->getServiceManager()->get("Books\Model\TableManager")->getTable("User")->getPk();
		$this->container["CurrUser"]=$user[$pk];
    }
    
    /**
    * @return   boolean
    */
    public function logOut(){
     	//$this->container->getManager()->destroy();
		unset($this->container["CurrUser"]);
    }
    
    /**
    * @return   boolean
    */
    public function isLogged(){
     	if($this->getCurrUser()!=null) return true;
		return false;
    }    
    
    
    

    

}


?>