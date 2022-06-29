const openMenu = document.querySelector('.openMenu-aside')
const closeMenu = document.querySelector('.closeMenu-aside')
const conteudo = document.querySelector('#conteudo')

openMenu.addEventListener('click', function () {
    document.querySelector('.aside-menu').classList.add('aside-menu-active')
})

closeMenu.addEventListener('click', function () {
    document.querySelector('.aside-menu').classList.remove('aside-menu-active')
})

conteudo.addEventListener('click', function () {
    document.querySelector('.aside-menu').classList.remove('aside-menu-active')
})
const cartaoContent = document.querySelectorAll('.dashbord-card-content');
const cartaoContentProgress = document.querySelector('.dashboard-progress-porcentagem');
const cartaoContentTotal = document.querySelector('.progress-total');
const cartaoContentTotalAtual = document.querySelector('.progress-total-atual');
var numInicialCartao = 0
var numTag = 0;
let progress = 0;
//cartaoContentTotal.innerHTML = cartaoContent.length;
//cartaoContentTotalAtual.innerHTML = numTag + 1;
progress = (100 / cartaoContent.length) * 1;
cartaoContentProgress.style.width = progress + "%";

function dashboardCartao(num) {
    cartaoContent[numInicialCartao].classList.remove('active');
    if ((numInicialCartao + num) > (cartaoContent.length - 1)) {
        numInicialCartao = 0;
        dashboardCartaoAcoes()
    } else if ((numInicialCartao + num) < 0) {
        numInicialCartao = cartaoContent.length - 1
        dashboardCartaoAcoes(num)
    } else {
        dashboardCartaoAcoes(num)
    }


}

function dashboardCartaoAcoes(num = 0) {
    if (((numInicialCartao + num) >= 0 && (numInicialCartao + num) < cartaoContent.length)) {
        numTag = numInicialCartao += num;
        cartaoContent[numTag].classList.add('active');

        progress = (100 / cartaoContent.length) * (numInicialCartao + 1);
        cartaoContentTotalAtual.innerHTML = numTag + 1;
        cartaoContentProgress.style.width = progress + "%";
    } else {
        cartaoContent[numTag].classList.add('active');
    }
}