// script for star rating
const stars = document.querySelectorAll(".stars i");

stars.forEach((star, index1) => {
    // Handle click event to set active stars
    star.addEventListener("click", () => {
        stars.forEach((star, index2) => {
            index1 >= index2 ? star.classList.add("active") : star.classList.remove("active");
        });
    });

    // Handle hover event to temporarily show stars as active
    star.addEventListener("mouseover", () => {
        stars.forEach((star, index2) => {
            index1 >= index2 ? star.classList.add("hover") : star.classList.remove("hover");
        });
    });

    // Remove hover effect when mouse leaves the stars
    star.addEventListener("mouseout", () => {
        stars.forEach((star) => {
            star.classList.remove("hover");
        });
    });
});


// script for copying number to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Phone number copied to clipboard');
    }).catch(function(error) {
        console.error('Error copying text: ', error);
    });
}