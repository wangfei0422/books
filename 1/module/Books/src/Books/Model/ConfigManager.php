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



class ConfigManager extends ConfigHelper{        
    
	const BOOK_TYPE_KEY="books.type";
    /**
    * @return   array
    */
    public function getBookTypes(){
     	$types=$this->getConfig(self::BOOK_TYPE_KEY);
		if(empty($types)){
			$types=array(0=>array('name'=>'默认','description'=>'图书默认分类','time'=>date('Y-m-d h:i:s')));
			$this->saveConfig(self::BOOK_TYPE_KEY,$types);
		}
		foreach($types as $id => $type){
			$types[$id]["id"]=$id;
		}
		return $types;
    }
    
    /**
    * @param    string $array    
    * @return   boolean
    */
    public function addBookType($type){
		if(!is_array($type))return false;
		$type['time']=date('Y-m-d h:i:s');
		$types=$this->getBookTypes();
		$isEdit=false;
		foreach($types as $i => $t){
			if($t['name']==$type['name']){
				$types[$i]=$type;
				$isEdit=true;
			}
		}
		if(!$isEdit)$types[]=$type;
		$this->saveConfig(self::BOOK_TYPE_KEY,$types);
		return true;
    }
    
    /**
    * @param    string $type    
    * @return   boolean
    */
    public function deleteBookType($type){
		if(!is_string($type) || empty($type)) return false;
     	$types=$this->getConfig(self::BOOK_TYPE_KEY);
		foreach($types as $i => $t){
			if($t['name']==$type){
				unset($types[$i]);
				$this->saveConfig(self::BOOK_TYPE_KEY,$types);
				return true;
			}
		}
		return false;
    }
    
    /**
    * @param    int $type  
    * @return   boolean
    */
    public function bookTypeExist($type){
		if(is_int($type)){
			$types=$this->getConfig(self::BOOK_TYPE_KEY);
			if(isset($types[$type]))return true;			
		}else if(is_string($type) && $this->getTypeId($type)!==false){
			return true;
		}
		return false;
    }    
    
    /**
    * @param    string $type    
    * @return   string
    */
    public function getTypeId($type){
		$types=$this->getConfig(self::BOOK_TYPE_KEY);
		foreach($types as $i => $t){
			if($t['name']==$type)return (string)$i;
		}
		return false;
    }    
    

    

}


?>