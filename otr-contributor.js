function showTab(index) {
  document.querySelectorAll(".tab-content").forEach((el, i) => {
    el.style.display = i === index ? "block" : "none";
  });
}

function showYearTab(showIndex, yearIndex) {
  // Hide all year-content blocks inside the selected show tab
  document
    .querySelectorAll(`.tab-content#tab-${showIndex} .year-content`)
    .forEach(el => {
      el.style.display = "none";
    });

  // Show only the selected year block
  const yearBlock = document.querySelector(
    `.tab-content#tab-${showIndex} .tab-${showIndex}-year-${yearIndex}`
  );
  if (yearBlock) {
    yearBlock.style.display = "block";
  }
}
