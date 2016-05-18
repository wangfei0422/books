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
class Book extends EntityBase implements InputFilterAwareInterface{        
    
	const DEFAULT_PLEDGE=10;
	
    /**
    * @return   void
    */
    public function __construct(){
     	parent::__construct();
		//设置默认值
		$this["type"]		=	"default";
		$this["sub_type"]	=	"default";
		$this["name"]		=	"no name";
		$this["thumb_image"]=	"default_thumb_image";
		$this["big_image"]	=	"default_big_image";
		$this["id_user"]	=	-1;
		$this["description"]=	"no description yet";
		$this["pledge"]		=	self::DEFAULT_PLEDGE;
		$this["pledgeExpireTime"]	=	date($this->datetimeFormat);
		$this["whoWantBook"]		=	-1;
		$this["pledged"]			=	false;
		
		//FK 指向本表PK的表
		$this->tablesFkToMe=array("BorrowedRecord");
    }
    
    /**
    * @return   boolean
    */
    public function isWaitingPledge(){
		$whoWantBook=$this->tm->getTable("User")->get($this["whoWantBook"]);
		$notExpired=$this->hf->dateNewer($this[$pledgeExpireTime]);
     	if($this["pledged"]==false && !is_null($whoWantBook) && $notExpired)return true;
		return false;
    }
    
    /**
    * @return   boolean
    */
    public function isBorrowed(){
		if(is_null($this->getCurrUser()))return false;
		return true;
    }
    
    /**
    * @param    User $userWhoPledge    
    * @param    int $daysWanted    
    * @return   boolean
    */
    public function borrow(User $userWhoPledge, $daysWanted){
		$r=new BorrowedRecord();
		$r["id_user"]		=	$this["whoWantBook"];
		$r["id_book"]		=	$this["id_book"];
		$r["borrow_date"]	=	date($this->datetimeFormat);;
		$r["borrow_days"]	=	$daysWanted;
		$r["return_date"]	=	$r["borrow_date"];
		$r["whoPayPledge"]	=	$userWhoPledge["id_user"];
		$r->save();
		
     	$this["pledgeExpireTime"]=date($this->datetimeFormat);
		$this["pledged"]=true;
		$this->save();
    }
    
    /**
    * @return   boolean
    */
    public function return(){
		$r=$this->getCurrRecord();
		if(is_null($r))return true;
		$r["return_date"]=date($this->datetimeFormat);
		$r->save();
		return true;
    }

    /**
    * @return   User
    */
    public function getCurrUser(){
     	if(is_null($this->getCurrRecord()))return null;
		return $this->tm->getTable("User")->get($this["id_user"]);
    }
    
    /**
    * @return   BorrowedRecord
    */
    public function getCurrRecord(){
     	$records=$this->tm->getTable("BorrowedRecord")->fetchAllForEntity($this);
		foreach($records as $record){
			if(!$record->isReturned())return $record;
		}
		return null;
    }
	
    /**
    * @return   Object
    */
    public function getFeedbacks(){
     	$temp=array();
		$records=$this->getBorrowedRecords();
		foreach($records as $record){
			$feedbacks=$record->getFeedbacks();
			foreach($feedbacks as $feedback) $temp[]=$feedback;
		}
		return $temp;
    }
    
    /**
    * @return   int
    */
    public function getLeftDays(){
     	return $this->getCurrRecord()->getLeftDays();
    }
    
    /**
    * @return   User
    */
    public function getUserWhoWant(){
     	return $this->tm->getTable("User")->get($this["whoWantBook"]);
    }
    
    /**
    * @return   User
    */
    public function getUserWhoPledge(){
		$r=$this->getCurrRecord();
     	if(is_null($r))return null;
		return  $this->tm->getTable("User")->get($this["whoPayPledge"]);
    }
    
    /**
    * @return   array
    */
    public function getBorrowedRecords(){
     	return $this->tm->getTable("BorrowedRecord")->fetchAllForEntity($this);
    }
    
    /**
    * @return   boolean
    */
    public function saveForIdleStatus(){
     	$this["whoWantBook"]=-1;
		$this["pledgeExpireTime"]=date($this->datetimeFormat);
		$this["pledged"]=false;
		$this-save();
    }
    
    /**
    * @param    User $user    
    * @return   boolean
    */
    public function saveForWaitingPledgeStatus(User $user){
     	$this["whoWantBook"]=$user["id_user"];
		$this["pledgeExpireTime"]=date($this->datetimeFormat);
		$this["pledged"]=false;
		$this-save();
    }    

    /**
    * @return   int
    */
    public function getAverageStar(){
     	$feedbacks=$this->getFeedbacks();
		$temp=array();
		foreach($feedbacks as $feedback)$temp[]=$feedback["star"];
		if(empty($temp))return 0;
		$aveStar=(float)array_sum($temp)/count($temp);
		return round($aveStar);
    }
    
    /**
    * @return   int
    */
    public function getBorrowCount(){
     	return count($this->getBorrowedRecords());
    }    
	
    /**
    * @param    InputFilterInterface $inputFilter    
    * @return   void
    */
    public function setInputFilter(InputFilterInterface $inputFilter){
     	// TODO: implement
    }
    
    /**
    * @return   Zend.InputFilter.InputFilterInterface
    */
    public function getInputFilter(){
     	// TODO: implement
    }
    
    

    

}


?>