<?php
namespace core;

class control{

    public $assign;
    public function assign($name,$value){
        $this->assign[$name]=$value;
    }

    public function display($file){
        $file=SILVER.VIEW.$file;
        extract($this->assign);
        if (is_file($file)) {
            include $file;
        }
    }


}
