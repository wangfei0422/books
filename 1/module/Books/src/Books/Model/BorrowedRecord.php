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
class BorrowedRecord extends EntityBase implements InputFilterAwareInterface{        
    
    /**
    * @return   void
    */
    public function __construct(){
     	// TODO: implement
    }
    
    /**
    * @return   Book
    */
    public function getBook(){
     	// TODO: implement
    }
    
    /**
    * @return   int
    */
    public function getRealDays(){
     	// TODO: implement
    }
    
    /**
    * @return   int
    */
    public function getLeftDays(){
     	// TODO: implement
    }
    
    /**
    * @return   boolean
    */
    public function isExpired(){
     	// TODO: implement
    }
    
    /**
    * @return   boolean
    */
    public function isReturned(){
     	// TODO: implement
    }
    
    /**
    * @return   Object
    */
    public function getFeedbacks(){
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