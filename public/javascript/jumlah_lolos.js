const chartlolos = document.querySelector("#chartLolos");
const monthInput = document.querySelector("#bulan");
const kelasInput = document.querySelector("#kelas");
const bln = document.querySelector("#bln");
const kls = document.querySelector("#kls");
let chart;

const API_URL = "/hikari/app/api/api_jumlah_lolos.php";
async function fetchdata(bulan,kelas){
    try{
        // const respon = await fetch(`../../../app/api/api_jumlah_lolos.php?kelas=${kelas.value}&bulan=${bulan.value}`);
        const respon = await fetch(`${API_URL}?kelas=${kelas.value}&bulan=${bulan.value}`);
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
