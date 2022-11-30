function changePage(page) {
    if (window.location.pathname.includes(page)) {
        return
    }
    window.location = './' + page
}

window.onscroll = function () { myFunction() };

var header = document.getElementById("nav-container");
var sticky = header.offsetTop;

function myFunction() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
}