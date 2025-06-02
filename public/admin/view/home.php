<?php
// require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
require __DIR__.'/../../../autoloader.php';

$kelas = tampil("SELECT id_kelas, kelas FROM kelas");

?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</head>
<body>
   <h2 class="font-semibold text-2xl mb-2 font-[Lato]">DASHBOARD</h2>
    <input type="month" class="border-2 border-gray-200 rounded p-1 outline-none " id="month" name="month" value="<?php echo date('Y-m'); ?>">
    <div class="sm:grid sm:grid-cols-2 gap-2 mt-2">
        <div class="border-2 p-2 rounded border-gray-200 bg-white shadow-sm">
            <h2 class="font-semibold text-base font-[Lato]">Jumlah Siswa Lolos Bulan <span id="bln"></span></h2>
            <div id="chartLolos"></div>
        </div>
        <div class="border-2 p-2 rounded border-gray-200 bg-white shadow-sm">
            <h2 class="font-semibold text-base font-[Lato]">Jadwal Mensetsu </h2>
            <div id="chartMensetsu"></div>

        </div>
        
    </div>
    <div class="grid md:grid-cols-3 gap-2 grid-cols-1 mt-2">
      <?php foreach ($kelas as $kls) : ?>
        <div class="border-2 p-2 rounded border-gray-200 bg-white shadow-sm">
          <h2 class="font-semibold text-base font-[Lato]">Presensi Kelas <?php echo $kls['kelas']; ?></h2>
          <div id="chartKelas<?php echo $kls['id_kelas']; ?>"></div>
        </div>
      <?php endforeach; ?>
      
    </div>
</body>


<script>
const chartlolos = document.querySelector("#chartLolos");
const monthInput = document.querySelector("#month");
const bln = document.querySelector("#bln");
const chartMensetsu = document.querySelector("#chartMensetsu");
const semuaKelas = <?php echo json_encode(array_column($kelas, 'id_kelas')); ?>; // Ambil semua id_kelas dari array $kelas
const chartMapKelas = {}; // Peta untuk menyimpan chart berdasarkan id_kelas
let chart;

// chart jumlah_lolos
async function fetchdata(bulan) {
  try {
    const res = await fetch(`../../../app/api/api_jmllolos_perbulan.php?bulan=${bulan}`);
    const data = await res.json();
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

  } catch (err) {
    console.error("Error Fetching Data:", err);
  }
};

// chart absen kelas
const chartKelas = document.querySelectorAll("[id^='chartKelas']"); // Ambil semua elemen yang id-nya diawali dengan 'chartKelas'
async function fetchdataKelas(bulan,kelasId){
  const response = await fetch(`../../../app/api/api_grafikabsen.php?bulan=${bulan}&kelas=${kelasId}`);
  const data = await response.json();
  const tgl = data.map(item => item.tgl);
  const hadir = data.map(item => parseInt(item.hadir));
  const izin = data.map(item => parseInt(item.izin));
  const alpha = data.map(item => parseInt(item.alpha));
  const sakit = data.map(item => parseInt(item.sakit));
  const mensetsu = data.map(item => parseInt(item.mensetsu));

  const options = {
    chart: {
      type: 'area',
      height: 300,
      zoom: {
        enabled: false
      },
      toolbar: {
        show: false
      }
    },
    xaxis: {
      categories: tgl
    },
    yaxis: {
      min: 0
    },
    series: [
      { name: 'Hadir', data: hadir },
      { name: 'Izin', data: izin },
      { name: 'Alpha', data: alpha },
      { name: 'Sakit', data: sakit },
      { name: 'Mensetsu', data: mensetsu },
    ],
    colors: [ '#3b82f6','#10b981', '#ef4444','#9d32a8', '#facc15'],
    tooltip: {
      shared: true,
      intersect: false,
    },
    dataLabels: {
      enabled: false
    },
  };
  // 🧼 Hapus chart lama kalau ada
  if (chartMapKelas[kelasId]) {
    chartMapKelas[kelasId].destroy();
  }
  const target = document.querySelector(`#chartKelas${kelasId}`);
  const chart = new ApexCharts(target, options);
  chart.render();
  chartMapKelas[kelasId] = chart; // Simpan chart ke dalam peta berdasarkan id_kelas
}

// chart jadwal mensetsu
fetch('../../../app/api/api_jadwal_mensetsu.php')
  .then(res => res.json())
  .then(data => {
    const options = {
      chart: {
        type: 'rangeBar',
        height: 300,
        zoom: {
          enabled: false
        },
      },
      plotOptions: {
        bar: {
          horizontal: true,
          barHeight: '50%',
          //borderRadius: 10,
        }
      },
      colors: data.map(item => item.fillColor), // warna unik berdasarkan nama SO
      xaxis: {
        type: 'datetime'
      },
      tooltip: {
        custom: function({ series, seriesIndex, dataPointIndex, w }) {
          const d = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
          return `<div style="padding:5px">
                    <div class="text-red-900 font-semibold">${d.x}</div>
                    ${d.jumlah_job ? `Jumlah Job: ${d.jumlah_job}` : ''}<br/>
                  </div>`;
        }
      },
      series: [{
        name: 'Jadwal Mensetsu',
        data: data
      }],
    };

    const chart = new ApexCharts(chartMensetsu, options);
    chart.render();
  });

// event bulan diganti
monthInput.addEventListener('change', () => {
  loadSemuaGrafikKelas(monthInput.value); // Load semua grafik kelas saat bulan diubah
  fetchdata(monthInput.value);
  bln.innerHTML = formatBulan(monthInput.value);
  console.log(monthInput.value);
});

// fungsi untuk format bulan
function formatBulan(bulan) {
  const bulanBaru = new Date(`${bulan}-01`);
  const formatter = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' });
  return formatter.format(bulanBaru);
}

// 🔥 Load semua grafik kelas waktu halaman pertama kali load
function loadSemuaGrafikKelas(bulan) {
  semuaKelas.forEach(idKelas => {
    fetchdataKelas(bulan, idKelas);
  });
}

// Load pertama kali
loadSemuaGrafikKelas(monthInput.value);
fetchdata(monthInput.value);
bln.innerHTML = formatBulan(monthInput.value);
</script>

</html>