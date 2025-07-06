function initstaff() {
    const formTambah = document.getElementById("form-tambah-staff");
    if (formTambah) {
        formTambah.addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(formTambah);

            fetch("router.php?page=staff&act=simpan", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=staff", "2");
                } else {
                    toastr.error(response.message || "Gagal menyimpan data.");
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error("Terjadi kesalahan saat mengirim data.");
            });
        });
    }

    const formUpdate = document.getElementById("form-update-staff");
    if (formUpdate) {
        formUpdate.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formUpdate);

            fetch("router.php?page=staff&act=update", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=staff", "2");
                } else {
                    toastr.error(response.message || "Gagal mengupdate data.");
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error("Terjadi kesalahan saat mengirim data.");
            });
        });
    }
    
    const formDelete = document.getElementById("form-hapus-staff");
    if (formDelete) {
        formDelete.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formDelete);

            fetch("router.php?page=staff&act=delete", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=staff", "2");
                } else {
                    toastr.error(response.message || "Gagal menghapus data.");
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error("Terjadi kesalahan saat mengirim data.");
            });
        });
    }


}

window.initstaff = initstaff;
