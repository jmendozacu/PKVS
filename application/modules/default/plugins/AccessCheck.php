<?php
class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract
{

    private $_acl = null;

    public function __construct(Zend_Acl $acl)
    {
        $this->_acl = $acl;
    }

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $module = $request->getModuleName();
        $resource = $request->getControllerName();
        $action = $request->getActionName();


        /** Testēšanas nolūkos, lai nelec visu laiku ārā paziņojumi par neeksistējošu resursu */
        if (APPLICATION_ENV == "production") {
            try {
                if (!$this->_acl->isAllowed(Zend_Registry::get('role'), $module . ':' . $resource, $action)) {
                    //$this->getActionController()->
                    var_dump($module);
                    var_dump($resource);
                    var_dump($action);
                    var_dump($module . ':' . $resource);

                    $request->setControllerName('authentication')->setModuleName('default')
                            ->setActionName('login');
                }
            }
            catch (Exception $ex) {
                var_dump($ex);

            }
        }
    }

}
