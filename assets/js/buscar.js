function searchEmployee() {
    const searchBar = document.getElementById('search-bar');
    const name = searchBar.value;

    if (!name) {
        alert('Por favor, insira um nome para pesquisar.');
        return;
    }

    fetch(`/funcionario.php?name=${encodeURIComponent(name)}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            document.getElementById('employee-photo').src = `/uploads/funcionarios/${data.foto || 'placeholder.png'}`;
            document.getElementById('employee-name').textContent = data.nome;
            document.getElementById('employee-email').textContent = data.email;
            document.getElementById('employee-cpf').textContent = data.cpf;
            document.getElementById('employee-role').textContent = data.cargo;
            document.getElementById('employee-address').textContent = data.endereco;
            document.getElementById('employee-phone').textContent = data.telefone;
        })
        .catch(error => console.error('Erro ao buscar funcionário:', error));
}
