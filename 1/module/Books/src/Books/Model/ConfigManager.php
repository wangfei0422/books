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
     	$types=$this->getConfig(self::BOOK_TYPE_KEY,array("default"));
		if(!in_array("default",$types))$types[]="default";
		return $types;
    }
    
    /**
    * @param    string $type    
    * @return   boolean
    */
    public function addBookType($type){
		if(!is_string($type) || empty($type)) return false;
     	$types=$this->getConfig(self::BOOK_TYPE_KEY,array("default"));
		$types[]=$type;
		$types=array_unique($types);
		$this->saveConfig(self::BOOK_TYPE_KEY,$types);
		return true;
    }
    
    /**
    * @param    string $type    
    * @return   boolean
    */
    public function deleteBookType($type){
		if(!is_string($type) || empty($type)) return false;
     	$types=$this->getConfig(self::BOOK_TYPE_KEY,array("default"));
		$i=array_search($type,$types);
		if($i===false) return;
		unset($types[$i]);
		$this->saveConfig(self::BOOK_TYPE_KEY,$types);
		return true;
    }
    
    /**
    * @return   boolean
    */
    public function bookTypeExist(){
		if(!is_string($type) || empty($type)) return false;
     	$types=$this->getConfig(self::BOOK_TYPE_KEY,array("default"));
		$i=array_search($type,$types);
		if($i===false) return false;
		return true;
    }    
    
    
    

    

}


?>