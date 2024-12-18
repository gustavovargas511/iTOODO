<?php
include(__DIR__ . '../../../includes/header.php');
include(__DIR__ . '/../controllers/TodoController.php');
include(__DIR__ . '/../controllers/UserController.php');

// Initialize controllers
$todoController = new TodoController($pdo);
$userController = new UserController($pdo);
$error = null;

//handle delete todo
if (
    $_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['action'])
    && $_POST['action'] === 'delete'
) {

    if (
        isset($_POST['todoId'])
        && is_numeric($_POST['todoId'])
    ) {

        $todoId = (int)$_POST['todoId'];

        if ($todoController->deleteTodoById($todoId)) {
            header("Location: " . $_SERVER['PHP_SELF']);
            //exit;
        } else {
            $error = "Failed to delete the task. Please try again.";
        }
    } else {
        $error = "Invalid task ID.";
    }
}

// Handle new/edit todo form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['todoTitle'], $_POST['todoBody'])) {
    $todoTitle = htmlspecialchars($_POST['todoTitle']);
    $todoBody = htmlspecialchars($_POST['todoBody']);

    // Validate inputs
    if (!empty($todoTitle) && !empty($todoBody)) {
        $userid = $userController->getUserIdByUsername($_SESSION['username']);
        $todo = new Todo();
        $todo->setTitle($todoTitle);
        $todo->setBody($todoBody);
        $todo->setCompleted(0); // Defaults to incomplete
        $todo->setCompletionDate(NULL);
        $todo->setUserId($userid->getId());

        // Check if it's an update or new task creation
        if (isset($_POST['todoId']) && !empty($_POST['todoId'])) {
            // Update operation
            $todoToUpdate = $todoController->getTodoById($_POST['todoId']); // Retrieve the existing task
            $todoToUpdate->setTitle($todoTitle);
            $todoToUpdate->setBody($todoBody);
            $todoToUpdate->setCompleted(isset($_POST['completed']) ? 1 : 0); // Set completed if checked
            $result = $todoController->updateTodo($todoToUpdate);

            if (!$result) {
                $error = "Failed to update the task.";
            }
        } else {
            // New task creation
            $result = $todoController->createTodo($todo);
            if ($result <= 0) {
                $error = "Error creating the task. Please try again.";
            }
        }

        // Reset form inputs and $_POST data
        // $_POST['todoTitle'] = $_POST['todoBody'] = null; // Clear form fields
        // unset($_POST); // Optional, clears all form data from memory
        header("Location: " . $_SERVER['PHP_SELF']);
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

<div class="container">
    <div class="row my-3">
        <div class="col">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" class="form-control" placeholder="Search todo..." name="searchTodo" id="searchTodo">
            </div>
        </div>
    </div>
</div>
<div class="container flex-grow-1">
    <?php foreach ($userTodos as $todo) : ?>
        <div class="card mb-2" todo-card-title="<?= htmlspecialchars($todo->getTitle()) ?>">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <?= htmlspecialchars($todo->getTitle()) ?>
                </div>
                <div>
                    <span class="badge <?= $todo->getCompleted() ? 'text-bg-success' : 'text-bg-warning' ?> p-2">
                        <?= $todo->getCompleted() ? 'Completed' : 'Pending' ?>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <blockquote class="blockquote mb-0">
                        <p><?= htmlspecialchars($todo->getBody()) ?></p>
                        <footer class="blockquote-footer">Added on <cite title="Source Title"><?= $todo->getCreatedAt() ?></cite></footer>
                    </blockquote>
                    <div class="d-grid gap-2 d-md-block">
                        <!-- Include todo details in data-* attributes -->
                        <button class="btn btn-primary edit-btn"
                            data-id="<?= $todo->getId() ?>"
                            data-title="<?= htmlspecialchars($todo->getTitle()) ?>"
                            data-body="<?= htmlspecialchars($todo->getBody()) ?>"
                            data-completed="<?= $todo->getCompleted() ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#newTaskModal">
                            Edit
                        </button>
                        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="todoId" value="<?= $todo->getId() ?>">
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<?php
include(__DIR__ . '../../../includes/footer.php');
?>