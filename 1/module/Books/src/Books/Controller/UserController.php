<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends Controller
{

    public function indexAction()
    {
        return new ViewModel($this->data);
    }

    public function addAction()
    {
        return new ViewModel($this->data);
    }

    public function deleteAction()
    {
        return new ViewModel($this->data);
    }

    public function editAction()
    {
        return new ViewModel($this->data);
    }

    public function listAction()
    {
        return new ViewModel($this->data);
    }

    public function pageAction()
    {
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
        return new ViewModel($this->data);
    }

    public function bookManageAction()
    {
        return new ViewModel($this->data);
    }

    public function bookFeedbackManageAction()
    {
        return new ViewModel($this->data);
    }

    public function articleManageAction()
    {
        return new ViewModel($this->data);
    }

    public function articleFeedbackManageAction()
    {
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
        return new ViewModel($this->data);
    }

    public function notManagerAction()
    {
        return new ViewModel($this->data);
    }


}

