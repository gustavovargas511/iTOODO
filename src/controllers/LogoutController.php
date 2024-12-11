<?php

class LogoutController
{

    public static function logoutIfLogged()
    {

        session_start();

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

    public static function handleLogout()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
            // Destroy the session
            // session_start(); //Session already started on dashboardSessionHandler(); that is always being called on dashboard
            session_unset();
            session_destroy();

            // Redirect to the login page
            header('Location: login.php');
            exit();
        }
    }

    public static function dashboardSessionHandler(){
        session_start();

        if (!isset($_SESSION['username'])) {
            header('Location: login.php');
            //echo '<h1> Welcome ' . $_SESSION['username'] . '</h1>';
            // echo '<a href="logout.php">Logout</a>';
        }
    }

}
?>