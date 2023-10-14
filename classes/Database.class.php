<?php

class Database {

    const DATABASE_SERVER = "127.0.0.1";
    const DATABASE_NAME = "zs1quiz_blank";
    const DATABASE_USER = "root";
    const DATABASE_PASSWORD = "";
    const DATABASE_CHARSET = "utf8mb4";
    const TABLE_NAME = "questions";
    const HASH_METHOD = "crc32b";

    const ADMIN_REQUEST = "/admin";
    const ADMIN_PASSWORD = "admin_pass";

    const QUESTION_IMAGES_PATH = "images/questions/";

    const NOTIFICATION_TYPE_ERROR = "ERROR";
    const NOTIFICATION_TYPE_WARNING = "WARNING";

    protected function connectDatabase(){

        $dsn = "mysql:host=".self::DATABASE_SERVER.";dbname=".self::DATABASE_NAME.";charset=".self::DATABASE_CHARSET;
        
        try{
            $conn = new PDO($dsn, self::DATABASE_USER, self::DATABASE_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(PDOException $e){
            echo "Connection failed: ".$e->getMessage();
        }

    }

    protected function setNotificationMessage($message, $type = self::NOTIFICATION_TYPE_ERROR){
        $_SESSION["NOTIFICATIONS"][$type] = $message;
    }

    protected function getGuestIp(){

        return $_SERVER["REMOTE_ADDR"];

    }
}