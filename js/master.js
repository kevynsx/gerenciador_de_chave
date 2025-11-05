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

function abrirMenuModalUserLogado(){
    const menuuserlogado = document.getElementById("menuusuariologado")
    menuuserlogado.classList.add("abrir")

    menuuserlogado.addEventListener("click", (e) => {
        if(e.target.id == "fechar" || e.target.id == "menuusuariologado"){
            menuuserlogado.classList.remove("abrir")
        }
    })
}

function abrirMenuCadastroUsuario(){
    const cadastrousuariomodal = document.getElementById("cadastrousuario")
    cadastrousuariomodal.classList.add("abrir")

    cadastrousuariomodal.addEventListener("click", (e) => {
        if(e.target.id == "cadastrar" || e.target.id == "cadastrousuario"){
            cadastrousuariomodal.classList.remove("abrir")
        }
        if(e.target.id == "fechar" || e.target.id == "cadastrousuario"){
            cadastrousuariomodal.classList.remove("abrir")
        }
    })
}