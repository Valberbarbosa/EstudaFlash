var idCardAtualView = 0;
const arrayCardView = document.querySelector('#cards-opcao').value;
var arrayCardViewAdd = arrayCardView.split(',');

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
                document.querySelector('.btn-card-view-facil').setAttribute('data-id', response.content[0].id);
                document.querySelector('.btn-card-view-facil').setAttribute('data-assunto', response.content[0].id);
                document.querySelector('.btn-card-view-facil').setAttribute('data-click', 'fácil');

                document.querySelector('.btn-card-view-medio').setAttribute('data-id', response.content[0].id);
                document.querySelector('.btn-card-view-medio').setAttribute('data-assunto', response.content[0].id);
                document.querySelector('.btn-card-view-medio').setAttribute('data-click', 'médio');

                document.querySelector('.btn-card-view-dificio').setAttribute('data-id', response.content[0].id);
                document.querySelector('.btn-card-view-dificio').setAttribute('data-assunto', response.content[0].id);
                document.querySelector('.btn-card-view-dificio').setAttribute('data-click', 'difícil');

                document.querySelector('.alerta-card-visualizar-deletar a').href = `pages/deletar_card.php?id=${response.content[0].id}&id_lista=${response.content[0].id_lista}`;
                document.querySelector('.alerta-card-visualizar-container').innerHTML = `<h1 class="h1-titulo">${response.content[0].titulo}</h1><div class="conteudo">${response.content[0].descricao}</div>`;
                document.querySelector('.alerta-card-visualizar-acao').classList.add('active')
                document.querySelector('.alerta-editar-licao-container #editar-id').value = response.content[0].id;
                document.querySelector('.alerta-editar-licao-container #editar-titulo').value = response.content[0].titulo; 
                document.querySelectorAll('.trumbowyg-editor')[1].innerHTML = response.content[0].descricao;      


            } else {
                alert('Não conseguimos buscar as informações do card')
            }
        }
    });

}

document.querySelectorAll('.dashboard-card-corpo').forEach((e) => {
    e.addEventListener('click', (element) => {
        //document.querySelector('.alerta-editar-licao-container .ck-content').setAttribute('id', 'editartexto');
        document.querySelector('.alerta-card-visualizar').classList.add('alerta-card-visualizar-active');
        getInforCard(element.target.dataset.id);
        idCardAtualView = element.target.dataset.postagem;
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
document.querySelector('.alerta-card-visualizar-editar').addEventListener('click', () => {
    document.querySelector('.alerta-editar-licao').classList.add('alerta-editar-licao-active');
    document.querySelector('.alerta-card-visualizar').classList.remove('alerta-card-visualizar-active');
})

document.querySelector('.alerta-editar-licao-finalizar').addEventListener('click', () => {
    document.querySelector('.alerta-editar-licao').classList.remove('alerta-editar-licao-active');
})

document.querySelectorAll('.btn-card-view button').forEach((e) => {
    e.addEventListener('click', (element) => {
        document.querySelector('.alerta-card-visualizar-content-loading').classList.add('active');


        $.ajax({
            url: `/pages/salvar_revisar.php`,
            method: 'POST',
            dataType: 'json',
            data: {
                id: element.target.dataset.id,
                id_assunto: element.target.dataset.assunto,
                click: element.target.dataset.click,
            },
            success: function (response) {
                console.log(response);
                document.querySelector('.alerta-card-visualizar-content-loading').classList.remove('active');
                document.querySelector('.alerta-card-visualizar').classList.remove('alerta-card-visualizar-active');
                if (response.status == 'sucesso') {
                    Swal.fire(
                        'Muito bom!',
                        `Você classificou esse flashcard como ${element.target.dataset.click}!`,
                        'success'
                    )
                } else {
                    Swal.fire(
                        'Poxaaa!',
                        `Você já classificou esse flashcard como ${element.target.dataset.click}!`,
                        'error'
                    )
                }
            }
        });
    })
})



document.querySelector('.alerta-card-left').addEventListener('click', () => {
    document.querySelector('.alerta-card-visualizar-acao').classList.remove('active')
    document.querySelector('.alerta-card-visualizar-container').innerHTML = `<div class="loading"><img class="loading-img" src="./assets/IMG/load-gif.gif" alt="loading"></div>`;
    if (idCardAtualView > 0) {
        idCardAtualView--;
        getInforCard(arrayCardViewAdd[idCardAtualView]);
    } else {
        idCardAtualView = arrayCardViewAdd.length - 1;
        getInforCard(arrayCardViewAdd[idCardAtualView]);
    }
})
document.querySelector('.alerta-card-right').addEventListener('click', () => {
    document.querySelector('.alerta-card-visualizar-acao').classList.remove('active')
    document.querySelector('.alerta-card-visualizar-container').innerHTML = `<div class="loading"><img class="loading-img" src="./assets/IMG/load-gif.gif" alt="loading"></div>`;
    if (idCardAtualView < arrayCardViewAdd.length - 1) {
        idCardAtualView++;
        getInforCard(arrayCardViewAdd[idCardAtualView]);
    } else {
        idCardAtualView = 0;
        getInforCard(arrayCardViewAdd[idCardAtualView]);
    }

})  

const btnOpenEditar = document.querySelector('.dashbord-container-btn-editar')
const alertaEditar = document.querySelector('.cartao-editar')
const btnCloseEditar = document.querySelector('.cartao-editar-finalizar')

btnOpenEditar.addEventListener('click', function(){
    alertaEditar.classList.add('alerta-add-licao-active')
})

btnCloseEditar.addEventListener('click', function(){
    alertaEditar.classList.remove('alerta-add-licao-active')
})


