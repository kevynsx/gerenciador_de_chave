function abrirMenuModalUserLogado(){
    const menuuserlogado = document.getElementById("menuusuariologado")
    menuuserlogado.classList.add("abrir")

    menuuserlogado.addEventListener("click", (e) => {
        if(e.target.id == "fechar" || e.target.id == "menuusuariologado"){
            menuuserlogado.classList.remove("abrir")
        }
    })
}