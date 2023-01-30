<?php

function compareDeadlines($a, $b) {
    $date1 = DateTime::createFromFormat('Y-m-d', $a['deadline']);
    $date2 = DateTime::createFromFormat('Y-m-d', $b['deadline']);
    return $date1 <=> $date2;
}

function saveVoteToJSON($id, $option, $user){
    $polls = json_decode(file_get_contents('polls.json'), true);
    for($i = 0; $i < count($polls); $i++){
        $poll = $polls[$i];
        if($poll['id'] == $id && !array_key_exists($user, $poll['voted'])){
            if(is_array($_POST['option'])){
                $polls[$i]['voted'][$user] = $_POST['option'];
                foreach($_POST['option'] as $option){
                    $polls[$i]['answers'][$option]++;
                }
            }else if(is_string($_POST['option'])){
                $polls[$i]['voted'][$user][] = $_POST['option'];
                $polls[$i]['answers'][$_POST['option']]++;
            }
            break;
        }
    }
    file_put_contents('polls.json', json_encode($polls, JSON_PRETTY_PRINT));
}

// use before changing the vote. Before submiting a change, will be used this function and then saveVoteToJSON function
function retractVote($id, $user){
    $polls = json_decode(file_get_contents('polls.json'), true);
    for($i = 0; $i < count($polls); $i++){
        $poll = $polls[$i];
        if($poll['id'] == $id && array_key_exists($user, $poll['voted'])){
            $answers = array_keys($poll['answers']);
            for($j = 0; $j < count($answers); $j++){
                if(in_array($answers[$j], $polls[$i]['voted'][$user])){
                    $polls[$i]['answers'][$answers[$j]]--;
                }
            }
            unset($polls[$i]['voted'][$user]);
            break;
        }
    }
    file_put_contents('polls.json', json_encode($polls, JSON_PRETTY_PRINT));
}

function removePoll($id){
    $polls = json_decode(file_get_contents('polls.json'), true);
    $new_polls = [];
    foreach ($polls as $key => $poll) {
        if ($poll['id'] != $id) {
          array_push($new_polls, $poll);
        }
    }
    file_put_contents('polls.json', json_encode($new_polls, JSON_PRETTY_PRINT));
}

function changePoll($id, $question, $deadline){
    $polls = json_decode(file_get_contents('polls.json'), true);
    for($i = 0; $i < count($polls); $i++){
        $poll = $polls[$i];
        if($poll['id'] == $id){
            
            if(!empty($question) && strlen($question)>5){
                $polls[$i]['question'] = filter_var(trim($question));
            }else{
                return "*Question input must be at least 5 characters";
            }

            if(!empty($deadline) && strtotime($deadline) > time()){
                $polls[$i]['deadline'] = $deadline;
            }else{
                return "*Date input is incorrect";
            }
            file_put_contents('polls.json', json_encode($polls, JSON_PRETTY_PRINT));
            return "success";
            break;
        }
    }
    return "*Something went wrong";
}

function isAdmin($username){
    $users = json_decode(file_get_contents('users.json'), true);
    foreach($users as $user){
        if($user['username'] == $username && $user['isAdmin']){
            return true;
        }
    }
    return false;
}

function getQuestion($id){
    $polls = json_decode(file_get_contents('polls.json'), true);
    foreach ($polls as $key => $poll) {
        if ($poll['id'] == $id) {
            echo $poll['question'];
        }
    }
}

function getOptions($id){
    $polls = json_decode(file_get_contents('polls.json'), true);
    foreach ($polls as $key => $poll) {
        if ($poll['id'] == $id) {
            echo implode(', ', $poll['options']);
        }
    }
}

function isMultiple($id){
    $polls = json_decode(file_get_contents('polls.json'), true);
    foreach ($polls as $key => $poll) {
        if ($poll['id'] == $id && $poll['isMultiple']) {
            echo "checked";
        }
    }
}

function getDeadline($id){
    $polls = json_decode(file_get_contents('polls.json'), true);
    foreach ($polls as $key => $poll) {
        if ($poll['id'] == $id) {
            echo $poll['deadline'];
        }
    }
}
?>