var slideIndex = 0;
showSlides();

function plusSlides(n) {
  (n>=0?showSlides(slideIndex):showSlides(slideIndex-=2));
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i, slides = document.getElementsByClassName("bannerSlides"), dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1;}    
  if (n < 0) {slideIndex = slides.length-1;}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slideIndex++;
  if (slideIndex > slides.length) {slideIndex = 1}
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }

    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";
    if(n==undefined){
      setTimeout(showSlides, 5000);
    }
  }