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
	const VERIFY_BIT_START=0;
	const VERIFY_BIT_LEN=1;
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
    * @var      HelperFunctions
    */
    protected $hf;
	
    /**
    * @var      TableBase
    */
    private $table;    

    /**
    * @var      array
    */
    protected $tablesFkToMe=array();
	
    /**
    * @var      string
    */ 	
	protected $datetimeFormat="Y-m-d H:i:s";
	
    //settor for $this->table
    public function setTable($value){
       $this->table=$value;
    }
    
    //gettor for $this->table
    public function getTable(){
	   if($this->table==null){
			$table=preg_split("/Books\\\\Model\\\\/",static::class);
			if(isset($table[1])){
				$this->setTable($this->tm->getTable($table[1]));
			}else{
				return null;
			}		
	   }
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
		$this->hf=$sm->get("Books\Model\HelperFunctions");
		
		$this["status"]=1;											//Ĭ��״̬�Ѿ���֤,ûstatus�������Ҫunset���ֶ�
		//$pk=$this->getTable()->getPk();							//��ʱ�����ܵ��ô˺��������������δ��ƴ�����
		//$this[$pk]=0;												//Ĭ������Ϊ�㣬����������Ҫ���ô˼�ǰ�ַ���

    }

    /**
    * @param    boolean $verified    
    * @return   boolean
    */
    public function setVerify($verified=true){
     	if(!isset($this["status"]))return true;						//���û��status�ֶΣ����������á�
		$maskValue=0;
		if($verified)$maskValue=1; 
		$this["status"]=$this->hf->setMaskValue(self::VERIFY_BIT_START,self::VERIFY_BIT_LEN,$this["status"],$maskValue);
		$user->save();
		return true;
    }
	
    /**
    * @param    mixed $data    
    * @return   void
    */
    public function exchangeArray($data){
		if(!is_array($this->storage))$this->storage=array();
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
		$maskValue=$this->hf->getMaskValue(self::VERIFY_BIT_START,self::VERIFY_BIT_LEN,$this["status"]);
		if($maskValue==1)return true;
		return false;
    }
    
    /**
    * @return   boolean
    */
    public function delete(){
		$this->tm->deleteWith($this->tablesFkToMe,$this);
		$pk=$this->getTable()->getPk();
     	return $this->getTable()->delete($this[$pk]);
    }
    
    /**
    * @return   boolean
    */
    public function save(){
		$pk=$this->getTable()->getPk();
		$temp=$this->getArrayCopy();
		if(isset($temp["extension"]))unset($temp["extension"]);
		if(!isset($temp[$pk]))$temp[$pk]=0;
		//var_dump($temp);
		//exit();
     	return $this->getTable()->save($temp);
    }
    
    /**
    * @return   User
    */
    public function getUser(){
		$userTable=$this->tm->getTable("User");
		$userTablePk=$userTable->getPk();
     	if(isset($this[$userTablePk])){
			if($this->getTable()->getTableGateway()->getTable() == "User") return $this;
			return $userTable->get($this[$userTablePk]);
		}
		return null;
    }    

}


?>