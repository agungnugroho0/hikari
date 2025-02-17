const siswaList = document.getElementById("siswa_list");
const html5QrCode = new Html5Qrcode("reader");

function startScanner() {
    html5QrCode.start(
        { facingMode: "environment" }, 
        {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        },
        (decodedText, decodedResult) => {
            // Hentikan scanner untuk sementara
            html5QrCode.stop().then(() => {
                $.ajax({
                type: 'POST',
                url: '../../app/api/absen_proses.php',
                data: { "nis": decodedText},
                success: function(data) {
                    // Tampilkan SweetAlert2 dan restart scanner setelah ditutup
                    Swal.fire({
                        title: 'Scan Berhasil!',
                        text: data,
                        icon: 'success',
                        timer : 1000,
                        showConfirmButton: false
                    }).then(() => {
                        // Mulai ulang scanner setelah menutup notifikasi
                        loadSiswa();
                        startScanner();
                    });
                },
                error: function() {
                    
                }
            });
            }).catch((err) => {
                console.error("Gagal menghentikan scanner:", err);
            });
        }
    ).catch((err) => {
        console.error("Gagal memulai scanner:", err);
    });
}

function stopScanner() {
html5QrCode.stop().then(() => {
    console.log("Scanner dihentikan.");
}).catch((err) => {
    console.error("Gagal menghentikan scanner:", err);
});
}

async function updateStatus(nis, status) {
try {
    const response = await fetch('../../app/api/absen_izin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ nis, status }),
    });

    if (!response.ok) {
        throw new Error('Gagal mengupdate status.');
    }

    const result = await response.text();
    Swal.fire({
        title: 'Berhasil!',
        text: result,
        icon: 'success',
        showConfirmButton: false,
        timer: 1000
    });

    // Perbarui daftar siswa
    loadSiswa();
} catch (error) {
    console.error(error.message);
    Swal.fire({
        title: 'Error!',
        text: 'Gagal mengupdate status.',
        icon: 'error',
        showConfirmButton: false,
        timer: 1000
    });
}
}

async function loadSiswa() {
try {
    const response = await fetch('../../app/api/api_belum_absen.php');
    if (!response.ok) {
        throw new Error('Gagal memuat data siswa.');
    }
    const siswaData = await response.json();
    let siswaHtml = '';
    if (siswaData.length > 0) {
        siswaData.forEach((siswa) => {
            siswaHtml += `
                <div class="border p-2 mb-2 rounded shadow">
                    <p class="font-semibold pb-2">${siswa.nama}</p>
                    <button onclick="updateStatus('${siswa.nis}', 'I')" class="rounded px-2 bg-blue-700 text-white font-semibold">IZIN</button>
                    <button onclick="updateStatus('${siswa.nis}', 'A')" class="rounded px-2 bg-red-700 text-white font-semibold">ALPHA</button>
                    <button onclick="updateStatus('${siswa.nis}', 'M')" class="rounded px-2 bg-green-700 text-white font-semibold">MENSETSU</button>
                    <button onclick="updateStatus('${siswa.nis}', 'S')" class="rounded px-2 bg-orange-700 text-white font-semibold">SAKIT</button>
                </div>`;
        });
    } else {
        siswaHtml = '<p class="text-gray-500">Semua siswa sudah melakukan absensi.</p>';
    }
    siswaList.innerHTML = siswaHtml;
} catch (error) {
    console.error(error.message);
}
}


loadSiswa();
startScanner();
document.getElementById("startButton").addEventListener("click", startScanner);
document.getElementById("stopButton").addEventListener("click", stopScanner);