<?php

class Guest extends Database{

    private string $nickname;
    private string $id;

    public function __construct($nickname){

        $this->nickname = $nickname;
        $this->id = $this->uniqueId();
    
        $stmt = $this->connectDatabase()->prepare("INSERT INTO guests(id, username) VALUES(?, ?)");
        $stmt->execute([
            $this->id,
            $this->nickname,
        ]);

    }

    public function getNickname(){
        return $this->nickname;
    }
    public function getId(){
        return $this->id;
    }


    private function uniqueId(){

        $try = strtoupper(hash(self::HASH_METHOD, bin2hex(random_bytes(4)).time()));

        $stmt = $this->connectDatabase()->prepare("SELECT id from guests WHERE id =?;");
        $stmt->execute([$try]);

        if($stmt->rowCount()){
            $try = $this->uniqueId();
        }
        return $try;

    }

}