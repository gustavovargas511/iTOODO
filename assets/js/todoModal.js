//edit and new to do form * pending to move to isolated js file
document.addEventListener("DOMContentLoaded", () => {
  const editButtons = document.querySelectorAll(".edit-btn");
  const modalTitle = document.querySelector(".modal-title");
  const todoIdInput = document.querySelector("#modalTaskId");
  const todoTitleInput = document.querySelector("#modalTaskTitle");
  const todoBodyInput = document.querySelector("#modalTaskBody");
  const modalCompletedCheckbox = document.querySelector(
    "#modalCompletedCheckbox"
  );
  const flexCheckDefault = document.querySelector("#flexCheckDefault");
  // Update modal for editing
  editButtons.forEach((button) => {
    button.addEventListener("click", () => {
      modalTitle.textContent = "Edit Task"; // Change modal title for editing
      todoIdInput.value = button.getAttribute("data-id");
      todoTitleInput.value = button.getAttribute("data-title");
      todoBodyInput.value = button.getAttribute("data-body");
      modalCompletedCheckbox.classList.remove("d-none");
      const isCompleted = button.getAttribute("data-completed"); // Check if completed
      // console.log(isCompleted);
      flexCheckDefault.checked = isCompleted === "1"; // Set checkbox state
    });
  });

  // Reset modal for creating new task
  const newTaskButton = document.querySelector(".new-task-btn");
  newTaskButton.addEventListener("click", () => {
    modalTitle.textContent = "Enter New Task"; // Reset modal title for new task
    todoIdInput.value = ""; // Clear task ID
    todoTitleInput.value = "";
    todoBodyInput.value = "";
    modalCompletedCheckbox.classList.add("d-none");
  });
});
