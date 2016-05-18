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
use		Zend\InputFilter\InputFilter;
use		Zend\InputFilter\InputFilterInterface;

use		Zend\InputFilter\InputFilterAwareInterface;
class User extends EntityBase implements InputFilterAwareInterface{        
    
	const MANAGER_BIT_START=0;
	const MANAGER_BIT_LEN=1;
	const USER_TYPE_BIT_START=1;
	const USER_TYPE_BIT_LEN=5;

	const TYPE_DEFAULT=0;
	const TYPE_SENIOR=1;
	const DEFAULT_BORROW_DAYS=2;
	
    /**
    * @return   void
    */
    public function __construct(){
     	parent::__construct();
		//设置默认值
		$this["name"]="not set";
		$this["type"]=1;		//非管理员   普通用户  | 管理员   大四用户  | 
		$this["head_image"]="";
		$this["qq_number"]="00000000";
		$this["mail"]	=	"default@books.com";
		$this["pw"]		=	"";
		
		//FK 指向本表PK的表
		$this->tablesFkToMe=array("Book","Article","BorrowedRecord","BookFeedback","ArticleFeedback","Log");
    }
    
    /**
    * @param    mixed $user    
    * @param    boolean $senior    
    * @return   boolean
    */
    public function setSenior($user, $senior=true){
     	if(is_bool($user)){
			$senior=$user;
			$user=$this;
		}
		$maskValue=self::TYPE_DEFAULT;
		if($senior)$maskValue=TYPE_SENIOR; 
		$user["type"]=$this->hf->setMaskValue(self::USER_TYPE_BIT_START,self::USER_TYPE_BIT_LEN,$user["type"],$maskValue);
		$user->save();
		return true;
    }
    
    /**
    * @param    mixed $user    
    * @param    boolean $manager    
    * @return   boolean
    */
    public function setManager($user, $manager=true){
     	if(is_bool($user)){
			$manager=$user;
			$user=$this;
		}
		$maskValue=1;
		if($manager)$maskValue=0;				//零是管理员
		$user["type"]=$this->hf->setMaskValue(self::MANAGER_BIT_START,self::MANAGER_BIT_LEN,$user["type"],$maskValue);
		$user->save();
		return true;
    }
    
    /**
    * @param    EntityBase $entity    
    * @param    boolean $verified    
    * @return   boolean
    */
    public function verify(EntityBase $entity, $verified=true){
     	if(is_bool($entity)){
			$verified=$entity;
			$$entity=$this;
		}
		$entity->setVerify($verified);
    }
	
    /**
    * @return   boolean
    */
    public function isSenior(){
		$maskValue=$this->hf->getMaskValue(self::USER_TYPE_BIT_START,self::USER_TYPE_BIT_LEN,$this["type"]);
		if($maskValue==self::TYPE_SENIOR)return true;
		return false;
    }
    
    /**
    * @return   boolean
    */
    public function isManager(){
		$maskValue=$this->hf->getMaskValue(self::MANAGER_BIT_START,self::MANAGER_BIT_LEN,$this["type"]);
		if($maskValue ==0)return true;
		return false;
    }
    
    /**
    * @return   Object
    */
    public function getBooks(){
		$table=$this->tm->getTable("Book");
		return $table->fetchAllForEntity($this);
    }
    
    /**
    * @return   Object
    */
    public function getArticles(){
     	$table=$this->tm->getTable("Article");
		return $table->fetchAllForEntity($this);
    }
    
    /**
    * @param    Book $book    
    * @return   boolean
    */
    public function borrowBookRequest(Book $book){
     	if($book->isBorrowed()) return false;
		if($book->isWaitingPledge())return false;
		$book->saveForWaitingPledgeStatus($this);
		return true;
    }

    /**
    * @param    Book $book    
    * @return   boolean
    */
    public function borrowBookCancel(Book $book){
     	$book->saveForIdleStatus();
		return true;
    }
	
    /**
    * @return   Object
    */
    public function getBooksWaitingToPledge(){
		$field="whoWantBook";
		$field_v=$this["id_user"];
		$books=$this->tm->getTable("Book")->fetchAll("",array($field => $field_v));
		$temp=array();
		foreach($books as $book){
			if($book->isWaitingPledge())$temp[]=$book;
		}
		return $temp;
    }
    
    /**
    * @param    Book $book    
    * @return   boolean
    */
    public function payPledge(Book $book){
		if($book->isWaitingPledge()){
			$book->borrow($this,self::DEFAULT_BORROW_DAYS);	
			return true;
		}
		return false;
    }
    
    /**
    * @param    Event $e    
    * @return   Object
    */
    private function onPaySucess($e){
     	// TODO: implement
    }
    
    /**
    * @param    Event $e    
    * @return   Object
    */
    private function onPayFail($e){
     	// TODO: implement
    }
    
    /**
    * @param    Book $book    
    * @return   boolean
    */
    public function returnBook(Book $book){
     	if($book->isBorrowed()){
			$book->return();
			return true;
		}
		return false;
    }
    
    /**
    * @return   Object
    */
    public function getBooksBorrowed(){
		$borrowRecords=$this->tm->getTable("BorrowedRecord")->fetchAllForEntity($this);
		$books=array();
		foreach($borrowRecords as $record){
			$book_id=$record["id_book"];
			if(!isset($books[$book_id])){
				$book=$record->getBook();
				$books[$book_id]=$book;
			}
			$books[$book_id]["extension"]["records"][]=$record;
		}
		return array_values($books);
    }
    
    /**
    * @return   Object
    */
    public function getBooksCurrBorrowed(){
		$borrowRecords=$this->tm->getTable("BorrowedRecord")->fetchAllForEntity($this);
		$books=array();
		foreach($borrowRecords as $record){
			if(!$record->isReturned()){
				$book=$record->getBook();
				$book["extension"]["record"]=$record;
				$books[]=$book;
			}
		}
		return $books;
    }
    
    /**
    * @param    int $days    
    * @return   Object
    */
    public function getBooksNeedToReturnWithinDays($days=0){
     	$books=$this->getBooksCurrBorrowed();
		if($days==0)return $books;
		$temp=array();
		foreach($books as $book){
			if($book["extension"]["record"]->getLeftDays()<=$days){
				$temp[]=$book;
			}
		}
		return $temp;
    }
    
    /**
    * @param    Object $message    
    * @return   boolean
    */
    public function log($message){
		$log=null;
     	if(is_string($message)){
			$log=new Log();
			$log["message"]=$message;
		}else if($message instanceof Log){
			$log=$message;
		}else{
			return false;
		}
		$log["id_user"]=$this["id_user"];
		$log["date"]=(new \DateTime())->format($this->datetimeFormat);
		$log->save();
		return true;
	}
    
    /**
    * @return   Object
    */
    public function getLogs(){
     	$table=$this->tm->getTable("Log");
		return $table->fetchAllForEntity($this);
    }
	
	private $inputFilter=null;
    /**
    * @param    InputFilterInterface $inputFilter    
    * @return   void
    */
    public function setInputFilter(InputFilterInterface $inputFilter){
     	$this->inputFilter=$inputFilter;
    }
    
    /**
    * @return   Zend.InputFilter.InputFilterInterface
    */
    public function getInputFilter(){
     	if(!$this->inputFilter){
			
			$inputFilter=new InputFilter();
 			$inputFilter->add(array(
				'name'		=>"id_user",
				'required'	=>true,
				'filters'	=>array(
					array('name'=>'Int'),
				),
			));
/* 			$inputFilter->add(
				'name'		=>"id_user",
				'required'	=>true,
				'filters'	=>array(
					array('name'=>'Int'),
				),
			);
			$inputFilter->add(
				'name'		=>"name",
				'required'	=>true,
				'filters'	=>array(
					array('name'=>'StringTrim',),
				),
				'validators'=>array(
					array(
						'name'=>'StringLeng',
						'options'=>array(
							'encoding'=>'UTF-8',
							'min'	  =>'1',
							'max'	  =>'32',
						),
					),
				),
			);
			
			$inputFilter->add(
				'name'		=>"pw",
				'required'	=>true,
				'filters'	=>array(
					array('name'=>'StringTrim',),
				),
				'validators'=>array(
					array(
						'name'=>'StringLeng',
						'options'=>array(
							'encoding'=>'UTF-8',
							'min'	  =>'1',
							'max'	  =>'32',
						),
					),
				),
			); */

			
			$this->inputFilter=$inputFilter;
		}
		return $this->inputFilter;
    }

}


?>