<?php

class Admin extends Database {

    private array $operation;

    public function grabInput(){

        $this->operation = [
            "resetQuiz" => $_POST["resetQuiz"] ?? false,
            "kickGuest" => $_POST["kickGuest"] ?? false
        ];

    }
    public function execute(){

        if($this->operation["resetQuiz"]){

            $this->clearRanking();

        }

        if($guestId = $this->operation["kickGuest"]){

            $this->kickGuest($guestId);

        }

    }


    private function clearRanking(){

        $clearRanking = $this->connectDatabase()->query("DELETE FROM scores; DELETE FROM guests");

    }

    private function kickGuest($guestId){

        $removeScore = $this->connectDatabase()->prepare("DELETE FROM scores WHERE guestID = ?");
        $removeScore->execute([$guestId]);

        $removeGuest = $this->connectDatabase()->prepare("DELETE FROM guests WHERE id = ?");
        $removeGuest->execute([$guestId]);

    }


}