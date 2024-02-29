// $('.hero-slider').slick({
//     autoplay:true,
//     Infinite:false,
// speed:200,                                 //  a function for sliders
//     nextArrow: $('.next'),
//     prevArrow: $('.prev')
// });

const header = document.querySelector('header')
function fixedNavbar() {
    header.classList.toggle('scrolled', window.scrollY > 0)
}

fixedNavbar()

window.addEventListener('scroll', fixedNavbar)

let userBtn = document.querySelector('#user-btn')

userBtn.addEventListener('click', function(){ // Changed from menu to userBtn
    let userBox = document.querySelector('.user-box'); // Changed from nav to userBox
    userBox.classList.toggle('active');
});