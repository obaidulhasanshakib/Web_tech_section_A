document.addEventListener("DOMContentLoaded", () => {
  const passForm = document.getElementById("passForm");
  if (passForm) {
    passForm.addEventListener("submit", (e) => {
      const n = passForm.querySelector("input[name='new_password']").value;
      const c = passForm.querySelector("input[name='confirm_password']").value;
      if (n !== c) {
        e.preventDefault();
        alert("New password and confirm password mismatch!");
      }
    });
  }
});
