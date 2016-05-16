<?php
//
// +------------------------------------------------------------------------+
// | PHP Version 5                                                          |
// +------------------------------------------------------------------------+
// | Copyright (c) All rights reserved.                                     |
// +------------------------------------------------------------------------+
// | This source file is subject to version 3.00 of the PHP License,        |
// | that is available at http://www.php.net/license/3_0.txt.               |
// | If you did not receive a copy of the PHP license and are unable to     |
// | obtain it through the world-wide-web, please send a note to            |
// | license@php.net so we can mail you a copy immediately.                 |
// +------------------------------------------------------------------------+
// | Author:                                                                |
// +------------------------------------------------------------------------+
//
// $Id$
//
// +------------------------------------------------------------------------+
// | Contributor  :  Wang                                                   |
// | Change Log   :  Add namespace surport                                  |
// | Change Log   :  Add Settor and Gettor                                  |
// +------------------------------------------------------------------------+


/**
* @author       WangMeng
*/

namespace 	Wfwechat\Config;
use			Zend\Db\Adapter\Adapter;
use 		Zend\Db\TableGateway\TableGateway;
use			Zend\Db\Sql\Where;

class ConfigTable implements ConfigStoreInterface{
    
    /**
    * @Object TableGateway
    */  
    private $tg;
        
    
    /** 
    * @return   void
    */
    public function __construct(){
	
		if(defined("SAE_MYSQL_DB")){
			$adapter=new Adapter(array(
				'driver'   => 'Mysqli',
				'database' => SAE_MYSQL_DB,
				'username' => SAE_MYSQL_USER,
				'password' => SAE_MYSQL_PASS,
				'hostname' => SAE_MYSQL_HOST_M,
				'port'     => SAE_MYSQL_PORT, 
			));	
		}else{
			$adapter=new Adapter(array(
				'driver'   => 'Mysqli',
				'database' => 'wfwechat',
				'username' => 'root',
				'password' => '',
				'hostname' => 'localhost',
				'port'     => '3306'
			));	
		}
		$this->tg=new TableGateway('config',$adapter);
    }    
    
    /**
    * @param    array $name   
    * @return   array | String
    */
    public function getConfig($name="",$default=""){
		$where=new Where();
		$name_=$name;
		if($name!=""){$name.=".";}
		$where->like('name',$name."%");
     	$result=$this->tg->select($where)->toArray();
		if(count($result)==0){
			$result=$this->tg->select((new Where())->equalTo('name', $name_))->toArray();
			if(count($result)==0){
				return $default;
			}else{
				return $result[0]["value"];
			}
		}

		$config_data=array();
		foreach($result as $item){
			$item_name=explode(".",substr($item["name"],strlen($name)));
			$curr_pos=&$config_data;
			$i=0;
			if(count($item_name)>1){
				for($i=0;$i<=count($item_name)-2;$i++){
					if(!(isset($curr_pos[$item_name[$i]]) && is_array($curr_pos[$item_name[$i]]))){
						$curr_pos[$item_name[$i]]=array();
					}
					$curr_pos=&$curr_pos[$item_name[$i]];
				}
				$curr_pos[$item_name[$i]]=$item["value"];
			}else if(count($item_name)==1){
				if(!(isset($curr_pos[$item_name[0]]) && is_array($curr_pos[$item_name[0]]))){
					$curr_pos[$item_name[0]]=$item["value"];
				}
			}
		}
		return $config_data;
    }
    
    /**
    * @param    array|String $value
    * @param    String $name  
    * @return   boolean
    */
    private function saveConfig_($value,$name=""){

		if(!is_array($value)){
			$value=(string)$value;
			if($name!=""){
				$this->saveItem($name,$value);
			}
			return true;
		}
     	if($name!=""){$name.=".";}
		foreach($value as $n => $v){
			$this->saveConfig_($v,$name.(string)$n);
		}
    }

    /**
    * @param    array|String $value
    * @param    String $name  
    * @return   boolean
    */
    public function saveConfig($value,$name=""){
		if($value==""){
			if($name=="")return false;									//无效操作
			$this->tg->delete((new Where())->equalTo('name', $name));
			return true;												//值为空则删除键
		}
		if($name!="") $this->clearConfig($name);	//清除旧值
		
		$this->saveConfig_($value,$name);
    }
	
    /**
    * @param    String $name  
    * @return   boolean
    */
    public function clearConfig($name){
		$this->tg->delete((new Where())->like('name', $name."%"));	//清除旧值
    }
	
    /**
    * @param    String $name  
    * @param    String $value
    * @return   void
    */
    public function saveItem($name,$value=""){
		//print($name . "=>" . $value);
		//print("</br>");
		if(count($this->tg->select((new Where())->equalTo('name', $name))->toArray())==1){
			$this->tg->update(array("name"=>$name,"value"=>(string)$value),(new Where())->equalTo('name', $name));
		}else{
			$this->tg->insert(array("name"=>$name,"value"=>(string)$value));
		}
    }

    

}


?>