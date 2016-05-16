<?php
//
// +------------------------------------------------------------------------+
// | PHP Version 5                                                          |
// +------------------------------------------------------------------------+
// | Copyright (c) All rights reserved.                                     |
// +------------------------------------------------------------------------+
// | This source file is subject to version 3.00 of the PHP License,        |
// | that is available at http://www.php.net/license/3_0.txt.               |
// | If you did not receive a copy of the PHP license and are unable to     |
// | obtain it through the world-wide-web, please send a note to            |
// | license@php.net so we can mail you a copy immediately.                 |
// +------------------------------------------------------------------------+
// | Author: WangMeng                                                       |
// +------------------------------------------------------------------------+
//
// $Id$
//
// +------------------------------------------------------------------------+
// | Contributor  :  Wang                                                   |
// | Change Log   :  Add namespace surport                                  |
// | Change Log   :  Add Settor and Gettor                                  |
// +------------------------------------------------------------------------+


/**
* @author       WANGMENG
*/

namespace Wfwechat;

use Overtrue\Wechat\Media;


class MediaIdToUrl{
    
    /**
    * @var      array
    */
    private $maps=array(
		"default"=>array("url"=>"二维码.jpg","text"=>"you have no any special url,this is the default url"),
		"b1EN8aMPv-l_mUOBbRqcptTZ78FOE6omAKzamzV0Lv4"=>array("青黄红.png"),//"http://mmbiz.qpic.cn/mmbiz/zkqlC2zaia8TJib8TYYkpLTX5HzPo2YnXzggGEPCHmeJ1FpgRwPjXPZbmQxwCaUWwND4mkRplPC1r9ys3L3M3vmg/0?wx_fmt=png"
		"xOjsm5F-0-4KzLpGyk3Dvy3pDPueNThXu0d1iG1qS4I"=>array("黄金玉米面条.jpg"),//"http://mmbiz.qpic.cn/mmbiz/zkqlC2zaia8Q72CW7e3aCnIvZ8K2emNdEibjgZnBOkqib3UwHlFANQYFnnichClAcluCP3dwdCEQxTUDtzyjC6tQQg/0?wx_fmt=jpeg"
		"O80OP7JfTzXHffbLjJ-aNmNQGLPh0K7Qh8DVLG1wJ60"=>array("二维码.jpg"),//"http://mmbiz.qpic.cn/mmbiz/zkqlC2zaia8SvsXoyENhessUW72ia20d58AWDcw1FiaDq7dIul5yuYxy4rcEBPzypv1DG2JsmgvHKOJpJQr7wXicVg/0?wx_fmt=jpeg"
		"O80OP7JfTzXHffbLjJ-aNpU6wWAT6DF-xN1I0yzfIhs"=>array("佳和五金机电商城.jpg"),//"http://mmbiz.qpic.cn/mmbiz/zkqlC2zaia8SvsXoyENhessUW72ia20d58FdwP90tNZbmZbygDMp9ice3R74m5ibjRzWmgaAWjiarVvPL0z161hibyVQ/0?wx_fmt=png"
		"O80OP7JfTzXHffbLjJ-aNqqLxT2VxDJH3uyykwXmXYM"=>array("佳和五金机电商城2.jpg"),//"http://mmbiz.qpic.cn/mmbiz/zkqlC2zaia8SvsXoyENhessUW72ia20d58sc6MiaWCnQvqYqnx5vGuaWmaibUMOibrkxfQjlzxBdIJLAiapIn3eSsEIQ/0?wx_fmt=png"
		"b1EN8aMPv-l_mUOBbRqcpr43dVJkpQyyzF3VW162kc0"=>array("赤橙黄绿青蓝紫.jpg"),//"http://mmbiz.qpic.cn/mmbiz/zkqlC2zaia8TJib8TYYkpLTX5HzPo2YnXzwuKKC2BP7bzhib4QDzMvdyfYpXdiaJuMFTKhSr5dbibXF3eKoSjqnSEGg/0?wx_fmt=png"
	);    
    
    /**
    * @var      int
    */
    private $expireTime=0;    //每一小时更新
	
    /**
    * @return   void
    */
    public function __construct(){
     	// TODO: implement
    }
    
    /**
    * @param    string $mediaId    
    * @return   string
    */
    public function getUrl($mediaId){
     	$mediaId=trim((string)$mediaId);
		$url=$this->maps["default"]["url"];
		
		global $g;
		$ct=$g["config"];
		
		if(substr($mediaId,0,4)=="http"){
			$wechatUrl=$mediaId;
			$medias=$ct->getConfig("wechat.medias",array("time"=>"0","urls"=>array()));
			$lastTime=(int)$medias["time"];
			if($lastTime==0 || time()-$lastTime>=$this->expireTime) $this->refresh();
			
			$urls=$medias["urls"];
			foreach($urls as $i){
				if($i["url"]==$wechatUrl){
					$mediaId=$i["id"];
					break;
				}
			}
		}
		if(in_array($mediaId,$this->maps)){
			$url=$this->maps[$mediaId]["url"];
		}
		return $url;
    }    
    
    
    /**
    * @param    string $mediaId    
    * @return   string
    */
    public function getText($mediaId){
     	// TODO: implement
    }    
    
    /**
    * @return   void
    */
    public function refresh(){
		global $g;
		$wechat=$g["curr_wechat"];
		$media=new Media($wechat["appId"],$wechat["appSecret"]);
		$medias=$media->lists("image");
		$urls=array();
		$images=$medias["item"];
		foreach($images as $i){
			$urls[]=array(
				"url"=>trim((string)$i["url"]),
				"id" =>trim((string)$i["media_id"]),);
		}

		$ct=$g["config"];
		$ct->saveConfig(array("time"=>(string)time(),"urls"=>$urls),"wechat.medias");
    }    


}


?>