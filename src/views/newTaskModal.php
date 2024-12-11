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
                    <input type="hidden" id="modalTaskId" name="todoId" value="">
                    <div class="form-group mb-2" id="modalCompletedCheckbox">
                        <div class="form-check">
                            <label class="form-check-label" for="flexCheckDefault">
                                Mark as completed.
                            </label>
                            <input class="form-check-input" type="checkbox" value="" name="completed" id="flexCheckDefault">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="modalTaskTitle">Title</label>
                        <input type="text" id="modalTaskTitle" name="todoTitle" class="form-control" value="">
                    </div>
                    <div class="form-group">
                        <label for="modalTaskBody">Body</label>
                        <textarea id="modalTaskBody" name="todoBody" class="form-control"></textarea>
                    </div>
                    <div class="mt-2 d-flex">
                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    </div>
                </form>
                <?php if (!empty($errorMessage)) : ?>
                    <div class="alert alert-danger mt-2"><?= $errorMessage ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>