<?php

class Customer_IndexController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $customerMapper = new Customer_Model_CustomerMapper();

        $this->view->civility = array(1 => 'customer.mister_abrev', 2 => 'customer.missis_abrev', 3 => 'customer.miss_abrev');
        $this->view->customer = $customerMapper->get(1);

    }

}
