<?php

/**
 * @author Michael Mandt <michael.mandt@logic-works.de>
 * @package lw_events_list
 */
class lw_events_list extends lw_plugin
{

    protected $db;
    protected $request;
    protected $response;
    protected $config;

    /**
     * For the functionality of this plugin is it necessary to include
     * the "Autoloader" and the instances of "in_auth" and "auth"
     * objects.
     */
    public function __construct()
    {
        parent::__construct();
        include_once(dirname(__FILE__) . '/Services/Autoloader.php');
        $autoloader = new \LwEventsList\Services\Autoloader();
        $this->response = new \LwEventsList\Services\Response();
    }

    /**
     * The HTML frontend output will be build for logged in user. Not logged in
     * user will be redirected to the login page. 
     * 
     * @return string
     */
    public function buildPageOutput()
    {    
        if (array_key_exists("source", $this->params)) {
            
            if (array_key_exists("language", $this->params)) {
                $plugindata["parameter"]["language"] = $this->params["language"];
            }
            else {
                $plugindata["parameter"]["language"] = "en";
            }
            
            $plugindata["parameter"]["source"] = $this->params["source"];
        }
        else {
            die("Plugin-Aufruf nicht korrekt! Bsp. : [PLUGIN:lw_events_list?source=22&language=de]");
        }

        $response = new \LwEventsList\Services\Response();
        $response->setDbObject($this->db);
        $response->setDataByKey("plugindata", $plugindata["parameter"]);

        $controller = new \LwEventsList\Controller\ListController($response, $this->config, $this->request);
        $controller->execute();

        return $response->getOutputByKey("lw_events_list");
    }

    /**
     * The HTML backend output will be build.
     * 
     * @return string
     */
    public function getOutput()
    {
        return "";
    }

    /**
     * Here will be set if the plugin-conetentbox is deleteable from a page.
     * 
     * @return boolean
     */
    function deleteEntry()
    {
        return true;
    }
}