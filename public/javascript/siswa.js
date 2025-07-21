function initsiswa() {
     const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            observer.unobserve(entry.target); // animasi hanya sekali
          }
        });
      },
      {
        threshold: 0.1 // elemen muncul 10% di layar
      }
    );

    document.querySelectorAll('.fade-in-up').forEach(el => {
      observer.observe(el);
    });

   const formUpdate = document.getElementById("form-update-siswa");
    if (formUpdate) {
        formUpdate.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formUpdate);
            const nis = document.getElementById("nis").value;


            fetch("router.php?page=siswa&act=update", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu(`router.php?page=siswa&act=detail&nis=${nis}`, "4");
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
            
        });
    };
   
   
    const formJob = document.getElementById("form-tambah-peserta_job");
    if (formJob) {
        formJob.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formJob);
            const nis = document.getElementById("nis").value;


            fetch("router.php?page=siswa&act=tambah_job", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if (response.success) {
                    toastr.success(response.message);
                    loadPageFromMenu(`router.php?page=siswa&act=detail&nis=${nis}`, "4");
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
            
        });
    }


    const formDoc = document.getElementById("form-upload-doc");
    if (formDoc) {
        formDoc.addEventListener("submit", function (e) {
            e.preventDefault();

            const formData = new FormData(formDoc);
            const nis = document.getElementById("nis").value;

            fetch("router.php?page=siswa&act=upload_doc", {
                method: "POST",
                body: formData
            })
            // .then(res => res.json())
            // .then(response => {
            //     if (response.success) {
            //         toastr.success(response.message);
            //         loadPageFromMenu(`router.php?page=siswa&act=detail&nis=${nis}`, "4");
            //     } else {
            //         toastr.error(response.message || "Gagal mengupload dokumen.");
            //     }
            // })
            // .catch(err => {
            //     console.error(err);
            //     toastr.error("Terjadi kesalahan saat mengirim dokumen dari js siswa.");
            // });

            // maintenance
            .then(async res => {
                const text = await res.text(); // baca semua respon sebagai teks
                try {
                    const json = JSON.parse(text); // coba parse ke JSON
                    if (json.success) {
                        toastr.success(json.message);
                        loadPageFromMenu(`router.php?page=siswa&act=detail&nis=${nis}`, "4");
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
            
        });
    }
    
   
    let pendingDeleteUrl = null;

    document.querySelectorAll('.btn-hapus').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        pendingDeleteUrl = this.getAttribute('data-url');
        document.getElementById('toast-konfirmasi-hapus').classList.remove('hidden');
      });
    });

    const btnBatal = document.getElementById('btn-batal-hapus');
    if (btnBatal) {
      btnBatal.addEventListener('click', () => {
        pendingDeleteUrl = null;
        document.getElementById('toast-konfirmasi-hapus').classList.add('hidden');
      });
    }

    const btnYa = document.getElementById('btn-ya-hapus');
    if (btnYa) {
      btnYa.addEventListener('click', () => {
        if (!pendingDeleteUrl) return;

        fetch(pendingDeleteUrl)
          .then(res => res.json())
          .then(data => {
            if (data.success) {
              toastr.success(data.message || "Berhasil menghapus siswa");
            } else {
              toastr.error(data.message || "Gagal menghapus siswa");
            }
            document.getElementById('toast-konfirmasi-hapus').classList.add('hidden');
            loadPageFromMenu("router.php?page=siswa", "4");
          })
          .catch(err => {
            toastr.error("Terjadi kesalahan saat menghapus siswa.");
            console.error(err);
            document.getElementById('toast-konfirmasi-hapus').classList.add('hidden');
          });
      });
    }

    const jobSelect = document.getElementById('job');

    if (jobSelect) {
      const inputMap = {              // id input ↔ nama atribut data-*
        so:         'so',
        perusahaan: 'perusahaan',
        interview:  'interview',
        penempatan: 'penempatan',
        tgl_job:    'tgl_job',
      };

      const updateFields = () => {
        const opt           = jobSelect.options[jobSelect.selectedIndex];
        const isPlaceholder = !opt.value || opt.value === 'Pilih Job';

        Object.entries(inputMap).forEach(([inputId, dataKey]) => {
          const el = document.getElementById(inputId);
          if (!el) return;

          // ambil value di option atau kosongkan
          const val = isPlaceholder ? '' : opt.getAttribute(`data-${dataKey}`) || '';

          // kalau input masih disabled, aktifkan sementara
          const wasDisabled = el.disabled;
          if (wasDisabled) el.disabled = false;

          el.value = val;             // ← di sinilah val dipakai

          if (wasDisabled) el.disabled = true;

          console.log(`Set ${inputId} →`, val);
        });
      };

      updateFields();                 // isi sekali di first load
      jobSelect.addEventListener('change', updateFields);  // isi setiap ganti
    }

}


window.initsiswa = initsiswa;
