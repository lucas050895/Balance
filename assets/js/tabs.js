const tabs = document.querySelectorAll(".tab");
const contents = document.querySelectorAll(".tab-content");

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    tabs.forEach((t) => t.classList.remove("active"));
    tab.classList.add("active");

    const selected = tab.getAttribute("data-tab");
    contents.forEach((c) => {
      c.style.display = c.id === selected ? "block" : "none";
    });
  });
});
