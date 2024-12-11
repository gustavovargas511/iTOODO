document.getElementById("createTaskBtn").addEventListener("click", function () {
  const formData = new FormData(document.getElementById("newTaskForm"));
  const todoTitle = formData.get("todoTitle");
  const todoBody = formData.get("todoBody");

  if (!todoTitle || !todoBody) {
    alert("Please fill in all fields.");
    return;
  }

  fetch("insertTodo.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        window.location.reload(); // Refresh the page on success
      } else {
        alert("Error creating task: " + data.message);
      }
    })
    .catch((error) => console.error("Error:", error));
});
