
const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggle-btn');
const mobileMenuBtn = document.getElementById('mobile-menu-btn');
const mobileOverlay = document.getElementById('mobile-overlay');

// 1. Desktop Toggle
toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('collapsed');
});

// 2. Mobile Open
mobileMenuBtn.addEventListener('click', () => {
    sidebar.classList.add('mobile-open');
    mobileOverlay.classList.remove('hidden');
    setTimeout(() => mobileOverlay.classList.remove('opacity-0'), 10);
});

// 3. Mobile Close
function closeMobileMenu() {
    sidebar.classList.remove('mobile-open');
    mobileOverlay.classList.add('opacity-0');
    setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
}

mobileOverlay.addEventListener('click', closeMobileMenu);
