<?php

namespace Books\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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


}

