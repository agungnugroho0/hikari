const kelas = document.getElementById('kelas');
    const bulan = document.getElementById('bulan');
    const hasil = document.getElementById('hasil');
    const exportBtn = document.getElementById('exportBtn');

    async function loadData() {
        const response = await fetch(`../../../app/api/api_presensi.php?kelas=${kelas.value}&bulan=${bulan.value}`);
        if (!response.ok) {
            throw new Error("Gagal mengambil data");
        }
        const data = await response.text();
        hasil.innerHTML = data;
    }

    function exportexcel(){
        // Ambil tabel dari div hasil
        const table = hasil.querySelector('table');
        if (!table) {
            alert("Tidak ada data yang dapat diekspor");
            return;
        }
        // Konversi tabel ke excel
        const wb = XLSX.utils.table_to_book(table, {sheet: "Presensi"},{cellStyles: true}, {cellDates: true});
        // Simpan ke file
        XLSX.writeFile(wb, `Presensi ${kelas.value} ${bulan.value}.xlsx`);
    }

    loadData();
    kelas.addEventListener('change', loadData);
    bulan.addEventListener('change', loadData);
    exportBtn.addEventListener('click', exportexcel);