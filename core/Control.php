<?php
namespace core;

class Control
{

    public $assign = array();

    public function assign($name, $value)
    {
        $this->assign[$name] = $value;
    }

    public function display_normal($file)
    {
        $file = SILVER . VIEW . $file;
        extract($this->assign);
        if (is_file($file)) {
            include $file;
        }
    }

    //https://twig.sensiolabs.org/doc/1.x/api.html
    public function display($file)
    {
        $loader = new \Twig_Loader_Filesystem(SILVER . VIEW);
        $twig = new \Twig_Environment($loader, array(
            'cache' => SILVER . '/cache/twig/',
            'debug' => DEBUG)
        );
        echo $twig->render($file, $this->assign);

    }

    public function error($error = '')
    {
        $res = array();
        $res['ok'] = false;
        $res['result'] = $error;
        echo json_encode($res);
    }

    public function success($obj)
    {
        $res = array();
        $res['ok'] = true;
        $res['result'] = $obj;
        echo json_encode($res);
    }

    public function result($ok, $obj, $error = '')
    {
        $res = array();
        $res['ok'] = $ok;
        $res['result'] = $ok == true ? $obj : $error;
        echo json_encode($res);
    }

    protected function redirect($control, $action, $requestPara = array())
    {
        $paraString='';
        if (count($requestPara)>0) {
            $paraString='?';
            foreach ($requestPara as $key => $value) {
                $paraString.=$key.'='.$value.'&';
            }
            $paraString=rtrim($paraString,'&');
        }
        header("Location:/" . $control . '/' . $action.$paraString);
    }

    public function redirect500($message='')
    {
        $this->assign('message',$message);
        $this->display('500.html');
    }
}
