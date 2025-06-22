function showTab(index) {
  document.querySelectorAll(".tab-content").forEach((el, i) => {
    el.style.display = i === index ? "block" : "none";
  });
}

function showYearTab(showIndex, yearIndex) {
  document.querySelectorAll(`.year-content.tab-${showIndex}-year-*`).forEach(el => {
    el.style.display = "none";
  });
  const el = document.querySelector(`.year-content.tab-${showIndex}-year-${yearIndex}`);
  if (el) el.style.display = "block";
}
