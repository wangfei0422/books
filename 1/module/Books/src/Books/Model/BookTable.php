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
		usort($temp,function($a,$b){
			$a_star=$a->getAverageStar();
			$b_star=$b->getAverageStar();
			if($a_star == $b_star) return 0;
			return ($a_star > $b_star) ? -1 : 1;
		});
		if($n==0)return $temp;
		return array_slice($temp,0,$n);
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
		usort($temp,function($a,$b){
			$a_star=$a->getBorrowCount();
			$b_star=$b->getBorrowCount();
			if($a_star == $b_star) return 0;
			return ($a_star > $b_star) ? -1 : 1;
		});
		if($n==0)return $temp;
		return array_slice($temp,0,$n);
    }    
    
    /**
    * @param    string $type    
    * @param    array $books    
    * @return   array
    */
    public function getBooksByType($type="", $books=null){
		if(is_null($books)){
			$books=$this->fetchAll();
		}
		global $g;
		$cm=$g["App"]->getServiceManager()->get("Books\Model\ConfigManager");
		$types_=$cm->getBookTypes();
		$types=[];
		if(is_string($type)){
			if($type==""){
				$types=$types_;
			}else{
				$types[]=$type;
			}
		}else if(is_array($type)){
			$types=$type;
		}else{
			return null;
		}
		foreach($types as $i=>$type){
			if(!in_array($type,$types_))unset($types[i]);
		}
		if(empty($types))return null;
		$temp=[];
		foreach($types as $t){
			$temp2=array('type'=>$t,'books'=>[]);
			foreach($books as $book){
				if($book['type']==$t){
					$temp2['books'][]=$book;
				}
			}
			if(is_string($type) && $t==$type)return $temp2['books'];
			$temp[]=$temp2;
		}
		return $temp;
    }
	
    /**
    * @param    int $userType    
    * @param    array $books    
    * @return   array
    */
    public function getBooksByUserType($userType, $books=null){
		$temp=[];
		if($books==null){
			global $g;
			$users=$g["App"]->getServiceManager()->get("Books\Model\TableManager")->getTable("User")->getUsersByType($userType);
			$temp=[];
			foreach($users as $user){
				$books=$user->getBooks();
				foreach($books as $book){
					$temp[]=$book;
				}
			}		
		}else{
			foreach($books as $book){
				if($book->getUser()->getType()==$userType) $temp[]=$book;
			}
		}
		return $temp;
    }    
}


?>