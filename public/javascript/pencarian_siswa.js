function cari() {
  const query = document.querySelector('input[name="search"]').value;
  if (query.length === 0) {
    // Jika pencarian kosong, sembunyikan hasil pencarian
    document.getElementById("searchResults").classList.add("hidden");
    return;
  }
  fetch(`../../app/api/search.php?query=${encodeURIComponent(query)}`)
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
                  <a href="../admin/detail_siswa.php?nis=${item.nis}" class="flex cursor-default">
                    <div class="w-10 h-10 overflow-hidden rounded-full"><img src="../image/photos/${item.foto}"></div>
                    <div class="flex flex-col">
                      <div class="font-normal truncate pl-1.5">${item.nama}</div>
                      <div class="text-gray-500 pl-1.5">siswa</div>
                    </div>
                  </a>
                `;
          } else if (item.sumber == "lolos") {
            div.innerHTML = `
                    <a href="../admin/detail_siswa.php?nis=${item.nis}&lolos=ya" class="flex cursor-default">
                    <div class="w-10 h-10 overflow-hidden rounded-full"><img src="../image/photos/${item.foto}"></div>
                    <div class="flex flex-col">
                      <div class="font-normal truncate pl-1.5">${item.nama}</div>
                      <div class="text-gray-500 pl-1.5">lolos</div>
                    </div>
                  </a>
                `;
          }

          resultsContainer.appendChild(div);
        });
      }
      resultsContainer.classList.remove("hidden");
    });
}
