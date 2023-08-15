<?php
require_once "../config.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="../aseet/style/style.css"/>
</head>
<body>
<?php

require_once "../app/function.php";
date_default_timezone_set('asia/tehran');
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $userNameValidate = validate($username, "username");
    $emailValidate = validate($email, "email");
    $nameValidate = validate($name, "name");
    $passwordValidate = validate($password, "password");
    $time = date("Y-m-d H:i:s");

    if ($userNameValidate && $emailValidate && $nameValidate && $passwordValidate) {
        if (SAVE_DATA === 'JSON'){
            $content = file_get_contents('../storage/users.json');
            $users = json_decode($content, true);
        }
        if (SAVE_DATA === 'MYSQL'){
            //todo database connection
        }
        foreach ($users as $user) {
            if ($user['user_name'] != $username && $user['email'] != $email) {
                if (empty($content)) {
                    $id = 1;
                } else {
                    $end = end($users);
                    $id = $end['id'] + 1;
                }
                $user = [
                    'id' => $id,
                    'user_name' => $username,
                    'email' => $email,
                    'name' => $name,
                    'password' => $password,
                    'time' => $time,
                    'admin' => false,
                    'block' => false,
                ];
                $users[] = $user;
                if (SAVE_DATA === 'JSON'){
                    $result = file_put_contents('../storage/users.json', json_encode($users));
                }
                if (SAVE_DATA === 'MYSQL'){
                    //todo database connection
                }

                mkdir("../storage/users folder/$username", 0777, true);
                if ($result !== false) {
                    echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
                    return;
                } else {
                    echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
                }
            } else {
                echo "<div class='form'>
                  <h3>Error. Enter Unique User Name and Email.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
                exit();
            }
        }
    } else {
        echo "<div class='form'>
                  <h3>Validation Error.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
    }
} else {
    ?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Registration</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" required/>
        <input type="text" class="login-input" name="email" placeholder="Email Adress">
        <input type="text" class="login-input" name="name" placeholder="Name" required/>
        <input type="password" class="login-input" name="password" placeholder="Password">
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link"><a href="login.php">Click to Login</a></p>
    </form>
    <?php
}
?>
</body>
</html>