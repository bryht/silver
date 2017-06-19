<?php

namespace core;

class Route
{

    public $control;
    public $action;

    public function __construct()
    {
       
        if (isset($_SERVER['PATH_INFO'])) {
            $request_uri = $_SERVER['PATH_INFO'];
            $patharr = explode('/', $request_uri);
            if (count($patharr) > 2 && $patharr[1] == 'api') {
                $this->control = API_RELATIVE . ucwords($patharr[2]) . 'Api'; // \app\api\indexApi
                $this->action = $patharr[3];
            } else if (count($patharr) > 1) {
                $this->control = CONTROL_RELATIVE . ucwords($patharr[1]) . 'Control'; //\app\control\indexControl
                $this->action = $patharr[2];
            }
        } else {
            $conf = Conf::get_init_index();
            $this->control = CONTROL_RELATIVE.ucwords($conf['control']).'Control';
            $this->action = $conf['action'];
        }

    }

}
