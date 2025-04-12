<?php
    namespace app\models;

    class viewsModel{
        protected function getViewsModel($view){
            $whiteList=['dashboard','register','login'];

            if(in_array($view,$whiteList)){
                if(is_file("./app/views/content/".$view."-view.php")){
                    $content="./app/views/content/".$view."-view.php";
                }
                else{
                    $content="404";
                }
            }
            else if($view=="login" || $view=="index"){
                $content="login";
            }
            else{
                $content="404";
            }

            return $content;
        }
    }