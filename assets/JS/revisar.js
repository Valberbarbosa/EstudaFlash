

function getInforCard(idName) {
    $.ajax({
        url: `/pages/buscar_card.php`,
        method: 'POST',
        dataType: 'json',
        data: {
            id: idName,
        },
        success: function (response) {
            if (response.status == 'sucesso') {

                document.querySelector('.alerta-card-visualizar-editar a').href = `pages/continuar_revisao_card.php?id=${response.content[0].id}`;
                document.querySelector('.alerta-card-visualizar-concluida a').href = `pages/revisar_card_concluida.php?id=${response.content[0].id}`;
                document.querySelector('.alerta-card-visualizar-container').innerHTML = `<h1 class="h1-titulo">${response.content[0].titulo}</h1><div class="conteudo">${response.content[0].descricao}</div>`;
                document.querySelector('.alerta-card-visualizar-acao').classList.add('active')
                document.querySelector('.alerta-editar-licao-container #editar-titulo').value = response.content[0].titulo;
                document.querySelector('.alerta-editar-licao-container .ck-content').innerText = response.content[0].descricao;
                $('#editor2').val('my new content');



            } else {
                alert('Não conseguimos buscar as informações do card')
            }
        }
    });
}
document.querySelectorAll('.dashboard-card-corpo').forEach((e) => {
    e.addEventListener('click', (element) => {
        document.querySelector('.alerta-card-visualizar').classList.add('alerta-card-visualizar-active');
        getInforCard(element.target.dataset.id);
    });
});
document.querySelector('.alerta-card-visualizar-close').addEventListener('click', () => {
    document.querySelector('.alerta-card-visualizar').classList.remove('alerta-card-visualizar-active');
    document.querySelector('.alerta-card-visualizar-container').innerHTML = `<div class="loading"><img class="loading-img" src="./assets/IMG/load-gif.gif" alt="loading"></div>`;
    document.querySelector('.alerta-card-visualizar-acao').classList.remove('active')
})
document.querySelector('.alerta-card-visualizar-btnclose').addEventListener('click', () => {
    document.querySelector('.alerta-card-visualizar').classList.remove('alerta-card-visualizar-active');
    document.querySelector('.alerta-card-visualizar-container').innerHTML = `<div class="loading"><img class="loading-img" src="./assets/IMG/load-gif.gif" alt="loading"></div>`;
    document.querySelector('.alerta-card-visualizar-acao').classList.remove('active')
})

document.querySelector('.alerta-card-visualizar-editar').addEventListener('click')

