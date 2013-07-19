<?php

/**
 * @author Michael Mandt <michael.mandt@logic-works.de>
 * @package lw_events_calendar
 */

namespace LwEventsList\Views;

class ListView
{

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function render($array, $show, $lang, $source)
    {
        if($show == "list"){
            $view = new \lw_view(dirname(__FILE__) . '/Templates/List.phtml');
        }else{
            $view = new \lw_view(dirname(__FILE__) . '/Templates/ListArchived.phtml');
        }

        $baseUrl = \lw_page::getInstance($source)->getUrl();
        $view->baseUrl = $baseUrl;
        $view->baseUrlWithoutIndex = substr($baseUrl, 0, strpos($baseUrl, "index=") + strlen("index="));
        $view->lang = $lang;
        $view->array = $array;

        return $view->render();
    }
    
}