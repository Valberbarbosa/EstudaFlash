const btn_publico_value = document.querySelector('#ball__mover-value');
document.querySelector('.ball-mover').addEventListener('click', function () {
    if (document.querySelector('.btn').classList.toggle('btn-m')) {
        tornarPublicoCard(btn_publico_value.value, 'adicionar');
        document.querySelector('.btn-texto').innerHTML = 'Sim';
        document.querySelector('.ball').classList.add('btn-text-m');
    } else {
        tornarPublicoCard(btn_publico_value.value, 'remover');
        document.querySelector('.btn-texto').innerHTML = 'Não';
        document.querySelector('.ball').classList.remove('btn-text-m');
    }
});
function tornarPublicoCard(idCard, acao) {
    $.ajax({
        url: `/pages/tornar_publico_card.php`,
        method: 'POST',
        dataType: 'json',
        data: {
            id: idCard,
            acao: acao,
        },
        success: function (response) {
            console.log(response);
        }
    });
}

document.querySelectorAll('.dashboard-card-corpo').forEach((e) => {
    e.addEventListener('click', (element) => {
        document.querySelector('.alerta-card-visualizar').classList.add('alerta-card-visualizar-active');

        $.ajax({
            url: `/pages/buscar_card.php`,
            method: 'POST',
            dataType: 'json',
            data: {
                id: element.target.dataset.id,
            },
            success: function (response) {
                if(response.status == 'sucesso'){
                    document.querySelector('.alerta-card-visualizar-deletar a').href = `pages/deletar_card.php?id=${response.content[0].id}&id_lista=${response.content[0].id_lista}`;
                    document.querySelector('.alerta-card-visualizar-container').innerHTML = `<h1 class="h1-titulo">${response.content[0].titulo}</h1><div class="conteudo">${response.content[0].descricao}</div>`;
                    document.querySelector('.alerta-editar-licao-container #editar-titulo').value = response.content[0].titulo;
                }else{
                    alert('Não conseguimos buscar as informações do card')
                }
            }
        });
    });
});
document.querySelector('.alerta-card-visualizar-close').addEventListener('click', ()=>{
    document.querySelector('.alerta-card-visualizar').classList.remove('alerta-card-visualizar-active');
    document.querySelector('.alerta-card-visualizar-container').innerHTML = `<div class="loading"><img class="loading-img" src="./assets/IMG/load-gif.gif" alt="loading"></div>`;
})
document.querySelector('.alerta-card-visualizar-btnclose').addEventListener('click', ()=>{
    document.querySelector('.alerta-card-visualizar').classList.remove('alerta-card-visualizar-active');
    document.querySelector('.alerta-card-visualizar-container').innerHTML = `<div class="loading"><img class="loading-img" src="./assets/IMG/load-gif.gif" alt="loading"></div>`;
})
document.querySelector('.alerta-card-visualizar-editar').addEventListener('click', ()=>{
    document.querySelector('.alerta-editar-licao').classList.add('alerta-editar-licao-active');
    document.querySelector('.alerta-card-visualizar').classList.remove('alerta-card-visualizar-active');
})