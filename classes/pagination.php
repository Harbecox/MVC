<?php

class Pagination{

    private $currentPage = 1;
    private $pagesCount = 100;
    private $countInPage = 20;

    public function setCurrentPage($page){
        $this->currentPage = $page;
        return $this;
    }

    public function setPagesCount($count){
        $this->pagesCount = $count;
        return $this;
    }

    public function setCountInPage($count){
        $this->countInPage = $count;
        return $this;
    }

    public function get(){

        $count = ceil($this->pagesCount/$this->countInPage);
        $out = array();
        if($count == 1){
            return $out;
        }
        if($count <= 5){
            for($i=1;$i<=$count;$i++){
                array_push($out,$i);
            }
            return $out;
        }

        if($this->currentPage == 1 || $this->currentPage == 2){
            array_push($out,1);
            array_push($out,2);
            array_push($out,3);
            array_push($out,null);
            array_push($out,$count);
            return $out;
        }

        if($this->currentPage == $count || $this->currentPage == $count - 1){
            array_push($out,1);
            array_push($out,null);
            array_push($out,$count - 2);
            array_push($out,$count - 1);
            array_push($out,$count);
            return $out;
        }

        if($this->currentPage == $count || $this->currentPage == $count - 1){
            array_push($out,1);
            array_push($out,null);
            array_push($out,$count - 2);
            array_push($out,$count - 1);
            array_push($out,$count);
            return $out;
        }

        array_push($out,1);

        if($this->currentPage - 4 >= 0){
            array_push($out,null);
        }
        array_push($out,$this->currentPage - 1);
        array_push($out,$this->currentPage);
        array_push($out,$this->currentPage + 1);
        if($this->currentPage + 3 <= $count){
            array_push($out,null);
        }

        array_push($out,$count);
        return $out;
    }

}