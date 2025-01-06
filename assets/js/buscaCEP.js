function buscarCEP() {
    const cep = document.getElementById("cep").value.replace(/\D/g, ""); 
    if (cep.length === 8) { 
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (data.erro) {
                    alert("CEP não encontrado!");
                } else {
                    document.getElementById("address").value = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
                }
            })
            .catch(() => alert("Erro ao buscar o CEP."));
    } else {
        alert("CEP inválido!");
    }
}
