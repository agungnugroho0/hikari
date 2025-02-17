        // Menangani event klik pada gambar 'centang'
        document.querySelectorAll('img[src="<?= BASE_URL2 ?>public/image/asset/centang.png"]').forEach((img) => {
        img.addEventListener('click', function() {
            // Menampilkan SweetAlert untuk memasukkan tagihan
            Swal.fire({
                title: 'Tagihan SO',
                input: 'text',
                inputPlaceholder: 'Masukkan tagihan di sini...',
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Tagihan tidak boleh kosong!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirimkan nilai tagihan ke server atau lakukan aksi lain di sini
                    // Misalnya, menggunakan AJAX atau form submit
                    Swal.fire({
                        icon: 'success',
                        title: 'Tagihan telah disimpan',
                        text: `Tagihan: ${result.value}`
                    });
                }
            });
        });
    });
