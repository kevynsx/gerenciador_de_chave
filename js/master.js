// JS funcional
function abrirMenuAddChave() {
    const modal = document.getElementById("addchavemenu");

    // Abre o modal
    modal.classList.add("abrir");

    // Listener para fechar (só adiciona uma vez!)
    const fecharModal = (e) => {
        const idsFechar = ["fechar", "addchavemenu"];
        if (idsFechar.includes(e.target.id)) {
            modal.classList.remove("abrir");
        }
    };

    // Remove listeners anteriores e adiciona novo
    modal.removeEventListener("click", fecharModal); // segurança
    modal.addEventListener("click", fecharModal);
}
