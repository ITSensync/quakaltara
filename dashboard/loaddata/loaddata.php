<?php
include "../layout/header.php";
include "../koneksi/konek.php";
date_default_timezone_set('Asia/Jakarta');
$tgll = date('Y-m-d H:i:s');
$tgl = date('Y-m-d');
ini_set('display_errors', 1);

if ((isset($_SESSION['sparingpwk']) == true) && (isset($_SESSION['username']) != "") && (isset($_SESSION['id_device']) != "")) {
    $ids = $_SESSION['id_device'];
    $ss = mysqli_query($link, "SELECT * FROM `device_tbl_2` WHERE id_device='$ids'");
    $d = mysqli_fetch_array($ss);

    $nama = $d['tempat'];
    $tb = $d['id_device'];

    // kepala();

    $jparam = 1;
    $jparam2 = 1;
    $jparam3 = 1;
    $jparam4 = 1;
    $jparam5 = 1;

    $param = array("TSS");
    $param2 = array("COD");
    $param3 = array("PH");
    $param4 = array("NH3N");
    $param5 = array("DEBIT");
    $field = array("tss");
    $field2 = array("cod");
    $field3 = array("ph");
    $field4 = array("nh3n");
    if ($_SESSION['id_device'] == "ipci") {
        echo $field5 = array("debit");
    } else {
        $field5 = array("debit2");
    }
} else {
    echo "<script>alert('Gagal Login Silahkan Ulangi Kembali');
                          document.location.href='index.php';</script>";
}
?>
<div class="row">
    <div class="col-lg-6 col-xlg-9 col-md-7">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">COD</div>
                </div>
            </div>
            <div class="card-body">

                <div id="cod"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xlg-9 col-md-7">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">TSS</div>
                </div>
            </div>
            <div class="card-body">

                <div id="tss"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xlg-9 col-md-7">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">PH</div>
                </div>
            </div>
            <div class="card-body">

                <div id="ph"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xlg-9 col-md-7">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">NH3n</div>
                </div>
            </div>
            <div class="card-body">

                <div id="nh3n"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Sparing</div>
                </div>
            </div>
            <div class="card-body">

                <div id="debit"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="example" class="table is-striped responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">PH</th>
                            <th scope="col">TSS</th>
                            <th scope="col">COD</th>
                            <th scope="col">NH3N</th>
                            <th scope="col">DEBIT(m<sup>3</sup>)</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $query = "SELECT * FROM $tb WHERE  `time` LIKE '%$tgl%' ORDER BY `time` DESC";
                        // echo $query;
                        // echo $tb;
                        $selek = mysqli_query($link, $query);
                        $k = 1;
                        while ($data = mysqli_fetch_array($selek)) {
                            if ($data['ph'] == 0 || $data['ph'] > 15) {
                                $ph = "-";
                            } else {
                                $ph = $data['ph'];
                            }
                        ?>
                            <tr>
                                <th scope="row"><?php echo $k++; ?></th>
                                <td><?php echo $data["time"]; ?></td>
                                <td><?php echo $ph; ?></td>
                                <td><?php echo $data["tss"]; ?></td>
                                <td><?php echo $data["cod"]; ?></td>
                                <td><?php echo $data["nh3n"]; ?></td>
                                <td><?php if ($_SESSION['id_device'] == "ipci") {
                                        echo $data["debit"];
                                    } else {
                                        echo $data["debit2"];
                                    } ?></td>

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

<script type='text/javascript'>
    Highcharts.chart('cod', {
        chart: {
            type: 'spline'
        },
        title: {
            text: '<?php echo strtoupper($tb) ?>'
        },
        subtitle: {
            text: 'Baku Mutu COD 115'
        },

        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%H:%M:%S',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: 'values',
            },

            plotLines: [{
                    value: 115,
                    color: '#000000',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'Baku Mutu COD 115'
                    }
                }


            ]
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: 'Time {point.x: %Y-%m-%d %H:%M:%S} <br> Value {point.y:.2f}'
        },
        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        colors: ['#7AC29A'],
        series: [
            <?php
            for ($i = 0; $i < $jparam2; $i++) {
            ?> {
                    name: '<?php echo $param2[$i] ?>',
                    data: [
                        <?php
                        $select = mysqli_query($link, "SELECT *, SUBSTR(`time`,1,4) AS y, SUBSTR(`time`,6,2)-1 AS mm, SUBSTR(`time`,9,2) AS dd, SUBSTR(`time`,12,2) AS j, SUBSTR(`time`,15,2) AS m, SUBSTR(`time`,18,2) AS d FROM ( SELECT * FROM `$tb` WHERE `time` LIKE '%$tgl%'  ORDER BY `time` DESC ) sub ORDER BY `time` ASC");
                        while ($data = mysqli_fetch_array($select)) {
                            echo "[Date.UTC(" . $data['y'] . ", " . $data['mm'] . ", " . $data['dd'] . ", " . $data['j'] . ", " . $data['m'] . ", " . $data['d'] . "), " . $data[$field2[$i]] . "],";
                        }
                        ?>
                    ]
                },

            <?php
            }
            ?>
        ]
    });
</script>

<script type='text/javascript'>
    Highcharts.chart('ph', {
        chart: {
            type: 'spline'
        },
        title: {
            text: '<?php echo strtoupper($tb) ?>'
        },
        subtitle: {
            text: 'Baku Mutu PH Maks 9 - Min -6'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%H:%M:%S',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: 'values',
            },

            plotLines: [

                {
                    value: 9,
                    color: '#000000',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'Baku Mutu PH Maks 9'
                    }
                },
                {
                    value: 6,
                    color: '#000000',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'Baku Mutu PH Min 6 '
                    }
                }

            ]
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: 'Time {point.x: %Y-%m-%d %H:%M:%S} <br> Value {point.y:.2f}'
        },
        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        colors: ['#3d1fe4'],
        series: [
            <?php
            for ($i = 0; $i < $jparam3; $i++) {
            ?> {
                    name: '<?php echo $param3[$i] ?>',
                    data: [
                        <?php
                        $select = mysqli_query($link, "SELECT *, SUBSTR(`time`,1,4) AS y, SUBSTR(`time`,6,2)-1 AS mm, SUBSTR(`time`,9,2) AS dd, SUBSTR(`time`,12,2) AS j, SUBSTR(`time`,15,2) AS m, SUBSTR(`time`,18,2) AS d FROM ( SELECT * FROM `$tb` WHERE `time` LIKE '%$tgl%'  ORDER BY `time` DESC ) sub ORDER BY `time` ASC");
                        while ($data = mysqli_fetch_array($select)) {
                            echo "[Date.UTC(" . $data['y'] . ", " . $data['mm'] . ", " . $data['dd'] . ", " . $data['j'] . ", " . $data['m'] . ", " . $data['d'] . "), " . $data[$field3[$i]] . "],";
                        }
                        ?>
                    ]
                },

            <?php
            }
            ?>
        ]
    });
</script>

<script type='text/javascript'>
    Highcharts.chart('nh3n', {
        chart: {
            type: 'spline'
        },
        title: {
            text: '<?php echo strtoupper($tb) ?>'
        },
        subtitle: {
            text: 'Baku Mutu NHN-3 Maks 20 PPM'
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%H:%M:%S',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: 'values',
            },

            plotLines: [

                {
                    value: 20,
                    color: '#000000',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'Baku Mutu NHN-3 Maks 20 PPM'
                    }
                },


            ]
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: 'Time {point.x: %Y-%m-%d %H:%M:%S} <br> Value {point.y:.2f}'
        },
        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        colors: ['#000'],
        series: [
            <?php
            for ($i = 0; $i < $jparam4; $i++) {
            ?> {
                    name: '<?php echo $param4[$i] ?>',
                    data: [
                        <?php
                        $select = mysqli_query($link, "SELECT *, SUBSTR(`time`,1,4) AS y, SUBSTR(`time`,6,2)-1 AS mm, SUBSTR(`time`,9,2) AS dd, SUBSTR(`time`,12,2) AS j, SUBSTR(`time`,15,2) AS m, SUBSTR(`time`,18,2) AS d FROM ( SELECT * FROM `$tb` WHERE `time` LIKE '%$tgl%'  ORDER BY `time` DESC ) sub ORDER BY `time` ASC");
                        while ($data = mysqli_fetch_array($select)) {
                            echo "[Date.UTC(" . $data['y'] . ", " . $data['mm'] . ", " . $data['dd'] . ", " . $data['j'] . ", " . $data['m'] . ", " . $data['d'] . "), " . $data[$field4[$i]] . "],";
                        }
                        ?>
                    ]
                },

            <?php
            }
            ?>
        ]
    });
</script>

<script type='text/javascript'>
    Highcharts.chart('debit', {
        chart: {
            type: 'spline'
        },
        title: {
            text: '<?php echo strtoupper($tb) ?>'
        },
        subtitle: {
            text: 'm3/2 menit'
        },

        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%H:%M:%S',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: 'values',
            },

            plotLines: [




            ]
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: 'Time {point.x: %Y-%m-%d %H:%M:%S} <br> Value {point.y:.2f}'
        },
        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        colors: ['#ddf70c'],
        series: [
            <?php
            for ($i = 0; $i < $jparam5; $i++) {
            ?> {
                    name: '<?php echo $param5[$i] ?>',
                    data: [
                        <?php
                        $select = mysqli_query($link, "SELECT *, SUBSTR(`time`,1,4) AS y, SUBSTR(`time`,6,2)-1 AS mm, SUBSTR(`time`,9,2) AS dd, SUBSTR(`time`,12,2) AS j, SUBSTR(`time`,15,2) AS m, SUBSTR(`time`,18,2) AS d FROM ( SELECT * FROM `$tb` WHERE `time` LIKE '%$tgl%'  ORDER BY `time` DESC ) sub ORDER BY `time` ASC");
                        while ($data = mysqli_fetch_array($select)) {
                            echo "[Date.UTC(" . $data['y'] . ", " . $data['mm'] . ", " . $data['dd'] . ", " . $data['j'] . ", " . $data['m'] . ", " . $data['d'] . "), " . $data[$field5[$i]] . "],";
                        }
                        ?>
                    ]
                },

            <?php
            }
            ?>
        ]
    });
</script>

<script type='text/javascript'>
    Highcharts.chart('tss', {
        chart: {
            type: 'spline'
        },
        title: {
            text: '<?php echo strtoupper($tb) ?>'
        },
        subtitle: {
            text: 'Baku Mutu TSS 30'
        },

        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%H:%M:%S',
                year: '%b'
            },
            title: {
                text: 'Date'
            }
        },
        yAxis: {
            title: {
                text: 'values',
            },

            plotLines: [

                {
                    value: 30,
                    color: '#000000',
                    dashStyle: 'shortdash',
                    width: 2,
                    label: {
                        text: 'Baku Mutu TSS 30'
                    }
                }


            ]
        },
        tooltip: {
            headerFormat: '<b>{series.name}</b><br>',
            pointFormat: 'Time {point.x: %Y-%m-%d %H:%M:%S} <br> Value {point.y:.2f}'
        },
        plotOptions: {
            spline: {
                marker: {
                    enabled: true
                }
            }
        },

        colors: ['#e41f1f'],
        series: [
            <?php
            for ($i = 0; $i < $jparam; $i++) {
            ?> {
                    name: '<?php echo $param[$i] ?>',
                    data: [
                        <?php
                        $select = mysqli_query($link, "SELECT *, SUBSTR(`time`,1,4) AS y, SUBSTR(`time`,6,2)-1 AS mm, SUBSTR(`time`,9,2) AS dd, SUBSTR(`time`,12,2) AS j, SUBSTR(`time`,15,2) AS m, SUBSTR(`time`,18,2) AS d FROM ( SELECT * FROM `$tb` WHERE `time` LIKE '%$tgl%'  ORDER BY `time` DESC ) sub ORDER BY `time` ASC");
                        while ($data = mysqli_fetch_array($select)) {
                            echo "[Date.UTC(" . $data['y'] . ", " . $data['mm'] . ", " . $data['dd'] . ", " . $data['j'] . ", " . $data['m'] . ", " . $data['d'] . "), " . $data[$field[$i]] . "],";
                        }
                        ?>
                    ]
                },

            <?php
            }
            ?>
        ]
    });
</script>
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