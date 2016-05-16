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
    
    /**
    * @return   boolean
    */
    public function isWaitingPledge(){
     	// TODO: implement
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