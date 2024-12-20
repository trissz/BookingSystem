document.addEventListener("DOMContentLoaded", async () => {

    const stars = document.getElementById("stars").getElementsByTagName("span");
    let selectedRating = 0; 
    const ratingInput = document.getElementById("rating"); 
    ratingInput.value = selectedRating; 
  
    Array.from(stars).forEach(star => {
      star.addEventListener("click", () => {
        selectedRating = parseInt(star.getAttribute("data-value")); 
        ratingInput.value = selectedRating;
        Array.from(stars).forEach(star => star.style.color = "gray"); 
  
        for (let i = 0; i < selectedRating; i++) {
          stars[i].style.color = "gold";
        }
  
        console.log(ratingInput.value); 
      });
    });
  });
  