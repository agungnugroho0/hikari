function initlolos(){
 const formUpdate = document.getElementById("form-update-lolos");
    if (formUpdate) {
        formUpdate.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formUpdate);
            const nis = document.getElementById("nis").value;


            fetch("router.php?page=lolos&act=update", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu(`router.php?page=lolos&act=detail&nis=${nis}`, "5");
                } else {
                    toastr.error(response.message || "Gagal mengupdate data.");
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error("Terjadi kesalahan saat mengirim data dari js siswa.");
            });

            // maintenance
        //     .then(async res => {
        //         const text = await res.text(); // baca semua respon sebagai teks
        //         try {
        //             const json = JSON.parse(text); // coba parse ke JSON
        //             if (json.success) {
        //                 toastr.success(json.message);
        //                 loadPageFromMenu(`router.php?page=siswa&act=detail&nis=${nis}`, "4");
        //             } else {
        //                 toastr.error(json.message || "Gagal mengupdate data.");
        //             }
        //         } catch (e) {
        //             console.error("⚠️ Respon bukan JSON:", text);  // log full respon
        //             toastr.error("Respon bukan JSON: cek konsol!");
        //         }
        //     })
        //     .catch(err => {
        //         console.error("⚠️ Gagal fetch:", err);
        //         toastr.error("Kesalahan saat mengirim data.");
        //     });
        // end maintenance
        });
    };
     
    const formTransaksi = document.getElementById("form-bayar");
    if (formTransaksi) {
        formTransaksi.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formTransaksi);
            const nis = document.getElementById("nis").value;


            fetch("router.php?page=lolos&act=transaksi", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu(`router.php?page=lolos&act=detail&nis=${nis}`, "5");
                } else {
                    toastr.error(response.message || "Gagal mengupdate data.");
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error("Terjadi kesalahan saat mengirim data dari js siswa.");
            });

            // maintenance
            // .then(async res => {
            //     const text = await res.text(); // baca semua respon sebagai teks
            //     try {
            //         const json = JSON.parse(text); // coba parse ke JSON
            //         if (json.success) {
            //             toastr.success(json.message);
            //             loadPageFromMenu(`router.php?page=siswa&act=detail&nis=${nis}`, "4");
            //         } else {
            //             toastr.error(json.message || "Gagal mengupdate data.");
            //         }
            //     } catch (e) {
            //         console.error("⚠️ Respon bukan JSON:", text);  // log full respon
            //         toastr.error("Respon bukan JSON: cek konsol!");
            //     }
            // })
            // .catch(err => {
            //     console.error("⚠️ Gagal fetch:", err);
            //     toastr.error("Kesalahan saat mengirim data.");
            // });
        // end maintenance
        });
    };

    // function formatRupiah(angka, prefix) {
    //         var number_string = angka.replace(/[^,\d]/g, '').toString(),
    //             split = number_string.split(','),
    //             sisa = split[0].length % 3,
    //             rupiah = split[0].substr(0, sisa),
    //             ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
    //         // tambahkan titik setiap 3 angka
    //         if (ribuan) {
    //             separator = sisa ? '.' : '';
    //             rupiah += separator + ribuan.join('.');
    //         }

    //         rupiah = split[1] !== undefined ? rupiah + '.' + split[1] : rupiah;
    //         return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    //     }

    //     document.addEventListener('DOMContentLoaded', function() {
    //         const input = document.getElementById('tagihan');

    //         input.addEventListener('keyup', function(e) {
    //             this.value = formatRupiah(this.value);
    //         });
            
    //     });

    const formTagihan = document.getElementById("form-tagihan");
    if (formTagihan) {
        formTagihan.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formTagihan);
            const nis = document.getElementById("nis").value;


            fetch("router.php?page=lolos&act=tagihan", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu(`router.php?page=lolos&act=detail&nis=${nis}`, "5");
                } else {
                    toastr.error(response.message || "Gagal mengupdate data.");
                }
            })
            .catch(err => {
                console.error(err);
                toastr.error("Terjadi kesalahan saat mengirim data dari js siswa.");
            });

           
        });
    };
}

window.initlolos = initlolos;