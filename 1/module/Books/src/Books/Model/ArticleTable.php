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
    public function getTopStar($n){
     	$articles=$this->fetchAll();
		$temp=[];
		foreach($articles as $article){
			$temp[]=$article;
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
    * @param    int $n    
    * @return   array
    */
    public function getTopBrowse($n){
     	$articles=$this->fetchAll();
		$temp=[];
		foreach($articles as $article){
			$temp[]=$article;
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