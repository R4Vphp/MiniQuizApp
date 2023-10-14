<?php

class Ranking extends Database {

    const HIGHLIGHTED = "highlight";
    
    const EVERYONE_FINISHED = "Wszyscy uczestnicy ukończyli QUIZ!";

    private int $top10Count;
    private int $guestsCount;
    private int $rankingCount;

    public function loadTop10(){

        $stmt = $this->connectDatabase()->query("SELECT scores.guestID,username,startTime,finishTime,MAX(scores.score) AS valueMax FROM scores,guests WHERE scores.guestID = guests.id AND scores.score IS NOT NULL GROUP BY scores.guestID ORDER BY valueMax DESC, finishTime - startTime ASC, startTime ASC LIMIT 10;");
        $rows = $stmt->rowCount();
        $result = $stmt->fetchAll();
        $this->top10Count = $rows;

        echo "<table><tr><th>Nick#Id</th><th>Punkty</th><th>Czas</th></tr>";

        $currentQuestId = $this->getCurrentGuestId();

        forEach($result as $key => $r){

            $index = $key + 1;
            $id = $r["guestID"];
            $nickname = $r['username'];
            $value = $r['valueMax'];
            $time = date("i:s", $r["finishTime"] - $r["startTime"]);
            $style = "";

            if($currentQuestId === $id){
                $style = self::HIGHLIGHTED;
            }

            $uid = "<b>".$nickname."</b>#".substr($id, 0, 4);

            echo "<tr class='$style' i='$index'><td>$uid</td><td>$value</td><td>$time</td></tr>";

        }
        
        echo "</table>";
        echo "<h4>TOP $rows</h4>";

    }

    public function loadGuests(){

        $stmt = $this->connectDatabase()->query("SELECT * FROM guests,scores WHERE guestID = guests.id ORDER BY startTime ASC");
        $rows = $stmt->rowCount();
        $result = $stmt->fetchAll();
        $this->guestsCount = $rows;

        echo "<table><tr><th>Nick#Id</th><th>Ip</th><th>Godzina rozpoczęcia</th><th>Godzina ukończenia</th><th>Akcja</th></tr>";

        forEach($result as $key => $r){

            $index = $key + 1;
            $id = $r["guestID"];
            $nickname = $r["username"];
            $startTime = date("H:i:s", $r["startTime"]);
            $ip = $r["ip"];
            if($r["finishTime"]){
                $finishTime = date("H:i:s", $r["finishTime"]);
            }else{
                $finishTime = "<div class='load' style='width: 30px;'></div>";
            }

            $uid = "<b>".$nickname."</b>#".$id;

            echo "<tr i='$index'><td>$uid</td><td>$ip</td><td>$startTime</td><td>$finishTime</td><td><button type='submit' class='admin micro' name='kickGuest' value='$id'>Wyrzuć</button></td></tr>";

        }

        echo "</table>";
        return $rows;
    }

    public function loadRanking(){

        $stmt = $this->connectDatabase()->query("SELECT scores.guestID,guests.username,ip,startTime,scores.finishTime,MAX(scores.score) AS valueMax FROM scores,guests WHERE scores.guestID = guests.id AND score IS NOT NULL GROUP BY scores.guestID ORDER BY valueMax DESC, finishTime - startTime ASC, startTime ASC");
        $rows = $stmt->rowCount();
        $result = $stmt->fetchAll();
        $this->rankingCount = $rows;

        echo "<table><tr><th>Nick#Id</th><th>Punkty</th><th>Czas</th></tr>";


        forEach($result as $key => $r){

            $index = $key + 1;
            $id = $r["guestID"];
            $nickname = $r["username"];
            $points = $r["valueMax"];
            $ip = $r["ip"];
            $timeTaken = date("i:s", $r["finishTime"] - $r["startTime"]);

            $h = "";
            if($key === 0){
                $h = self::HIGHLIGHTED;
            }

            $uid = "<b>".$nickname."</b>#".$id;

            echo "<tr class='$h' i='$index'><td>$uid</td><td>$points</td><td>$timeTaken</td></tr>";

        }

        echo "</table>";
        return $rows;

    }

    private function getCurrentGuestId(){
        if($_SESSION["QuizSession"] ?? false){
            return $_SESSION["QuizSession"]->getGuest()->getId();
        }else{
            return false;
        }
        
    }

    public function everyoneFinished(){

        if($this->guestsCount !== 0 AND $this->guestsCount === $this->rankingCount){
            $this->setNotificationMessage(self::EVERYONE_FINISHED, self::NOTIFICATION_TYPE_WARNING);
        }

    }

}