const menuToggle = document.getElementById('menu-toggle');
const navMenu = document.getElementById('nav-menu');

if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', () => {
        navMenu.classList.toggle('hidden');
        navMenu.classList.toggle('flex');
        navMenu.classList.toggle('flex-col');
        navMenu.classList.toggle('absolute');
        navMenu.classList.toggle('top-16');
        navMenu.classList.toggle('left-0');
        navMenu.classList.toggle('w-full');
        navMenu.classList.toggle('bg-primary');
        navMenu.classList.toggle('px-6');
        navMenu.classList.toggle('py-4');
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            navMenu.className = 'hidden md:flex gap-6';
        }
    });
}

const form = document.getElementById('contact-form');
if (form) {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const nama = document.getElementById('input-nama');
        const errorNama = document.getElementById('error-nama');
        const timeNow = new Date().toISOString();
        const path = window.location.pathname;

        if (!nama.value.trim()) {
            errorNama.classList.remove('hidden');
            console.log(`[LOG ${timeNow}, ${path}] : Form kosong!`);
        } else {
            errorNama.classList.add('hidden');
            const successMessage = `Terima kasih, ${nama.value}! Pesan terkirim.`;
            showSuccessToast(successMessage);
            console.log(`[LOG ${timeNow}, ${path}] : ${successMessage}`);
            form.reset();
        }
    });
}


// Component reusable
function showSuccessToast(message) {
    succesToast.show(message);
}

function createToast({ position = 'bottom-6 right-6', bg = 'bg-primary', duration = 3000 } = {}) {
    const toast = document.createElement('div');
    toast.className = `hidden fixed ${position} ${bg} text-white text-lg font-semibold px-12 py-5 rounded-xl shadow-xl z-50`;
    const toastMessage = document.createElement('p');
    toast.appendChild(toastMessage);
    document.body.appendChild(toast);

    return {
        show(message) {
            toastMessage.textContent = message;
            toast.classList.remove('hidden');
            setTimeout(() => toast.classList.add('hidden'), duration);
        }
    };
}

const succesToast = createToast({ position: 'top-6 left-1/2 -translate-x-1/2', bg: 'bg-primary', duration: 1000 });



