const tbody = document.querySelector(".listar-agendamentos");
const cadForm = document.getElementById("cad-agendamento-form");
const msgAlertaErroCad = document.getElementById("msgAlertaErroCad");
const msgAlerta = document.getElementById("msgAlerta");
const cadModal = new bootstrap.Modal(document.getElementById("cadAgendamentoModal"));

const listarAgendamento = async (pagina) => {
    const dados1 = await fetch("./list.php?pagina=" + pagina);
    const resposta = await dados1.text();
    tbody.innerHTML = resposta;
}

listarAgendamento(1);

cadForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dadosAgend = new FormData(cadForm);
    dadosAgend.append("add", 1);

    document.getElementById("cad-agendamento-btn").value = "Agendando...";

    const dados1 = await fetch("cadAgendamento.php", {
        method: "POST",
        body: dadosAgend,
    });

    const resposta = await dados1.json();
    
    if(resposta['erro']){
        msgAlertaErroCad.innerHTML = resposta['mensagem'];
    }else{
        msgAlerta.innerHTML = resposta['mensagem'];
        cadForm.reset();
        cadModal.hide();
        listarAgendamento(1);
    }
    document.getElementById("cad-agendamento-btn").value = "Cadastrar";
});