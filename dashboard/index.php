<?php
include "layout/header.php";
include "koneksi/konek.php";
date_default_timezone_set('Asia/Ujung_Pandang');
$tgll = date('Y-m-d H:i:s');
$tgl = date('Y-m-d');
ini_set('display_errors', 1);
?>

<body>
	<div class="wrapper">
		<?php
		include "layout/navbar.php";
		?>

		<!-- Sidebar -->
		<?php
		include "layout/sidebar.php";
		?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-warning-gradient">
					<div class="page-inner py-5">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white pb-2 fw-bold">Dashboard </h2>
							</div>
							<div class="ml-auto">
								<?php
								$select = "SELECT * FROM gps_data ORDER BY waktu desc Limit 1";
								$query = mysqli_query($link, $select);
								$data = mysqli_fetch_array($query);
								?>
								<h5 class="text-white op-7 mb-2"> Latitude : <?= $data['latitude'] ?></h5>
								<h5 class="text-white op-7 mb-2"> Longitude : <?= $data['longitude']?></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--5">

					<div id="tabel"></div>




				</div>
			</div>
			<?php
			include "layout/footer.php";
			?>

			<script type="text/javascript">
				$('#tabel').load('loaddata/loaddashboard.php')
				$(document).ready(function() {
					setInterval(function() {
						$('#tabel').load('loaddata/loaddashboard.php')
					}, 50000);
				});
			</script>
</body>

</html>