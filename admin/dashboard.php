<?php
include "../koneksi/koneksi.php";
ini_set('display_errors', 1);

date_default_timezone_set('Asia/Ujung_Pandang');

$tgll = date('Y-m-d H:i:s');
$tgl = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $no2_formula = $_POST['no2_formula'];
    $ph_formula = $_POST['ph_formula'];
    $sal_formula = $_POST['sal_formula'];
    $do_formula = $_POST['do_formula'];
    $level_formula = $_POST['level_formula'];


    $sql = "INSERT into formula (waktu, no2_formula, ph_formula, sal_formula, do_formula, level_formula) 
    VALUES ('$tgll', '$no2_formula','$ph_formula','$sal_formula','$do_formula','$level_formula' )";

    if (mysqli_query($link, $sql)) {
        echo '<script>
                    window.onload = function() {
                        setTimeout(function() {
                            alert("Faktor koreksi berhasil disimpan.");
                        }, 2000); // Mengatur waktu penutupan alert (dalam milidetik)
                    }
                  </script>';
    } else {
        echo "Terjadi kesalahan saat menyimpan formula: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- datatables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.9.1/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.bulma.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.highcharts.com/media/com_demo/css/highslide.css">

    <title>Data Qua Kaltara</title>
</head>

<body>
    <div class="row">
        <?php
        include "nav.php";
        ?>
    </div>

    <div class="container-fluid">

        <div class="row mt-5">
            <!--RAW STATUS -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">RAW STATUS</h1>
                        <table id="example2" class="table is-striped responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">TEMP</th>
                                    <th scope="col">HUM</th>
                                    <th scope="col">PRESS</th>
                                    <th scope="col">PV</th>
                                    <th scope="col">BAT</th>
                                    <th scope="col">SOC</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php


                                $query = "SELECT * FROM `tb_status` WHERE  `waktu` LIKE '%$tgl%' ORDER BY `waktu` DESC";

                                $selek = mysqli_query($link, $query);

                                $k = 1;


                                while ($data = mysqli_fetch_array($selek)) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $k++; ?></th>
                                        <td><?php echo $data["waktu"]; ?></td>
                                        <td><?php echo $data["temp"]; ?></td>
                                        <td><?php echo $data["hum"]; ?></td>
                                        <td><?php echo $data["press"]; ?></td>
                                        <td><?php echo $data["pv"]; ?></td>
                                        <td><?php echo $data["bat"]; ?></td>
                                        <td><?php echo $data["soc"]; ?></td>

                                    </tr>
                                <?php
                                }

                                ?>
                            </tbody>

                        </table>


                    </div>
                </div>
            </div>

            <!--  raw data-->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">RAW DATA</h1>
                        <table id="example" class="table is-striped responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">NO</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">PH</th>
                                    <th scope="col">DO</th>
                                    <th scope="col">SAL</th>
                                    <th scope="col">NO2</th>
                                    <th scope="col">TEMP</th>
                                    <th scope="col">LEVEL</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php


                                $query = "SELECT * FROM `tb_data` WHERE  `waktu` LIKE '%$tgl%' ORDER BY `waktu` DESC";

                                $selek = mysqli_query($link, $query);

                                $k = 1;


                                while ($data = mysqli_fetch_array($selek)) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $k++; ?></th>
                                        <td><?php echo $data["waktu"]; ?></td>
                                        <td><?php echo $data["ph"]; ?></td>
                                        <td><?php echo $data["do"]; ?></td>
                                        <td><?php echo $data["sal"]; ?></td>
                                        <td><?php echo $data["no2"]; ?></td>
                                        <td><?php echo $data["wtemp"]; ?></td>
                                        <td><?php echo $data["level"]; ?></td>

                                    </tr>
                                <?php
                                }

                                ?>
                            </tbody>

                        </table>


                    </div>
                </div>
            </div>
        </div>


        <!-- tabel data -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">DATA PER 30 MNT</h>
                            <table id="example3" class="table is-striped responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">NO</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">PH</th>
                                        <th scope="col">DO</th>
                                        <th scope="col">SAL</th>
                                        <th scope="col">NO2</th>
                                        <th scope="col">TEMP</th>
                                        <th scope="col">LEVEL</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php


                                    $query = "SELECT * FROM `maintb_data` WHERE  `waktu` LIKE '%$tgl%' ORDER BY `waktu` DESC";

                                    $selek = mysqli_query($link, $query);

                                    $k = 1;


                                    while ($data = mysqli_fetch_array($selek)) {
                                    ?>
                                        <tr>
                                            <th scope="row"><?php echo $k++; ?></th>
                                            <td><?php echo $data["waktu"]; ?></td>
                                            <td><?php echo $data["ph"]; ?></td>
                                            <td><?php echo $data["do"]; ?></td>
                                            <td><?php echo $data["sal"]; ?></td>
                                            <td><?php echo $data["no2"]; ?></td>
                                            <td><?php echo $data["temp"]; ?></td>
                                            <td><?php echo $data["level"]; ?></td>

                                        </tr>
                                    <?php
                                    }

                                    ?>
                                </tbody>

                            </table>


                    </div>
                </div>
            </div>

        </div>
    </div>

</body>

</html>


<script src="https://code.jquery.com/jquery-3.2.1.slim.js" integrity="sha256-tA8y0XqiwnpwmOIl3SGAcFl2RvxHjA8qp0+1uCGmRmg=" crossorigin="anonymous"></script>


<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bulma.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.bulma.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bulma.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            lengthChange: true,
            buttons: ['excel', 'pdf']
        });

        // Insert at the top left of the table
        table.buttons().container()
            .appendTo($('div.column.is-half', table.table().container()).eq(0));
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            lengthChange: true,
            buttons: ['excel', 'pdf']
        });

        // Insert at the top left of the table
        table.buttons().container()
            .appendTo($('div.column.is-half', table.table().container()).eq(0));
    });
</script>
<script>
    $(document).ready(function() {
        var table = $('#example3').DataTable({
            lengthChange: true,
            buttons: ['excel', 'pdf']
        });

        // Insert at the top left of the table
        table.buttons().container()
            .appendTo($('div.column.is-half', table.table().container()).eq(0));
    });
</script>