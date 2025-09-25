function abrirMenuAddChave(){
    const addchavemodal = document.getElementById("addchavemenu")
    addchavemodal.classList.add("abrir")

    addchavemodal.addEventListener("click", (e)=>{
        if(e.target.id == "addchavebotao" || e.target.id == "addchavemenu"){
            addchavemodal.classList.remove("abrir")

        }
        if(e.target.id == "fechar" || e.target.id == "addchavemenu"){
            addchavemodal.classList.remove("abrir")
        }
    })
}