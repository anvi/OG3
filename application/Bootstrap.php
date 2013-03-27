<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initNavigation()
    {
        $config    = new Zend_Config_Json(APPLICATION_PATH . '/configs/navigation.json');
        Zend_Registry::set('Zend_Navigation', new Zend_Navigation($config));
    }
}

