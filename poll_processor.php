<?php
    class CreatePoll{
        private $question;
        private $options;
        private $isMultiple;
        private $createdAt;
        private $deadline;
        private $stored_polls;
        private $storage = "polls.json";
        private $new_poll;
        public $error;

        public function __construct($question, $options, $isMultiple, $deadline){
            $this->stored_polls = json_decode(file_get_contents($this->storage), true);

            $this->question = filter_var(trim($question));
            $this->options = array_map('trim', explode(',', filter_var(trim($options))));
            $this->isMultiple = $isMultiple;
            $this->createdAt = date('Y-m-d');
            $this->deadline = $deadline;

            if($this->valid_inputs()){
                $this->new_poll = [
                    "id" => uniqid("poll", false),//sprintf("poll%d", count($this->stored_polls)+1),
                    "question" => $this->question,
                    "options" => $this->options,
                    "isMultiple" => $this->isMultiple,
                    "createdAt" => $this->createdAt,
                    "deadline" => $this->deadline,
                    "answers" => array_fill_keys($this->options, 0),
                    "voted" => []
                ];

                array_push($this->stored_polls, $this->new_poll);
                if(!file_put_contents($this->storage, json_encode($this->stored_polls, JSON_PRETTY_PRINT))){
                    $this->error = "Something went wrong";
                }
            }else{

            }

        }

        function valid_inputs(){
            if(empty($this->question) || empty($this->options) || empty($this->isMultiple) || empty($this->deadline)){
                $this->error = "*All fields must be filled";
                return false;
            }

            if(!check_len($this->question)){
                $this->error = "*The question is too short";
                return false;
            }

            if(count($this->options) < 2){
                $this->error = "There must be at least 2 options";
                return false;
            }

            if(strtotime($this->deadline) < strtotime($this->createdAt)){
                $this->error = "The deadline cannot be in the past";
                return false;
            }

            return true;
        }





    }

    function check_len($item){
        $length = strlen($item);
        if ($length > 5) {
            return true;
        }
        return false;
    }
?>