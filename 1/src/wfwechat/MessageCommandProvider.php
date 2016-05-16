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


use		Wfwechat\ServiceCommand\CommandTextProviderInterface;
class MessageCommandProvider implements CommandTextProviderInterface{
    
    /**
    * @var      string
    */
    private $commandText;
    
    /**
    * @var      string
    */
    private $uid;    
    
    
    
        
    
    /**
    * @param    string $commandText    
    * @param    string $uid    
    * @return   void
    */
    public function __construct($commandText, $uid){
     	$this->commandText=$commandText;
		$this->uid=$uid;
    }    
    
    /**
    * @return   string
    */
    public function getCommandText(){
     	return $this->commandText;
    }
    
    
    /**
    * @param    string $commandText    
    * @return   void
    */
    public function setCommandText($commandText){
     	$this->commandText=$commandText;
    }
    
    /**
    * @return   string
    */
    public function getUid(){
     	return $this->uid;
    }
    
    /**
    * @param    string $uid    
    * @return   void
    */
    public function setUid($uid){
     	$this->uid=$uid;
    }
    
    

    

}


?>