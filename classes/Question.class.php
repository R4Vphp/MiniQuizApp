<?php

class Question extends Database {

    private int $id;
    private string $contents;
    private array $answers;
    private array $correctHashes;
    private int $correctAnswersAmount;
    private $image;

    const SINGLE_CHOICE = "radio";
    const MULTI_CHOICE = "checkbox";

    public function printQuestion($index){

        $id = $this->id;
        $contents = $this->contents;
        $answers = $this->answers;
        $type = $this->getType();
        $image = $this->image;

        echo "<div class='question' id='$index'><h4>$index.</h4>";

        if($image){
            $path = self::QUESTION_IMAGES_PATH;
            if(file_exists($path.$image)){
                echo "<center><img class='zoom' src='$path$image' alt='$image'/></center>";
            }else{
                echo "<center><h5 class='imgNotFound'>Nie znaleziono: $image</h5></center>";
            }
        }
        
        echo "<p class='white'>$contents</p><hr /><ul>";

        forEach($answers as $a){
            
            $text = $a->getText();
            $hash = $a->getHash();
            $mark = $a->getMark();
            $selected = $a->getSelected();

            echo "<label><li class='white $mark'><input type='$type' name='".$id."[]' value='$hash' $selected/>$text</li></label>";

        }

        echo "</ul>";

        if($type === self::MULTI_CHOICE){
            echo "<p class='learn-more'>Pytanie <b>wielokrotnego</b> wyboru.</p>";
        }

        echo "</div>";
    }

    public function __construct($id, $contents, $answers, $correctHashes, $image){

        $this->id = $id;
        $this->contents = $contents;
        $this->answers = $answers;
        $this->correctHashes = $correctHashes;
        $this->correctAnswersAmount = count($correctHashes);
        $this->image = $image;

        shuffle($this->answers);

    }

    public function getId(){
        return $this->id;
    }
    public function getContents(){
        return $this->contents;
    }
    public function getAnswers(){
        return $this->answers;
    }
    public function getCorrectHashes(){
        return $this->correctHashes;
    }
    public function getCorrectAnswersAmount(){
        return $this->correctAnswersAmount;
    }
    public function getImage(){
        return $this->image;
    }
    public function getType(){
        if($this->correctAnswersAmount > 1){
            return self::MULTI_CHOICE;
        }
        return self::SINGLE_CHOICE;
    }

}