<?php
include $_SERVER['DOCUMENT_ROOT'] . '/TODOit/config/database.php';
include(__DIR__ . '/../../includes/sessionHandlers.php');

startSessionIfNeeded();
logoutIfLogged();

// Correctly access POST data
$username = htmlspecialchars($_POST['username'] ?? '');
$password = htmlspecialchars($_POST['password'] ?? '');

try {
    // Only proceed if the username and password are set
    if (!empty($username) && !empty($password)) {
        // Query to get the user and their hashed password
        $query = "SELECT pass FROM user WHERE username = :username LIMIT 1";
        $stmt = $pdo->prepare($query);

        // Bind parameters
        $stmt->bindParam(':username', $username);

        // Execute the query
        $stmt->execute();

        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify if the entered password matches the hashed password
            if (password_verify($password, $user['pass'])) {
                // Password is correct, start the session and redirect
                $_SESSION['username'] = $username;
                header('Location: dashboard.php');
                exit();
            } else {
                echo '<script>alert("Invalid username or password.");</script>';
            }
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