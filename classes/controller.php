<?php

abstract class Controller
{
    protected $model;
    protected $view;
    protected $data;
    protected $permission = 0;

            function __construct($model)
    {
        session_start();
        $this->model = new $model;
        $this->view = new View();
        $this->data = &$this->view->data;
        $this->view->header = $this->model->getHeader();
        $this->view->footer = $this->model->getFooter();
        if($_POST){
            $_POST = $this->h_encode($_POST);
        }
    }

    abstract protected function action_index();

    // public function checkPermision(){
    //     if($this->permission > $_SESSION['user']['role'] ){
    //         if($this->permission == 1){
    //             header("location:/login");
    //         }else{
    //             header("location:/admin_login");
    //         }
    //     }
    // }
    
    
    protected function h_decode($arr){
        if(!is_array($arr)){
            return $arr;
        }
        foreach ($arr as $k => $v) {
            if(is_array($v)){
                $arr[$k] = $this->h_decode($v);
            }else{
                $arr[$k] = htmlspecialchars_decode($v);
                $arr[$k] = str_replace("<ul>", "<p><ul>", $arr[$k]);
                $arr[$k] = str_replace("</ul>", "</ul></p>", $arr[$k]);
            }
        }
        return $arr;
    }

    protected function h_encode($arr){
        foreach ($arr as $k => $v) {
            if(is_array($v)){
                $arr[$k] = $this->h_decode($v);
            }else{
                $arr[$k] = htmlspecialchars($v,ENT_QUOTES);
            }
        }
        return $arr;
    }


}