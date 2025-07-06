function inithomeguru(){
    let chart;
    let chart2;
    const monthInput = document.querySelector("#bulan");
    const kelasInput = document.querySelector("#kelas");
    const chartlolos = document.querySelector("#chartLolos");
    let chartabsen = document.querySelector("#chartKelas");

     // 🔥 Deteksi dark mode
     async function fetchdata(bulan,kelas){
         try{
             const respon = await fetch(`../../public/api/api_grafiklolosperkelas.php?bulan=${bulan.value}&kelas=${kelas.value}`);
             const data = await respon.json();
             // const text = await respon.text();
             // console.log("RESPON DARI SERVER:", data);
             const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

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
                  foreColor: isDark ? '#f3f4f6' : '#1f2937', // 🔤 teks
              },
              colors:  [isDark ? '#4ade80' : '#8B0000'], // 🌈 Warna batang/area
              dataLabels: {
                  enabled: false
              },
              stroke: {
                  curve: 'smooth',
                  width: 2
              },
              series: [{
                  name: 'Siswa Lolos',
                  data: jumlah,
              }],
              xaxis: {
                  categories: tanggal,
                  labels: {
                    style: {
                        colors: isDark ? '#f3f4f6' : '#1f2937'
                    }
                }
              },
              yaxis: {
                  min: 0,
                  labels: {
                    style: {
                        colors: isDark ? '#f3f4f6' : '#1f2937'
                    }
                }
              },
            grid: {
                borderColor: isDark ? '#334155' : '#e5e7eb'
            },
            tooltip: {
                theme: isDark ? 'dark' : 'light' // ✅ Fix tooltip background
            }
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
  async function fetchdataKelas() {
    const response = await fetch(`../../public/api/api_grafikabsendashboard.php?bulan=${bulan.value}&kelas=${kelas.value}&laporan=true`);
    const isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const data = await response.json();
    const tgl = data.map(item => item.tgl);
    const hadir = data.map(item => parseInt(item.hadir));
    const izin = data.map(item => parseInt(item.izin));
    const alpha = data.map(item => parseInt(item.alpha));
    const sakit = data.map(item => parseInt(item.sakit));
    const mensetsu = data.map(item => parseInt(item.mensetsu));

    const options = {
      chart: { type: "area", height: 300, zoom: { enabled: false }, toolbar: { show: false },foreColor: isDark ? '#f3f4f6' : '#1f2937'},
      xaxis: { categories: tgl,  
        labels: {
                    style: {
                        colors: isDark ? '#f3f4f6' : '#1f2937'
                    }
                }},
      yaxis: { min: 0,
        labels: {
                    style: {
                        colors: isDark ? '#f3f4f6' : '#1f2937'
                    }
                } },
      series: [
        { name: "Hadir", data: hadir },
        { name: "Izin", data: izin },
        { name: "Alpha", data: alpha },
        { name: "Sakit", data: sakit },
        { name: "Mensetsu", data: mensetsu }
      ],
      colors: ["#3b82f6", "#10b981", "#ef4444", "#9d32a8", "#facc15"],
      tooltip: { shared: true, intersect: false,theme: isDark ? 'dark' : 'light' },
      dataLabels: { enabled: false }
    };

    if (chart2) chart2.destroy();
    chart2 = new ApexCharts(chartabsen, options);
    chart2.render();
  }
  
  
  monthInput.addEventListener('change', () => {
      fetchdata(monthInput, kelasInput);
      fetchdataKelas(monthInput,kelasInput);
    });
    
    fetchdataKelas(monthInput,kelasInput);
    fetchdata(monthInput, kelasInput);
    
    const darkScheme = window.matchMedia("(prefers-color-scheme: dark)"); // Deteksi dark mode sistem (media query)
    darkScheme.addEventListener("change", () => { // Fungsi untuk update chart saat sistem berubah
        console.log("🎨 Sistem mode berubah, update chart...");
        fetchdata(monthInput, kelasInput);
    });

}

window.inithomeguru = inithomeguru;