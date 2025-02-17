document.addEventListener("DOMContentLoaded", () => {
  const menuItems = document.querySelectorAll(".menu-item");
  const contentArea = document.getElementById("menu-content");

  // Fungsi untuk mendapatkan nilai parameter dari URL
  const getQueryParam = (param) => {
    
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
  };

  const showInitialContent = () => {

    const menuId = getQueryParam('menu_id') || 1; // Default ke menu 1 jika tidak ada 'menu_id'
    if (window.location.href.includes("detail_siswa.php")) return;
    // Temukan menu yang sesuai dengan menu_id
    menuItems.forEach((menu) => menu.classList.remove("bg-white", "font-semibold", "text-black"));
    
    const targetMenu = [...menuItems].find(item => item.getAttribute('data-menu-id') === menuId);
    
    if (targetMenu) {
      targetMenu.classList.add("bg-white", "font-semibold", "text-black");
    }

    fetch(`getMenuContent.php?menu_id=${menuId}`) // Muat konten menu sesuai menu_id
      .then((response) => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.text();
      })
      .then((data) => {
        contentArea.innerHTML = data;
        contentArea.classList.remove("opacity-0", "hidden");
        contentArea.classList.add("opacity-100");
      })
      .catch((error) => {
        console.error("Error fetching menu content:", error);
        contentArea.innerHTML = "<p>Error loading content.</p>";
        contentArea.classList.remove("opacity-0", "hidden");
        contentArea.classList.add("opacity-100");
      });
  };

  showInitialContent();

  menuItems.forEach((item) => {
    item.addEventListener("click", () => {
      
      contentArea.classList.remove("opacity-100");
      contentArea.classList.add("opacity-0");

      menuItems.forEach((menu) => menu.classList.remove("bg-white", "font-semibold", "text-black"));
      item.classList.add("bg-white", "font-semibold", "text-black");

      const menuId = item.getAttribute("data-menu-id");
      // history.pushState({}, '', `?menu_id=${menuId}`);

      setTimeout(() => {
        fetch(`getMenuContent.php?menu_id=${menuId}`)
          .then((response) => {
            if (!response.ok) throw new Error("Network response was not ok");
            return response.text();
          })
          .then((data) => {
            contentArea.innerHTML = data;
            contentArea.classList.remove("opacity-0");
            contentArea.classList.add("opacity-100");
          })
          .catch((error) => {
            console.error("Error fetching menu content:", error);
            contentArea.innerHTML = "<p>Error loading content.</p>";
            contentArea.classList.remove("opacity-0");
            contentArea.classList.add("opacity-100");
          });
      }, 200); 
    });
  });
});
