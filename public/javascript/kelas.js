function initkelas(){
    const formTambah = document.getElementById("form-tambah-kelas");
    if (formTambah) {
        formTambah.addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(formTambah);

            fetch("router.php?page=kelas&act=simpan", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=kelas", "6");
                } else {
                    toastr.error(response.message || "Gagal menyimpan data.");
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error("Terjadi kesalahan saat mengirim data di js.");
            });
        });
    }

    const formEdit = document.getElementById("form-edit-kelas");
    if (formEdit) {
        formEdit.addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(formEdit);

            fetch("router.php?page=kelas&act=update", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=kelas", "6");
                } else {
                    toastr.error(response.message || "Gagal menyimpan data.");
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error("Terjadi kesalahan saat mengirim data di js.");
            });
        });
    }

    document.querySelectorAll('.btn-hapus').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault(); // cegah bawaan
        const url = this.getAttribute('data-url');

        fetch(url)
            .then(res => res.json())
            // console.log(res.json)
            .then(data => {
                if (data.success) {
                    toastr.success(data.message || "Berhasil menghapus kelas");
                } else {
                    toastr.error(data.message || "Gagal menghapus kelas di js");
                }

                // reload ulang halaman wawancara
                loadPageFromMenu("router.php?page=kelas", "6");
            })
            .catch(err => {
                toastr.error("Terjadi kesalahan saat memproses kelas di js");
                console.error(err);
            });
        });
    });
    
}