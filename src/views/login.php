<?php
include $_SERVER['DOCUMENT_ROOT'] . '/TODOit/config/database.php';

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

// Correctly access POST data
$username = htmlspecialchars($_POST['username'] ?? '');
$password = htmlspecialchars($_POST['password'] ?? '');

try {
    // Only proceed if the username and password are set
    if (!empty($username) && !empty($password)) {
        // Query to get the user
        $query = "SELECT 1 FROM user WHERE username = :username AND pass = :password LIMIT 1";
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        // Execute the query
        $stmt->execute();

        if ($stmt->fetch()) {
            // echo '<script>alert("Login successful!");</script>';
            $_SESSION['username'] = $username;
            header('Location: dashboard.php');
        } else {
            echo '<script>alert("Invalid username or password.");</script>';
        }
    }
} catch (PDOException $e) {
    // Handle query error
    echo "Error: " . htmlspecialchars($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/backgroundCustom.css">
    <title>Login</title>
</head>

<body class="gradient-bg vh-100 d-flex justify-content-center align-items-center">

    <div class="shadow p-3 mb-5 bg-body-tertiary rounded">
        <div class="mb-2 p-2 d-flex justify-content-center">
            <p class="m-2">Please login to your iTOODO account</p>
        </div>
        <form action="" method="post">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <input type="password" id="password" name="password" placeholder="Password" class="form-control" aria-describedby="passwordHelpBlock">
            </div>
            <div class="d-flex justify-content-center">
                <input class="btn btn-primary mt-2" type="submit" value="Login">
            </div>
        </form>
    </div>

</body>

</html>