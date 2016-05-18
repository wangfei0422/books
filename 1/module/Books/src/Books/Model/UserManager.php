<?php
//
// +------------------------------------------------------------------------+
// | PHP Version 5                                                          |
// +------------------------------------------------------------------------+
// | 作者：王梦                                                             |
// +------------------------------------------------------------------------+
// | 类文件由powerdesigner生成，在原版本基础上增加了以下属性:               |
// | 1 增加了命名空间支持                                                   |
// | 2 增加了settor和gettor支持                                             |
// +------------------------------------------------------------------------+
// | 时间：2016年5月                                                       |
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