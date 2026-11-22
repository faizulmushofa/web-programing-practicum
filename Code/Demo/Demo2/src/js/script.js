const menuButton = document.querySelector('#menu-button');
const mobileMenu = document.querySelector('#mobile-menu');
const searchInput = document.querySelector('#search-input');
const mediaGrid = document.querySelector('#media-grid');
const loading = document.querySelector('#loading');
const errorMessage = document.querySelector('#error-message');
const pagination = document.querySelector('#pagination');

let media = [];
let activeAura = 'all';
let currentPage = 1;
const itemsPerPage = 8;

menuButton.addEventListener('click', () => {
    const isOpen = !mobileMenu.classList.toggle('hidden');
    menuButton.setAttribute('aria-expanded', isOpen);
});

function renderCards() {
    const query = searchInput.value.toLowerCase();
    const filtered = media.filter((item) => {
        const title = item.attributes.titles.en_jp?.toLowerCase() || item.attributes.canonicalTitle.toLowerCase();
        const rating = Number(item.attributes.averageRating || 0);
        const episodes = item.attributes.episodeCount || 0;
        const status = item.attributes.status;
        const type = item.attributes.showType;
        const auraMatch = activeAura === 'all' ||
            (activeAura === 'high-rated' && rating >= 80) ||
            (activeAura === 'movies' && type === 'movie') ||
            (activeAura === 'ongoing' && status === 'current');
        return title.includes(query) && auraMatch;
    });

    const pageCount = Math.ceil(filtered.length / itemsPerPage);
    const pageItems = filtered.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage);

    mediaGrid.innerHTML = pageItems.map((item) => {
        const data = item.attributes;
        const title = data.titles.en_jp || data.canonicalTitle;
        return `
            <article class="overflow-hidden bg-surface">
                <img src="${data.posterImage?.medium || ''}" alt="${title}" class="h-64 w-full object-cover">
                <div class="p-4">
                    <h3 class="font-bold">${title}</h3>
                    <p class="mt-2 text-sm text-gray-400">Rating: ${data.averageRating ?? 'N/A'} · Episodes: ${data.episodeCount ?? 'N/A'}</p>
                </div>
            </article>
        `;
    }).join('') || '<p class="col-span-full text-gray-400">No matching titles.</p>';
    pagination.innerHTML = Array.from({ length: pageCount }, (_, index) => `
        <button data-page="${index + 1}" class="border border-white/30 px-3 py-1">${index + 1}</button>
    `).join('');
    pagination.querySelectorAll('button').forEach((button) => {
        button.addEventListener('click', () => {
            currentPage = Number(button.dataset.page);
            renderCards();
        });
    });
}

async function loadMedia() {
    try {
        const response = await fetch('https://kitsu.io/api/edge/anime?sort=-startDate', {
            headers: { Accept: 'application/vnd.api+json' }
        });
        if (!response.ok) throw new Error('API request failed');
        const firstPage = await response.json();
        media = firstPage.data;
        let nextUrl = firstPage.links?.next;
        for (let page = 1; nextUrl && page < 5; page++) {
            const nextResponse = await fetch(nextUrl, {
                headers: { Accept: 'application/vnd.api+json' }
            });
            if (!nextResponse.ok) break;
            const nextPage = await nextResponse.json();
            media.push(...nextPage.data);
            nextUrl = nextPage.links?.next;
        }
        loading.classList.add('hidden');
        renderCards();
    } catch (error) {
        loading.classList.add('hidden');
        errorMessage.textContent = 'Gagal mengambil data dari API.';
        errorMessage.classList.remove('hidden');
    }
}

searchInput.addEventListener('input', () => {
    currentPage = 1;
    renderCards();
});
document.querySelectorAll('.aura-button').forEach((button) => {
    button.addEventListener('click', () => {
        activeAura = button.dataset.aura;
        currentPage = 1;
        renderCards();
    });
});

lucide.createIcons();
loadMedia();