<?php
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
  
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
    <input type="month" class="border-2 border-gray-200 rounded p-1 outline-none" id="month" name="month" value="<?php echo date('Y-m'); ?>">
    <div class="sm:grid sm:grid-cols-2 sm:gap-2 mt-2">
        <div class="border-2 p-2 rounded border-gray-200 bg-white shadow-sm">
            <h2 class="font-semibold text-base font-[Lato]">Jumlah Siswa Lolos Bulan <span id="bln"></span></h2>
            <div id="chartLolos"></div>
        </div>
        <div class="border-2 p-2 rounded border-gray-200 bg-white shadow-sm">
            <h2 class="font-semibold text-base font-[Lato]">Jadwal Mensetsu </h2>
            <div id="chartMensetsu"></div>

        </div>
        
    </div>
</body>


<script>
  const chartlolos = document.querySelector("#chartLolos");
  const monthInput = document.querySelector("#month");
  const bln = document.querySelector("#bln");
  
  // console.log(chartlolos); // Buat debugging
  let chart;

  async function fetchdata(bulan) {
    try {
      const res = await fetch(`../../../app/api/api_jmllolos_perbulan.php?bulan=${bulan}`);
      const data = await res.json();

      // console.log("DATA DARI API:", data); // Buat debugging

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
  }

  
  // Load pertama kali
  fetchdata(monthInput.value);
  bln.innerHTML = formatBulan(monthInput.value);


  monthInput.addEventListener('change', () => {
    fetchdata(monthInput.value);
    bln.innerHTML = formatBulan(monthInput.value);
  });

  function formatBulan(bulan) {
  const bulanBaru = new Date(`${bulan}-01`);
  const formatter = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' });
  return formatter.format(bulanBaru);
}


const chartMensetsu = document.querySelector("#chartMensetsu");

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
          rangeBarGroupRows: true,
          borderRadius: 10,
        }
      },
      // colors: ['#8B0000', '#000000'], // merah buat yang udah, abu buat yang belum
      colors: data.map(item => item.fillColor), // warna unik berdasarkan nama SO
      xaxis: {
        type: 'datetime'
      },
      tooltip: {
          custom: function({ series, seriesIndex, dataPointIndex, w }) {
            const d = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
            return `<div style="padding:5px">
                      <div class=" text-red-900 font-semibold">${d.x}</div>
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

</script>
</html>