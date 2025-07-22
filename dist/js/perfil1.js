const menuToggle = document.querySelector('.menuToggle');
const navigation = document.querySelector('.navigation');
const bom = document.querySelector('.content-wrapper');

menuToggle.onclick = function() {
    navigation.classList.toggle('active');
}