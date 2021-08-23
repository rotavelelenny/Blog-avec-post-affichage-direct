// When the user scrolls the page, execute myFunction
window.onscroll = function() {myFunction()};

    // Get the header
    var header = document.getElementById("header_sticky");

    // Get the offset position of the navbar
    var sticky = header.offsetTop;

    // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    // ! Menu / header on the sticky-fixed top with scroll (Y)
    function myFunction() {
        if (window.pageYOffset > sticky) {
            header.classList.add("sticky_top");
            
        } else {
            header.classList.remove("sticky_top");
        }
}

// // ! Only use for Menu / header (inside log)  sticky-fixed on the left with scrollbar (Y)
// function myFunction() {
//     if (window.pageYOffset > sticky) {
//         header.classList.add("sticky_left");
//     } else {
//         header.classList.remove("sticky_left");
//     }
// }