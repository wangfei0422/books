<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Books\Form\ArticleForm;
use Books\Model\Article;
class ArticleController extends Controller
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
		$form=new ArticleForm();
		$form->get("id_article")->setValue(0);
		$form->get("id_user")->setValue($this->u['id_user']);
		$request=$this->getRequest();
		if($request->isPost()){
			$article=new Article();
			$form->setInputFilter($article->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()){
				$article->exchangeArray($form->getData());
				$article->save();
				return $this->redirect()->toRoute('book/default',array('controller'=>'article','action'=>'list'),array('query'=>array('id_user'=>$this->u['id_user'],'page'=>1)));
			}
		}
		$this->data['form']=$form;
        return new ViewModel($this->data);
    }

    public function deleteAction()
    {
		//query id_article
		$form=new ArticleForm();
		$request=$this->getRequest();
		if(!$request->isPost()){
			$qd=$request->getQuery();
			$id_article=$qd['id_article'];
			$article=$this->tm->getTable("Article")->get($id_article);
			if(!is_null($article)){
				$form->get("id_article")->setValue($id_article);
				$form->get("submit")->setValue("确认删除？");
			}else{
				$this->data['status']['success']=false;
				$this->data['status']['message']="您要删除的文章不存在，请确认";
			}
		}else{
			$pd=$request->getPost();
			$article=$this->tm->getTable("Article")->get($pd["id_article"]);
			if(!is_null($article))$article->delete();
			return $this->redirect()->toRoute('book/default',array('controller'=>'article','action'=>'list'),array('query'=>array('id_user'=>$this->u['id_user'],'page'=>1)));	
		}
		$this->data["form"]=$form;
        return new ViewModel($this->data);
    }

    public function editAction()
    {
		//query:id_article
		$form=new ArticleForm();
		$request=$this->getRequest();
		if(!$request->isPost()){
			$qd=$request->getQuery();
			$form->bind($this->tm->getTable("Article")->get($qd['id_article']));
			$form->get("submit")->setValue("提交");
		}else{
			$article=new Article();
			$form->setInputFilter($article->getInputFilter());
			$form->setData($request->getPost());
			if($form->isValid()){
				$article->exchangeArray($form->getData());
				$article->save();
				$id_article=$article['id_article'];
				$this->redirect()->toRoute('book/default',array('controller'=>'article','action'=>'page'),array('query'=>array('id_article'=>$id_article)));
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
			$articles=$user->getArticles();
			$paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($articles));
		}else{
			$paginator=$this->tm->getTable("Article")->fetchAll("","",-1,-1,true);
		}
		$paginator->setCurrentPageNumber($page);
		//$paginator->setItemCountPerPage(1);
		$this->data["paginator"]=$paginator;
        return new ViewModel($this->data);
    }

    public function pageAction()
    {
		//query id_article
		$qd=$this->getRequest()->getQuery();
		$id_article=$qd["id_article"];
		$article=$this->tm->getTable("Article")->get($id_article);
		$article->increaseBrowseCount();
		$this->data["feedbacks"]=$article->getFeedbacks();
		$this->data["user"]=$article->getUser();
		$this->data["article"]=$article;
        return new ViewModel($this->data);
    }


}

