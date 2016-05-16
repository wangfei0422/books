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



class HelperFunctions{        
    
    /**
    * @param    int $start    
    * @param    int $length    
    * @param    int $target    
    * @return   int
    */
    public function getMaskValue($start, $length, $target){
		//$mask=(2**($length+1)-1) << $start;
		$mask=(pow(2,($length+1))-1) << $start;
		$target &= $mask;
		return $target >> $start;
    }
    
    /**
    * @param    int $start    
    * @param    int $length    
    * @param    int $target    
    * @param    int $value    
    * @return   int
    */
    public function setMaskValue($start, $length, $target, $value){
		//$mask=(2**($length+1)-1) << $start;
		$mask=(pow(2,($length+1))-1) << $start;
		$target &= ~$mask;
		$value <<= $start;
		$value &= $mask;
		$target |= $value;
		return $target;
    }    

	    /**
    * @param    mixed $left    
    * @param    mixed $right    
    * @return   boolean
    */
    public function dateNewer($left, $right=null){
		if(is_string($left)) $left= new \DateTime($left);
		if(is_null($right)){
			$right=new \DateTime();
		}else if(is_string($right)){
			$right=new \DateTime($right);
		}		
		return $left->diff($right)->format("%R") == "-";
    }
		
}


?>