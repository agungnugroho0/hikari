<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
define('BASE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/public/admin/');
define('BASE_URL2', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/hikari/');
admin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
    <title>View Lolos</title>
</head>
<button
  class="bg-white text-center w-48 rounded-xl h-8 relative text-black text-sm font-semibold group mt-2 sm:hidden"
  type="button"
  onclick="window.location.href='../index.php';"
>
  <div
    class="bg-red-800 rounded-2xl h-8 w-1/4 flex items-center justify-center absolute left-0 top-[0px] group-hover:w-[184px] z-10 duration-500"
  >
    <svg
      xmlns="http://www.w3.org/2000/svg"
      viewBox="0 0 1024 1024"
      height="25px"
      width="25px"
    >
      <path
        d="M224 480h640a32 32 0 1 1 0 64H224a32 32 0 0 1 0-64z"
        fill="#ffffff"
      ></path>
      <path
        d="m237.248 512 265.408 265.344a32 32 0 0 1-45.312 45.312l-288-288a32 32 0 0 1 0-45.312l288-288a32 32 0 1 1 45.312 45.312L237.248 512z"
        fill="#ffffff"
      ></path>
    </svg>
  </div>
  <p class="translate-x-2">Go Back</p>
</button>
<body>
    <table id="tableLolos" class="w-full text-sm text-left px-3 shadow-md ">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th class="px-3 py-3 w-10">No</th>
                <th class="py-3 px-3">Nama</th>
                <th class="py-3 px-3">Tgl Lolos</th>
                <th class="py-3 px-3">Job</th>
                <th class="py-3 px-3">Perusahaan</th>
                <th class="py-3 px-3">SO</th>
                <th class="py-3 px-3"></th>
            </tr>
        </thead>
        <tbody id="dataBody" class="bg-white h-auto">
            <!-- Data akan dimuat di sini -->
        </tbody>
    </table>

    <!-- Pagination -->
    <div id="pagination" class="py-3 px-3 flex justify-center">
        <!-- Pagination buttons akan dimuat di sini -->
    </div>

    <script>
        $(document).ready(function() {
            // Tentukan page dan limit default
            let currentPage = 1;
            const limit = 10;

            // Fungsi untuk memuat data
            function loadData(page) {
                $.ajax({
                    url: '../../../app/api/api_lolos.php',
                    type: 'GET',
                    data: { page: page, limit: limit },
                    dataType: 'json',
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                            return;
                        }

                        // Kosongkan tabel dan pagination
                        $('#dataBody').empty();
                        $('#pagination').empty();

                        // Isi tabel dengan data
                        response.data.forEach((item, index) => {
                            $('#dataBody').append(`
                                <tr class="hover:bg-slate-100 border-b-2 border-slate-100 cursor-default">
                                    <td class="py-3 px-3">${(page - 1) * limit + index + 1}</td>
                                    <td class="py-3 px-3">${item.nama}</td>
                                    <td class="py-3 px-3">${item.tgl_lolos}</td>
                                    <td class="py-3 px-3">${item.job}</td>
                                    <td class="py-3 px-3">${item.perusahaan}</td>
                                    <td class="py-3 px-3">${item.so}</td>
                                    <td class="py-3 px-3"> <a href="<?= BASE_URL ?>detail_siswa.php?nis=${item.nis}&lolos=ya" target="_top" class='text-red-800'>Details</a></td>
                                </tr>
                            `);
                        });

                        // Buat pagination
                        for (let i = 1; i <= response.total_pages; i++) {
                            $('#pagination').append(`
                                <button class="pagination-button mx-1 px-4 py-2 border rounded ${i === page ? 'bg-blue-500 text-white' : 'bg-gray-200'}" 
                                        data-page="${i}">${i}</button>
                            `);
                        }
                    },
                    error: function() {
                        alert('Error loading data');
                    }
                });
            }

            // Panggil fungsi loadData untuk memuat halaman pertama
            loadData(currentPage);

            // Event handler untuk tombol pagination
            $(document).on('click', '.pagination-button', function() {
                let page = $(this).data('page');
                loadData(page);
            });
        });
    </script>
</body>
</html>
