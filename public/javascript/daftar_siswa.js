function initdaftar_siswa(){
document.querySelectorAll('.btn-naik').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault(); // cegah bawaan
        const url = this.getAttribute('data-url');

        fetch(url)
            // .then(res => res.json())
            
            // .then(data => {
            //     if (data.success) {
            //         toastr.success(data.message || "Berhasil menaikan kelas");
            //     } else {
            //         toastr.error(data.message || "Gagal menghapus kelas di js");
            //     }

            //     // reload ulang halaman siswa
            //     loadPage(null,"router.php?page=daftar_siswa");
            //     updateActiveMenuById("2");

            // })
            // .catch(err => {
            //     toastr.error("Terjadi kesalahan saat memproses daftar_siswa di js");
            //     console.error(err);
            // });

        // maintenance
            .then(async res => {
                const text = await res.text(); // baca semua respon sebagai teks
                try {
                    const json = JSON.parse(text); // coba parse ke JSON
                    if (json.success) {
                        toastr.success(json.message);
                        loadPage(null,"router.php?page=daftar_siswa");
                        updateActiveMenuById("2");
                    } else {
                        toastr.error(json.message || "Gagal mengupdate data.");
                    }
                } catch (e) {
                    console.error("⚠️ Respon bukan JSON:", text);  // log full respon
                    toastr.error("Respon bukan JSON: cek konsol!");
                }
            })
            .catch(err => {
                console.error("⚠️ Gagal fetch:", err);
                toastr.error("Kesalahan saat mengirim data.");
            });
        // end maintenance
        });
    });
}
window.initdaftar_siswa = initdaftar_siswa;