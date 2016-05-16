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

namespace Wfwechat\Message;
use		Wfwechat\ServiceCommand\StateMachines;
use		Wfwechat\MessageCommandProvider;
use		Wfwechat\ServiceCommand\CommandState;

class OnSubscribe extends AbstactOnMessage{            
    
	public function on($input){
		$input=$input->getParams();
		$user=$input["FromUserName"];
		$cp=new MessageCommandProvider(StateMachines::$INIT_COMMAND,$user);
		$sm=new StateMachines(new CommandState(),$cp);
		if($sm->hasResponse()){
			return "谢谢关注，请按提示初始化您的个人配置。\n".$sm->apply();
		}else{
			return "谢谢关注，您的支持是我们进步的最大动力。";
		}
	}
}


?>