<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Books\Form\UserForm;
use Zend\Form\Element;
class IndexController extends Controller
{

    public function indexAction()
    {
		//如果登录，则跳转至用户页，若没有，则跳转至singIn
		if($this->um->isLogged()){
			$this->redirect()->toRoute("book/default",array('controller'=>'user','action'=>'page'));
		}else{
			$this->redirect()->toRoute("sign_in");			
		}
        return new ViewModel($this->data);
    }
	
	//主页action
    public function startAction()
    {
		$tm=$this->tm;
		$this->data["users"]=$tm->getTable("User")->fetchAll()->toArray();
		$this->data["books"]=$tm->getTable("Book")->fetchAll()->toArray();
		$this->data["articles"]=$tm->getTable("Article")->fetchAll()->toArray();
        return new ViewModel($this->data);
    }

    public function signInAction()
    {
		$form=new UserForm();
		$form->get("submit")->setValue("登录");
		$request=$this->getRequest();
		if($request->isPost()){
			$f=$request->getPost();
			$name=$f["name"];
			$pw=$f["pw"];
			$user=$this->tm->getTable("User")->getWithName($name);
			if(!is_null($user)){
				if($user["pw"]==$pw){								////////////////$pw为何为空？
					$this->um->logIn($user);
					$c=$this->um->getContainer();
					if(isset($c["jump_url"])){
						$jump_url=urldecode($c["jump_url"]);
						unset($c["jump_url"]);
						return $this->prg($jump_url,true);
					}
					$this->redirect()->toRoute("main_page");					
				}
				$this->data["status"]["sucess"]=false;
				$this->data["status"]["message"]="密码错误，请核对密码。";
			}else{
				$this->data["status"]["sucess"]=false;
				$this->data["status"]["message"]="用户不存在，请核对用户名。";
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }


}

