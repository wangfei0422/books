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