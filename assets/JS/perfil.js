const reader = new FileReader();

document.querySelector('#foto__upload').addEventListener('change', function () {
    var imagemUpload = document.querySelector('#foto__upload').files[0];
    var imagemPreview = document.querySelector('#foto__upload-preview');
    reader.onloadend = function () {
        imagemPreview.src = reader.result;
    }
    if (imagemUpload) {
        reader.readAsDataURL(imagemUpload);
    } else {
        imagemPreview.src = "";
    }
})

document.querySelector('.perfil-btn-formulario-delete').addEventListener('click', (e) => {
    swal({
        title: "Tem certeza?",
        text: "Uma vez excluído, você não poderá recuperar está conta!",
        icon: "warning",
        buttons: true,
        buttons: ["Cancelar", "Deletar"],
        dangerMode: true,
    })
        .then((willDelete) => {
            if (willDelete) {
                swal("Conta deletada com sucesso!", {
                    icon: "success",
                });
                location.href = "/pages/deletar_conta.php";
            } else {
                swal("Sua conta está salva!");
            }
        });
})
