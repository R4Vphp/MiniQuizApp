<?php

class LogInOut extends Database {

    const ACCESS_DENIED = "Odmowa dostępu.";
    const PASSWORD_NULL = "Hasło nie zostało wprowadzone.";
    const PASSWORD_INCORRECT = "Nieprawidłowe hasło.";
    const LOGIN_MANIFEST = "Zalogowano jako administrator";

    public function handleErrors(){

        $pass = $_POST["authorization"] ?? null;
        
        if($_SERVER["SERVER_ADDR"] != $_SERVER["REMOTE_ADDR"]){
            $this->setNotificationMessage(self::ACCESS_DENIED);
            return false;
        }elseif(!$pass){
            $this->setNotificationMessage(self::PASSWORD_NULL);
            return false;
        }elseif($pass !== self::ADMIN_PASSWORD){
            $this->setNotificationMessage(self::PASSWORD_INCORRECT);
            return false;
        }elseif($pass === self::ADMIN_PASSWORD AND $_SERVER["SERVER_ADDR"] == $_SERVER["REMOTE_ADDR"]){
            return true;
        }

    }

    public function loginAdmin(){
        $_SESSION[__CLASS__] = true;
    }
    public function logoutAdmin(){
        unset($_SESSION[__CLASS__]);
    }
    public static function isLogged(){
        if($_SESSION[__CLASS__] ?? false){
            return true;
        }
        return false;
    }
    public static function loginManifest(){
        if(self::isLogged()){
            echo "<p>".self::LOGIN_MANIFEST."</p>";
        }
    }

}