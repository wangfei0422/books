<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Books\Form\UserForm;
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

    public function signInAction()
    {
		$form=new UserForm();
		$form->get("submit")->setValue("登录");
		$request=$this->getRequest();
		if($request->isPost()){
			$user=$this->tm->getTable("User")->getWithName($form->get("name")->getValue());
			if($user!=null){
				$this->um->logIn($user);
				$this->redirect()->toRoute("book/default",array('controller'=>'user','action'=>'page'));
			}else{
				$this->data["no_user"]=true;
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }


}

