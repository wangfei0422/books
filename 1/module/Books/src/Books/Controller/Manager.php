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

namespace Books\Controller;
use		Zend\ServiceManager\ServiceLocatorInterface;

use		Zend\ServiceManager\AbstractFactoryInterface;
class Manager implements AbstractFactoryInterface{            
    
    /**
    * @var      array
    */
    private $controllers=array("Index","User","Book","Article","BookFeedback","ArticleFeedback");
	
    /**
    * @param    ServiceLocatorInterface $serviceLocator    
    * @param    string $name    
    * @param    string $requestedName    
    * @return   boolean
    */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName){
		$c=preg_split("/Books\\\\Controller\\\\/",$requestedName);
		if(isset($c[1])){
			$c=$c[1];
		}else{
			return false;
		}
		if(in_array($c,$this->controllers))return true;
		return false;
    }
    
    /**
    * @param    ServiceLocatorInterface $serviceLocator    
    * @param    string $name    
    * @param    string $requestedName    
    * @return   mixed
    */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName){
		if(!$this->canCreateServiceWithName($serviceLocator,$name,$requestedName))return null;
		$class="\\".$requestedName."Controller";
     	$c=new $class();
		global $g;
		$sm=$g["App"]->getServiceManager();
		$serviceLocator->injectControllerDependencies($c,$serviceLocator);
		if($c instanceof Controller){
			$c->setSm($sm);
			$c->setEm($sm->get("EventManager"));
			$c->setUm($sm->get("Books\Model\UserManager"));
			$c->setTm($sm->get("Books\Model\TableManager"));
			$c->setCm($sm->get("Books\Model\ConfigManager"));
			$c->setHf($sm->get("Books\Model\HelperFunctions"));
			$u=$sm->get("Books\Model\UserManager")->getCurrUser();
			if(!is_null($u))	$c->setU($u);
			$c->setData(array(
				"u"=>$u,
				"status"=>array(
					"sucess"=>true,
					"message"=>"You are sucessful for executing the action.This is the default message.",
				),
			));
		}
		return $c;
    }
    
    

    

}


?>