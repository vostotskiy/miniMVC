<?php
namespace Framework;
/**
 * base directory for main template
 */
define('LAYOUT_BASEDIR', dirname(__FILE__) . '/../src/Common/layouts');
/**
 * base directory for modules templates
 */
define('SRC_BASEDIR', dirname(__FILE__) . '/../src');

use Framework\Registry;

/**
 * Class View used for view rendering and data keeping
 * @package Framework
 */
Class View
{

    /** Registry instance
     * @var \Framework\Registry|null
     */
    protected $registry;
    /** current controller data
     * @var mixed
     */
    protected $controller;
    /**
     * module instance
     * @var mixed
     */
    protected $module;
    /**
     * @var string
     */
    protected $mainLayoutName = 'main';
    /**array of variables to be rendered
     * @var array
     */
    protected $params = array();

    /**
     * View constructor.
     * @param $module
     * @param $controller
     * @param $params
     */
    function __construct($module, $controller, $params)
    {
        $this->module = $module;
        $this->controller = $controller;
        $this->params = $params;
        $this->registry = Registry::getInstance();
    }

    /** render partial template inside controller's template
     * @param $templatePath path to template from current views folder
     * @param array $params variables
     */
    public function _partial($templatePath, $params = array())
    {
        $path = SRC_BASEDIR . '/' . $this->module . '/' . 'views/' . lcfirst($this->controller) . '/' . $templatePath;
        extract($params);
        include($path);
    }


    /** compile template
     * @param $templatePath
     * @param array $params
     * @return string
     */
    protected function fetchPartial($templatePath, $params = array())
    {
        extract($params);
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }


    /** main method, that renders main layout, including module layout and current view
     * @param string $templateName
     * @param string $layoutName
     * @return string
     * @throws \Exception
     */
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
        $flashes = $this->registry->flashes;
        unset($this->registry->flashes);

        $mainLayoutFullPath = LAYOUT_BASEDIR . '/' . $this->mainLayoutName . '.php';
        return $this->fetchPartial($mainLayoutFullPath, ['content' => $template, 'flashes' => $flashes]);


    }

}