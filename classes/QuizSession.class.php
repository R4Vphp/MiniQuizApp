<?php

class QuizSession extends Database {

    private object $guest;
    private string $ip;

    private string $state;
    private int $startTime;
    private int $finishTime;
    
    private int $guestScore;
    private int $maxScore;

    private array $questionSet;

    const STATE_ACTIVE = "ACTIVE";
    const STATE_FINISHED = "FINISHED";

    const GRADES = [
        100 => "6",
        95 => "5+",
        90 => "5",
        85 => "5-",
        80 => "4+",
        75 => "4",
        70 => "4-",
        65 => "3+",
        50 => "3",
        45 => "3-",
        40 => "2+",
        30 => "2",
        25 => "2-",
        20 => "2=",
        15 => "1+",
        5 => "1",
        0 => "xD"
    ];

    public function __construct(Guest $guest){

        $this->state = self::STATE_ACTIVE;
        $this->guest = $guest;
        $this->guestScore = 0;
        $this->startTime = time();
        $this->ip = $this->getGuestIp();

        $this->loadQuestions();
        $this->maxScore = count($this->questionSet);

        $stmt = $this->connectDatabase()->prepare("INSERT INTO scores(guestID, startTime, ip) VALUES(?, ?, ?)");
        $stmt->execute([
            $this->guest->getId(),
            $this->startTime,
            $this->ip
        ]);

        $_SESSION[__CLASS__] = $this;

    }

    public function destroy(){
        unset($_SESSION[__CLASS__]);
    }
    
    private function loadQuestions(){

        $stmt = $this->connectDatabase()->query("SELECT * FROM ".self::TABLE_NAME);
        
        $this->questionSet = $stmt->fetchAll();

        forEach($this->questionSet as $key => $question){

            $tempAns = [
                $question["answer1"] ?? null,
                $question["answer2"] ?? null,
                $question["answer3"] ?? null,
                $question["answer4"] ?? null,
                $question["answer5"] ?? null,
                $question["answer6"] ?? null
            ];
            $tempAns = array_filter($tempAns);

            $answers = [];
            $correctHashes = [];
            forEach($tempAns as $k => $a){
                $answers[$k] = new Answer($a);
                $correctHashes[] = $answers[$k]->getHash();
            }
            $correctHashes = array_splice($correctHashes, 0, $question["correctAnswers"]);

            $this->questionSet[$key] = new Question(
                $question["id"],
                $question["contents"],
                $answers,
                $correctHashes,
                $question["image"]
            );
        }
        shuffle($this->questionSet);

    }

    public function getGuest(){
        return $this->guest;
    }
    public function getIp(){
        return $this->ip;
    }
    public function getState(){
        return $this->state;
    }
    public function getMaxScore(){
        return $this->maxScore;
    }
    public function getGuestScore(){
        return $this->guestScore;
    }
    public function isPerfectScore(){
        if($this->guestScore === $this->maxScore){
            return true;
        }
        return false;
    }
    public function getGrade(){

        $percentage = $this->guestScore / $this->maxScore * 100;
        forEach(self::GRADES as $key => $grade){
            if($percentage >= $key){
                return $grade;
            }
        }
        return "!?";

    }
    public function getSessionLenght(){

        return date("i:s", $this->finishTime - $this->startTime);

    }

    public function printQuestions(){

        forEach($this->questionSet as $key => $q){
            $q->printQuestion($key + 1);
        }

    }

    public function finishQuiz(){

        $this->finishTime = time();
        $this->state = self::STATE_FINISHED;
        $this->saveScore();

    }


    public function prepareSummary(){

        forEach($this->questionSet as $key => $q){

            $answers = $q->getAnswers();
            $hashes = $q->getCorrectHashes();
            $guess = $_POST[$q->getId()] ?? [];
            sort($guess);
            sort($hashes);

            if($hashes === $guess){
                $this->guestScore++;
                unset($this->questionSet[$key]);
                continue;
            }

            forEach($answers as $k => $a){

                $answerHash = $a->getHash();

                if(in_array($answerHash, $guess)){
                    $a->setSelected(Answer::ANSWER_SELECTED);
                }
                if(in_array($answerHash, $hashes)){
                    $a->setMark(Answer::ANSWER_CORRECT);
                }
                if(!in_array($answerHash, $hashes) AND $a->getSelected()){
                    $a->setMark(Answer::ANSWER_INCORRECT);
                }

            }

        }

    }
    private function saveScore(){

        $stmt = $this->connectDatabase()->prepare("UPDATE scores SET score = ? , finishTime = ? WHERE guestID = ?");
        $stmt->execute([
            $this->guestScore,
            $this->finishTime,
            $this->guest->getId()
        ]);

    }

}