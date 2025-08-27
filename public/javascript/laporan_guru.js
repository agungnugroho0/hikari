function initlaporan_guru() {
  let kelas = document.getElementById("kelas");
  let bulan = document.getElementById("bulan");
  const monthInput = document.querySelector("#bulan");

  const hasil = document.getElementById("hasil");
  let chartabsen = document.querySelector("#chartKelas");
  let kls2 = document.querySelector("#kls2");
  let bln2 = document.querySelector("#bln2");

  let chart2;


  async function fetchdataKelas() {
    const response = await fetch(`../../public/api/api_grafikabsendashboard.php?bulan=${bulan.value}&kelas=${kelas.value}&laporan=true`);
    const data = await response.json();
    const tgl = data.map(item => item.tgl);
    const hadir = data.map(item => parseInt(item.hadir));
    const izin = data.map(item => parseInt(item.izin));
    const alpha = data.map(item => parseInt(item.alpha));
    const sakit = data.map(item => parseInt(item.sakit));
    const mensetsu = data.map(item => parseInt(item.mensetsu));

    const options = {
      chart: { type: "area", height: 300, zoom: { enabled: false }, toolbar: { show: false } },
      xaxis: { categories: tgl },
      yaxis: { min: 0 },
      series: [
        { name: "Hadir", data: hadir },
        { name: "Izin", data: izin },
        { name: "Alpha", data: alpha },
        { name: "Sakit", data: sakit },
        { name: "Mensetsu", data: mensetsu }
      ],
      colors: ["#3b82f6", "#10b981", "#ef4444", "#9d32a8", "#facc15"],
      tooltip: { shared: true, intersect: false },
      dataLabels: { enabled: false }
    };

    if (chart2) chart2.destroy();
    chart2 = new ApexCharts(chartabsen, options);
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

  async function loadData() {
    const response = await fetch(`../../public/api/api_tabelabsensi.php?bulan=${bulan.value}&kelas=${kelas.value}`);
    if (!response.ok) {
      hasil.innerHTML = "<p>Gagal mengambil data.</p>";
      return;
    }
    const data = await response.text();
    hasil.innerHTML = data;
  }

  kelas.addEventListener("change", () => {
    loadData();
    fetchdataKelas();
    bln2.textContent = formatBulan(bulan.value);
    kls2.textContent = kelas.value;
  });

  bulan.addEventListener("change", () => {
    loadData();
    fetchdataKelas();
    bln2.textContent = formatBulan(bulan.value);
    kls2.textContent = kelas.value;
  });


  
  

  function formatBulan(bulan) {
    const bulanBaru = new Date(`${bulan}-01`);
    const formatter = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' });
    return formatter.format(bulanBaru);
  }



  // Init
  bln2.textContent = formatBulan(bulan.value);
  kls2.textContent = kelas.value;
  fetchdataKelas();
  loadData();
}
