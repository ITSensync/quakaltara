<div class="main-header">
	<!-- Logo Header -->
	<!-- <div class="logo-header" data-background-color="blue" > -->
	<div class="logo-header" data-background-color="orange2">
		<a href="" class="logo">
			<img src="../assets/img/ioh2.png" alt="navbar brand" class="navbar-brand img-fluid " width="150px">
			<!-- <p class="navbar-brand" alt="navbar brand" style="color: white; font-weight:bold;">QUA KALTARA -->
			</p>

		</a>
		<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon">
				<i class="icon-menu"></i>
			</span>
		</button>
		<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
		<div class="nav-toggle">
			<button class="btn btn-toggle toggle-sidebar">
				<i class="icon-menu"></i>
			</button>
		</div>
	</div>
	<!-- End Logo Header -->

	<!-- Navbar Header -->
	<nav class="navbar navbar-header navbar-expand-lg" data-background-color="orange">

		<div class="container-fluid">
			<div class="collapse" id="search-nav">
				<form class="navbar-left navbar-form">
					<div class="input-group">
						<div class="input-group-prepend">


						</div>
						<a id="date_time" href="#" style="color:white; font-weight:bold;" class=" navbar-expand-lg"> </a>
						<script type="text/javascript">
							window.onload = date_time('date_time');
						</script>

						</a>



					</div>
				</form>
			</div>

			<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
				</li>
				<?php
					include "koneksi/konek.php";

					$bat = "SELECT soc FROM tb_status ORDER by waktu DESC LIMIT 1";
					$query = mysqli_query($link, $bat);
					$data = mysqli_fetch_array($query);
					?>
				<li class="nav-item dropdown hidden-caret">
					
					<p class="nav-link" style="font-size:19px; "><i class="fa fa-battery-three-quarters" aria-hidden="true" style="color:#ec008c;"></i> <?= $data['soc'];?> % </p>
				</li>
				<li class="nav-item dropdown hidden-caret">
					<p class="nav-link" style="font-size:19px; "><i class="fa fa-map-marker fa-5x" style="color:#ec008c;"></i>Tarakan </p>
				</li>
			
			</ul>
		</div>
	</nav>
	<!-- End Navbar -->
</div>