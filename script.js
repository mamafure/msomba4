const menuBtn = document.getElementById('menuBtn');
const closeBtn = document.getElementById('closeBtn');
const navOverlay = document.getElementById('navOverlay');

// Open Menu
menuBtn.addEventListener('click', () => {
    navOverlay.classList.add('active');
});

// Close Menu
closeBtn.addEventListener('click', () => {
    navOverlay.classList.remove('active');
});

// Close menu when a link is clicked
const links = document.querySelectorAll('.nav-links a');
links.forEach(link => {
    link.addEventListener('click', () => {
        navOverlay.classList.remove('active');
    });
});



function checkLogin(isLoggedIn) {
    if (!isLoggedIn) {
        alert("Please login first to continue shopping at MSOMBA PHONE POINT!");
        window.location.href = "login.php";
    } else {
        alert("Added to cart successfully!");
        // Here you would normally add the logic to actually add to database cart
    }
}