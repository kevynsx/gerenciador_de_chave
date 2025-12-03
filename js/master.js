function abrirMenuAddChave(){
    const addchavemodal = document.getElementById("addchavemenu")
    addchavemodal.classList.add("abrir")

    addchavemodal.addEventListener("click", (e) => {
        if(e.target.id == "addchavebotao" || e.target.id == "addchavemenu"){
            addchavemodal.classList.remove("abrir")
        }
        if(e.target.id == "fechar" || e.target.id == "addchavemenu"){
            addchavemodal.classList.remove("abrir")
        }
    })
}

function abrirMenuVerUsuarios(){
    const verusuariosmodal = document.getElementById("tabelausuarios")
    verusuariosmodal.classList.add("abrir")

    verusuariosmodal.addEventListener("click", (e) => {
        if(e.target.id == "fechar" || e.target.id == "tabelausuarios"){
            verusuariosmodal.classList.remove("abrir")
        }
    })
}

function confirmacaoApagarChave(){
    const confirmacaoapagarchavemodal = document.getElementById("confirmacaoapagarchave")
    confirmacaoapagarchavemodal.classList.add("abrir")

    confirmacaoapagarchavemodal.addEventListener("click", (e) => {
        if(e.target.id == "sim" || e.target.id == "confirmacaoapagarchave"){
            confirmacaoapagarchavemodal.classList.remove("abrir")
        }
        if(e.target.id == "nao" || e.target.id == "confirmacaoapagarchave"){
            confirmacaoapagarchavemodal.classList.remove("abrir")
        }
    })
}

function editarChave(){
    const editarchavemodal = document.getElementById("editarchavemenu")
    editarchavemodal.classList.add("abrir")

    editarchavemodal.addEventListener("click", (e) => {
        if(e.target.id == "editarchavebotao" || e.target.id == "editarchavemenu"){
            editarchavemodal.classList.remove("abrir")
        }
        if(e.target.id == "fechar" || e.target.id == "editarchavemenu"){
            editarchavemodal.classList.remove("abrir")
        }
    })
}

function confirmacaoApagarUser(){
    const confirmacaoapagarusermodal = document.getElementById("confirmacaoapagaruser")
    confirmacaoapagarusermodal.classList.add("abrir")

    confirmacaoapagarusermodal.addEventListener("click", (e) => {
        if(e.target.id == "sim" || e.target.id == "confirmacaoapagaruser"){
            confirmacaoapagarusermodal.classList.remove("abrir")
        }
        if(e.target.id == "nao" || e.target.id == "confirmacaoapagaruser"){
            confirmacaoapagarusermodal.classList.remove("abrir")
        }
    })
}

function editarUser(){
    const editarusermodal = document.getElementById("editarusermenu")
    editarusermodal.classList.add("abrir")

    editarusermodal.addEventListener("click", (e) => {
        if(e.target.id == "editaruserbotao" || e.target.id == "editarusermenu"){
            editarusermodal.classList.remove("abrir")
        }
        if(e.target.id == "fechar" || e.target.id == "editarusermenu"){
            editarusermodal.classList.remove("abrir")
        }
    })
}
// Seleciona todos os botões de editar
const editarBtns = document.querySelectorAll('.editarUserBtn');
const modalEditar = document.getElementById('editarusermenu');
const fecharModal = document.getElementById('fecharEditar');

editarBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        const nome = btn.dataset.nome;
        const cpf = btn.dataset.cpf;
        const cargo = btn.dataset.cargo;

        document.getElementById('editarId').value = id;
        document.getElementById('editarNome').value = nome;
        document.getElementById('editarCpf').value = cpf;
        document.getElementById('editarFuncao').value = cargo;

        modalEditar.style.display = 'block';
    });
});

// Fecha o modal ao clicar no "X"
fecharModal.addEventListener('click', () => {
    modalEditar.style.display = 'none';
});

// Fecha o modal clicando fora dele (opcional)
window.addEventListener('click', (e) => {
    if (e.target === modalEditar) {
        modalEditar.style.display = 'none';
    }
});

function abrirMenuModalUserLogado(){
    const menuuserlogado = document.getElementById("menuusuariologado")
    menuuserlogado.classList.add("abrir")

    menuuserlogado.addEventListener("click", (e) => {
        if(e.target.id == "fechar" || e.target.id == "menuusuariologado"){
            menuuserlogado.classList.remove("abrir")
        }
        if(e.target.id == "verusuariosbotao" || e.target.id == "menuusuariologado"){
            menuuserlogado.classList.remove("abrir")
        }
        if(e.target.id == "cadastrarusuariobotao" || e.target.id == "menuusuariologado"){
            menuuserlogado.classList.remove("abrir")
        }
    })
}


function abrirMenuCadastroUsuario(){
    const cadastrousuariomodal = document.getElementById("cadastrarusuariomenu")
    cadastrousuariomodal.classList.add("abrir")

    cadastrousuariomodal.addEventListener("click", (e) => {
        if(e.target.id == "cadastrar" || e.target.id == "cadastrarusuariomenu"){
            cadastrousuariomodal.classList.remove("abrir")
        }
        if(e.target.id == "fechar" || e.target.id == "cadastrarusuariomenu"){
            cadastrousuariomodal.classList.remove("abrir")
        }
    })
}

function abrirRelatorioPrincipal(){
    const relatorioprincipalmodal = document.getElementById("relatorioprincipalmenu")
    relatorioprincipalmodal.classList.add("abrir")

    relatorioprincipalmodal.addEventListener("click", (e) => {
        if(e.target.id == "relatorioprincipalbotao" || e.target.id == "relatorioprincipalmenu"){
            relatorioprincipalmodal.classList.remove("abrir")
        }
        if(e.target.id == "fechar" || e.target.id == "relatorioprincipalmenu"){
            relatorioprincipalmodal.classList.remove("abrir")
        }
        if(e.target.id == "relatoriohistoricobotao" || e.target.id == "relatorioprincipalmenu"){
            relatorioprincipalmodal.classList.remove("abrir")
        }
    })
}

function abrirRelatorioHistorico(){
    const relatoriohistoricomodal = document.getElementById("relatoriohistoricomenu")
    relatoriohistoricomodal.classList.add("abrir")

    relatoriohistoricomodal.addEventListener("click", (e) => {
        if(e.target.id == "voltarhistoricoprincipal" || e.target.id == "relatoriohistoricomenu"){
            relatoriohistoricomodal.classList.remove("abrir")
        }
        if(e.target.id == "fechar" || e.target.id == "relatoriohistoricomenu"){
            relatoriohistoricomodal.classList.remove("abrir")
        }
    })
}