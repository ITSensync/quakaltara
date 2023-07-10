<?php
ini_set('display_errors', 1);
include "../koneksi/koneksi.php";

date_default_timezone_set('Asia/Ujung_Pandang');
$tgl = date("Y-m-d H:i:s");

$ids = $_GET['id'];



if ($ids == "") {
    echo "idnya isi dong";
} else {
    if ($ids == "status") {
        $status = "status";
        $temp = $_GET['temp'];
        $hum = $_GET['hum'];
        $press = $_GET['press'];
        $pv = $_GET['pv'];
        $bat = $_GET['bat'];
        $soc = $_GET['soc'];


        $statusArray = array(
            'id' => $status,
            'waktu' => $tgl,
            'temp' => $temp,
            'hum' => $hum,
            'press' => $press,
            'pv' => $pv,
            'bat' => $bat,
            'soc' => $soc
        );
        $statusJson = json_encode($statusArray);
        print_r($statusJson);
        $url = 'http://secure.getsensync.com/kaltara/api/insert_raw.php'; // Ganti dengan URL yang sesuai

        // Inisialisasi cURL
        $ch = curl_init();

        // Set konfigurasi cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $statusJson);
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
        echo $response . '<br>';

        $insert_status = "INSERT INTO `tb_status` (waktu, temp, hum, press, pv, bat, soc)
                                    VALUES ('$tgl',
                                            '$temp',
                                            '$hum',
                                            '$press',
                                            '$pv',
                                            '$bat',
                                            '$soc')";
        $asd = mysqli_query($link, $insert_status);
        if ($asd) {
            echo "received";
        } else {
            echo "gagal bos";
        }
    } elseif ($ids == "data") {
        $data = "data";

        $ph = $_GET['ph'];
        $do = $_GET['do'];
        $sal = $_GET['sal'];
        $no2201 = $_GET['no2'];
        $level = $_GET['level'];
        $wtemp = $_GET['wtemp'];
        $phStatus = $_GET['phStatus'];
        $doStatus = $_GET['doStatus'];
        $salStatus = $_GET['salStatus'];
        $no2Status =   $_GET['no2Status'];
        $tempStatus = $_GET['tempStatus'];

      
      	
      	
      	$no2_formula = ROUND($no2201/10 ,2);
     	
      
        $dataArray = array(
            'id' => $data,
            'waktu' => $tgl,
            'ph' => $ph,
            'do' => $do,
            'sal' => $sal,
            'no2' => $no2_formula,
            'level' => $level,
            'wtemp' => $wtemp
        );
        $dataJson = json_encode($dataArray);
        print_r($dataJson);
        $url = 'http://secure.getsensync.com/kaltara/api/insert_raw.php'; // Ganti dengan URL yang sesuai

        // Inisialisasi cURL
        $ch = curl_init();

        // Set konfigurasi cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
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
        echo $response . '<br>';


        $insert_data = "INSERT INTO `tb_data` (waktu, ph,do,sal,no2,`level`,wtemp,phStatus,doStatus,salStatus,no2Status,tempStatus)
                                    VALUES ('$tgl',
                                            '$ph',
                                            '$do',
                                            '$sal',
                                            '$no2_formula',
                                            '$level',
                                            '$wtemp',
                                            '$phStatus',
                                            '$doStatus',
                                            '$salStatus',
                                            '$no2Status',
                                            '$tempStatus')";
        $asd = mysqli_query($link, $insert_data);
        if ($asd) {
            echo "received <br>";
        } else {
            echo "gagal";
        }
    }
}

// insert status


// insert data