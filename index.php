<?php
require('functions.php');

session_start();

if(isset($_GET['logout'])){
    unset($_SESSION['user']);
    header("location: login.php");
    exit();
}

if(isset($_GET['polls'])){
    header("location: polls.php");
    exit();
}

if(isset($_GET['my_votes'])){
    header("location: my_votes.php");
    exit();
}

if(isset($_SESSION['user']) && isAdmin($_SESSION['user']) && isset($_GET['add_poll'])){
    header("location: add_poll.php");
    exit();
}

if(isset($_SESSION['user']) && isAdmin($_SESSION['user']) && isset($_GET['remove_poll'])){
    header("location: remove_poll.php");
    exit();
}

if(isset($_SESSION['user']) && isAdmin($_SESSION['user']) && isset($_GET['edit_poll'])){
    header("location: edit_poll.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body >
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">📊POLLIO</a>
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
            <?php
            if(isset($_SESSION['user'])){
                echo '
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                    <a class="nav-link" href="?logout">Log Out</a>
                    </li>
                </ul>';
            }
            ?>
            </div>
        </div>
    </nav>
        <div class="container mt-5">
            <h1 class="display-4 text-center">Welcome to POLLIO</h1>
            <p class="lead text-center">Here, you can participate in a variety of polls on a wide range of topics. Simply browse through the available polls, choose the one you want to participate in, and cast your vote.</p>
            <p class="text-center">With our easy-to-use interface and constantly updated selection of polls, you'll find everything you need to make your voice heard. Thank you for visiting and happy voting!</p>
            <div class="text-center mt-5">
            <a href="?polls" class="btn btn-primary btn-lg">Browse Polls</a>
            </div>

            
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>