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



class ConfigManager extends ConfigHelper{        
    
	const BOOK_TYPE_KEY="books.type";
    /**
    * @return   array
    */
    public function getBookTypes(){
     	return $this->getConfig(self::BOOK_TYPE_KEY,array("default"));
    }
    
    /**
    * @param    string $type    
    * @return   boolean
    */
    public function addBookType($type){
		if(!is_string($type) || empty($type)) return false;
     	$types=$this->getConfig(self::BOOK_TYPE_KEY,array("default"));
		$types[]=$type;
		array_unique($types);
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