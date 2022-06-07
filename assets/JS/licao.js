const btnOpen = document.querySelector('.dashbord-container-btn-add')
const alertaAddLicao = document.querySelector('.alerta-add-licao')
const btnClose = document.querySelector('.alerta-add-licao-finalizar')

btnOpen.addEventListener('click', function(){
    alertaAddLicao.classList.add('alerta-add-licao-active')
})

btnClose.addEventListener('click', function(){
    alertaAddLicao.classList.remove('alerta-add-licao-active')
})
