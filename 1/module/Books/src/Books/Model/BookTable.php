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



class BookTable extends TableBase{        
    
    /**
    * @param    int $n    
    * @return   array
    */
    public function getTopStar($n){
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
		return array_slice($temp2,0,$n);
    }
    
    /**
    * @return   array
    */
    public function getTopBorrowed(){
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
		return array_slice($temp2,0,$n);
    }    
    
    
    

    

}


?>