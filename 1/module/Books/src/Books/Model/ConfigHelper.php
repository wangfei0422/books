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


use			Zend\Db\Sql\Where;
class ConfigHelper{
	
    /**
    * @var      ConfigTable
    */
    private $configTable;    
   
	
    /**
    * @return   void
    */
    public function __construct(){
     	global $g;
		$this->configTable=$g["App"]->getServiceManager()->get("Books\Model\TableManager")->getTable("Config");
    }
	
    /**
    * @param    String $key    
    * @param    Object $default    
    * @return   mixed
    */
    public function getConfig($key="", $default=array()){
		$tg=$this->configTable->getTableGateway();
		$pk=$this->configTable->getPk();
		$where=new Where();
		$name=$key;
		if($key!="") $key.=".";
		$where->like($pk,$key."%");
     	$result=$tg->select($where)->toArray();
		if(count($result)==0){
			$result=$tg->select((new Where())->equalTo($pk, $name))->toArray();
			if(count($result)==0){
				return $default;
			}else{
				return $result[0]["value"];
			}
		}

		$config_data=array();
		foreach($result as $item){
			$item_key=explode(".",substr($item[$pk],strlen($key)));
			$curr_pos=&$config_data;
			$i=0;
			if(count($item_key)>1){
				for($i=0;$i<=count($item_key)-2;$i++){
					if(!(isset($curr_pos[$item_key[$i]]) && is_array($curr_pos[$item_key[$i]]))){
						$curr_pos[$item_key[$i]]=array();
					}
					$curr_pos=&$curr_pos[$item_key[$i]];
				}
				$curr_pos[$item_key[$i]]=$item["value"];
			}else if(count($item_key)==1){
				if(!(isset($curr_pos[$item_key[0]]) && is_array($curr_pos[$item_key[0]]))){
					$curr_pos[$item_key[0]]=$item["value"];
				}
			}
		}
		return $config_data;
    }
    
    /**
    * @param    string $key    
    * @param    mixed $value    
    * @return   boolean
    */
    public function saveConfig($key="", $value=""){
		$tg=$this->configTable->getTableGateway();
		$tg->delete((new Where())->like($this->configTable->getPk(), $key."%"));	//清除旧值
		if($value=="") return true;
		
		return $this->saveConfig2($key,$value);
    }
    
    /**
    * @param    string $key    
    * @param    mixed $value    
    * @return   boolean
    */
    private function saveConfig2($key, $value){
		if(!is_array($value)){
			$value=(string)$value;
			if($key!=""){
				$data=array($this->configTable->getPk() => $key,"value"=>$value);
				if(!$this->configTable->save($data))return false;
			}
			return true;
		}
     	if($key!=""){$key.=".";}
		foreach($value as $k => $v){
			if(!$this->saveConfig2($key.(string)$k,$v))return false;
		}
		return true;
    }    
    

    

}


?>