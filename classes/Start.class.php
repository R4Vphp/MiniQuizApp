<?php

class Start extends Database{

    const ALLOWED_SYMBOLS = "abcdefghijklmnopqrstuvwxyz_0123456789";
    const BANNED_WORDS = [
       
    ];
    const POKEMON_ALPHABET = [
        0 => "o",
        1 => "i",
        2 => "z",
        3 => "e",
        4 => "a",
        5 => "s",
        6 => "g",
        8 => "b",
        9 => "g",
        "v" => "u",
        "_" => "",
        "q" => "ku",
        "y" => "j"
    ];

    const NICKNAME_MIN_LEN = [3, "znaki"];
    const NICKNAME_MAX_LEN = [16, "znaków"];

    const SESSION_IP_LIMIT = "Wykorzystano limit podejść.";

    const NICKNAME_EMPTY = "Nick nie został wprowadzony.";
    const NICKNAME_BANNED_WORD = "Nick zawiera niedozwolone słowo.";
    const NICKNAME_BANNED_SYMBOLS = "Nick zawiera niedozwolone znaki.";
    const NICKNAME_TOO_SHORT = "Nick krótszy niż";
    const NICKNAME_TOO_LONG = "Nick dłuższy niż";
    const NICKNAME_ALREADY_TAKEN = "Ten nick jest już zajęty.";
    const NICKNAME_2137 = "Nie śmiej się z papieża!";

    private string $nickname;

    public function grabInput(){

        $this->nickname = trim($_POST["nickname"] ?? "");

    }

    public function handleErrors(){

        $nickname = $this->nickname;
        if(empty($nickname)){
            
            $this->setNotificationMessage(self::NICKNAME_EMPTY);
            return false;

        }elseif($nickname === self::ADMIN_REQUEST){
            
            header("Location: admin");
            return self::ADMIN_REQUEST;

        }elseif(!$this->isNickValid($nickname)){
            
            $this->setNotificationMessage(self::NICKNAME_BANNED_SYMBOLS);
            return false;

        }elseif($word = $this->isNickBanned($nickname)){
            
            $moreInfo = "<br /><b>BANNED WORD:</b> $word";
            $this->setNotificationMessage(self::NICKNAME_BANNED_WORD.$moreInfo);
            return false;

        }/*elseif($this->isNickAlreadyTaken($nickname)){
            
            $this->setNotificationMessage(self::NICKNAME_ALREADY_TAKEN);
            return false;

        }*/elseif(strlen($nickname) > self::NICKNAME_MAX_LEN[0]){

            $moreInfo = " ".implode(" ", self::NICKNAME_MAX_LEN).".";
            $this->setNotificationMessage(self::NICKNAME_TOO_LONG.$moreInfo);
            return false;

        }elseif(strlen($nickname) < self::NICKNAME_MIN_LEN[0]){

            $moreInfo = " ".implode(" ", self::NICKNAME_MIN_LEN).".";
            $this->setNotificationMessage(self::NICKNAME_TOO_SHORT.$moreInfo);
            return false;

        }elseif($this->is2137($nickname)){

            $this->setNotificationMessage(self::NICKNAME_2137);
            return false;

        }elseif($this->isIpAlreadyUsed()){

            $this->setNotificationMessage(self::SESSION_IP_LIMIT);
            return false;

        }else{
            
            return $nickname;

        }

    }

    private function isIpAlreadyUsed(){

        if(LogInOut::isLogged()){
            return false;
        }

        $stmt = $this->connectDatabase()->prepare("SELECT id from scores WHERE ip = ?;");
        $stmt->execute([$_SERVER["REMOTE_ADDR"]]);

        if($stmt->rowCount()){
            return true;
        }
        return false;

    }

    private function isNickAlreadyTaken($nick){

        $stmt = $this->connectDatabase()->prepare("SELECT id from guests WHERE username =?;");
        $stmt->execute([$nick]);

        if($stmt->rowCount()){
            return true;
        }
        return false;

    }
    private function isNickBanned($nick){

        $nick = str_split(strtolower($nick), 1);
	
        forEach($nick as $key => $letter){
            if(array_key_exists($letter, self::POKEMON_ALPHABET)){
                $nick[$key] = self::POKEMON_ALPHABET[$letter];
            }
        }

        forEach($nick as $key => $letter){
            if(array_key_exists($key - 1, $nick) && $nick[$key] == $nick[$key - 1]){
                unset($nick[$key - 1]);
            }
        }

        $nick = implode("", $nick);
        forEach(self::BANNED_WORDS as $word){
            if(strpos($nick, $word) !== false){
                return $word;
            }
        }
        return false;

    }
    private function isNickValid($nick){

        $nick = str_split(strtolower($nick), 1);

        forEach($nick as $symbol){
            if(strpos(self::ALLOWED_SYMBOLS, $symbol) === false){
                return false;
            }
        }
        return true;

    }
    private function is2137($nick){
        if(strpos($nick, "2137") !== false){
            return true;
        }
        return false;
        
    }

}