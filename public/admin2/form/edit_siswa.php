<?php 
require $_SERVER['DOCUMENT_ROOT'].'/hikari/autoloader.php';
admin();
$nis = $_GET['nis'];
$nis = trim($_GET['nis']); // Pastikan NIS bersih dari spasi tambahan
if(isset($_GET['lolos'])){
    $siswa = tampil("SELECT * FROM lolos WHERE nis = $nis");
    $ket = 'lolos';
} elseif (isset($_GET['siswa'])){
    $siswa = tampil("SELECT * FROM siswa WHERE nis = $nis");
    $ket = 'siswa';
}
$sis = $siswa[0];

// Ambil data kelas dari tabel kelas
$kelasData = tampil("SELECT id_kelas, kelas FROM kelas");

$panjang = [
    'NAMA LENGKAP' => $sis['nama'],
    'カタカナ' => $sis['panggilan'],
    'TEMPAT LAHIR' => $sis['tempat_lhr'],
    'WA' => $sis['wa'],
    'NO_RUMAH' => $sis['no_rumah'],
    'KELURAHAN' => $sis['kelurahan'],
    'RT' => $sis['rt'],
    'RW' => $sis['rw'],
    'KECAMATAN' => $sis['kecamatan'],
    'KABUPATEN' => $sis['kabupaten'],
    'PROVINSI' => $sis['provinsi'],
    'HOBI' => $sis['hobi'],
    'TUJUAN KE JEPANG' => $sis['tujuan'],
    'KELEBIHAN' => $sis['kelebihan'],
    'KEKURANGAN' => $sis['kekurangan'],
];

$pilihan = [
    'GENDER' => ['L', 'P'],
    'AGAMA' => ['ISLAM', 'KRISTEN', 'KATOLIK', 'HINDU', 'BUDDHA', 'KONGHUCU'],
    'STATUS' => ['BELUM MENIKAH', 'MENIKAH', 'CERAI'],
    'DARAH' => ['A', 'B', 'AB', 'O'],
    'BB' => range(30, 220),
    'TB' => range(30, 220),
    'MEROKOK' => ['YA', 'TIDAK'],
    'ALKOHOL' => ['YA', 'TIDAK'],   
    'TANGAN' => ['KANAN', 'KIRI']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title><?= $sis['nama'] ?></title>
</head>
<body>
    <form action="../../../app/database/edit_siswa.php" method="POST" class="container mx-auto max-w-md shadow-md p-7 my-3 rounded" enctype="multipart/form-data">
        <input type="text" name="nis" value="<?= $sis['nis'] ?>" class="w-full px-3 py-1.5 rounded-md mb-2 font-semibold bg-gray-200" readonly>
        <input type="text" name="ket" value="<?=$ket?>" hidden>
        <?php foreach ($panjang as $label => $value): ?>
            <?php if ($label == 'TEMPAT LAHIR'): ?>
                <label for="tgl" class="block text-sm font-normal text-gray-500">Tempat, Tanggal Lahir</label>
                <div class="flex gap-3 mb-2">
                    <input id="<?= strtolower(str_replace(' ', '_', $label)) ?>" name="<?= strtolower(str_replace(' ', '_', $label)) ?>" type="text" class="block rounded-md bg-white px-3 py-1.5 text-gray-900 outline outline-1 outline-gray-300" value="<?= $value ?>">
                    <input type="date" id="tgl" name="tgl" value="<?= $sis['tgl'] ?>" class="grow rounded-md bg-white px-3 py-1.5 text-gray-900 outline outline-1 outline-gray-300">
                </div>
            <?php else: ?>
                <label for="<?= strtolower(str_replace(' ', '_', $label)) ?>" class="block text-sm font-normal text-gray-500"><?= $label ?></label>
                <div class="mb-2">
                    <input id="<?= strtolower(str_replace(' ', '_', $label)) ?>" name="<?= strtolower(str_replace(' ', '_', $label)) ?>" type="text" class="block w-full rounded-md bg-white px-3 py-1.5 text-gray-900 outline outline-1 outline-gray-300" value="<?= $value ?>">
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

        <div class="grid grid-cols-2 gap-2">
            <?php foreach ($pilihan as $label => $options): ?>
                <div class="my-1">
                    <label for="<?= strtolower(str_replace(' ', '_', $label)) ?>" class="block text-sm font-normal text-gray-500"><?= $label ?></label>
                    <select name="<?= strtolower(str_replace(' ', '_', $label)) ?>" id="<?= strtolower(str_replace(' ', '_', $label)) ?>" class="block w-full rounded-md bg-white px-3 py-1.5 text-gray-900 outline outline-1 outline-gray-300">
                        <?php foreach ($options as $pilih): ?>
                            <option value="<?= htmlspecialchars($pilih) ?>" <?= ($pilih == $sis[strtolower(str_replace(' ', '_', $label))]) ? 'selected' : '' ?>><?= $pilih ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>
            
            <!-- Dropdown untuk Kelas -->
            <div class="my-1">
                <label for="id_kelas" class="block text-sm font-normal text-gray-500">Kelas</label>
                <select name="id_kelas" id="id_kelas" class="block w-full rounded-md bg-white px-3 py-1.5 text-gray-900 outline outline-1 outline-gray-300">
                    <?php foreach ($kelasData as $kelas): ?>
                        <option value="<?= $kelas['id_kelas'] ?>" <?= ($kelas['id_kelas'] == $sis['id_kelas']) ? 'selected' : '' ?>><?= $kelas['kelas'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <hr class="my-3">
        <label for="foto" class="block text-sm font-normal text-gray-500">Foto Siswa</label>
        <div class="flex">
            <div class="overflow-clip rounded-full origin-center w-7 h-7">
                <img src="../../image/photos/<?= $sis['foto'] ?>" alt="Foto siswa">
            </div>
            <input type="file" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 hover:bg-gray-50" name="foto">
        </div>

        <div class="mt-3 flex items-center justify-end gap-x-6">
            <a href="../detail_siswa.php?nis=<?= $nis ?>">
                <button type="button" class="text-sm font-semibold text-gray-900">Cancel</button>
            </a>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Save</button>
        </div>
    </form>
</body>
</html>
