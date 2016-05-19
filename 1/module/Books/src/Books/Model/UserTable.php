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