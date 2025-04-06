/* Submit forms via AJAX */
const ajaxForms = document.querySelectorAll(".AjaxForm");

ajaxForms.forEach((form) => {
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Are you sure?",
      text: "Do you want to perform the requested action?",
      icon: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, proceed",
      cancelButtonText: "No, cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        let data = new FormData(this);
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");

        let headers = new Headers();

        let config = {
          method: method,
          headers: headers,
          mode: "cors",
          cache: "no-cache",
          body: data,
        };

        fetch(action, config)
          .then((response) => response.json())
          .then((response) => {
            return ajaxAlerts(response);
          });
      }
    });
  });
});

function ajaxAlerts(alert) {
  if (alert.type === "simple") {
    Swal.fire({
      icon: alert.icon,
      title: alert.title,
      text: alert.text,
      confirmButtonText: "Accept",
    });
  } else if (alert.type === "reload") {
    Swal.fire({
      icon: alert.icon,
      title: alert.title,
      text: alert.text,
      confirmButtonText: "Accept",
    }).then((result) => {
      if (result.isConfirmed) {
        location.reload();
      }
    });
  } else if (alert.type === "clear") {
    Swal.fire({
      icon: alert.icon,
      title: alert.title,
      text: alert.text,
      confirmButtonText: "Accept",
    }).then((result) => {
      if (result.isConfirmed) {
        document.querySelector(".AjaxForm").reset();
      }
    });
  } else if (alert.type === "redirect") {
    window.location.href = alert.url;
  }
}

/* Logout button */
let btnExit = document.getElementById("btn_exit");

btnExit.addEventListener("click", function (e) {
  e.preventDefault();

  Swal.fire({
    title: "Do you want to log out?",
    text: "The current session will close, and you will be logged out of the system.",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, log out",
    cancelButtonText: "Cancel",
  }).then((result) => {
    if (result.isConfirmed) {
      let url = this.getAttribute("href");
      window.location.href = url;
    }
  });
});
