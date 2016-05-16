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



abstract class AbstactOnMessage{
    
    /**
    * @var      mixed
    */
    private $input;    
    
    //settor for $this->input
    public function setInput($value){
       $this->input=$value;
    }
    
    //gettor for $this->input
    public function getInput(){
       return $this->input;
    }    
    
    /**
    * @return   void
    */
    public function __construct(){
     	// TODO: implement
    }
    
    /**
    * @param    mixed $input    
    * @return   void
    */
    public function on($input){
		$input=$input->getParams();
		return "如果您收到这条消息，说明此功能正在开发中...";
    }    
    
    
    

    

}


?>