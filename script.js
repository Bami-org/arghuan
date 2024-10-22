// Get all the nav-link elements
var navLinks = document.querySelectorAll(".nav-link");

// Add a click event listener to each nav-link
navLinks.forEach(function (link) {
  link.addEventListener("click", function () {
    // Remove the active class from all nav-links
    navLinks.forEach(function (l) {
      l.classList.remove("active");
    });

    // Add the active class to the clicked link
    this.classList.add("active");
  });
});

// Get the navbar toggler button
var navbarToggler = document.querySelector(".navbar-toggler");

// Get the main navbar element
var mainNavbar = document.getElementById("navbarNav");

// Add a click event listener to the navbar toggler button
navbarToggler.addEventListener("click", function () {
  // Toggle the 'show' class on the main navbar element
  mainNavbar.classList.toggle("show");
});
