<?php

class Notification {

    public function __construct(){

        $error = $_SESSION["NOTIFICATIONS"]["ERROR"] ?? null;
        $warning = $_SESSION["NOTIFICATIONS"]["WARNING"] ?? null;

        if($error){

            echo "<div class='alert'><h6>BŁĄD!</h6><p>$error</p></div>";
            unset($_SESSION["NOTIFICATIONS"]["ERROR"]);

        }
        if($warning){

            echo "<div class='notify'><h6>UWAGA!</h6><p>$warning</p></div>";
            unset($_SESSION["NOTIFICATIONS"]["WARNING"]);

        }

    }

}