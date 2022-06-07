const openMenu = document.getElementById('open-menu');
const closeMenu = document.getElementById('close-menu');
const menu = document.querySelector('.menu');

openMenu.addEventListener('click', ()=>{
    menu.classList.add('menu-active')
})
closeMenu.addEventListener('click', ()=>{
    menu.classList.remove('menu-active')
})