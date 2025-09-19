window.addEventListener('load', function() {
  // Quando a página estiver completamente carregada, o preloader é escondido
  document.querySelector('.loadingspinner').style.display = 'none';
});

const searchInput = document.querySelector('.search__input');
const searchButton = document.querySelector('.search__button');

// Páginas que serão pesquisadas
const pages = ['../Equipe.html', '../clientes.html'];

async function doSearch(query) {
  if (!query) return;

  let results = [];

  for (const page of pages) {
    const response = await fetch(page);
    const text = await response.text();

    const parser = new DOMParser();
    const doc = parser.parseFromString(text, 'text/html');

    // Seleciona todo texto relevante (p, h1, h2...)
    const items = Array.from(doc.body.querySelectorAll('p, h1, h2, h3, li, div'));

    items.forEach(item => {
      if (item.textContent.toLowerCase().includes(query.toLowerCase())) {
        results.push({ text: item.textContent, page });
      }
    });
  }

  return results;
}

// Função para enviar resultados para results.html
async function searchAndRedirect() {
  const query = searchInput.value.trim();
  if (!query) return;

  const results = await doSearch(query);
  localStorage.setItem('searchResults', JSON.stringify({ query, results }));
  window.location.href = 'results.html';
}

// Evento botão e Enter
searchButton.addEventListener('click', searchAndRedirect);
searchInput.addEventListener('keypress', (e) => {
  if (e.key === 'Enter') searchAndRedirect();
});

// Lógica para results.html
const resultsContainer = document.getElementById('results');
if (resultsContainer) {
  const data = JSON.parse(localStorage.getItem('searchResults'));
  if (!data) {
    resultsContainer.innerHTML = '<p>Nenhum resultado encontrado.</p>';
  } else {
    const { query, results } = data;
    if (results.length === 0) {
      resultsContainer.innerHTML = `<p>Nenhum resultado encontrado para "${query}"</p>`;
    } else {
      results.forEach(r => {
        const div = document.createElement('div');
        div.innerHTML = `<strong>${r.page}:</strong> ${r.text}`;
        resultsContainer.appendChild(div);
      });
    }
  }
}
