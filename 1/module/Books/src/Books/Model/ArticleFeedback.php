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
use		Zend\InputFilter\InputFilterInterface;
use		Zend\InputFilter\InputFilter;

use		Zend\InputFilter\InputFilterAwareInterface;
class ArticleFeedback extends EntityBase implements InputFilterAwareInterface{        
    
    /**
    * @return   void
    */
    public function __construct(){
     	parent::__construct();
		//����Ĭ��ֵ
		$this["id_article"]		=	-1;
		$this["id_user"]		=	-1;
		$this["date"]	=	date($this->datetimeFormat);
		$this["star"]	=	0;
		$this["feedback"]	=	"you have commit ,but you do not set anything!";
		
		//FK ָ�򱾱�PK�ı� Ϊ�գ�Ĭ��
		//$this->tablesFkToMe=array();
    }
    
    /**
    * @return   Article
    */
    public function getArticle(){
     	return $this->tm->getTable("Article")->get($this["id_article"]);
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