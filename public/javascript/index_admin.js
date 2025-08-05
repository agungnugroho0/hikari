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
    // const pageName = page.split('=')[1] || 'home';
    const jsPath = `/public/javascript/${pageName}.js`;
    const initFunc = `init${pageName.charAt(0).toLowerCase()}${pageName.slice(1)}`;

    loadScript(jsPath, () => {
        if (typeof window[initFunc] === 'function') {
            window[initFunc]();
            if (pageName === "home") {
            setTimeout(() => {
                if (document.getElementById("calendar")) {
                    loadMensetsuCalendar();
                }
            }, 100); // delay pendek
            }
        } else {
            console.warn(`Fungsi ${initFunc}() tidak ditemukan`);
        }
    });
}

// Load halaman via fetch dan proses script-nya
function loadPage(event, page) {
    fetch(page)
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            document.getElementById('content-area').innerHTML = doc.body.innerHTML;

            // Deteksi nama page dari router
            const url = new URL(page, window.location.origin);
            const route = url.searchParams.get("page");
            if (route) {
                loadScriptForPage(`page=${route}`);
            }

            // Highlight menu yang diklik
            if (event) {
                document.querySelectorAll('nav a').forEach(link => {
                    link.parentElement.classList.remove('bg-white','dark:bg-blue-900');
                });
                event.target.closest('li').classList.add('bg-white','dark:bg-blue-900');
            }

        })
        .catch(err => {
            document.getElementById('content-area').innerHTML = "Oops! Gagal load konten.";
            console.error(err);
        });
}

// Saat pertama kali halaman diload
document.addEventListener("DOMContentLoaded", () => {
    toastr.options = {
        "progressBar": true,
        "positionClass": "toast-top-center",
        "timeOut": "3000"
    };

    const getQueryParam = (param) => {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    };

    const menuId = getQueryParam("menu_Id");
    const nis = getQueryParam("nis");
    const lolos = getQueryParam("lolos");
    const defaultPage = "router.php?page=home";
    let found = false;

    // Cek menu aktif dari parameter
    if (menuId) {
        document.querySelectorAll("nav a").forEach(link => {
            if (link.dataset.menuId === menuId) {
                link.parentElement.classList.add("bg-white","dark:bg-blue-900");
                let page = link.getAttribute("onclick").match(/'([^']+)'/)[1];

                // Inject parameter tambahan
                if ((menuId === "4" || menuId === "5") && nis) {
                    const params = [];
                    if (nis) params.push(`nis=${nis}`);
                    if (lolos) params.push(`lolos=${lolos}`);
                    if (params.length) {
                        page += `?${params.join("&")}`;
                    }
                }

                loadPage(null, page);
                found = true;
            } else {
                link.parentElement.classList.remove("bg-white","dark:bg-blue-900");
            }
        });
    }

    // Jika tidak ada menuId → default ke halaman home
    if (!menuId || !found) {
        document.querySelectorAll("nav a").forEach(link => {
            link.parentElement.classList.remove("bg-white","dark:bg-blue-900");
        });

        const defaultLink = document.querySelector("nav a[data-menu-id='1']");
        if (defaultLink) {
            defaultLink.parentElement.classList.add("bg-white","dark:bg-blue-900");
        }

        loadPage(null, defaultPage); // auto-detect akan panggil initHome()
    }
});



function loadPageFromMenu(pageUrl, menuId) {
    // Set menu aktif
    document.querySelectorAll("nav a").forEach(link => {
        link.parentElement.classList.remove("bg-white","dark:bg-blue-900");
        if (link.dataset.menuId === menuId) {
            link.parentElement.classList.add("bg-white","dark:bg-blue-900");
        }
    });

    // Load konten
    loadPage(null, pageUrl);
}
