<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BookController extends AbstractActionController
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

    public function borrowAction()
    {
        return new ViewModel($this->data);
    }

    public function cancelAction()
    {
        return new ViewModel($this->data);
    }

    public function returnAction()
    {
        return new ViewModel($this->data);
    }

    public function payPledgeAction()
    {
        return new ViewModel($this->data);
    }


}

