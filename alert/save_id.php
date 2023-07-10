<?php
// Konfigurasi koneksi database
$servername = "localhost";
$username = "root";
$password = "makanminggu12";
$dbname = "quakaltaradb";

// Mengambil data dari API Telegram
$url = "https://api.telegram.org/bot5787365441:AAHFRDMMTc1eHJ9Vqtn0mKxCKR8sBV4GN_k/getupdates";
$data = file_get_contents($url);
$result = json_decode($data, true);

// Memeriksa apakah ada pesan yang diterima
if (isset($result['result'])) {
    $messages = $result['result'];

    // Menghubungkan ke database
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    // Memproses setiap pesan
    foreach ($messages as $message) {
        // Mendapatkan chat_id dan nama pengirim
        $chat_id = $message['message']['chat']['id'];
        $name = $message['message']['from']['first_name'];

        // Memeriksa apakah chat_id sudah ada dalam database
        $sql = "SELECT * FROM user_telegram WHERE chat_id = '$chat_id'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            // Jika chat_id belum ada, menyimpan data ke database
            $sql = "INSERT INTO user_telegram (chat_id, nama) VALUES ('$chat_id', '$name')";
            if ($conn->query($sql) === TRUE) {
                echo "Data berhasil disimpan.";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Chat ID sudah ada, data tidak perlu disimpan lagi.";
        }
    }

    $conn->close();
} else {
    echo "Tidak ada pesan yang diterima.";
}
?>