<?php
include "../koneksi/koneksi.php";
ini_set('display_errors', 1);



// Membuat soket server
$serverSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($serverSocket === false) {
    echo "Error: Tidak dapat membuat soket server\n";
    exit;
}

// Mengikat soket ke alamat IP dan port yang diinginkan
$ipAddress = "192.168.20.55"; // Ganti dengan alamat IP server Anda
$port = 8500; // Ganti dengan port yang diinginkan
$result = socket_bind($serverSocket, $ipAddress, $port);
if ($result === false) {
    echo "Error: Tidak dapat mengikat soket server ke $ipAddress:$port\n";
    exit;
}

// Mendengarkan koneksi masuk
$result = socket_listen($serverSocket);
if ($result === false) {
    echo "Error: Tidak dapat mendengarkan koneksi masuk\n";
    exit;
}

// Menerima koneksi
$clientSocket = socket_accept($serverSocket);
if ($clientSocket === false) {
    echo "Error: Tidak dapat menerima koneksi\n";
    exit;
}

// Menerima data dari GPS tracker Rut955
$data = socket_read($clientSocket, 1024);
if ($data === false) {
    echo "Error: Tidak dapat membaca data dari GPS tracker\n";
    exit;
}

// Menutup koneksi
socket_close($clientSocket);
socket_close($serverSocket);

// Proses data yang diterima
echo "Data dari GPS tracker Rut955: <br>";


// Parsing data untuk mendapatkan latitude dan longitude
$gpsData = explode(',', $data);
if ($gpsData[0] === '$GPGGA') {
    $latitude = $gpsData[2];
    $latitudeDirection = $gpsData[3];
    $longitude = $gpsData[4];
    $longitudeDirection = $gpsData[5];
    $timeUtc = $gpsData[1];

    // Mengonversi waktu UTC ke WIB
    date_default_timezone_set('Asia/Ujung_Pandang');
    $timeWib = date('H:i:s', strtotime($timeUtc . 'UTC'));
    $waktu = date('Y-m-d H:i:00');

    // Mengonversi format latitude dan longitude
    function convertLatitude($latitude, $latitudeDirection)
    {
        $degrees = intval(substr($latitude, 0, 2));
        $minutes = floatval(substr($latitude, 2)) / 60;

        $decimalLatitude = $degrees + $minutes;

        if ($latitudeDirection === 'S') {
            $decimalLatitude = -$decimalLatitude;
        }

        return round($decimalLatitude, 7);
    }

    function convertLongitude($longitude, $longitudeDirection)
    {
        $degrees = intval(substr($longitude, 0, 3));
        $minutes = floatval(substr($longitude, 3)) / 60;

        $decimalLongitude = $degrees + $minutes;

        if ($longitudeDirection === 'W') {
            $decimalLongitude = -$decimalLongitude;
        }

        return round($decimalLongitude, 7);
    }

    // Konversi format latitude dan longitude
    $decimalLatitude = convertLatitude($latitude, $latitudeDirection);
    $decimalLongitude = convertLongitude($longitude, $longitudeDirection);



    // Simpan ke database atau lakukan tind

    $query = "INSERT INTO gps_data (waktu, latitude, longitude) VALUES ('$waktu','$decimalLatitude', '$decimalLongitude')";
    $result = mysqli_query($link, $query);
    if ($result) {
        echo "Data berhasil disimpan ke database";
    } else {
        echo "Gagal menyimpan data ke database: " . mysqli_error($link);
    }

    // kirim ke server

    $array = array(
        'waktu' => $waktu,
        'latitude' => $decimalLatitude,
        'longitude' => $decimalLongitude
    );

    $jsonData = json_encode($array);
    print_r($jsonData);

    $url = 'http://secure.getsensync.com/kaltara/api/insert_gps.php';



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
} else {
    echo "Error: Data tidak valid\n";
}
