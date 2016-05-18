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
class BorrowedRecord extends EntityBase implements InputFilterAwareInterface{        
    
    /**
    * @return   void
    */
    public function __construct(){
     	parent::__construct();
		//����Ĭ��ֵ
		$this["id_user"]		=	-1;
		$this["id_book"]		=	-1;
		$this["borrow_date"]	=	date($this->datetimeFormat);;
		$this["borrow_days"]	=	0;
		$this["return_date"]	=	$this["borrow_date"];
		$this["whoPayPledge"]	=	-1;
		
		if(isset($this["status"]))unset($this["status"]);
		//FK ָ�򱾱�PK�ı�
		$this->tablesFkToMe=array("BookFeedback");
    }
    
    /**
    * @return   Book
    */
    public function getBook(){
     	return $this->tm->getTable("Book")->get($this["id_book"]);
    }
    
    /**
    * @return   int
    */
    public function getRealDays(){
		$start_date=$this["borrow_date"];
		$end_date=$this["return_date"];
     	if(!$this->isReturned())$end_date=$date($this->datetimeFormat);
		$this->hf->dateDiffDays($start_date,$end_date);
    }
    
    /**
    * @return   int
    */
    public function getLeftDays(){
     	if($this->isReturned())return 0;
		$start_date=new \DateTime();
		$end_date=(new \DateTime($this["borrow_date"]))->modify("+{$this["borrow_days"]} day");
		$this->hf->dateDiffDays($start_date,$end_date);
		
    }
    
    /**
    * @return   boolean
    */
    public function isExpired(){
     	if($this->getLeftDays()>0)return true;
		return false;
    }
    
    /**
    * @return   boolean
    */
    public function isReturned(){
     	return $this["borrow_date"]!=$this["return_date"]
    }
    
    /**
    * @return   Object
    */
    public function getFeedbacks(){
     	return $this->tm->getTable("BookFeedback")->fetchAllForEntity($this);
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