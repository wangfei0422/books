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



class BookTable extends TableBase{        
    
    /**
    * @param    int $n    
    * @return   array
    */
    public function getTopStar($n=0){
     	$books=$this->fetchAll();
		$temp=[];
		foreach($books as $book){
			$temp[]=$book;
		}
		$temp2=usort($temp,function($a,$b){
			$a_star=$a->getAverageStar();
			$b_star=$b->getAverageStar();
			if($a_star == $b_star) return 0;
			return ($a_star > $b_star) ? -1 : 1;
		});
		if($n==0)return $temp2;
		return array_slice($temp2,0,$n);
    }
    
    /**
    * @param    int $n    
    * @return   array
    */
    public function getTopBorrowed($n=0){
     	$books=$this->fetchAll();
		$temp=[];
		foreach($books as $book){
			$temp[]=$book;
		}
		$temp2=usort($temp,function($a,$b){
			$a_star=$a->getBrowseCount();
			$b_star=$b->getBrowseCount();
			if($a_star == $b_star) return 0;
			return ($a_star > $b_star) ? -1 : 1;
		});
		if($n==0)return $temp2;
		return array_slice($temp2,0,$n);
    }    
    
    /**
    * @param    string $type    
    * @param    array $books    
    * @return   array
    */
    public function getBooksByType($type="", $books=null){
		if($books==null)$books=$this->fetchAll();
		global $g;
		$cm=$g["App"]->getServiceManager()->get("Books\Model\ConfigManager");
		$types=$cm->getBookTypes();
		if(!in_array($type,$types))return null;
		if($type!="")$types=[$type];
		$temp=[];
		foreach($types as $t){
			$temp2=array('type'=>$t,'books'=>[]);
			foreach($books as $book){
				if($book['type']==$t){
					$temp2['books'][]=$book;
				}
			}
			if($t==$type)return $temp2['books'];
			$temp[]=$temp2;
		}
		return $temp;
    }    

    

}


?>