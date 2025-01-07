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

document.addEventListener("DOMContentLoaded", function () {
    const navbarHeight = document.querySelector('.navbar').offsetHeight;  // Get navbar height dynamically
    const links = document.querySelectorAll('a.nav-link[href^="#"]');  // Select all navigation links with href starting with '#'

    links.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();  // Prevent default anchor click behavior
            const targetId = this.getAttribute('href').substring(1);  // Get the target ID from href
            const targetElement = document.getElementById(targetId);  // Get the target element by ID

            if (targetElement) {
                const targetPosition = targetElement.offsetTop - navbarHeight;  // Adjust position by navbar height

                window.scrollTo({
                    top: targetPosition,  // Scroll to the correct position
                    behavior: 'smooth',  // Smooth scroll effect
                });
            }
        });
    });
});