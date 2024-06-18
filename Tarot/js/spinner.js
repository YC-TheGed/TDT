document.getElementById("preloader").style.display = "flex";

window.addEventListener("load", function () {
  // Hide the preloader
  document.getElementById("preloader").style.display = "none";

  // Show the page content
  document.querySelector("body").style.visibility = "visible";
});
