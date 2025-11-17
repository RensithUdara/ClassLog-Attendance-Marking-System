// Mobile menu and notification button functionality
const navbarMenu = document.querySelector(".navbar .links");
const hamburgerBtn = document.querySelector(".hamburger-btn");
const hideMenuBtn = navbarMenu.querySelector(".close-btn");
const notificationBtn = document.querySelector(".notification-btn");
const showPopupBtn = document.querySelector(".logout-btn");

// Show mobile menu
hamburgerBtn.addEventListener("click", () => {
    navbarMenu.classList.add("show-menu");
});

// Hide mobile menu
hideMenuBtn.addEventListener("click", () => {
    navbarMenu.classList.remove("show-menu");
});

