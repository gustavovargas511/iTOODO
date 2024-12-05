<?php
include $_SERVER['DOCUMENT_ROOT'] . '/TODOit/config/database.php';

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    //echo '<h1> Welcome ' . $_SESSION['username'] . '</h1>';
    // echo '<a href="logout.php">Logout</a>';
}
// else {
//     echo '<h1>Welcome guest</h1>';
//     // echo '<a href="/13_sessions.php">Login screen</a>';
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/css/buttonsCustomColors.css">
    <link rel="stylesheet" href="../../assets/css/backgroundCustom.css">
    <title>Welcome :D</title>
</head>

<body class="gradient-bg d-flex flex-column min-vh-100">