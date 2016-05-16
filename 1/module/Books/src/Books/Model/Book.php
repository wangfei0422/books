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
		$this["pledgeExpireTime"]	=	\DateTime()->format($this->datetimeFormat);
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
     	// TODO: implement
    }
    
    /**
    * @param    User $userWhoPledge    
    * @param    int $daysWanted    
    * @return   boolean
    */
    public function borrow(User $userWhoPledge, $daysWanted){
     	// TODO: implement
    }
    
    /**
    * @return   boolean
    */
    public function return(){
     	// TODO: implement
    }
    
    /**
    * @return   Object
    */
    public function getFeedbacks(){
     	// TODO: implement
    }
    
    /**
    * @return   int
    */
    public function getLeftDays(){
     	// TODO: implement
    }
    
    /**
    * @return   User
    */
    public function getUserWhoWant(){
     	// TODO: implement
    }
    
    /**
    * @return   User
    */
    public function getUserWhoPledge(){
     	// TODO: implement
    }
    
    /**
    * @return   array
    */
    public function getBorrowsRecords(){
     	// TODO: implement
    }
    
    /**
    * @return   boolean
    */
    public function saveForIdleStatus(){
     	// TODO: implement
    }
    
    /**
    * @return   boolean
    */
    public function saveForWaitingPledgeStatus(){
     	// TODO: implement
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