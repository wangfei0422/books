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
class User extends EntityBase implements InputFilterAwareInterface{        
    
	const MANAGER_BIT_MASK=0x1;
	const USER_TYPE_BIT_MASK=~0x1;
	const TYPE_DEFAULT=0;
	const TYPE_SENIOR=1;
	const DEFAULT_BORROW_DAYS=2;
    /**
    * @return   boolean
    */
    public function isSenior(){
		$user_type=($this["status"] & self::USER_TYPE_BIT_MASK)>>1;
		if($user_type==self::TYPE_SENIOR)return true;
		return false;
    }
    
    /**
    * @return   boolean
    */
    public function isManager(){
		if($this["type"] & self::MANAGER_BIT_MASK ==0)return true;
		return false;
    }
    
    /**
    * @return   Object
    */
    public function getBooks(){
		$table=$this->tm->getTable("Book");
     	$tg=$table->getTableGateway();
		$pk=$this->getTable()->getPk();
		return $tg->select(array($pk=>$this[$pk]))->toArray();
    }
    
    /**
    * @return   Object
    */
    public function getArticles(){
     	$table=$this->tm->getTable("Article");
     	$tg=$table->getTableGateway();
		$pk=$this->getTable()->getPk();
		return $tg->select(array($pk=>$this[$pk]))->toArray();
    }
    
    /**
    * @param    Book $book    
    * @return   boolean
    */
    public function borrowBookRequest(Book $book){
     	if($book->isBorrowed()) return false;
		if($book->isWaitingPledge())return false;
		$book->saveForWaitingPledgeStatus();
		return true;
    }

    /**
    * @param    Book $book    
    * @return   boolean
    */
    public function borrowBookCancel(Book $book){
     	$book->saveForIdleStatus();
		return true;
    }
	
    /**
    * @return   Object
    */
    public function getBooksWaitingToPledge(){
		$bookTableGateway=$this->tm->getTable("Book")->getTableGateway();
		$books=$bookTableGateway->select(function($select){
			$select->where(array("whoWantBook"=>$this["id_user"]));
		})->toArray();
		$temp=array();
		foreach($books as $book){
			if($book->isWaitingPledge())$temp[]=$book;
		}
		return $temp;
    }
    
    /**
    * @param    Book $book    
    * @return   boolean
    */
    public function payPledge(Book $book){
		if($book->isWaitingPledge()){
			$book->borrow($this,self::DEFAULT_BORROW_DAYS);
			$book->saveForIdleStatus();		
			return true;
		}
		return false;
    }
    
    /**
    * @param    Event $e    
    * @return   Object
    */
    private function onPaySucess($e){
     	// TODO: implement
    }
    
    /**
    * @param    Event $e    
    * @return   Object
    */
    private function onPayFail($e){
     	// TODO: implement
    }
    
    /**
    * @param    Book $book    
    * @return   boolean
    */
    public function returnBook(Book $book){
     	if($book->isBorrowed()){
			$book->return();
			return true;
		}
		return false;
    }
    
    /**
    * @return   Object
    */
    public function getBooksBorrowed(){
		$borrowTableGateway=$this->tm->getTable("BorrowedRecord")->getTableGateway();
		$bookTableGateway=$this->tm->getTable("Book")->getTableGateway();
		$borrowRecords=$borrowTableGateway->select(array("id_user"=>$this["id_user"]));
		$books=array();
		foreach($borrowRecords as $record){
			$book_id=$record["id_book"];
			if(!isset($books[$book_id])){
				$book=$bookTableGateway->get($book_id);
				$books[$book_id]=$book;
			}
			$books[$book_id]["extension"]["records"][]=$record;
		}
		return array_values($books);
    }
    
    /**
    * @return   Object
    */
    public function getBooksCurrBorrowed(){
		$borrowTableGateway=$this->tm->getTable("BorrowedRecord")->getTableGateway();
		$bookTableGateway=$this->tm->getTable("Book")->getTableGateway();
		$borrowRecords=$borrowTableGateway->select(array("id_user"=>$this["id_user"]));
		$books=array();
		foreach($borrowRecords as $record){
			if(!$record->isReturned()){
				$book_id=$record["id_book"];
				$book=$bookTableGateway->get($book_id);
				$book["extension"]["record"]=$record;
				$books[]=$book;
			}
		}
		return $books;
    }
    
    /**
    * @param    int $days    
    * @return   Object
    */
    public function getBooksNeedToReturnWithinDays($days=0){
     	$books=$this->getBooksCurrBorrowed();
		if($days==0)return $books;
		$temp=array();
		foreach($books as $book){
			if($book["extension"]["record"]->getLeftDays()<=$days){
				$temp[]=$book;
			}
		}
		return $temp;
    }
    
    /**
    * @param    Object $message    
    * @return   boolean
    */
    public function log($message){
     	// TODO: implement
    }
    
    /**
    * @return   Object
    */
    public function getLogs(){
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