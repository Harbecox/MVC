<?php

class Controller_home extends Controller
{

    protected $permission = 0;

    function action_index()
    {
        $this->view->generate("home.php");
    }

}
