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
use		Wfwechat\MessageCommandProvider;
use		Wfwechat\ServiceCommand\StateMachines;
use		Wfwechat\ServiceCommand\CommandState;

class OnText extends AbstactOnMessage{            
    
	public function on($input){
		$input=$input->getParams();
		$content=$input["Content"];
		$user=$input["FromUserName"];
		//$cp=new MessageCommandProvider(StateMachines::$INIT_COMMAND,"U");
		//return $content . "--" . $user;
		$cp=new MessageCommandProvider($content,$user);
		$sm=new StateMachines(new CommandState(),$cp);
		if($sm->hasResponse()){
			return $sm->apply();
		}else{
			return $this->customReply($input);
		}
	}

    /**
    * @param    mixed $input    
    * @return   string
    */
    public function customReply($input){
     	return "您的消息已接收，我们的客服稍后将给您回复。";
    }    
}


?>