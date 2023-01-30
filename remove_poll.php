<?php
require("functions.php");

session_start();

if(!isset($_SESSION['user'])){
    header("location: login.php");
    exit();
}

if(isset($_GET['polls'])){
    header("location: polls.php");
    exit();
}

if(isset($_GET['logout'])){
    unset($_SESSION['user']);
    header('location: login.php');
    exit();
}

if(isset($_GET['my_votes'])){
    header('location: my_votes.php');
    exit();
}

if(isset($_GET['index'])){
    header("location: index.php");
}

if(isAdmin($_SESSION['user']) && isset($_GET['add_poll'])){
    header("location: add_poll.php");
    exit();
}

if(isAdmin($_SESSION['user']) && isset($_GET['remove_poll'])){
    header("location: remove_poll.php");
    exit();
}

if(isAdmin($_SESSION['user']) && isset($_GET['edit_poll'])){
    header("location: edit_poll.php");
    exit();
}

if(isset($_POST['id'])){
    removePoll($_POST['id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove polls</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body >
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="?index">📊POLLIO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link" aria-current="page" href="?polls">Polls</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="?my_votes">My votes</a>
                </li>
                <?php 
                if(isset($_SESSION['user']) && isAdmin($_SESSION['user'])){
                    echo '
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Poll actions
                    </a>
                    <ul class="dropdown-menu">
                    <li><a class="dropdown-item text-success" href="?add_poll">Add new</a></li>
                    <li><a class="dropdown-item text-danger" href="?remove_poll">Remove</a></li>
                    <li><a class="dropdown-item text-primary" href="?edit_poll">Edit existing</a></li>
                    </ul>
                    </li>';
                } 
                ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                <a class="nav-link" href="?logout">Log Out</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="text-center">Active polls to remove</h2><hr>
            <?php
            $polls = json_decode(file_get_contents('polls.json'), true);
            usort($polls, 'compareDeadlines');
            foreach($polls as $poll){
                $expired = time() > strtotime($poll['deadline']);
                if (!$expired){
                    echo '<form method="POST" action="remove_poll.php" class="mb-3">';
                    echo '<input type="hidden" name="id" value="'. $poll['id'] .'">';
                    echo '<div class="form-group">';
                    echo '<div><b>' . $poll['question'] . '</b></div>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<div><b>Poll ID:</b> ' . $poll['id'] . '</div>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<div><b>Created at </b> ' . date('jS M Y', strtotime($poll['createdAt'])) . '</div>';
                    echo '</div>';
                    echo '<div class="form-group">';
                    echo '<div><b>Deadline at</b> ' . date('jS M Y', strtotime($poll['deadline'])) . '</div>';
                    echo '</div>';
                    echo '<div><b>Votes:</b> ' . array_sum($poll['answers']) . '</div>';
                    echo '<button type="submit" class="btn btn-danger mt-1">Remove</button>';
                    echo '</form>';
                    echo '<hr>';
                }
            }
            ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>