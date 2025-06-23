function showTab(index) {
  document.querySelectorAll(".tab-content").forEach((el, i) => {
    el.style.display = i === index ? "block" : "none";
  });
}

function showYearTab(showIndex, yearIndex) {
  // Hide all year content within the current show tab
  document.querySelectorAll(`.tab-${showIndex}-year-*`).forEach(el => {
    el.style.display = "none";
  });

  // Show the selected year tab content
  const yearContent = document.querySelector(`.tab-${showIndex}-year-${yearIndex}`);
  if (yearContent) {
    yearContent.style.display = "block";
  }
}
