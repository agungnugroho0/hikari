<?php
function uploadFotoSiswa($file, $nis,$targetDir = __DIR__ . "/../../public/image/photos/") {
    // 1. Buat direktori jika belum ada
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0755, true)) {
            return "Gagal membuat direktori target.";
        }
    }

    // 2. Jika tidak ada file yang diunggah
    if ($file['error'] === UPLOAD_ERR_NO_FILE) {
        $foto_siswa = tampil("SELECT foto FROM siswa WHERE nis='$nis'");
        foreach ($foto_siswa as $value){
            $foto = $value['foto'];
        }
        return [
            'status' => 'success',
            'foto' => $foto['foto']
        ];
    }

    // 3. Validasi file
    $allowedTypes = ['jpg', 'jpeg', 'png'];
    $fileName = basename($file['name']); // Ambil nama file asli
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Ekstensi file
    $targetFile = $targetDir . $fileName; // Gabungkan direktori dan nama file

    // 4. Validasi format file
    if (!in_array($fileExt, $allowedTypes)) {
        return "Format file tidak diizinkan. Hanya JPG, JPEG, dan PNG.";
    }

    // 5. Periksa jika ada kesalahan saat mengunggah file
    if ($file['error'] !== 0) {
        return "Terjadi kesalahan saat mengunggah file.";
    }

    // 6. Periksa jika file dengan nama yang sama sudah ada
    if (file_exists($targetFile)) {
        // Tambahkan timestamp ke nama file untuk menghindari konflik
        $fileNameWithoutExt = pathinfo($fileName, PATHINFO_FILENAME); // Nama file tanpa ekstensi
        $newFileName = $fileNameWithoutExt . '_' . time() . '.' . $fileExt;
        $targetFile = $targetDir . $newFileName;
        $fileName = $newFileName; // Update nama file yang diunggah
    }

    // 7. Pindahkan file dari lokasi sementara ke direktori target
    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return [
            'status' => 'success',
            'foto' => $fileName
        ];
    } else {
        return "Gagal mengunggah file.";
    }
}

function uploadfotoso($files,$targetDir = __DIR__ . "/../../public/image/img_so/"){
        // 1. Buat direktori jika belum ada
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0755, true)) {
                return "Gagal membuat direktori target.";
            }
        };

        // 2. Validasi file
        $allowedTypes = ['jpg', 'jpeg', 'png'];
        $fileName = basename($files['name']); // Ambil nama file asli
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // Ekstensi file
        $targetFile = $targetDir . $fileName; // Gabungkan direktori dan nama file

        // 3. Periksa jika ada kesalahan saat mengunggah file
        if ($files['error'] !== 0) {
            return "Terjadi kesalahan saat mengunggah file.";
        }

        if (move_uploaded_file($files['tmp_name'], $targetFile)) {
            return [
                'status' => 'success',
                'foto' => $fileName
            ];
        } else {
            return "Gagal mengunggah file.";
        }

}