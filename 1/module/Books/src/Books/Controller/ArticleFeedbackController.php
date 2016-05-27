<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Books\Model\ArticleFeedback;
use Books\Form\ArticleFeedbackForm;
class ArticleFeedbackController extends Controller
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
		//query id_article
		$request=$this->getRequest();
		$qd=$request->getQuery();
		$form=new ArticleFeedbackForm();
		$form->get("id")->setValue(0);
		$form->get("id_article")->setValue($qd["id_article"]);
		$form->get("id_user")->setValue($this->u['id_user']);
		$request=$this->getRequest();
		if($request->isPost()){
			$articleFeedback=new ArticleFeedback();
			$form->setInputFilter($articleFeedback->getInputFilter());
			$pd=$request->getPost();
			$form->setData($pd);
			if($form->isValid()){
				$articleFeedback->exchangeArray($form->getData());
				$articleFeedback->save();
				$id_article=$pd["id_article"];
				return $this->redirect()->toRoute('book/default',array('controller'=>'article','action'=>'page'),array('query'=>array('id_article'=>$id_article)));
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }

    public function deleteAction()
    {
		//query id
		$form=new ArticleFeedbackForm();
		$request=$this->getRequest();
		if(!$request->isPost()){
			$qd=$request->getQuery();
			$id=$qd['id'];
			$articleFeedback=$this->tm->getTable("ArticleFeedback")->get($id);
			if(!is_null($articleFeedback)){
				$form->get("id")->setValue($id);
				$form->get("submit")->setValue("确认删除？");
			}else{
				$this->data['status']['success']=false;
				$this->data['status']['message']="您要删除的文章回复不存在，请确认";
			}
		}else{
			$pd=$request->getPost();
			$articleFeedback=$this->tm->getTable("ArticleFeedback")->get($pd["id"]);
			if(!is_null($articleFeedback)){
				$id_article=$articleFeedback["id_article"];
				$articleFeedback->delete();
				return $this->redirect()->toRoute('book/default',array('controller'=>'article','action'=>'page'),array('query'=>array('id_article'=>$id_article)));	
			}
			return $this->redirect()->toRoute('book/default',array('controller'=>'article','action'=>'list'),array('query'=>array('page'=>1)));	
		}
		$this->data["form"]=$form;
        return new ViewModel($this->data);
    }

    public function editAction()
    {
		//query:id
		$form=new ArticleFeedbackForm();
		$request=$this->getRequest();
		if(!$request->isPost()){
			$qd=$request->getQuery();
			$form->bind($this->tm->getTable("ArticleFeedback")->get($qd['id']));
			$form->get("submit")->setValue("提交");
		}else{
			$articleFeedback=new ArticleFeedback();
			$form->setInputFilter($articleFeedback->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()){
				$articleFeedback->exchangeArray($form->getData());
				$articleFeedback->save();
				$id_article=$articleFeedback['id_article'];
				$this->redirect()->toRoute('book/default',array('controller'=>'article','action'=>'page'),array('query'=>array('id_article'=>$id_article)));
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }


}

