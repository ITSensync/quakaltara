<?php
ini_set('display_errors', 1);
$link = mysqli_connect("localhost", "root", "makanminggu12", "quakaltaradb");
date_default_timezone_set('Asia/Ujung_Pandang');

$waktu = date("Y-m-d H:i:00");
$min5 = date('Y-m-d H:i:s', strtotime($waktu . "-30 minutes"));


$nilai = "SELECT round (AVG(ph),2) AS ph, round(AVG(do),2) AS do, round(AVG(sal),2) AS sal, round(AVG(no2),2) AS no2,round(AVG(wtemp),2) AS temp, round(AVG(`level`),2) AS `level`
          FROM tb_data WHERE `waktu` BETWEEN '$min5' AND '$waktu'";
$query = mysqli_query($link, $nilai);
$data = mysqli_fetch_array($query);
// echo $nilai;

$insert = "INSERT INTO `maintb_data` (waktu, ph, do, sal, no2, temp, `level`) VALUES ('$waktu', '$data[ph]', '$data[do]', '$data[sal]', '$data[no2]', '$data[temp]', '$data[level]')";

$asd = mysqli_query($link, $insert);
if ($asd) {
    echo "received <br>";
}

// kirim ke server
$array = array(
    'ph' => $data['ph'],
    'do' => $data['do'],
    'sal' => $data['sal'],
    'no2' => $data['no2'],
    'temp' => $data['temp'],
    'level'=> $data['level']
);

$jsonData = json_encode($array);
// print_r($jsonData);
// URL tujuan
$url = 'http://secure.getsensync.com/kaltara/api/insert.php'; // Ganti dengan URL yang sesuai

// Inisialisasi cURL
$ch = curl_init();

// Set konfigurasi cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

// Eksekusi cURL
$response = curl_exec($ch);

// Cek jika terjadi error
if ($response === false) {
    echo 'Error: ' . curl_error($ch);
}

// Menutup koneksi cURL
curl_close($ch);

// Menampilkan response dari server
echo $response;