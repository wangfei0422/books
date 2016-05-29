<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Books\Model\BookFeedback;
use Books\Form\BookFeedbackForm;
class BookFeedbackController extends Controller
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
		//query id_book_borrowed
		$request=$this->getRequest();
		$qd=$request->getQuery();
		$form=new BookFeedbackForm();
		$form->get("id")->setValue(0);
		$form->get("id_book_borrowed")->setValue($qd["id_book_borrowed"]);
		$form->get("id_user")->setValue($this->u['id_user']);
		$request=$this->getRequest();
		if($request->isPost()){
			$bookFeedback=new BookFeedback();
			$form->setInputFilter($bookFeedback->getInputFilter());
			$pd=$request->getPost();
			$form->setData($pd);
			if($form->isValid()){
				$bookFeedback->exchangeArray($form->getData());
				$bookFeedback->save();
				$id_book_borrowed=$pd["id_book_borrowed"];
				$borrow=$this->tm->getTable("BorrowedRecord")->get($id_book_borrowed);
				$id_book=$borrow['id_book'];
				return $this->redirect()->toRoute('book/default',array('controller'=>'book','action'=>'page'),array('query'=>array('id_book'=>$id_book)));
			}
		}
		$borrow=$this->tm->getTable("BorrowedRecord")->get($qd["id_book_borrowed"]);
		$this->data["book"]=$this->tm->getTable("Book")->get($borrow["id_book"]);
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }

    public function deleteAction()
    {
		//query id
		$form=new BookFeedbackForm();
		$request=$this->getRequest();
		if(!$request->isPost()){
			$qd=$request->getQuery();
			$id=$qd['id'];
			$bookFeedback=$this->tm->getTable("BookFeedback")->get($id);
			if(!is_null($bookFeedback)){
				$form->get("id")->setValue($id);
				$form->get("submit")->setValue("确认删除？");
			}else{
				$this->data['status']['success']=false;
				$this->data['status']['message']="您要删除的文章回复不存在，请确认";
			}
		}else{
			$pd=$request->getPost();
			$bookFeedback=$this->tm->getTable("BookFeedback")->get($pd["id"]);
			if(!is_null($bookFeedback)){
				$id_book_borrowed=$bookFeedback["id_book_borrowed"];
				$borrow=$this->tm->getTable("BorrowedRecord")->get($id_book_borrowed);
				$id_book=$borrow['id_book'];
				$bookFeedback->delete();
				return $this->redirect()->toRoute('book/default',array('controller'=>'book','action'=>'page'),array('query'=>array('id_book'=>$id_book)));	
			}

			return $this->redirect()->toRoute('book/default',array('controller'=>'book','action'=>'list'),array('query'=>array('page'=>1)));	
		}
		$this->data["form"]=$form;
        return new ViewModel($this->data);
    }

    public function editAction()
    {
		//query:id
		$form=new BookFeedbackForm();
		$request=$this->getRequest();
		if(!$request->isPost()){
			$qd=$request->getQuery();
			$form->bind($this->tm->getTable("BookFeedback")->get($qd['id']));
			$form->get("submit")->setValue("提交");
		}else{
			$bookFeedback=new BookFeedback();
			$form->setInputFilter($bookFeedback->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()){
				$bookFeedback->exchangeArray($form->getData());
				$bookFeedback->save();
				$id_book_borrowed=$bookFeedback['id_book_borrowed'];
				$borrow=$this->tm->getTable("BorrowedRecord")->get($id_book_borrowed);
				$id_book=$borrow['id_book'];
				$this->redirect()->toRoute('book/default',array('controller'=>'book','action'=>'page'),array('query'=>array('id_book'=>$id_book)));
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }


}

