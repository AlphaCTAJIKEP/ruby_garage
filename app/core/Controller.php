<?php 
    class Controller extends Exception{
        protected function view($view, $data = []){
            require_once '../app/views/' . $view . '.php'; 
        }
    }