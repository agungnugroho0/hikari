function inithome(){
const chartlolos = document.querySelector("#chartLolos");
const monthInput = document.querySelector("#month");
const bln = document.querySelector("#bln");
const chartMensetsu = document.querySelector("#chartMensetsu");

// const semuaKelas = <?php echo json_encode(array_column($kelas, 'id_kelas')); ?>; // Ambil semua id_kelas dari array $kelas
const semuaKelas = JSON.parse(document.getElementById("kelasData").dataset.kelas);

const chartMapKelas = {}; // Peta untuk menyimpan chart berdasarkan id_kelas
let chart;

// chart jumlah_lolos
async function fetchdata(bulan) {
  try {
    const res = await fetch(`../../public/api/api_jml_lolosperbulan.php?bulan=${bulan}`);
    const data = await res.json();
    const tanggal = data.map(item => item.tgl);
    const jumlah = data.map(item => parseInt(item.jumlah_lolos,10)); // Pastikan jumlah_lolos adalah angka
    const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
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
      colors: ['#ffc1bd'],
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'smooth',
        width: 2
      },
      plotOptions: {
        bar: {
          borderRadius: 100, // Radius sudut bar
          borderRadiusApplication: 'end', // Hanya atas (ujung bar)
          columnWidth: '80%', // Ukuran bar
        }
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
      tooltip:{
        theme: isDark ? 'dark' : 'light' ,
      }
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
  const response = await fetch(`../../public/api/api_grafikabsendashboard.php?bulan=${bulan}&kelas=${kelasId}`);
  const data = await response.json();
  const tgl = data.map(item => item.tgl);
  const hadir = data.map(item => parseInt(item.hadir));
  const izin = data.map(item => parseInt(item.izin));
  const alpha = data.map(item => parseInt(item.alpha));
  const sakit = data.map(item => parseInt(item.sakit));
  const mensetsu = data.map(item => parseInt(item.mensetsu));
  const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

  const options = {
    chart: {
      type: 'area',
      height: 300,
      zoom: {
        enabled: false
      },
      toolbar: {
        show: false
      },
      foreColor: isDark ? '#f3f4f6' : '#1f2937', 
    },
    xaxis: {
      categories: tgl,

    },
    yaxis: {
      min: 0,
      labels: {
                    style: {
                        colors: isDark ? '#f3f4f6' : '#1f2937',
                    }
                }
    },
    series: [
      { name: 'Hadir', data: hadir },
      { name: 'Izin', data: izin },
      { name: 'Alpha', data: alpha },
      { name: 'Sakit', data: sakit },
      { name: 'Mensetsu', data: mensetsu },
        
    ],
    colors: [ '#b1cbfa','#73a5d1', '#ff6f00','#2f88d6', '#6189ed'],
    tooltip: {
      shared: true,
      intersect: false,
       theme: isDark ? 'dark' : 'light' ,
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

fetch('../../public/api/api_jadwal_mensetsu.php')
  .then(res => res.json())
  .then(data => {
    console.log("📊 DATA MENSETSU:", data);
    const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

    const options = {
      chart: {
        type: 'rangeBar',
        height: 300,
        zoom: {
          enabled: false
        },
        foreColor: isDark ? '#f3f4f6' : '#1f2937', 
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
       theme: isDark ? 'dark' : 'light' ,
          custom: function({ series, seriesIndex, dataPointIndex, w }) {
          const d = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
         return `<div style="padding:5px dark:bg-black dark:text-white">
                    <div class="text-red-900 font-semibold dark:text-white">${d.x}</div>
                    <p class="font-semibold">${d.nama_job ? `Job : ${d.nama_job}` : ''}</p>
                    ${d.status ? `Tanggal : ${d.status}` : ''}<br/>
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

};
// Buat global biar bisa dipanggil dari luar
window.inithome = inithome;
