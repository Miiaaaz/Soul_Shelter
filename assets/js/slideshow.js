let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.classList.remove('active', 'fade-in');
    if (i === index) {
      slide.classList.add('active', 'fade-in');
    }
  });
  currentSlide = index;
}

function changeSlide(direction) {
  let newIndex = (currentSlide + direction + totalSlides) % totalSlides;
  showSlide(newIndex);
}

// Auto-slide every 5s
setInterval(() => changeSlide(1), 5000);

// Init
document.addEventListener('DOMContentLoaded', () => {
  showSlide(currentSlide);
});
