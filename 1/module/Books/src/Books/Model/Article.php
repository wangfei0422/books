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
class Article extends EntityBase implements InputFilterAwareInterface{        
    
	const BROWSE_COUNT_BIT_START=1;
	const BROWSE_COUNT_BIT_LEN=20;
    /**
    * @return   void
    */
    public function __construct(){
     	parent::__construct();
		//设置默认值
		$this["title"]		=	"default";
		$this["date"]			=	date($this->datetimeFormat);
		$this["content"]		=	"default";
		$this["id_user"]	=	-1;
		
		//FK 指向本表PK的表
		$this->tablesFkToMe=array("ArticleFeedback");
    }
    
    /**
    * @return   Object
    */
    public function getFeedbacks(){
     	return $this->tm->getTable("ArticleFeedback")->fetchAllForEntity($this);
    }    

    /**
    * @return   int
    */
    public function getBrowseCount(){
     	return $this->hf->getMaskValue(self::BROWSE_COUNT_BIT_START,self::BROWSE_COUNT_BIT_LEN,$this["status"]);
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
    * @return   boolean
    */
    public function increaseBrowseCount(){
		$v=$this->getBrowseCount();
		if($v>=(pow(2,self::BROWSE_COUNT_BIT_LEN)-1))return;
		$v++;
		var_dump($this->storage);
     	$this["status"]=$this->hf->setMaskValue(self::BROWSE_COUNT_BIT_START,self::BROWSE_COUNT_BIT_LEN,$this["status"],$v);
		$this->save();
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
				'name'		=>"id_article",
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
				'name'		=>"title",
				'required'	=>true,
				'validators'=>array(
					array(
						'name'=>'stringlength',
						'options'=>array(
							'encoding'=>'UTF-8',
							'min'	  =>'1',
							'max'	  =>'100',
						),
					),
				),
			));
			$inputFilter->add(array(
				'name'		=>"content",
				'required'	=>true,
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