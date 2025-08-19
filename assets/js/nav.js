const menu = document.querySelector(".menu");
const sidebar = document.querySelector("nav");
const menuImg = menu.querySelector("img");

menu.addEventListener("click", () => {
  sidebar.classList.toggle("active");
  menu.classList.toggle("active");
  menu.classList.contains("active")
    ? (menuImg.src = "https://arsentech.github.io/source-codes/icons/close.svg")
    : (menuImg.src = "https://arsentech.github.io/source-codes/icons/menu.svg");
});
