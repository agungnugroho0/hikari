fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json`)
.then(response => response.json())
.then(provinces => {
    var data = provinces;
    var tampung = '<option>Pilih Provinsi</option>'
    data.forEach(element => {
        tampung += `<option data-reg="${element.id}" value="${element.name}">${element.name}</option>`;
    })
    document.getElementById('provinsi').innerHTML = tampung;
});

const selectprovinsi = document.getElementById("provinsi");
selectprovinsi.addEventListener('change', (e) => {
var provinsi = e.target.options[e.target.selectedIndex].dataset.reg;
fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinsi}.json`)
    .then(respons => respons.json())
    .then(regencies => {
        var data = regencies;
        var tampung = '<option>Pilih Kabupaten</option>'
        data.forEach(element => {
            tampung += `<option data-dist="${element.id}" value="${element.name}">${element.name}</option>`;
        })
        document.getElementById('kabupaten').innerHTML = tampung;
    })
});

const selectkabupaten = document.getElementById("kabupaten");
selectkabupaten.addEventListener('change', (e) => {
var kabupaten = e.target.options[e.target.selectedIndex].dataset.dist;
fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${kabupaten}.json`)
    .then(respons => respons.json())
    .then(districts => {
        var data = districts;
        var tampung = '<option>Pilih Kecamatan</option>'
        data.forEach(element => {
            tampung += `<option data-vill="${element.id}" value="${element.name}">${element.name}</option>`;
        })
        document.getElementById('kecamatan').innerHTML = tampung;
    })
});

// const selectkecamatan = document.getElementById("kecamatan");
// selectkecamatan.addEventListener('change', (e) => {
//     var kecamatan = e.target.options[e.target.selectedIndex].dataset.vill;
//     fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatan}.json`)
//         .then(respons => respons.json())
//         .then(districts => {
//             var data = districts;
//             var tampung = '<option>Pilih Desa</option>'
//             data.forEach(element => {
//                 tampung += `<option value="${element.name}">${element.name}</option>`;
//             })
//             document.getElementById('kelurahan').innerHTML = tampung;
//         })
// });