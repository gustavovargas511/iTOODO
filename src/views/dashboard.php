<?php
include(__DIR__ . '../../../includes/header.php');

// LogoutController::handleLogout();

// $query = "SELECT * FROM todo";
$query = "select td.*
from todo td
inner join user us
on td.user_id = us.id
where us.username = :username";

$stmt = $pdo->prepare($query);

// Bind parameters
$stmt->bindParam(':username', $_SESSION['username']);

$stmt->execute();
// Fetch all rows
$userTodos = $stmt->fetchAll();

?>

<!-- <nav class="navbar bg-body-tertiary d-flex justify-content-between px-2">
    <div class="p-2">
        iTOODO
    </div>
    <div class="d-flex">
        <div class="pt-2 mx-2">
            <p>Welcome back <?= $_SESSION['username'] ?></p>
        </div>
        <div class="d-grid gap-2 d-md-block">
            <button class="btn btn-primary" type="button">New task</button>
            <form action="" method="post" style="display:inline;">
                <button class="btn btn-danger" type="submit" name="logout">Log Out</button>
            </form>
        </div>
    </div>
</nav> -->

<div class="container pt-5 flex-grow-1">
    <?php foreach ($userTodos as $todo) : ?>
        <div class="card mb-2">
            <div class="card-header">
                <?= $todo['title'] ?>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <blockquote class="blockquote mb-0">
                        <p><?= $todo['body'] ?></p>
                        <footer class="blockquote-footer">Added on <cite title="Source Title"><?= $todo['created_at'] ?></cite></footer>
                    </blockquote>
                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-pink" type="button">Edit Task</button>
                        <button class="btn btn-secondary" type="button">Mark Complete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Repeat cards as needed -->
    <?php endforeach; ?>
</div>

<?php
include(__DIR__ . '../../../includes/footer.php');
?>