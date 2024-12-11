<!-- Modal -->
<div class="modal fade" id="newTaskModal" tabindex="-1" aria-labelledby="centeredModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="centeredModalLabel">Enter New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="mb-3">
                        <label for="todoTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="todoTitle" name="todoTitle" placeholder="Enter to-do title" required>
                    </div>
                    <div class="mb-3">
                        <label for="todoBody" class="form-label">I need to:</label>
                        <input type="text" class="form-control" id="todoBody" name="todoBody" placeholder="Enter what you need to do" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Create TO-DO</button>
                </form>
                <?php if (!empty($errorMessage)) : ?>
                    <div class="alert alert-danger mt-2"><?= $errorMessage ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>