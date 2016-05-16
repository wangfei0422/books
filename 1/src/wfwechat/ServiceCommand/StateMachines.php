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

namespace Wfwechat\ServiceCommand;
use		Wfwechat\config\ConfigStoreInterface;
use 	Wfwechat\ServiceCommand\Commands\CommandOptions;

class StateMachines{
    public static $INIT_COMMAND="#CD";
	public static $CANCEL_COMMAND="#QX";
    /**
    * @var      array
    */
    private $machines;

    /**
    * @var      string
    */
    private $currMachine;
	
    /**
    * @var      int 秒数
    */
    private $expireTime=1000;
	
    /**
    * @var      string
    */
    private $initCommand="#CD";
	
    /**
    * @var      string
    */
    private $cancelCommand="#QX";
	
    /**
    * @var      CommandOptions
    */
    private $commandOptions;
	
    /**
    * @var      CommandState
    */
    private $stateObject;
    
    /**
    * @var      boolean
    */
    private $_isValidCommand=false;

    /**
    * @var      boolean
    */
	private $_hasResponse=false;

    /**
    * @var      boolean
    */
	private $_isInitCommand=false;

    /**
    * @var      boolean
    */
	private $_isCancelCommand=false;	
	
    /**
    * @var      string
    */
	private $response;

    /**
    * @var      string
    */
	private $responseHeader="请回复以下指令：";

    /**
    * @var      string
    */
	private $responseFooter;	

    /**
    * @var      ConfigStoreInterface
    */
    private $configStore;
    
    /**
    * @var      CommandTextProviderInterface
    */
    private $commandProvider;

    
    /**
    * @param    CommandState $state    
    * @param    CommandTextProviderInterface $command    
    * @return   void
    */
    public function __construct(CommandState $state, CommandTextProviderInterface $command){
     	$this->stateObject=$state;
		$this->commandProvider=$command;
		
		global $g;
		$this->configStore=$g["config"];
		$this->loadCurrentState();
		
		$machines=$g["commands"];
		foreach($machines as $machine){
			$class='Wfwechat\\ServiceCommand\\Commands\\'.$machine;
			if(class_exists($class)){
				$this->machines[$machine]=new $class(); 
			}
		}
		$this->responseFooter=$this->initCommand . ":主菜单\n". $this->cancelCommand . ":取消";
    }
    
    /**
    * @return   boolean
    */
    public function loadCurrentState(){
     	$datas=$this->configStore->getConfig("state_machines.user".$this->commandProvider->getUid(),
			array(	"curr_machine"	=>"None",
					"curr_state"	=>"None",
					"time"			=>"0",
					"data"			=>array())
		);

		$this->currMachine=$datas["curr_machine"];
		$this->stateObject->setState($datas["curr_state"]);
		$data		  	  =isset($datas["data"])?$datas["data"]:array();

		$cmd=$this->commandProvider->getCommandText();
		if(strtoupper($cmd)==$this->initCommand){		//初始化命令
			$this->_isInitCommand=true;
			$this->_hasResponse=true;
			$this->currMachine="Base";
			$this->stateObject->setState("Idle");
			return;
		}
		if($this->currMachine=="None" || $this->stateObject->getState()=="None") return;			//当前不在命令行程中
		$timeExpired=time()-(int)$datas["time"] >= $this->expireTime;
		if(!$timeExpired && strtoupper($cmd)==$this->cancelCommand){
			$this->_isCancelCommand=true;
			$this->_hasResponse=true;
			$this->resetState();
			$this->response="您已经退出了命令模式，回到主菜单，请回复[".$this->initCommand."]";
			return;
		}
		if(array_key_exists((string)((int)$cmd-1),$data)){
			$this->_hasResponse=true;
			if(!$timeExpired){
				$this->_isValidCommand=true;
			}else{
				$this->resetState();
				$this->response="你的命令已过期，回复[".$this->initCommand."]初始化新的命令过程。";
				return;
			}
		}else{
			$this->_hasResponse=true;
			if(!$timeExpired){
				$this->responseHeader="你的指令不正确，请回复以下指令：";
			}else{
				$this->resetState();
				$this->response="你的命令已过期,并且指令不正确,回复[".$this->initCommand."]初始化新的命令过程。";
				return;
			}
		}
		$this->commandOptions=new CommandOptions($data);
    }
    
    /**
    * @return   boolean
    */
    private function saveCurrentState(){
     	$this->configStore->saveConfig(
			array(	"curr_machine"	=>$this->currMachine,
					"curr_state"	=>$this->stateObject->getState(),
					"time"			=>(string)time(),
					"data"			=>$this->commandOptions->getOptions()),
			"state_machines.user".$this->commandProvider->getUid()
		);
    }
    
    /**
    * @param    string $id
    * @param    mixed $stateMachine    
    * @return   boolean
    */
    public function registerMachine($id,$stateMachine){
     	$this->machines[$id]=$stateMachine;
    }
    
    /**
    * @param    string $id    
    * @return   mixed
    */
    public function removeMachine($id){
     	unset ($this->machines[$id]);
    }
    
    /**
    * @param    string $id    
    * @return   mixed
    */
    public function getMachine($id){
     	return $this->machines[$id];
    }
    
    /**
    * @return   mixed
    */
    public function currentMachine(){
     	return $this->machines[$this->currMachine];
    }
    
    /**
    * @return   string
    */
    public function apply(){
		if($this->response!==null)return $this->response;
		
		if($this->_isInitCommand){
			$data=array();
			foreach($this->machines as $k=>$m){
				$data[]=array("text"=>$m->getPrompt(),"extra"=>array("id"=>$k));
			}
			$this->commandOptions=new CommandOptions($data);
		}
		if($this->_isValidCommand){
			$cmd=(int)$this->commandProvider->getCommandText();
			//主菜单命令
			$nextMachine_=$this->currMachine;
			if($this->currMachine=="Base" && $this->stateObject->getState()=="Idle"){
				$nextMachine_=$this->commandOptions->getOptions()[$cmd-1]["extra"]["id"];
			}
			$nextMachine=$this->machines[$nextMachine_];

			//实例化状态机
			$stateMachine=new \SM\StateMachine\StateMachine($this->stateObject, $nextMachine->getConfig());
			
			//查找自当前状态的转换
			$transitions=array_values($stateMachine->getPossibleTransitions());
			$transition=preg_split("/ /",$transitions[0]);
			$nextState=$transition[count($transition)-1];
			
			//执行操作
			$param=$this->commandOptions->getOptions()[$cmd-1];
			$param["extra"]=isset($param["extra"])?$param["extra"]:array();
			$param["extra"]["userId"]=$this->commandProvider->getUid();
			
			call_user_func_array(array($nextMachine,"on".$nextState),array($param));
			
			//操作执行成功，则应用转换
			$res=$nextMachine->getResult();
			if($res["isOk"]){
				$stateMachine->apply($transitions[0], true);
				$this->currMachine=$nextMachine_;
				try{
					if($stateMachine->can($this->stateObject->getState().' to Idle')){
						call_user_func_array(array($this->currentMachine(),"onIdle"),array($param));
						$this->resetState();
						$this->responseFooter=$this->initCommand . ":主菜单";
					}
				}catch(\SM\SMException $e){
					
				}
			}
			if($res["responseHeader"]!="") $this->responseHeader=$res["responseHeader"];
			$this->commandOptions=$res["options"];
		}
		$this->saveCurrentState();					//先保存命令状态，下一行附加命令提示信息。
		$this->response=$this->responseHeader."\n".$this->commandOptions->getPrompts();
		$this->response.=$this->responseFooter;
		return $this->response;
    }

    /**
    * @return   boolean
    */
    public function hasResponse(){
     	return $this->_hasResponse;
    }
    
    /**
    * @return   void
    */
    private function resetState(){
     	$this->configStore->clearConfig("state_machines.user".$this->commandProvider->getUid());
		$this->currMachine="None";
		$this->stateObject->setState("None");
    }    
    
    
    

    

}


?>