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
    // header('Location: login.php');
    // exit();
}

$username = $email = $password = '';

// if (!empty($_POST['username'])) {
//     $username = $_POST['username'];
//     echo '<script>alert("'. $username .'");</script>';
// }
// if (!empty($_POST['email'])) {
//     echo '<script>alert("' . $_POST['email'] . '");</script>';
// }
// if (!empty($_POST['pswd'])) {
//     echo '<script>alert("' . $_POST['pswd'] . '");</script>';
// }

// Correctly access POST data
$username = htmlspecialchars($_POST['username'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');
$password = htmlspecialchars($_POST['pswd'] ?? '');

try {
    // Only proceed if the username, email and password are set
    if (!empty($username) && !empty($email) && !empty($password)) {

        // Query to get the user
        $query = "INSERT INTO user (username, email, pass) VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        // Execute the query
        // $stmt->execute();

        if ($stmt->execute()) {
            echo '<script>alert("User inserted successfuly!");</script>';
            // $_SESSION['username'] = $username;
            // header('Location: dashboard.php');
        } else {
            echo '<script>alert("Error trying to insert user, please try again.");</script>';
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

    <!-- Container with custom width (50% width) -->
    <div class="shadow p-3 mb-5 bg-body-tertiary rounded w-50">
        <div class="mb-2 p-2 d-flex justify-content-center">
            <p class="m-2">Please fill in the required info</p>
        </div>
        <form action="" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="myusername">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
            </div>
            <div class="mb-3">
                <label for="pswd" class="form-label">Password</label>
                <input type="password" id="pswd" name="pswd" class="form-control" aria-describedby="passwordHelpBlock">
                <div id="passwordHelpBlock" class="form-text">
                    Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <input class="btn btn-primary mt-2" type="submit" value="Login">
            </div>
        </form>
    </div>

</body>

</html>