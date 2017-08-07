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

Class View {

    protected $template;
    protected $controller;
    protected $module;
    protected $mainLayoutName = 'main';
    protected $params = array();

    function __construct($module,$controller,$params) {
        $this->module = $module;
        $this->controller = $controller;
        $this->params = $params;
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
        $mainLayoutFullPath = LAYOUT_BASEDIR . '/' . $this->mainLayoutName . '.php';
        return $this->fetchPartial($mainLayoutFullPath, ['content' => $template]);


    }

}