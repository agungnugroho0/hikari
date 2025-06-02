const ctx = document.getElementById('chartLolos').getContext('2d');
     let chart; // Simpan referensi ke grafik
     function loadChart(tahun) {
        fetch(`/app/api/api_jumlah_lolos.php?tahun=${tahun}`)
        .then(response => response.json())  // Mengambil data dari server dan mengubahnya ke format JSON
            .then(data =>{
                const bulan = data.map(item => item.bulan); // Mengambil bulan dari data
                const jumlah = data.map(item => item.jumlah_lolos); // Mengambil jumlah siswa lolos dari data
                if (chart) {
                        chart.destroy(); // Hapus grafik lama sebelum membuat yang baru
                    }
                    chart = new Chart(ctx, {
                    type: 'bar',  // Grafik jenis batang
                    data: {
                        labels: bulan,  // Label sumbu X (bulan)
                        datasets: [{
                            label: `Jumlah Lolos ${tahun}`,
                            data: jumlah,  // Data jumlah siswa lolos
                            backgroundColor: '#69140e',
                            borderColor: '#69140e',
                            borderWidth: 3,
                            tension: 0.5, // Mengatur kelengkungan garis
                        }]
                    },
                    options: {
                        animation: {
                            duration: 2000, // Durasi animasi dalam milidetik
                            easing: 'easeInOutQuart' // Efek animasi yang halus
                        },
                        plugins: {
                            legend: {
                                display: false // Sembunyikan legend
                            }
                        },
                        scales: {
                            y: { beginAtZero: true } // Pastikan sumbu Y dimulai dari 0
                        }
                    }
                });

            })
     }
     document.getElementById('tahun').addEventListener('change', function() {
        const tahun = this.value; // Ambil tahun dari dropdown
        loadChart(tahun); // Panggil fungsi untuk memuat grafik dengan tahun yang dipilih
     });
        // Panggil fungsi untuk memuat grafik pertama kali dengan tahun default
        loadChart(new Date().getFullYear()); // Load data tahun ini saat pertama kali dibuka