function showTab(index) {
  document.querySelectorAll(".tab-content").forEach((el, i) => {
    el.style.display = i === index ? "block" : "none";
  });
}
