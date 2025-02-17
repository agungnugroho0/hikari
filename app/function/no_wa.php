<?php 
function formatnowa($nomor){
    $nomor_wa = preg_replace('/^0/', '+62', preg_replace('/^62/', '+62', $nomor));
    return !preg_match('/^\+62/', $nomor_wa) ? '+62' . $nomor_wa : $nomor_wa;
}; 
