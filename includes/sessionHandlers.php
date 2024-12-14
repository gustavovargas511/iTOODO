<?php

// Starts a session if not already started
function startSessionIfNeeded()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Handles logout logic if the user is logged in
function logoutIfLogged()
{
    startSessionIfNeeded();

    // Check if a session is active (i.e., the user is logged in)
    if (isset($_SESSION['username']) && $_SESSION['username'] !== null) {
        // Destroy the session data
        session_unset();  // Unset all session variables
        session_destroy();  // Destroy the session

        // Delete the session cookie by setting its expiration to a past date
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');  // Expire the cookie
        }

        // Redirect to the login page after logging out
        header('Location: login.php');
        exit();
    }
}

// Handles logout when a logout request is received
function handleLogout()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
        startSessionIfNeeded();

        // Destroy the session
        session_unset();
        session_destroy();

        // Redirect to the login page
        header('Location: login.php');
        exit();
    }
}

// Ensures the user is logged in before accessing the dashboard
function dashboardSessionHandler()
{
    startSessionIfNeeded();

    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }
}
?>