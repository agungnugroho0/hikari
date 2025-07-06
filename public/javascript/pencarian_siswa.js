function cari() {
  const query = document.querySelector('input[name="search"]').value;
  if (query.length === 0) {
    // Jika pencarian kosong, sembunyikan hasil pencarian
    document.getElementById("searchResults").classList.add("hidden");
    return;
  }
  fetch(`../../public/api/api_pencariansiswa.php?cari=${encodeURIComponent(query)}`)
    .then((response) => response.json())
    .then((data) => {
      // console.log(data);
      const resultsContainer = document.getElementById("searchResults");
      resultsContainer.innerHTML = "";
      if (data.length === 0) {
        resultsContainer.innerHTML =
          '<div class="p-2 text-center text-gray-500">Tidak ada hasil ditemukan.</div>';
      } else {
        data.forEach((item) => {
          const div = document.createElement("div");
          div.classList.add("p-2", "hover:bg-gray-50");

          // Tentukan tampilannya berdasarkan sumber data
          if (item.sumber == "siswa") {
            div.innerHTML = `
                  <div onclick="handlePilihHasil(null, 'router.php?page=siswa&act=detail&nis=${item.nis}&menuId=4')" class="flex cursor-default" data-menu-id='4'>
                    <div class="w-10 h-10 overflow-hidden rounded-full"><img src="../image/photos/${item.foto}"></div>
                    <div class="flex flex-col">
                      <div class="font-normal truncate pl-1.5">${item.nama}</div>
                      <div class="text-gray-500 pl-1.5">siswa</div>
                    </div>
                  </div>
                `;
          } else if (item.sumber == "lolos") {
            div.innerHTML = `
                  <div onclick="handlePilihHasil(null, 'router.php?page=lolos&act=detail&nis=${item.nis}&lolos=ya&menuId=5')" class="flex cursor-default" data-menu-id='5'>
                    <div class="w-10 h-10 overflow-hidden rounded-full"><img src="../image/photos/${item.foto}"></div>
                    <div class="flex flex-col">
                      <div class="font-normal truncate pl-1.5">${item.nama}</div>
                      <div class="text-gray-500 pl-1.5">lolos</div>
                    </div>
                  </div>
                `;
          }

          resultsContainer.appendChild(div);
        });
      }
      resultsContainer.classList.remove("hidden");
    });
  }

  function handlePilihHasil(event, url) {
  document.getElementById("searchResults").classList.add("hidden");
  document.querySelector('input[name="search"]').value = "";
  // Tambahkan menu_Id agar menu nav aktif
  const separator = url.includes('?') ? '&' : '?';
  const menuId = url.includes('page=siswa') ? 4 : url.includes('page=lolos') ? 5 : 1;
  const finalUrl = `${url}${separator}menu_Id=${menuId}`;
  
  loadPage(event, finalUrl);

  setTimeout(() => {
    const navLink = document.querySelector(`nav a[data-menu-id='${menuId}']`);
    if (navLink) {
      document.querySelectorAll('nav a').forEach(link => {
        link.parentElement.classList.remove('bg-white',"dark:bg-blue-900");
      });
      navLink.parentElement.classList.add('bg-white',"dark:bg-blue-900");
    }
  }, 100); 
}
