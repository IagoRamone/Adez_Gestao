async function filterSuggestions() {
    const input = document.getElementById('search-bar');
    const suggestions = document.getElementById('suggestions');
    const query = input.value;

    suggestions.innerHTML = ''; 

    if (query) {
        const response = await fetch(`../php/funvionarios.php?query=${query}`);
        const matches = await response.json();

        if (matches.length > 0) {
            matches.forEach(match => {
                const suggestionDiv = document.createElement('div');
                suggestionDiv.textContent = match.name;
                suggestionDiv.onclick = () => {
                    input.value = match.name;
                    suggestions.innerHTML = '';
                    suggestions.style.display = 'none';
                };
                suggestions.appendChild(suggestionDiv);
            });

            suggestions.style.display = 'block';
        } else {
            suggestions.style.display = 'none';
        }
    } else {
        suggestions.style.display = 'none';
    }
}
