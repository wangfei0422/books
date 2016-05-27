<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Books\Form\UserForm;
use Zend\Form\Element;
use Books\Model\User;
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
 		$u=$this->tm->getTable("User");
		$b=$this->tm->getTable("Book");
		$a=$this->tm->getTable("Article");
		//图书类型
		$this->data["book_types"]=$this->cm->getBookTypes();
		//图书推荐
		$this->data["books_top_borrowed"]=$books=$b->getTopBorrowed();
		//大四专场
		$books2=$b->getBooksByUserType(User::TYPE_SENIOR,$books);
		$this->data["books_for_senior"]=$b->getBooksByType("",$books2);
		//文章推荐
		$this->data["articles_top_browsed"]=$a->getTopBrowsed();
		//猜你喜欢
		if(!is_null($this->u)){
			$books2=$this->u->getBooksCurrBorrowed();
			$types=[];
			foreach($books2 as $book){
				$type=$book->getType();
				if(!in_array($type,$types))$types[]=$type;
			}
			$this->data["guess_your_love"]=$b->getBooksByType($types,$books);
		}
        return new ViewModel($this->data);
    }

    public function signInAction()
    {
		$form=new UserForm();
		$e=$form->get("name");
		$e->setAttributes(array("placeholder"=>$e->getLabel()));
		$e->setLabel("");
		$e=$form->get("pw");
		$e->setAttributes(array("placeholder"=>$e->getLabel()));
		$e->setLabel("");
		$form->get("submit")->setValue("登录");
		
		$request=$this->getRequest();
		if($request->isPost()){
			$f=$request->getPost();
			$name=$f["name"];
			$pw=$f["pw"];
			$user=$this->tm->getTable("User")->getWithName($name);
			if(!is_null($user)){
				if($user["pw"]==$pw){
					$this->um->logIn($user);
					$c=$this->um->getContainer();
					if(isset($c["jump_url"])){
						$jump_url=urldecode($c["jump_url"]);
						unset($c["jump_url"]);
						return $this->prg($jump_url,true);
					}
					return $this->redirect()->toRoute("main_page");					
				}
				$this->data["status"]["success"]=false;
				$this->data["status"]["message"]="密码错误，请核对密码。";
			}else{
				$this->data["status"]["success"]=false;
				$this->data["status"]["message"]="用户不存在，请核对用户名。";
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }


}

