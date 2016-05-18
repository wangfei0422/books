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
use		Books\Model\HelperFunctions;
use		Books\Model\ConfigManager;
use		Books\Model\TableManager;
use		Books\Model\UserManager;
use		Books\Model\User;
use		Zend\EventManager\EventManagerInterface;
use		Zend\ServiceManager\ServiceLocatorInterface;
use		Zend\Mvc\Controller\AbstractActionController;

class Controller extends AbstractActionController{
    
    /**
    * @var      ServiceLocatorInterface
    */
    protected $sm;
    
    /**
    * @var      UserManager
    */
    protected $um;
    
    /**
    * @var      TableManager
    */
    protected $tm;
    
    /**
    * @var      ConfigManager
    */
    protected $cm;
    
    /**
    * @var      HelperFunctions
    */
    protected $hf;
    
    /**
    * @var      User
    */
    protected $u;    

    /**
    * @var      array
    */
    protected $data=[];
    
    /**
    * @param    ServiceLocatorInterface $v    
    * @return   void
    */
    public function setSm(ServiceLocatorInterface $v){
     	$this->sm=$v;
    }
    
    /**
    * @param    EventManagerInterface $v    
    * @return   void
    */
    public function setEm(EventManagerInterface $v){
     	$this->em=$v;
    }
    
    /**
    * @param    UserManager $v    
    * @return   void
    */
    public function setUm(UserManager $v){
     	$this->um=$v;
    }
    
    /**
    * @param    TableManager $v    
    * @return   void
    */
    public function setTm(TableManager $v){
     	$this->tm=$v;
    }
    
    /**
    * @param    ConfigManager $v    
    * @return   void
    */
    public function setCm(ConfigManager $v){
     	$this->cm=$v;
    }
    
    /**
    * @param    HelperFunctions $v    
    * @return   void
    */
    public function setHf(HelperFunctions $v){
     	$this->hf=$v;
    }
    
    /**
    * @param    User $v    
    * @return   void
    */
    public function setU(User $v){
     	$this->u=$v;
    }    
    
    /**
    * @param    array $v    
    * @return   void
    */
    public function setData($v){
     	$this->data=$v;
    }    
    

    

}


?>