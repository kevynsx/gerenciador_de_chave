document.addEventListener('DOMContentLoaded', () => {
    
    // Pega o elemento do modal e o armazena na variÃ¡vel
    const addchavemodal = document.getElementById("addchavemenu");

    // Adiciona o ouvinte de evento 'click' ao documento inteiro
    document.addEventListener('click', (e) => {
        // Verifica se o clique foi no botÃ£o de abrir (ID 'addchavebotao')
        if (e.target.id === "addchavebotao") {
            // Se sim, adiciona a classe 'abrir' ao modal para mostrá-lo
            addchavemodal.classList.add("abrir");
        } 
        
        // Verifica se o clique foi no botÃ£o de fechar (ID 'fechar') ou fora do modal (na Ã¡rea escura)
        if (e.target.id === "fechar" || e.target.id === "addchavemenu") {
            // Se sim, remove a classe 'abrir' para escondê-lo
            addchavemodal.classList.remove("abrir");
        }
    });

});