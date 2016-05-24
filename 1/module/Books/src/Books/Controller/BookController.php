<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Books\Form\BookForm;
use Books\Model\Book;
class BookController extends Controller
{

    public function indexAction()
    {
        return new ViewModel($this->data);
    }

    public function verifyAction()
    {
        return new ViewModel($this->data);
    }

    public function addAction()
    {
		$form=new \Books\Form\BookForm();
		$form->get("id_book")->setValue(0);
		$form->get("id_user")->setValue($this->u['id_user']);
		$request=$this->getRequest();
		if($request->isPost()){
			$book=new Book();
			$form->setInputFilter($book->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()){
				$book->exchangeArray($form->getData());
				$book->save();
				return $this->redirect()->toRoute('book/default',array('controller'=>'book','action'=>'list'),array('query'=>array('id_user'=>$this->u['id_user'])));
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }

    public function deleteAction()
    {
		//query id_article
		$form=new BookForm();
		$request=$this->getRequest();
		if(!$request->isPost()){
			$qd=$request->getQuery();
			$id_book=$qd['id_book'];
			$book=$this->tm->getTable("Book")->get($id_book);
			if(!is_null($book)){
				$form->get("id_book")->setValue($id_book);
				$form->get("submit")->setValue("确认删除？");
			}else{
				$this->data['status']['success']=false;
				$this->data['status']['message']="您要删除的图书不存在，请确认";
			}
		}else{
			$pd=$form->getData();
			$book=$this->tm->getTable("Book")->get($pd["id_book"]);
			if(!is_null($book))$book->delete();
			return $this->redirect()->toRoute('book/default',array('controller'=>'book','action'=>'list'),array('query'=>array('id_user'=>$this->u['id_user'],'page'=>1)));	
		}
		$this->data["form"]=$form;
        return new ViewModel($this->data);
    }

    public function editAction()
    {
		//query:id_book
		$form=new BookForm();
		$request=$this->getRequest();
		if(!$request->isPost()){
			$qd=$request->getQuery();
			$form->bind($this->tm->getTable("Book")->get($qd['id_book']));
			$form->get("submit")->setValue("提交");
		}else{
			$book=new Book();
			$form->setInputFilter($book->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()){
				$book->exchangeArray($form->getData());
				$book->save();
				$id_book=$book['id_book'];
				$this->redirect()->toRoute('book/default',array('controller'=>'book','action'=>'page'),array('query'=>array('id_book'=>$id_book)));
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }

    public function listAction()
    {
		//query id_user page
		$qd=$this->getRequest()->getQuery();
		$this->data["id_user"]=$id_user=$qd["id_user"];
		$page=$qd["page"];
		$user=$this->tm->getTable("User")->get($id_user);
		$paginator=null;
		if(!is_null($user)){
			$books=$user->getBooks();
			$paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($books));
		}else{
			$paginator=$this->tm->getTable("Book")->fetchAll("","",-1,-1,true);
		}
		$paginator->setCurrentPageNumber($page);
		$this->data["paginator"]=$paginator;
        return new ViewModel($this->data);
    }

    public function pageAction()
    {
		//query id_book
		$qd=$this->getRequest()->getQuery();
		$id_book=$qd["id_book"];
		$this->data["book"]=$this->tm->getTable("Book")->get($id_book);
        return new ViewModel($this->data);
    }

    public function borrowAction()
    {
		//query id_book
		$qd=$this->getRequest()->getQuery();
		$id_book=$qd["id_book"];
		$this->data["book"]=$book=$this->tm->getTable("Book")->get($id_book);
		$this->data["ok"]=$this->u->borrowBookRequest($book);
        return new ViewModel($this->data);
    }

    public function cancelAction()
    {
		//query id_book
		$qd=$this->getRequest()->getQuery();
		$id_book=$qd["id_book"];
		$this->data["book"]=$book=$this->tm->getTable("Book")->get($id_book);
		$this->data["ok"]=$this->u->borrowBookCancel($book);
        return new ViewModel($this->data);
    }

    public function returnAction()
    {
		//query id_book
		$qd=$this->getRequest();
		$id_book=$qd["id_book"];
		$this->data["book"]=$book=$this->tm->getTable("Book")->get($id_book);
		$this->data["ok"]=$this->u->returnBook($book);
        return new ViewModel($this->data);
    }

    public function payPledgeAction()
    {
		//query id_book
		$qd=$this->getRequest();
		$id_book=$qd["id_book"];
		$this->data["book"]=$book=$this->tm->getTable("Book")->get($id_book);
		$this->data["ok"]=$this->u->payPledge($book);
        return new ViewModel($this->data);
    }


}

