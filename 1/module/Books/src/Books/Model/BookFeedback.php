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
use		Zend\InputFilter\InputFilterInterface;
use		Zend\InputFilter\InputFilter;

use		Zend\InputFilter\InputFilterAwareInterface;
class BookFeedback extends EntityBase implements InputFilterAwareInterface{        
    
    /**
    * @return   void
    */
    public function __construct(){
     	parent::__construct();
		//设置默认值
		$this["id_book_borrowed"]		=	-1;
		$this["id_user"]		=	-1;
		$this["date"]	=	date($this->datetimeFormat);
		$this["star"]	=	0;
		$this["feedback"]	=	"you have commit ,but you do not set!";
		
		//FK 指向本表PK的表 为空，默认
		//$this->tablesFkToMe=array();
    }
    
    /**
    * @return   Book
    */
    public function getBook(){
     	$r=$this->getBorrowedRecord();
		if(is_null($r))return null;
		return $this->tm->getTable("Book")->get($r["id_book"]);
    }
    
    /**
    * @return   BorrowedRecord
    */
    public function getBorrowedRecord(){
     	return $this->tm->getTable("BorrowedRecord")->get($this["id_book_borrowed"]);
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
				'name'		=>"id",
				'required'	=>true,
				'filters'	=>array(
					array('name'=>'int'),
				),
			));
			
 			$inputFilter->add(array(
				'name'		=>"id_book_borrowed",
				'required'	=>true,
				'filters'	=>array(
					array('name'=>'int'),
				),
			));
 			$inputFilter->add(array(
				'name'		=>"id_user",
				'required'	=>true,
				'filters'	=>array(
					array('name'=>'int'),
				),
			));
			$inputFilter->add(array(
				'name'		=>"feedback",
				'required'	=>true,
				'validators'=>array(
					array(
						'name'=>'stringlength',
						'options'=>array(
							'encoding'=>'UTF-8',
							'min'	  =>'5',
							'max'	  =>'300',
						),
					),
				),
			));
			$inputFilter->add(array(
				'name'		=>"is_verified",
				'required'	=>false,
			)); 
			$this->inputFilter=$inputFilter;
		}
		return $this->inputFilter;
    }

}


?>