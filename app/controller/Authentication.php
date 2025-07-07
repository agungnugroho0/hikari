<?php

namespace app\controller;
use app\model\user;
use app\core\Database;


class Authentication{
    private $usermodel;
    public function __construct(){
        $this->usermodel= new user();
    }

    public function login($username,$password){
        $user = $this->usermodel->getbyusername($username);
        if (!$user) return false;

        // cek password jika masih text
        if ($password === $user['password']){
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $this->usermodel->updatePassword($user['id_staff'], $hashed);
            $user['password'] = $hashed; // update var user
        }

        // autentikasi
        if (password_verify($password, $user['password'])){
            $_SESSION['username'] = $user['nama'];
            $_SESSION['level'] = $user['level'];
            $_SESSION['id_staff'] = $user['id_staff'];
            $_SESSION['id_kelas'] = $user['id_kelas'];
            $_SESSION['foto'] = $user['foto'];
            return $user['level']; // return level buat redirect
        }
        return false;
    }
}