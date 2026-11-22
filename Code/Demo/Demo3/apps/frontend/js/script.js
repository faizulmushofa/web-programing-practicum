const menuButton = document.querySelector('#menu-button');
const mobileMenu = document.querySelector('#mobile-menu');
const searchInput = document.querySelector('#search-input');
const mediaGrid = document.querySelector('#media-grid');
const loading = document.querySelector('#loading');
const errorMessage = document.querySelector('#error-message');
const pagination = document.querySelector('#pagination');
const contactForm = document.querySelector('#contact form');

// ponytail: konfigurasi baseURL backend PHP
const API_BASE_URL = 'http://localhost:8000';

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
        const title = (item.title || '').toLowerCase();
        const rating = Number(item.rating || 0);
        const status = item.status;
        const episodes = item.episodes || 0;

        const auraMatch = activeAura === 'all' ||
            (activeAura === 'high-rated' && rating >= 80) ||
            (activeAura === 'movies' && episodes === 1) ||
            (activeAura === 'ongoing' && status === 'current');
        return title.includes(query) && auraMatch;
    });

    const pageCount = Math.ceil(filtered.length / itemsPerPage);
    const pageItems = filtered.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage);

    mediaGrid.innerHTML = pageItems.map((item) => {
        const title = item.title;
        return `
            <article class="overflow-hidden bg-surface">
                <img src="${item.url_image || './images/anime.jpeg'}" alt="${title}" class="h-64 w-full object-cover">
                <div class="p-4">
                    <h3 class="font-bold">${title}</h3>
                    <p class="mt-2 text-sm text-gray-400">Rating: ${item.rating ?? 'N/A'} · Episodes: ${item.episodes ?? 'N/A'}</p>
                </div>
            </article>
        `;
    }).join('') || '<p class="col-span-full text-gray-400">No matching titles.</p>';

    pagination.innerHTML = Array.from({ length: pageCount }, (_, index) => `
        <button data-page="${index + 1}" class="border border-white/30 px-3 py-1 ${currentPage === index + 1 ? 'bg-card text-background' : ''}">${index + 1}</button>
    `).join('');

    pagination.querySelectorAll('button').forEach((button) => {
        button.addEventListener('click', () => {
            currentPage = Number(button.dataset.page);
            renderCards();
        });
    });
}

async function loadMedia() {
    loading.classList.remove('hidden');
    errorMessage.classList.add('hidden');

    try {
        const response = await fetch(`${API_BASE_URL}/media`);
        if (!response.ok) throw new Error('API request failed');

        const result = await response.json();
        // Mengambil data murni dari envelope backend { success: true, data: [...] }
        media = result.data || [];

        loading.classList.add('hidden');
        renderCards();
    } catch (error) {
        loading.classList.add('hidden');
        errorMessage.textContent = 'Gagal mengambil data dari Backend API (Pastikan server PHP aktif di port 8000).';
        errorMessage.classList.remove('hidden');
    }
}

// Hubungkan Form Contact Us ke backend POST /contact
if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const name = document.querySelector('#name').value;
        const email = document.querySelector('#email').value;
        const detail = document.querySelector('#message').value;

        try {
            const res = await fetch(`${API_BASE_URL}/contact`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ name, email, detail })
            });

            const json = await res.json();
            if (res.ok) {
                alert(`Sukses: ${json.message}`);
                contactForm.reset();
            } else {
                alert(`Gagal: ${json.message}`);
            }
        } catch (err) {
            alert('Tidak dapat terhubung ke server backend.');
        }
    });
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
