<?php
session_start();
require_once __DIR__."/../../autoloader.php";
$konek = koneksi();
$username = htmlspecialchars(trim($_POST['username']));
$password = htmlspecialchars(trim($_POST['password']));
if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
    header("location:/index.php?pesan=gagal");
    exit;
}
if (!preg_match('/^[a-zA-Z0-9_]+$/', $password)) {
    header("location:/index.php?pesan=gagal");
    exit;
}
try{
    $statement = $konek->prepare("SELECT * FROM staff WHERE username= :username");
    $statement->execute([':username'=>$username]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
}catch (PDOException $e){
    error_log($e->getMessage());
    header("location:/index.php?pesan=error");
    exit;
}

function posisi($level){
    if ($level == 'admin'){
        header("location:/public/admin/index.php");
    } elseif ($level =='guru'){
        header("location:/public/guru/index.php");
    } else{
        header("location:/index.php?pesan=gagal");
    }

}
if ($user) {
    // Cek apakah password cocok dengan *plain text*
    if ($password === $user['password']) {
        // Simpan password dalam bentuk hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updateStatement = $konek->prepare("UPDATE staff SET password = :password WHERE id_staff = :id");
        $updateStatement->execute([
            ':password' => $hashedPassword,
            ':id' => $user['id_staff']
        ]);
        $_SESSION['username'] = $user['nama'];
        $_SESSION['level'] = $user['level'];
        posisi($user['level']);
        exit;
    }
    // Jika password sudah di-hash, gunakan password_verify
    elseif (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['nama'];
        $_SESSION['level'] = $user['level'];
        posisi($user['level']);
        exit;
    } else {
        posisi(null);
        exit;
    }
} else {
    posisi(null);
    exit;
}
?>