<?php

class Answer extends Database {

    const ANSWER_CORRECT = "correct";
    const ANSWER_INCORRECT = "incorrect";
    
    const ANSWER_SELECTED = "checked";
    const ANSWER_UNSELECTED = "";

    private string $text;
    private string $hash;
    private string $mark;
    private string $selected;

    public function __construct($text){

        $this->text = $text;
        $this->hash = hash(self::HASH_METHOD, $text);
        $this->mark = self::ANSWER_UNSELECTED;
        $this->selected = self::ANSWER_UNSELECTED;

    }

    public function getText(){
        return $this->text;
    }
    public function getHash(){
        return $this->hash;
    }

    public function getMark(){
        return $this->mark;
    }
    public function setMark($set){
        $this->mark = $set;
    }
    public function getSelected(){
        return $this->selected;
    }
    public function setSelected($set){
        $this->selected = $set;
    }

}