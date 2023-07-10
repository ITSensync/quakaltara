<?php
include "../layout/header.php";
include "../koneksi/konek.php";
date_default_timezone_set('Asia/Ujung_Pandang');
$tgll = date('Y-m-d H:i:s');
$tgl = date('Y-m-d');
ini_set('display_errors', 1);

// if ((isset($_SESSION['sparingpwk']) == true) && (isset($_SESSION['username']) != "") && (isset($_SESSION['id_device']) != "")) {
// 	$ids = $_SESSION['id_device'];
// 	$ss = mysqli_query($link, "SELECT * FROM `device_tbl_2` WHERE id_device='$ids'");
// 	$d = mysqli_fetch_array($ss);

// 	$nama = $d['tempat'];
// 	$tb = $d['id_device'];

// 	// kepala();

// 	$jparam = 5;
// 	$param = array("cod", "tss", "nh3n", "ph", "debit");
// 	$field = array("cod", "tss", "nh3n", "ph", "debit2");
// } else {
// 	echo "<script>alert('Gagal Login Silahkan Ulangi Kembali');
//                           document.location.href='index.php';</script>";
// }

// $query = "SELECT * FROM $tb ORDER BY `time` DESC LIMIT 1";
// $ambil = mysqli_query($link, $query);
// $r = mysqli_fetch_array($ambil);
?>

<body>
	<div class="wrapper">
		<?php
		include "../layout/navbar.php";
		?>

		<!-- Sidebar -->
		<?php
		include "../layout/sidebar.php";
		?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-warning-gradient">
				<!-- <div class="panel-header bg-primary-gradient"> -->
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">Dashboard </h2>
								<!-- <h5 class="text-white op-7 mb-2"></h5> -->
							</div>

						</div>
					</div>
				</div>
				<div class="page-inner mt--5">

					<div id="tabel"></div>




				</div>
			</div>
			<?php
			include "../layout/footer.php";
			?>

			<script type="text/javascript">
				$('#tabel').load('../loaddata/loaddashboard.php')
				$(document).ready(function() {
					setInterval(function() {
						$('#tabel').load('../loaddata/loaddashboard.php')
					}, 50000);
				});
			</script>
</body>

</html>