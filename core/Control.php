<?php
namespace core;

class Control
{
    function __construct($foo = null) {
       
        if (session_get('user_id')==false) {
            $this->redirect('login','login');
        }
        $this->assign('user_id',session_get('user_id'));
        $this->assign('user_name',session_get('user_name'));
    }

    public $assign = array();
    public function assign($name, $value)
    {
        $this->assign[$name]=$value;
    }

    public function display_normal($file)
    {
        $file=SILVER.VIEW.$file;
        extract($this->assign);
        if (is_file($file)) {
            include $file;
        }
    }

    //https://twig.sensiolabs.org/doc/1.x/api.html
    public function display($file)
    {
        $loader = new \Twig_Loader_Filesystem(SILVER.VIEW);
        $twig = new \Twig_Environment($loader, array(
            'cache' => SILVER.'/cache/twig/',
            'debug' => DEBUG)
        );
        echo $twig->render($file, $this->assign);

    }

    protected function redirect($control,$action, $requestPara= array()){
        header("Location:/".$control.'/'.$action); 
    }
}
