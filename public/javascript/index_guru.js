// Fungsi buat load JS eksternal dari halaman yang di-fetch
function loadScript(src, onloadCallback = null) {
    return new Promise((resolve, reject) => {
        const existing = document.querySelector(`script[src="${src}"]`);
        if (existing) {
            existing.remove(); // ganti script kalau udah ada
        }

        const script = document.createElement('script');
        script.src = src;
        script.onload = () => {
            if (onloadCallback) onloadCallback();
            resolve();
        };
        script.onerror = reject;
        document.body.appendChild(script);
    });
}

// Auto-load file JS dan panggil fungsi init-nya sesuai nama page
function loadScriptForPage(page) {
    const pageName = page.split('page=')[1] || 'home';
    const jsPath = `/public/javascript/${pageName}.js`;
    const initFunc = `init${pageName.charAt(0).toLowerCase()}${pageName.slice(1)}`;

    loadScript(jsPath, () => {
        if (typeof window[initFunc] === 'function') {
            window[initFunc]();
        } else {
            console.warn(`Fungsi ${initFunc}() tidak ditemukan`);
        }
    });
}

// Fungsi update warna aktif pada menu SVG
function updateActiveMenuById(activeMenuId) {
    document.querySelectorAll('nav a').forEach(link => {
        const svg = link.querySelector('svg');
        if (!svg) return;

        if (link.dataset.menuId === activeMenuId) {
            svg.classList.add('text-blue-500', 'dark:text-white');
            svg.classList.remove('text-slate-500', 'dark:text-slate-700');
        } else {
            svg.classList.add('text-slate-500', 'dark:text-slate-700');
            svg.classList.remove('text-blue-500', 'dark:text-white');
        }
    });
}

// Load halaman via fetch dan proses script-nya
function loadPage(event, page) {
    if (event) event.preventDefault();

    // Ambil data-menu-id dari elemen yang diklik
    const clickedLink = event?.currentTarget;
    if (clickedLink && clickedLink.dataset.menuId) {
        const menuId = clickedLink.dataset.menuId;
        updateActiveMenuById(menuId);
    }

    fetch(page)
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            document.getElementById('content-area').innerHTML = doc.body.innerHTML;

            const url = new URL(page, window.location.origin);
            const route = url.searchParams.get("page");
            if (route) {
                loadScriptForPage(`page=${route}`);
            }
        })
        .catch(err => {
            document.getElementById('content-area').innerHTML = "Oops! Gagal load konten.";
            console.error(err);
        });
}

document.addEventListener("DOMContentLoaded", function () {
    // Load halaman default saat pertama kali dibuka
    loadPage(null, 'router.php?page=homeguru');

    // Set menu default aktif (data-menu-id="1" misal untuk home)
    updateActiveMenuById("1");
    toastr.options = {
        // "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "timeOut": "3000"
    };

});
