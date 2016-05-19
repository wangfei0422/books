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



class UserTable extends TableBase{            
    
    /**
    * @param    string $name    
    * @return   User
    */
    public function getWithName($name){
     	$user=$this->fetchAll("",array("name"=>$name));
		$user=$user->current();
		if(!$user)return null;
		return $user;
    }

    /**
    * @param    string $name    
    * @return   boolean
    */
    public function hasUser($name){
     	if(is_null($this->getWithName($name)))return false;
		return true;
    }    
	
    /**
    * @param    int $userType    
    * @return   array
    */
    public function getUsersByType($userType){
     	$users=$this->fetchAll();
		$temp=[];
		foreach($users as $user){
			if($user->getType()==$userType) $temp[]=$user;
		}
		return $temp;
    }    
}


?>