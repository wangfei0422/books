<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Books\Form\UserForm;
use Books\Model\User;
use Zend\Form\Form;
use Books\Form\BookTypeForm;
class UserController extends Controller
{
    public function indexAction()
    {
		//return $this->redirect()->toRoute('book/default',array('controller'=>'user','action'=>'list'),array('query'=>array('a'=>'b')));
        return new ViewModel($this->data);
    }

    public function addAction()
    {
		$form=new UserForm();
		$form->get("id_user")->setValue(0);
		$request=$this->getRequest();
		if($request->isPost()){
			$user=new User();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()){
				$user->exchangeArray($form->getData());
				if(!$this->tm->getTable("User")->hasUser($user['name'])){
					$user->save();
					$this->um->logIn($user);
					return $this->redirect()->toRoute('home');					
				}
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }

    public function deleteAction()
    {	
		$form=new UserForm();
		$request=$this->getRequest();
		if(!$request->isPost()){
			$qd=$request->getQuery();
			$id_user=$qd['id_user'];
			$user=$this->tm->getTable("User")->get($id_user);
			if(!is_null($user)){
				$form->get("id_user")->setValue($id_user);
				$form->get("submit")->setValue("确认删除？");
			}else{
				$data->data['status']['success']=false;
				$data->data['status']['message']="您要删除的用户不存在，请确认";
			}
		}else{
			$fd=$form->getData();
			$user=$this->tm->getTable("User")->get($fd["id_user"]);
			if(is_null($user))$user->delete();
			return $this->redirect()->toRoute('book/default',array('controller'=>'user','action'=>'list'));	
		}
		$this->data["form"]=$form;
        return new ViewModel($this->data);
    }

    public function editAction()
    {
		//query:id_user
		$form=new UserForm();
		$request=$this->getRequest();
		if(!$request->isPost()){
			$qd=$request->getQuery();
			$form->bind($this->tm->getTable("User")->get($qd['id_user']));		
			$form->get("submit")->setValue("提交");			
		}
		else{
			$user=new User();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()){
				$user->exchangeArray($form->getData());
				$user->save();
				$id_user=$user['id_user'];
				$this->redirect()->toRoute('book/default',array('controller'=>'user','action'=>'page'),array('query'=>array('id_user'=>$id_user)));
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }

    public function listAction()
    {
		$this->data["paginator"]=$this->tm->getTable("User")->fetchAll("","",-1,-1,true);
        return new ViewModel($this->data);
    }

    public function pageAction()
    {
		//query:id_user
		$request=$this->getRequest();
		$qd=$request->getQuery();
		$this->data['user']=$this->tm->getTable("User")->get($qd['id_user']);
        return new ViewModel($this->data);
    }

    public function exitAction()
    {
		$this->um->logOut();
		$this->redirect()->toRoute("main_page");
        return new ViewModel($this->data);
    }

    public function userManageAction()
    {
		$this->data["paginator"]=$this->tm->getTable("User")->fetchAll("","",-1,-1,true);
        return new ViewModel($this->data);
    }

    public function bookManageAction()
    {
		$this->data["paginator"]=$this->tm->getTable("Book")->fetchAll("","",-1,-1,true);
        return new ViewModel($this->data);
    }

    public function bookFeedbackManageAction()
    {
		$this->data["paginator"]=$this->tm->getTable("BookFeedback")->fetchAll("","",-1,-1,true);
        return new ViewModel($this->data);
    }

    public function articleManageAction()
    {
		$this->data["paginator"]=$this->tm->getTable("Article")->fetchAll("","",-1,-1,true);
        return new ViewModel($this->data);
    }

    public function articleFeedbackManageAction()
    {
		$this->data["paginator"]=$this->tm->getTable("ArticleFeedback")->fetchAll("","",-1,-1,true);
        return new ViewModel($this->data);
    }

    public function logManageAction()
    {
		
        return new ViewModel($this->data);
    }

    public function configManageAction()
    {
		
        return new ViewModel($this->data);
    }

    public function bookTypeManageAction()
    {
		$cm=$this->cm;
		$form=new BookTypeForm();
		$request=$this->getRequest();
		if($request->isPost()){
			$fd=$request->getPost();
			$cm->addBookType(array('name'=>$fd['name'],'description'=>$fd['description']));
		}
		$this->data['form']=$form;
		$this->data['types']=$this->cm->getBookTypes();
        return new ViewModel($this->data);
    }

    public function notManagerAction()
    {
        return new ViewModel($this->data);
    }


}

