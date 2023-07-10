<?php

$conn = mysqli_connect('localhost', 'root', 'makanminggu12', 'quakaltaradb');

// Ambil nilai-nilai terbaru dari database
$query = "SELECT * FROM user_telegram";
$result = mysqli_query($conn, $query);


$query2 = "SELECT * FROM maintb_data ORDER BY `waktu` DESC LIMIT 1";
$result2 = mysqli_query($conn, $query2);
$row2 = mysqli_fetch_assoc($result2);

$ph = $row2['ph'];

$atas_ph = 9;
$mendekati_atas = 8.5;
$bawah_ph =6;



while ($row = mysqli_fetch_array($result)) {
    $telegram_id = $row['chat_id'];
    $nama = $row['nama'];
    echo $nama;
    $pesan = '';
    if ($ph > $atas_ph) {
        $pesan .= " Nilai PH :" . $ph . " (Melibih baku mutu)";
      }
      if ($ph >= $mendekati_atas && $ph <= $atas_ph ) {
        $pesan .= " Nilai PH :" . $ph . " (Mendekati baku mutu)";
      }  
      if ($ph < $bawah_ph) {
        $pesan .= "Nilai PH :" . $ph . "(Kurang dari baku mutu)";
      }
    if (!empty($pesan)) {
        $secret_token = '5787365441:AAHFRDMMTc1eHJ9Vqtn0mKxCKR8sBV4GN_k';
        sendMessage($telegram_id, $pesan, $secret_token);
    }
}

function sendMessage($telegram_id, $pesan, $secret_token)
{
    $url = "https://api.telegram.org/bot" . $secret_token . "/sendMessage?parse_mode=markdown&chat_id=" . $telegram_id;
    $url = $url . "&text=" . urlencode($pesan);
    $ch = curl_init();
    $optArray = array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        echo 'Pesan gagal terkirim, error :' . $err;
    } else {
        echo 'Pesan terkirim';
    }
}