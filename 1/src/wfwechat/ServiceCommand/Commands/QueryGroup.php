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

namespace Wfwechat\ServiceCommand\Commands;


use		Wfwechat\ServiceCommand\StatusGraphInterface;
use 	Overtrue\Wechat\User;
use 	Overtrue\Wechat\Group;
class QueryGroup extends Base{            
    

    public static $PROMPT="查询组";
    protected $config = array(
        'graph'         => 'QueryGroup',
        'property_path' => 'state',  // Property path of the object actually holding the state
        'states'        => array(
            'QueryGroupStart','Idle',
        ),
        'transitions' => array(
            'Idle to QueryGroupStart' => array(
                'from' => array('Idle'),
                'to'   => 'QueryGroupStart'
            ),
            'QueryGroupStart to Idle' => array(
                'from' => array('QueryGroupStart'),
                'to'   => 'Idle'
            ),
        ),
    );
    protected $result=array(
            'isOk'           => false,
            'responseHeader' => '',
            'options'        => null,
        );
    public function onQueryGroupStart($data){
		global $g;
		$wechat=$g["wechat_info"][$g["wechat_id"]];
		
		$user=new User($wechat["appId"],$wechat["appSecret"]);
		$user_info=$user->get($data["extra"]["userId"]);			//此处可能会抛出异常

		$group=new Group($wechat["appId"],$wechat["appSecret"]);
		$groups=$group->lists();								//此处可能会抛出异常
		
		$currGroup=null;
		foreach($groups as $gr){
			if($gr["id"]==$user_info["groupid"]){
				
				$currGroup=$gr;
				break;
			}
		}
		
        $this->result['isOk']=true;
		if($currGroup!=null){
			$this->result['responseHeader']="您所在的分组为：".$currGroup["name"];
		}else{
			$this->result['responseHeader']="很报谦，您所在的分组查不到，您可以联系公共平台客服，或者稍后重试。";
		}
    }
    
    public function onIdle(){
        //nothing here.
    }

}


?>