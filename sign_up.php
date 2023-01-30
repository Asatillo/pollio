<?php require("register_processor.php") ?>

<?php 
    if(isset($_POST['submit'])){
        $user = new RegisterUser($_POST['username'], $_POST['password'], $_POST['password2'], $_POST['email']);
    }

    if(isset($_GET['login'])){
        header("location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body >
    <div class="container">
        
        <div class="text-center">
            <h2>Register Form</h2>
            <form action="" method="post">
                <div class="form-group w-50 mx-auto mb-2">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" name="username">
                </div>
                <div class="form-group w-50 mx-auto mb-2">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <div class="form-group w-50 mx-auto mb-2">
                    <label for="password">Confirm password:</label>
                    <input type="password" class="form-control" name="password2">
                </div>
                <div class="form-group w-50 mx-auto mb-2">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <button type="submit" name="submit" class="btn btn-primary mb-3">Register</button>
                <p>Already have an account? <a href="?login">Log in</a></p>
            </form>
            <p class="error"><?php echo @$user->error ?></p>
            <p class="success"><?php echo @$user->success?></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>