<?php
include $_SERVER['DOCUMENT_ROOT'] . '/TODOit/config/database.php';
// include $_SERVER['DOCUMENT_ROOT'] . '/TODOit/src/controllers/LogoutController.php';
include(__DIR__ . '/sessionHandlers.php');

startSessionIfNeeded();
handleLogout();

// LogoutController::dashboardSessionHandler();
// LogoutController::handleLogout();

?><!DOCTYPE html>
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
    <nav class="sticky-top shadow navbar bg-body-tertiary d-flex justify-content-between px-2">
        <div class="p-2">
            iTOODO
        </div>
        <div class="d-flex">
            <div class="pt-2 mx-2">
                <p>Welcome back <?= $_SESSION['username'] ?></p>
            </div>
            <div class="d-grid gap-2 d-md-block">
                <button class="btn btn-success new-task-btn" data-bs-toggle="modal" data-bs-target="#newTaskModal" type="button">New task</button>
                <form action="" method="post" style="display:inline;">
                    <button class="btn btn-danger" type="submit" name="logout">Log Out</button>
                </form>
            </div>
        </div>
    </nav>