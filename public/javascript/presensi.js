function initpresensi() {
  let kelas = document.getElementById("kelas");
  let bulan = document.getElementById("bulan");

  const hasil = document.getElementById("hasil");
  const exportBtn = document.getElementById("exportBtn");
  let chartabsen = document.querySelector("#chartKelas");
  let kls2 = document.querySelector("#kls2");
  let bln2 = document.querySelector("#bln2");

  let chart2;

  function exportexcel() {
    const table = hasil.querySelector("table");
    if (!table) {
      alert("Tidak ada data yang dapat diekspor");
      return;
    }
    const wb = XLSX.utils.table_to_book(table, { sheet: "Presensi" });
    XLSX.writeFile(wb, `Presensi ${kelas.value} ${bulan.value}.xlsx`);
  }

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

  exportBtn.addEventListener("click", exportexcel);

  const chartlolos = document.querySelector("#chartLolos");
  const monthInput = document.querySelector("#bulan");
  const kelasInput = document.querySelector("#kelas");
  const bln = document.querySelector("#bln");
  const kls = document.querySelector("#kls");
  let chart;

  async function fetchdata(bulan,kelas){
      try{
          const respon = await fetch(`../../public/api/api_grafiklolosperkelas.php?bulan=${bulan.value}&kelas=${kelas.value}`);
          const data = await respon.json();
          // const text = await respon.text();
          // console.log("RESPON DARI SERVER:", data);

          const tanggal = data.map(item => item.tgl);
          const jumlah = data.map(item => parseInt(item.jumlah_lolos,10)); // Pastikan jumlah_lolos adalah angka
          const options = {
              chart: {
                  type: 'bar',
                  height: 300,
                  toolbar: {
                  show: false
                  },
                  zoom: {
                  enabled: false
                  },
              },
              colors: ['#8B0000'],
              dataLabels: {
                  enabled: false
              },
              stroke: {
                  curve: 'smooth',
                  width: 2
              },
              series: [{
                  name: 'Siswa Lolos',
                  data: jumlah
              }],
              xaxis: {
                  categories: tanggal
              },
              yaxis: {
                  min: 0
              },
              };

              if (chart) {
              chart.updateOptions(options);
              } else {
              chart = new ApexCharts(chartlolos, options);
              chart.render();
              }
          

      }catch(err){
      console.error("Error Fetching Data:", err);

      };

  }

  function formatBulan(bulan) {
    const bulanBaru = new Date(`${bulan}-01`);
    const formatter = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' });
    return formatter.format(bulanBaru);
  }

  fetchdata(kelasInput,monthInput);
  monthInput.addEventListener('change', () => {
      bln.textContent = formatBulan(monthInput.value);
      fetchdata(monthInput, kelasInput);
  });

  kelasInput.addEventListener('change', () => {
      kls.textContent = kelasInput.value;
      fetchdata(monthInput, kelasInput);
  });

  bln.textContent = formatBulan(monthInput.value);
  kls.textContent = kelasInput.value;
  fetchdata(monthInput, kelasInput);


  // Init
  bln2.textContent = formatBulan(bulan.value);
  kls2.textContent = kelas.value;
  fetchdataKelas();
  loadData();
}
