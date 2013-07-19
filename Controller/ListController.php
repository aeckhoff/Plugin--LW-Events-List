<?php

/**
 * @author Michael Mandt <michael.mandt@logic-works.de>
 * @package lw_events_list
 */

namespace LwEventsList\Controller;

class ListController
{

    protected $response;
    protected $config;
    protected $request;
    
    public function __construct($response, $config, $request)
    {
        $this->response = $response;
        $this->config = $config;
        $this->request = $request;
    }

    public function execute()
    {
        $plugindata = $this->response->getDataByKey("plugindata");
        $queryHandler = new \LwEventsList\Model\DataHandler\QueryHandler($this->response->getDbObject());
        
        switch ($this->request->getAlnum("show")) {
            case "archive":
                $show = "archive";
                $array = $queryHandler->getAllArchivedEvents($plugindata["source"]);
                break;

            case "list":
            default:
                $show = "list";                
                $array = $queryHandler->getAllActualEvents($plugindata["source"]);
                break;
        }
        #print_r($array);die();
        $view = new \LwEventsList\Views\ListView($this->config);        
        $this->response->setOutputByKey("lw_events_list" , $view->render($array, $show, $plugindata["language"], $plugindata["source"]));
    }

}