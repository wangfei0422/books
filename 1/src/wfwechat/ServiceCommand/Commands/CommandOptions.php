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



class CommandOptions{
    
    /**
    * @var      array
    */
    private $options;    
    
        
    
    /**
    * @param    array $options    
    * @return   void
    */
    public function __construct($options=array()){
     	$this->options=$options;
    }
    
    /**
    * @return   string
    */
    public function getPrompts(){
		$prompt="";
		for($i=0;$i<count($this->options);$i++){
			$prompt=$prompt. ($i+1) . ":" . $this->options[$i]["text"]."\n";
		}
		return $prompt;
    }
    
    /**
    * @return   array
    */
    public function getOptions(){
     	return $this->options;
    }
    
    /**
    * @param    array $option    
    * @return   array
    */
    public function addOption($option){
     	$this->options[]=$option;
    }
    
    /**
    * @param    array $options    
    * @return   array
    */
    public function addOptions($options){
		$this->options=array_merge($this->options,$options);
    }    
    
    
    

    

}


?>