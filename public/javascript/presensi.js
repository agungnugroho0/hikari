document.addEventListener("DOMContentLoaded", function () {
let kelas = document.getElementById("kelas");
let bulan = document.getElementById("bulan");

const hasil = document.getElementById("hasil");
const exportBtn = document.getElementById("exportBtn");
let chartabsen = document.querySelector("#chartPresensi");
let kls2 = document.querySelector("#kls2");
let bln2 = document.querySelector("#bln2");

let chart2;

async function loadData() {
  const response = await fetch(
    `/app/api/api_presensi.php?kelas=${kelas.value}&bulan=${bulan.value}`
  );
  if (!response.ok) {
    throw new Error("Gagal mengambil data");
  }
  const data = await response.text();
  hasil.innerHTML = data;
}

function exportexcel() {
  // Ambil tabel dari div hasil
  const table = hasil.querySelector("table");
  if (!table) {
    alert("Tidak ada data yang dapat diekspor");
    return;
  }
  // Konversi tabel ke excel
  const wb = XLSX.utils.table_to_book(
    table,
    { sheet: "Presensi" },
    { cellStyles: true },
    { cellDates: true }
  );
  // Simpan ke file
  XLSX.writeFile(wb, `Presensi ${kelas.value} ${bulan.value}.xlsx`);
}

async function fetchdataKelas() {
  const response = await fetch(
    `/app/api/api_grafikabsenperkelas.php?bulan=${bulan.value}&kelas=${kelas.value}`
  );
  const data = await response.json();
  //   const text = await response.text();
  // console.log("RESPON DARI SERVER:", data);
  const tgl = data.map(item => item.tgl);
  const hadir = data.map(item => parseInt(item.hadir));
  const izin = data.map(item => parseInt(item.izin));
  const alpha = data.map(item => parseInt(item.alpha));
  const sakit = data.map(item => parseInt(item.sakit));
  const mensetsu = data.map(item => parseInt(item.mensetsu));

  const options = {
    chart: {
      type: "area",
      height: 300,
      zoom: {
        enabled: false,
      },
      toolbar: {
        show: false,
      },
    },
    xaxis: {
      categories: tgl,
    },
    yaxis: {
      min: 0,
    },
    series: [
      { name: "Hadir", data: hadir },
      { name: "Izin", data: izin },
      { name: "Alpha", data: alpha },
      { name: "Sakit", data: sakit },
      { name: "Mensetsu", data: mensetsu },
    ],
    colors: ["#3b82f6", "#10b981", "#ef4444", "#9d32a8", "#facc15"],
    tooltip: {
      shared: true,
      intersect: false,
    },
    dataLabels: {
      enabled: false,
    },
  };
  // 🧼 Hapus chart lama kalau ada
  if (chart2) {
    chart2.destroy();
  }
  chart2 = new ApexCharts(chartabsen, options);
  // console.log('Rendering chart...');
  chart2.render();
}

function formatBulan(bulan) {
  const bulanBaru = new Date(`${bulan}-01`);
  const formatter = new Intl.DateTimeFormat("id-ID", {
    month: "long",
    year: "numeric",
  });
  return formatter.format(bulanBaru);
}

// bulan.addEventListener('change',()=>{
// bln.textContent = formatBulan(bulan.value);
// fetchdataKelas(bulan.value, kelas.value);
// })

kelas.addEventListener("change", () => {
  loadData();
  fetchdataKelas(bulan.value, kelas.value);
  bln2.textContent = formatBulan(bulan.value);
  kls2.textContent = kelas.value;
});

bulan.addEventListener("change", () => {
  loadData();
  fetchdataKelas(bulan.value, kelas.value);
  bln2.textContent = formatBulan(bulan.value);
  kls2.textContent = kelas.value;
});
exportBtn.addEventListener("click", exportexcel);


window.addEventListener("DOMContentLoaded", () => {
  bln2.textContent = formatBulan(bulan.value);
  kls2.textContent = kelas.value;
  fetchdataKelas(bulan.value, kelas.value);
  loadData();
});

});