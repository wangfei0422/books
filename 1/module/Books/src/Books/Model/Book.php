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
		//����Ĭ��ֵ
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
		
		//FK ָ�򱾱�PK�ı�
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