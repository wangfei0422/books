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



class ArticleTable extends TableBase{        
    
    /**
    * @param    int $n    
    * @return   array
    */
    public function getTopStar($n=0){
     	$articles=$this->fetchAll();
		$temp=[];
		foreach($articles as $article){
			$temp[]=$article;
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
    public function getTopBrowsed($n=0){
     	$articles=$this->fetchAll();
		$temp=[];
		foreach($articles as $article){
			$temp[]=$article;
		}
		usort($temp,function($a,$b){
			$a_star=$a->getBrowseCount();
			$b_star=$b->getBrowseCount();
			if($a_star == $b_star) return 0;
			return ($a_star > $b_star) ? -1 : 1;
		});
		if($n==0)return $temp;
		return array_slice($temp,0,$n);
    }    
    
    
    

    

}


?>