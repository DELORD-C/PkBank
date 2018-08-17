<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="src/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Showdown</title>
</head>

<?php

include_once('php/config.php');

if(isset($_GET['dc']) && $_GET['dc'] == 1) {
    session_destroy();
    session_start();
    header("Location: index.php");
}

if (isset($_SESSION['pass']) && $_SESSION['pass'] == 1) {
    header("Location: home.php");
}

if (isset($_POST['pass']) && md5($_POST['pass']) == 'd6445d158adbb44555da4965ff83a034') {
    $_SESSION['pass'] = 1;
    header("Location: home.php");
}

?>

<body>
    <div class='connect'>
        <header class='connect__header'>
            <a href='index.php' class='header__title'>Pokemon bank</a>
        </header>
        <form action='index.php' method='post'>
            <input class='form__input' type='password' name='pass' required placeholder='Password'>
            <input class='form__btn btn' type='submit' value='Connection'>
        </form>
        <a href='home.php'><button class='connect__btn btn'>Invite</button></a>
    </div>
</body>
</html>