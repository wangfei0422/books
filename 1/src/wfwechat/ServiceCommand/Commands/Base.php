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



class Base{
    
    /**
    * @var      CommandOptions
    */
    protected $commandOptions;    
    
        
    
    /**
    * @return   void
    */
    public function __construct(){
     	$commandOptions=new CommandOptions();
		$this->result["options"]=$commandOptions;
    }
    
    /**
    * @return   string
    */
    public function getPrompt(){
     	return static::$PROMPT;
    }
    
    /**
    * @return   array
    */
    public function getConfig(){
     	return $this->config;
    }

    /**
    * @return   array
    */
    public function getResult(){
       return $this->result;
    }
    
    
    

    

}


?>