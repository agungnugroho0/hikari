function initfinance() {
  let timeout = null;
  loadData();

  document.getElementById('searchInput').addEventListener('input', e => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
      const keyword = e.target.value.trim();
      loadData(keyword);
    }, 200);
  });

  function loadData(keyword = '') {
    const url = keyword 
      ? `/public/api/api_finance.php?search=${encodeURIComponent(keyword)}`
      : '/public/api/api_finance.php';

    fetch(url)
      .then(res => res.json())
      .then(data => {
        // console.log('✅ Data fetched:', data);
        renderTable(data)})
      .catch(err => console.error('⚠️ Gagal fetch data:', err));
  }

  function renderTable(data) {
    const defaultTagihan = {
      "Pra-MCU": 0,
      "Pendidikan 1": 0,
      "Pendidikan 2": 0,
      "Sending Organizer": 0,
      "Lain - lain": 0,
      total: 0,
      status: ""
    };

    const grup = {};

const centang =`<svg
            xmlns:dc="http://purl.org/dc/elements/1.1/"
            xmlns:cc="http://creativecommons.org/ns#"
            xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
            xmlns:svg="http://www.w3.org/2000/svg"
            xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink"
            xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
            xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
            viewBox="0 0 512 512"
            id="svg2"
            version="1.1"
            inkscape:version="0.91 r"
            sodipodi:docname="anydo.svg"
            inkscape:export-filename="/home/alecive/Scrivania/firefoxTest1.png"
            inkscape:export-xdpi="100"
            inkscape:export-ydpi="100"
            class="w-5 h-5 inline-block">
            <sodipodi:namedview
                id="base"
                bordercolor="#1fa643"
                borderopacity="1.0"
                inkscape:pageopacity="0.0"
                inkscape:pageshadow="2"
                inkscape:zoom="0.6485915"
                inkscape:cx="314.02181"
                inkscape:cy="169.95964"
                inkscape:document-units="px"
                inkscape:current-layer="svg2"
                showgrid="false"
                inkscape:window-width="1366"
                inkscape:window-height="744"
                inkscape:window-x="0"
                inkscape:window-y="24"
                inkscape:window-maximized="1"
                inkscape:object-paths="false"
                inkscape:snap-intersection-paths="false"
                inkscape:object-nodes="true"
                inkscape:snap-smooth-nodes="true"
                inkscape:snap-nodes="true" />
            <defs
                id="defs4">
                <linearGradient
                x1="19.244999"
                y1="21.030804"
                x2="19.360001"
                gradientUnits="userSpaceOnUse"
                y2="44.984001"
                id="linearGradient2460">
                <stop
                    offset="0"
                    style="stop-color:#00bdf0;stop-opacity:1;"
                    id="stop3602" />
                <stop
                    offset="1"
                    style="stop-color:#0093dc;stop-opacity:1;"
                    id="stop3604" />
                </linearGradient>
                <linearGradient
                inkscape:collect="always"
                xlink:href="#ButtonShadow-0-1-1-5-9"
                id="linearGradient4114-2-6"
                gradientUnits="userSpaceOnUse"
                gradientTransform="matrix(1.0317796,0,0,1.0317796,-830.86406,592.67791)"
                x1="1012.5133"
                y1="484.41721"
                x2="1006.8082"
                y2="20.625916" />
                <linearGradient
                x1="45.447727"
                y1="92.539597"
                x2="45.447727"
                y2="7.0165396"
                id="ButtonShadow-0-1-1-5-9"
                gradientUnits="userSpaceOnUse"
                gradientTransform="matrix(1.0058652,0,0,0.994169,100,0)">
                <stop
                    id="stop3750-8-9-3-6-4"
                    style="stop-color:#000000;stop-opacity:1"
                    offset="0" />
                <stop
                    id="stop3752-5-6-4-2-9"
                    style="stop-color:#000000;stop-opacity:0.58823532"
                    offset="1" />
                </linearGradient>
                <linearGradient
                inkscape:collect="always"
                xlink:href="#ButtonShadow-0-1-1-5-9"
                id="linearGradient4112-2-6"
                gradientUnits="userSpaceOnUse"
                gradientTransform="matrix(1.0402541,0,0,1.0402541,-837.95116,592.51825)"
                x1="1012.5133"
                y1="484.41721"
                x2="1006.8082"
                y2="20.625916" />
                <linearGradient
                inkscape:collect="always"
                xlink:href="#ButtonShadow-0-1-1-5-9"
                id="linearGradient4110-6-7"
                gradientUnits="userSpaceOnUse"
                gradientTransform="matrix(1.023305,0,0,1.023305,-823.77704,592.83757)"
                x1="1012.5133"
                y1="484.41721"
                x2="1006.8082"
                y2="20.625916" />
                <linearGradient
                inkscape:collect="always"
                xlink:href="#ButtonShadow-0-1-1-5-9"
                id="linearGradient4116-6-3"
                gradientUnits="userSpaceOnUse"
                gradientTransform="matrix(1.0148305,0,0,1.0148305,-816.68996,592.99723)"
                x1="1012.5133"
                y1="484.41721"
                x2="1006.8082"
                y2="20.625916" />
                <linearGradient
                y2="20.625916"
                x2="1006.8082"
                y1="484.41721"
                x1="1012.5133"
                gradientTransform="matrix(1.0074153,0,0,1.0074153,-810.48879,593.1369)"
                gradientUnits="userSpaceOnUse"
                id="linearGradient5342-3"
                xlink:href="#ButtonShadow-0-1-1-5-9"
                inkscape:collect="always" />
                <linearGradient
                inkscape:collect="always"
                xlink:href="#linearGradient3737-9"
                id="linearGradient4084-8"
                gradientUnits="userSpaceOnUse"
                gradientTransform="translate(778.59979,-360.55963)"
                x1="993.43896"
                y1="51.511765"
                x2="988.78552"
                y2="363.73825" />
                <linearGradient
                id="linearGradient3737-9">
                <stop
                    id="stop3739-7"
                    style="stop-color:#ffffff;stop-opacity:1"
                    offset="0" />
                <stop
                    id="stop3741-4"
                    style="stop-color:#ffffff;stop-opacity:0"
                    offset="1" />
                </linearGradient>
                <linearGradient
                inkscape:collect="always"
                xlink:href="#linearGradient4046-3"
                id="linearGradient4086-12"
                gradientUnits="userSpaceOnUse"
                x1="1764.6487"
                y1="155.59685"
                x2="1763.6903"
                y2="-55.941216" />
                <linearGradient
                id="linearGradient4046-3">
                <stop
                    id="stop4048-7"
                    style="stop-color:#000000;stop-opacity:1;"
                    offset="0" />
                <stop
                    id="stop4050-73"
                    style="stop-color:#ffffff;stop-opacity:0.2"
                    offset="1" />
                </linearGradient>
                <linearGradient
                y2="32"
                x2="272"
                y1="288"
                x1="272"
                gradientTransform="translate(0,-4)"
                gradientUnits="userSpaceOnUse"
                id="linearGradient3876"
                xlink:href="#outerBackgroundGradient"
                inkscape:collect="always" />
                <linearGradient
                id="outerBackgroundGradient">
                <stop
                    id="stop3864-8-6"
                    offset="0"
                    style="stop-color:#007dbb;stop-opacity:1;" />
                <stop
                    id="stop3866-9-1"
                    offset="1"
                    style="stop-color:#00abd7;stop-opacity:1;" />
                </linearGradient>
                <linearGradient
                inkscape:collect="always"
                xlink:href="#outerBackgroundGradient"
                id="linearGradient5589"
                gradientUnits="userSpaceOnUse"
                gradientTransform="translate(571.12383,-178.05409)"
                x1="272"
                y1="288"
                x2="272"
                y2="32" />
                <linearGradient
                y2="32"
                x2="272"
                y1="288"
                x1="272"
                gradientTransform="translate(571.12383,-178.05409)"
                gradientUnits="userSpaceOnUse"
                id="linearGradient5614"
                xlink:href="#outerBackgroundGradient"
                inkscape:collect="always" />
                <radialGradient
                gradientUnits="userSpaceOnUse"
                r="236"
                fy="151.78598"
                fx="256"
                cy="151.78598"
                cx="256"
                id="radialGradient6124"
                xlink:href="#linearGradient2460"
                inkscape:collect="always" />
                <linearGradient
                inkscape:collect="always"
                xlink:href="#linearGradient3737-9"
                id="linearGradient7749"
                gradientUnits="userSpaceOnUse"
                gradientTransform="translate(778.59979,-360.55963)"
                x1="993.43896"
                y1="51.511765"
                x2="988.78552"
                y2="363.73825" />
                <linearGradient
                inkscape:collect="always"
                xlink:href="#linearGradient4046-3"
                id="linearGradient7751"
                gradientUnits="userSpaceOnUse"
                x1="1764.6487"
                y1="155.59685"
                x2="1763.6903"
                y2="-55.941216" />
                <linearGradient
                inkscape:collect="always"
                xlink:href="#linearGradient2460-9"
                id="linearGradient3157"
                gradientUnits="userSpaceOnUse"
                gradientTransform="matrix(12.102564,0,0,12.102564,-34.468255,-46.187105)"
                x1="18.930269"
                y1="6.2951212"
                x2="19.360001"
                y2="36.643665" />
                <linearGradient
                id="linearGradient2460-9"
                y2="44.984001"
                gradientUnits="userSpaceOnUse"
                x2="19.360001"
                y1="21.030804"
                x1="19.244999">
                <stop
                    id="stop3602-6"
                    style="stop-color:#fafafa;stop-opacity:1;"
                    offset="0" />
                <stop
                    id="stop3604-4"
                    style="stop-color:#f0f0f0;stop-opacity:1;"
                    offset="1" />
                </linearGradient>
                <radialGradient
                gradientUnits="userSpaceOnUse"
                r="236"
                fy="151.78598"
                fx="256"
                cy="151.78598"
                cx="256"
                id="radialGradient6124-5"
                xlink:href="#linearGradient2460-7"
                inkscape:collect="always" />
                <linearGradient
                x1="19.244999"
                y1="21.030804"
                x2="19.360001"
                gradientUnits="userSpaceOnUse"
                y2="44.984001"
                id="linearGradient2460-7">
                <stop
                    offset="0"
                    style="stop-color:#00bdf0;stop-opacity:1;"
                    id="stop3602-2" />
                <stop
                    offset="1"
                    style="stop-color:#0093dc;stop-opacity:1;"
                    id="stop3604-5" />
                </linearGradient>
                <radialGradient
                gradientTransform="translate(-20,-20)"
                r="236"
                fy="151.78598"
                fx="256"
                cy="151.78598"
                cx="256"
                gradientUnits="userSpaceOnUse"
                id="radialGradient8295"
                xlink:href="#linearGradient2460-7"
                inkscape:collect="always" />
                <linearGradient
                y2="363.73825"
                x2="988.78552"
                y1="51.511765"
                x1="993.43896"
                gradientTransform="translate(778.59979,-360.55963)"
                gradientUnits="userSpaceOnUse"
                id="linearGradient4084-8-0"
                xlink:href="#linearGradient3737-9-9"
                inkscape:collect="always" />
                <linearGradient
                id="linearGradient3737-9-9">
                <stop
                    offset="0"
                    style="stop-color:#ffffff;stop-opacity:1"
                    id="stop3739-7-4" />
                <stop
                    offset="1"
                    style="stop-color:#ffffff;stop-opacity:0"
                    id="stop3741-4-1" />
                </linearGradient>
                <linearGradient
                y2="-55.941216"
                x2="1763.6903"
                y1="155.59685"
                x1="1764.6487"
                gradientUnits="userSpaceOnUse"
                id="linearGradient4086-12-7"
                xlink:href="#linearGradient4046-3-0"
                inkscape:collect="always" />
                <linearGradient
                id="linearGradient4046-3-0">
                <stop
                    offset="0"
                    style="stop-color:#000000;stop-opacity:1;"
                    id="stop4048-7-4" />
                <stop
                    offset="1"
                    style="stop-color:#ffffff;stop-opacity:0.2"
                    id="stop4050-73-8" />
                </linearGradient>
            </defs>
            <metadata
                id="metadata7">
                <rdf:RDF>
                <cc:Work
                    rdf:about="">
                    <dc:format>image/svg+xml</dc:format>
                    <dc:type
                    rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
                    <dc:title />
                </cc:Work>
                </rdf:RDF>
            </metadata>
            <g
                id="layer1"
                inkscape:groupmode="layer"
                inkscape:label="Livello 1"
                transform="translate(0,-540.36218)" />
            <g
                id="g2036"
                transform="matrix(1.1,0,0,0.44444,95.081063,256.39254)">
                <g
                id="g3712"
                style="opacity:0.4"
                transform="matrix(1.0526,0,0,1.2857,-1.2632,-13.429)" />
            </g>
            <g
                transform="translate(97.481063,231.28154)"
                id="g3541" />
            <g
                transform="translate(97.481063,231.28154)"
                id="g3536" />
            <g
                id="g4103"
                transform="translate(-11.985071,-592.11719)" />
            <g
                id="g4076"
                transform="translate(-605.51932,-353.96833)">
                <g
                transform="translate(-926.66758,684.38448)"
                id="g4038" />
            </g>
            <rect
                style="fill:#55d400;fill-opacity:1;stroke:none"
                id="rect3069"
                width="444.03912"
                height="434.14014"
                x="35.461464"
                y="38.39838"
                ry="45.859875" />
            <path
                style="color:#000000;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:medium;line-height:normal;font-family:Sans;-inkscape-font-specification:Sans;text-indent:0;text-align:start;text-decoration:none;text-decoration-line:none;letter-spacing:normal;word-spacing:normal;text-transform:none;direction:ltr;block-progression:tb;writing-mode:lr-tb;baseline-shift:baseline;text-anchor:start;display:inline;overflow:visible;visibility:visible;fill:#ffffff;fill-opacity:1;stroke:none;stroke-width:17.73212814;marker:none;enable-background:new"
                d="m 347.51713,165.87342 -120.28026,120.21711 -54.0472,-53.73149 -25.2557,25.38197 c 26.4783,26.30612 52.9052,52.66399 79.42917,78.92405 48.49095,-48.49094 96.98188,-96.98187 145.47282,-145.47281 z"
                id="path3851"
                inkscape:connector-curvature="0"
                sodipodi:nodetypes="ccccccc" />
            </svg>`;
    // ================================
    // Kelompokkan data per NIS
    // ================================
    data.forEach(item => {
      const nis = item.nis;
      if (!grup[nis]) {
        grup[nis] = { ...defaultTagihan, nis, nama: item.nama, asal_data: item.asal_data, _statusList: [] };
      }


      const jenis = (item.jenis_tagihan || '').toLowerCase();
      const sisa = parseInt(item.sisa_tagihan) || 0;
      const status = (item.status_tagihan || '').toLowerCase();

      let value = sisa;
      if (status === "lunas") value = centang;

      // Pemetaan jenis tagihan
      if (jenis.includes("pra")) grup[nis]["Pra-MCU"] = value;
      else if (jenis.includes("registrasi")) grup[nis]["Pendidikan 1"] = value;
      else if (jenis.includes("hikari")) grup[nis]["Pendidikan 2"] = value;
      else if (jenis.includes("so")) grup[nis]["Sending Organizer"] = value;
      else grup[nis]["Lain - lain"] = value;

      // Simpan status untuk nanti dicek
      if (item.status_tagihan) grup[nis]._statusList.push(item.status_tagihan);
    });



    // =================================
    // buat centang lunas jika semua lunas
    // =================================
    

    // ================================
    // Hitung total dan status per siswa
    // ================================
    Object.values(grup).forEach(s => {
      s.total = Object.values(s)
        .filter(v => typeof v === "number")
        .reduce((a, b) => a + b, 0);

      s.status = s._statusList.length > 0 && s._statusList.every(st => st.toLowerCase() === "lunas")
        ? "Lunas"
        : "Belum Lunas";

      delete s._statusList;
    });

    // ================================
    // Render tabel HTML
    // ================================
    const tbody = document.getElementById('bodyTagihan');
    tbody.innerHTML = '';
    let no = 1;

    for (const nis in grup) {
      const t = grup[nis];
      const routePage = t.asal_data === 'lolos' ? 'lolos' : 'siswa';
      const halaman = t.asal_data === 'lolos' ? '5' : '4';

      // Badge warna untuk status
      const badge = t.status === "Lunas"
        ? `${centang} Lunas`
        : `<b>${t.total.toLocaleString()}</b>`;

      tbody.innerHTML += `
        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 *:py-2 *:pr-3 *:pl-2">
          <td class='text-center'>${no++}</td>
          <td>${t.nama}</td>
          <td>${t["Pra-MCU"].toLocaleString()}</td>
          <td>${t["Pendidikan 1"].toLocaleString()}</td>
          <td>${t["Pendidikan 2"].toLocaleString()}</td>
          <td>${t["Sending Organizer"].toLocaleString()}</td>
          <td>${t["Lain - lain"].toLocaleString()}</td>
          <td>${badge}</td>
          <td>
            <a href="#" 
              onclick="loadPageFromMenu('router.php?page=${routePage}&act=detail&nis=${t.nis}', '${halaman}')" 
              class="dark:text-slate-200  ">
            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 512 512" class="w-5 h-5 text-white">
            <path d="M0 0 C1.43883545 0.30599121 1.43883545 0.30599121 2.90673828 0.61816406 C40.0384403 8.7434959 74.20204007 25.11575876 103 50 C103.92167969 50.79148438 104.84335937 51.58296875 105.79296875 52.3984375 C116.08407269 61.46246227 125.63036719 71.12379902 134 82 C134.42104004 82.53931152 134.84208008 83.07862305 135.27587891 83.63427734 C165.87634314 123.0160358 181.52005603 171.0211175 181.3125 220.6875 C181.31034485 221.61642059 181.3081897 222.54534119 181.30596924 223.50241089 C181.25610813 236.89069476 180.89233116 249.88139636 178 263 C177.69400879 264.46397217 177.69400879 264.46397217 177.38183594 265.95751953 C171.07261183 295.78169025 159.72999281 324.05431244 142 349 C141.25234375 350.05960937 140.5046875 351.11921875 139.734375 352.2109375 C127.29285068 369.26209134 112.79817265 385.16774599 96 398 C95.46358887 398.41813965 94.92717773 398.8362793 94.37451172 399.26708984 C54.99149434 429.87351191 6.98379832 445.52007657 -42.6875 445.3125 C-43.61642059 445.31034485 -44.54534119 445.3081897 -45.50241089 445.30596924 C-58.89617837 445.25608771 -71.87362489 444.87302104 -85 442 C-86.4240918 441.70996094 -86.4240918 441.70996094 -87.87695312 441.4140625 C-140.318196 430.62614968 -189.70406802 401.10128104 -221.73242188 357.71630859 C-222.98942094 356.01432411 -224.2672632 354.32955002 -225.546875 352.64453125 C-245.33663122 326.18677868 -257.28809117 295.11218941 -264 263 C-264.18079102 262.17999512 -264.36158203 261.35999023 -264.54785156 260.51513672 C-269.96936103 235.12673603 -269.54137771 204.31767137 -264 179 C-263.70996094 177.5759082 -263.70996094 177.5759082 -263.4140625 176.12304688 C-255.65665917 138.41344736 -239.16457035 104.13435962 -214 75 C-213.22011719 74.08992188 -212.44023437 73.17984375 -211.63671875 72.2421875 C-209.47083724 69.77933868 -207.25655306 67.38004601 -205 65 C-204.53158691 64.50435547 -204.06317383 64.00871094 -203.58056641 63.49804688 C-195.63826073 55.15266855 -187.23894802 47.86793622 -178 41 C-177.44231934 40.5762207 -176.88463867 40.15244141 -176.31005859 39.71582031 C-149.38700168 19.27409458 -117.876025 6.87156144 -85 0 C-84.17999512 -0.18079102 -83.35999023 -0.36158203 -82.51513672 -0.54785156 C-56.85414484 -6.02757091 -25.5958949 -5.53025112 0 0 Z M-62 109 C-66.97265305 114.84392987 -69.60124057 120.69339821 -70.3125 128.375 C-69.51581541 137.61654124 -65.94456342 143.82292843 -59 150 C-52.12226873 154.51467713 -44.93921961 156.05305312 -36.796875 154.609375 C-29.51678776 152.62389666 -23.62368677 148.14874988 -19.58203125 141.7578125 C-16.19776024 134.69604845 -15.16062931 127.91174342 -17.15625 120.296875 C-20.09156723 112.30628921 -25.29166029 106.59399827 -33 103 C-43.98903073 99.43213288 -53.33193693 101.34212473 -62 109 Z M-60.875 189.9375 C-67.31031502 197.85001233 -67.14954368 206.2754582 -67.14526367 216.07910156 C-67.14862228 217.18557541 -67.1519809 218.29204926 -67.15544128 219.43205261 C-67.16492921 223.08492154 -67.1668934 226.73774452 -67.16796875 230.390625 C-67.17118311 232.9364219 -67.17454732 235.48221862 -67.17805481 238.02801514 C-67.18404088 243.36422223 -67.18593817 248.70041229 -67.18530273 254.03662109 C-67.18470281 260.18388298 -67.19524106 266.33105688 -67.2110464 272.47829652 C-67.22575695 278.41350939 -67.22928917 284.34869569 -67.22869301 290.28392792 C-67.22987001 292.79880889 -67.23427603 295.31369057 -67.24202538 297.82855988 C-67.25186935 301.35355334 -67.24892959 304.87832292 -67.24291992 308.40332031 C-67.24853943 309.43327621 -67.25415894 310.46323212 -67.25994873 311.5243988 C-67.22069651 320.62700195 -66.76462556 328.99761023 -60.78125 336.2421875 C-55.64805489 341.30784057 -50.39610064 343.77359329 -43.25 344.25 C-36.19525719 344.11911423 -31.00650108 341.40340744 -25.640625 336.98828125 C-19.7652335 329.86786631 -19.42004263 323.3712919 -19.48242188 314.46875 C-19.4754126 313.2319751 -19.46840332 311.9952002 -19.46118164 310.72094727 C-19.44665078 307.34874198 -19.44997425 303.97752584 -19.46269798 300.6053772 C-19.47287677 297.0643793 -19.46341884 293.52342156 -19.45715332 289.98242188 C-19.44989101 284.0376839 -19.45942716 278.09314517 -19.47851562 272.1484375 C-19.50028185 265.29092184 -19.49322946 258.43388201 -19.47121 251.57637787 C-19.45301536 245.67206521 -19.45051743 239.76789519 -19.46096468 233.86356354 C-19.46717741 230.3444286 -19.46809701 226.82551679 -19.45481873 223.30639648 C-19.44104069 219.38116182 -19.46017624 215.45645339 -19.48242188 211.53125 C-19.47432495 210.37568604 -19.46622803 209.22012207 -19.45788574 208.02954102 C-19.53976695 200.21514933 -20.67134443 194.79850556 -25.96484375 188.7578125 C-26.94130859 187.94957031 -26.94130859 187.94957031 -27.9375 187.125 C-28.58589844 186.57070312 -29.23429687 186.01640625 -29.90234375 185.4453125 C-40.29959973 178.2814676 -52.76500535 181.12808076 -60.875 189.9375 Z " fill="currentColor" transform="translate(299,35)"/>
            </svg>
            </a>
          </td>
        </tr>`;
    }
  }
}
window.initfinance = initfinance;
