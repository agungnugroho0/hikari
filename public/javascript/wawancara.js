function initwawancara(){

    function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            
            // tambahkan titik setiap 3 angka
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + '.' + split[1] : rupiah;
            return prefix === undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        const inputHikari = document.getElementById('hikari');
        if (inputHikari) {
            inputHikari.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
            });
            inputHikari.value = formatRupiah(inputHikari.value);
        }

        const inputSO = document.getElementById('biaya_so');
        if (inputSO) {
            inputSO.addEventListener('keyup', function(e) {
                this.value = formatRupiah(this.value);
            });
        }
const colorThief = new ColorThief();

  // window.addEventListener('load', () => {
    const images = document.querySelectorAll('.logo-img');
    const containers = document.querySelectorAll('.logo-container');

    images.forEach((img, index) => {
      // Pastikan gambar sudah selesai dimuat
      img.addEventListener('load', () => {
        applyColor(img, containers[index]);
      });

      if (img.complete) {
        applyColor(img, containers[index]); // Gambar sudah dimuat, langsung diterapkan
      }
    });

    function getLuminance(rgb) {
      const [r, g, b] = rgb;
      const a = [r, g, b].map(function (v) {
        v /= 255;
        return v <= 0.03928 ? v / 12.92 : Math.pow((v + 0.055) / 1.055, 2.4);
      });
      return 0.2126 * a[0] + 0.7152 * a[1] + 0.0722 * a[2];
    }

    function applyColor(img, container) {
      // Ambil warna dominan dari gambar
      const color = colorThief.getColor(img);
      const [r, g, b] = color;
      const luminance = getLuminance([r, g, b]);

      // Tentukan warna teks berdasarkan kecerahan latar belakang
      const textColor = luminance > 0.5 ? 'black' : 'white';
      
      // Sesuaikan warna latar belakang dan teks
      container.style.backgroundColor = `rgb(${r}, ${g}, ${b})`;
      const textElement = container.querySelector('.nama_so');
      textElement.style.color = textColor; // Mengubah warna teks
    }
  // });

  const formTambah = document.getElementById("form-tambah-wawancara");
    if (formTambah) {
        formTambah.addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(formTambah);

            fetch("router.php?page=wawancara&act=insert", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=wawancara", "3");
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
  const formEdit = document.getElementById("form-edit-wawancara");
    if (formEdit) {
        formEdit.addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(formEdit);

            fetch("router.php?page=wawancara&act=update", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=wawancara", "3");
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

    const formDelete = document.getElementById("form-hapus-wawancara");
    if (formDelete) {
        formDelete.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formDelete);

            fetch("router.php?page=wawancara&act=delete", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=wawancara", "3");
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
    const formTambahPeserta = document.getElementById("form-tambah-peserta");
    if (formTambahPeserta) {
        formTambahPeserta.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formTambahPeserta);

            // Ambil id_job
            const idJob = formTambahPeserta.querySelector('[name="id_job"]').value;
            formData.append('id_job', idJob);

            // Ambil semua checkbox yang dicentang
            const checkedBoxes = formTambahPeserta.querySelectorAll('input[name="siswa[]"]:checked');
            checkedBoxes.forEach(checkbox => {
            formData.append('siswa[]', checkbox.value);
            }); 

            fetch("router.php?page=wawancara&act=tambah_peserta", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=wawancara", "3");
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

     const formLolos = document.getElementById("form-lolos-peserta");
    if (formLolos) {
        formLolos.addEventListener("submit", function(e) {
            e.preventDefault();

            const formData = new FormData(formLolos);

            fetch("router.php?page=wawancara&act=simpan_lolos", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())            
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu("router.php?page=wawancara", "3");
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

    document.querySelectorAll('.btn-gagal').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault(); // cegah bawaan
        const url = this.getAttribute('data-url');

        fetch(url)
            .then(res => res.json())
            // console.log(res.json)
            .then(data => {
                if (data.success) {
                    toastr.success(data.message || "Berhasil menghapus peserta");
                } else {
                    toastr.error(data.message || "Gagal menghapus peserta");
                }

                // reload ulang halaman wawancara
                loadPageFromMenu("router.php?page=wawancara", "3");
            })
            .catch(err => {
                toastr.error("Terjadi kesalahan saat memproses hapus peserta di js");
                console.error(err);
            });
        });
    });

    
}
window.initwawancara = initwawancara;