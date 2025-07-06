function initso(){
    const formTambah = document.getElementById("form-tambah-so");
    if (formTambah) {
        formTambah.addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(formTambah);

            fetch("router.php?page=so&act=simpan", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=so", "8");
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
};

window.initso = initso;