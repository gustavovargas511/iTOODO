<?php
include(__DIR__ . '../../../includes/header.php');
include(__DIR__ . '/../controllers/TodoController.php');
include(__DIR__ . '/../controllers/UserController.php');

// Initialize controllers
$todoController = new TodoController($pdo);
$userController = new UserController($pdo);


// Handle new todo form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['todoTitle'], $_POST['todoBody'])) {
    $todoTitle = htmlspecialchars($_POST['todoTitle']);
    $todoBody = htmlspecialchars($_POST['todoBody']);

    // Validate inputs
    if (!empty($todoTitle) && !empty($todoBody)) {
        $userid = $userController->getUserIdByUsername($_SESSION['username']);
        $newTodo = new Todo();
        $newTodo->setTitle($todoTitle);
        $newTodo->setBody($todoBody);
        $newTodo->setCompleted(0);
        $newTodo->setCompletionDate(NULL);
        $newTodo->setUserId($userid->getId());

        if ($todoController->createTodo($newTodo) > 0) {
            // Reset form inputs and $_POST data
            $_POST['todoTitle'] = $_POST['todoBody'] = null; // Clear form fields
            //unset($_POST); // Optional, clears all form data from memory
        } else {
            $error = "Error creating the task. Please try again.";
        }
    } else {
        $error = "Both Title and Body are required.";
    }
}

// Get all user TODOs
$userTodos = $todoController->getTodosByUsername($_SESSION['username']);

?>

<?php // modal for user inserting
include(__DIR__ . '../../../src/views/newTaskModal.php');
?>

<div class="container pt-5 flex-grow-1">
    <?php foreach ($userTodos as $todo) : ?>
        <div class="card mb-2">
            <div class="card-header">
                <?= $todo->getTitle() ?>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <blockquote class="blockquote mb-0">
                        <p><?= $todo->getBody() ?></p>
                        <footer class="blockquote-footer">Added on <cite title="Source Title"><?= $todo->getCreatedAt() ?></cite></footer>
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