const loading = document.getElementById('loading');
const error = document.getElementById('error');
const container = document.getElementById('card-container');

async function fetchPokemon() {
    const path = window.location.pathname;
    try {
        console.log(`[LOG ${new Date().toISOString()}, ${path}] : Memulai fetch data pokemon...`);
        const res = await fetch('https://pokeapi.co/api/v2/pokemon?limit=30');
        if (!res.ok) throw new Error('Failed to fetch');
        const data = await res.json();

        const details = await Promise.all(
            data.results.map(p => fetch(p.url).then(r => r.json()))
        );

        loading.classList.add('hidden');
        container.classList.remove('hidden');
        console.log(`[LOG ${new Date().toISOString()}, ${path}] : Berhasil memuat ${details.length} pokemon.`);

        details.forEach(pokemon => {
            const card = document.createElement('div');
            card.className = 'bg-surface rounded-xl shadow-md p-4 flex flex-col items-center hover:shadow-lg transition-shadow';
            card.innerHTML = `
                <img src="${pokemon.sprites.front_default}" alt="${pokemon.name}" class="w-24 h-24">
                <p class="font-bold capitalize mt-2 text-text">${pokemon.name}</p>
                <p class="text-muted text-sm">#${String(pokemon.id).padStart(3, '0')}</p>
                <div class="flex gap-1 mt-2 flex-wrap justify-center">
                    ${pokemon.types.map(t => `<span class="text-xs bg-primary text-white px-2 py-0.5 rounded-full capitalize">${t.type.name}</span>`).join('')}
                </div>
            `;
            container.appendChild(card);
        });
    } catch (err) {
        loading.classList.add('hidden');
        error.classList.remove('hidden');
        console.log(`[LOG ${new Date().toISOString()}, ${path}] : Gagal fetch data pokemon. ${err.message}`);
    }
}

fetchPokemon();
