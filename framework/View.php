<?php
/**
 * Created by PhpStorm.
 * User: Vitalik
 * Date: 05.08.2017
 * Time: 16:09
 */

namespace Framework;
define('LAYOUT_BASEDIR', dirname(__FILE__). '/../src/Common/layouts');
define('SRC_BASEDIR', dirname(__FILE__). '/../src');
use Framework\Registry;
Class View {

    protected $registry;
    protected $template;
    protected $controller;
    protected $module;
    protected $mainLayoutName = 'main';
    protected $params = array();

    function __construct($module,$controller,$params) {
        $this->module = $module;
        $this->controller = $controller;
        $this->params = $params;
        $this->registry = Registry::getInstance();
    }
    public function _partial($templatePath, $params = array()){
        $path = SRC_BASEDIR . '/' . $this->module . '/' . 'views/' . lcfirst($this->controller) . '/' . $templatePath;
        extract($params);
         include ($path);
    }


    protected function fetchPartial($templatePath, $params = array()){
        extract($params);
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }


    public function renderTemplate($templateName = '', $layoutName = '')
    {
        if (!strlen($templateName)) {
            throw new \Exception('Empty template name');
        }
        //template content
        $templFullPath = SRC_BASEDIR . '/' . $this->module . '/' . 'views/' . lcfirst($this->controller) . '/' . $templateName . '.php';
        $template = $this->fetchPartial($templFullPath, $this->params);

        //module related layout wrapping
        if (strlen($layoutName)) {
            $layoutFullPath = SRC_BASEDIR . '/' . $this->module . '/' . 'layouts/' . $layoutName . '.php';
            $template = $this->fetchPartial($layoutFullPath, ['content' => $template]);
        }
        $flashes = [];
        if(isset($this->registry['flashes'])){
            $flashes = $this->registry->flashes;
            unset($this->registry->flashes);
        }
        $mainLayoutFullPath = LAYOUT_BASEDIR . '/' . $this->mainLayoutName . '.php';
        return $this->fetchPartial($mainLayoutFullPath, ['content' => $template,'flashes'=>$flashes]);


    }

}