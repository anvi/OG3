<?php

class Default_IndexController extends Zend_Controller_Action
{
    public function init()
    {
    }

    public function indexAction()
    {

    }

    public function errorAction()
    {
        throw new Exception($this->view->translate('default.error_occured_line%d', __LINE__));
    }

    public function aboutAction()
    {

    }

    public function contactAction()
    {

    }

    public function sitemapAction()
    {

    }

    public function listTableAction()
    {

        $db = Zend_Db_Table::getDefaultAdapter();

        if (empty($db)) {
            throw new Exception('No database defined');
        }
        $this->view->tableList = $db->listTables();
        array_unshift($this->view->tableList, '');

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost();
            if (isset($data['process']) && isset($this->view->tableList[$data['table']])) {
                $this->view->table = $data['table'];
                $this->view->tableInfo = $db->describeTable($this->view->tableList[$this->view->table]);
            }
        }
    }
}
