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

use		Zend\Stdlib\ArrayObject;

class EntityBase extends ArrayObject{
    const VERIFY_BIT_MASK=0x1;
    /**
    * @var      mixed
    */
    protected $sm;
    
    /**
    * @var      mixed
    */
    protected $em;
    
    
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
    * @var      TableBase
    */
    private $table;    
    
    //settor for $this->table
    public function setTable($value){
       $this->table=$value;
    }
    
    //gettor for $this->table
    public function getTable(){
       return $this->table;
    }   

    /**
    * @return   void
    */
    public function __construct(){
     	global $g;
		$this->sm=$sm=$g["App"]->getServiceManager();
		$this->em=$sm->get("EventManager");
		$this->um=$sm->get("Books\Model\UserManager");
		$this->tm=$sm->get("Books\Model\TableManager");
		$this->cm=$sm->get("Books\Model\ConfigManager");
		
    }
    
    /**
    * @param    mixed $data    
    * @return   void
    */
    public function exchangeArray($data){
		$this->storage=array();
		foreach($data as $field => $value){
			$this->storage[$field]=$value;			
		}
    }
    
    /**
    * @return   array
    */
    public function getArrayCopy(){
     	return $this->storage;
    }
    
    /**
    * @return   boolean
    */
    public function isVerified(){
     	if(!isset($this["status"]))return true;						//���û��status�ֶΣ���������֤��
		if($this["status"] & self::VERIFY_BIT_MASK ==1)return true;
		return false;
    }
    
    /**
    * @return   boolean
    */
    public function delete(){
		$pk=$this->table->getPk();
     	return $this->table->delete($this[$pk]);
    }
    
    /**
    * @return   boolean
    */
    public function save(){
		$pk=$this->table->getPk();
		if(!isset($this[$pk]))$this[$pk]=0;
     	return $this->table->save($this->storage);
    }
    
    /**
    * @return   User
    */
    public function getUser(){
		$userTable=$this->tm->getTable("User");
		$userTablePk=$userTable->getPk();
     	if(isset($this[$userTablePk])){
			if($this->table->getTableGateway()->getTable() == "User") return $this;
			return $userTable->get($this[$userTablePk]);
		}
		return null;
    }    
    
    
    

    

}


?>