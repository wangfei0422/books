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
use 	Overtrue\Wechat\Group;
class JoinToGroup extends Base{            
    
	public static $PROMPT="加入组";
    protected $config = array(
        'graph'         => 'JoinToGroup',
        'property_path' => 'state',  // Property path of the object actually holding the state
        'states'        => array(
            'JoinToGroupStart','HasJoined','Idle',
        ),
        'transitions' => array(
            'Idle to JoinToGroupStart' => array(
                'from' => array('Idle'),
                'to'   => 'JoinToGroupStart'
            ),
            'JoinToGroupStart to HasJoined' => array(
                'from' => array('JoinToGroupStart'),
                'to'   => 'HasJoined'
            ),
            'HasJoined to Idle' => array(
                'from' => array('HasJoined'),
                'to'   => 'Idle'
            ),
        ),
    );
    protected $result=array(
            'isOk'           => false,
            'responseHeader' => '',
            'options'        => null,
        );
    public function onJoinToGroupStart($data){
		global $g;
		$wechat=$g["wechat_info"][$g["wechat_id"]];
		$group=new Group($wechat["appId"],$wechat["appSecret"]);
		$groups=$group->lists();									//此处可能会抛出异常。
        $this->result['isOk']=true;
		$this->result['responseHeader']="请选择组对应的序号：";
		foreach($groups as $gr){
			$this->result['options']->addOption(array("text"=>$gr["name"]."(".$gr["count"].")","extra"=>array("group"=>$gr)));
		}
    }
    public function onHasJoined($data){
		global $g;
		$wechat=$g["wechat_info"][$g["wechat_id"]];
		
		$group=new Group($wechat["appId"],$wechat["appSecret"]);
		$group->moveUser($data["extra"]["userId"], $data["extra"]["group"]["id"]);		//此处可能会抛出异常
		
        $this->result['isOk']=true;
		$this->result['responseHeader']="您已经加入了分组[".$data["extra"]["group"]["name"]."],回复任意消息与客服交流，或者回复以下命令：";		
    }
    
    public function onIdle(){
        //nothing is here
    }

}


?>