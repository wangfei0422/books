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