<?php
include "../layout/header.php";
include "../koneksi/konek.php";
date_default_timezone_set('Asia/Ujung_Pandang');
$tgll = date('Y-m-d H:i:s');
$tgl = date('Y-m-d');
ini_set('display_errors', 1);


$jparam = 5;
$param = array("PH", "DO", "SALINITY", "NITRITE", "TEMPERATURE");
$field = array("ph", "do", "sal", "no2", "temp");


$query = "SELECT * FROM `maintb_data` ORDER BY `waktu` DESC LIMIT 1";
$ambil = mysqli_query($link, $query);
$r = mysqli_fetch_array($ambil);
?>

<div class="row mt--2">
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-4 mt-4">
						<div class="icon-big text-center">
							<i class="fas fa-tint fa-2x"></i>
						</div>
					</div>

					<div class="col-8">
						<div class="card-title "> PH </div>
						<div class="card-category"> BM PH : 6 -9 </div>
						<p style="font-size: 40px;"><?= $r['ph']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-4 mt-4">
						<div class="icon-big text-center">
							<i class="fas fa-tint-slash fa-2x"></i>
						</div>
					</div>

					<div class="col-8">
						<div class="card-title "> SALINITY </div>
						<div class="card-category"> BM SAL : ? </div>
						<p style="font-size: 40px;"><?= $r['sal']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-4 mt-4">
						<div class="icon-big text-center">
							<i class="fas fa-flask fa-2x"></i>
						</div>
					</div>

					<div class="col-8">
						<div class="card-title "> DO </div>
						<div class="card-category"> BM DO : ? ppm </div>
						<p style="font-size: 40px;"><?= $r['do']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-4 mt-4">
						<div class="icon-big text-center">
							<span class="material-icons" style="font-size: 40px;">
								hub
							</span>
						</div>
					</div>

					<div class="col-8">
						<div class="card-title "> NITRITE </div>
						<div class="card-category"> BM NITRITE : ? ppm </div>
						<p style="font-size: 40px;"><?= $r['no2']; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-4 mt-4">
						<div class="icon-big text-center">
							<span class="material-symbols-outlined" style="font-size: 40px;">
							device_thermostat
							</span>
						</div>
					</div>

					<div class="col-8">
						<div class="card-title "> TEMP </div>
						<div class="card-category">  </div>
                      <p style="font-size: 40px;"><?= $r['temp']; ?> <span> &deg; </span></p>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<div class="row">
	<div class="col-md-8">
		<div class="card-grafik">
			<div class="card-header">
				<div class="card-head-row">
					<div class="card-title">QUA KALTARA</div>
				</div>
			</div>
			<div id="chart02"></div>
		</div>
	</div>
	 <div class="col-md-4">
		<div class="card card-warning">
			<div class="card-body">
				<div class="row">
					<div class="col-4 mt-4">
						<div class="icon-big tet-center">
							<span class="material-icons" style="font-size: 60px;">
								water
							</span>
						</div>
					</div>

					<div class="col-8">
						<div class="card-title "> WATER LEVEL </div>
                      <p style="font-size: 40px;"><?= $r['level']; ?><span>cm </span></p>
					</div>

				</div>
			</div>
		</div>

	</div> 
</div>

<script type='text/javascript'>
	Highcharts.getJSON(
		'https://cdn.jsdelivr.net/gh/highcharts/highcharts@v7.0.0/samples/data/usdeur.json',
		function(data) {

			Highcharts.chart('chart02', {

				chart: {
					zoomType: 'x',
					// backgroundColor: 'rgba(4, 2, 2, 0.142)',
					height: 300,
					color: '#fff'

				},
				title: {
					text: 'Chart',
					style: {
						'color': '#fff',
					}
				},

				xAxis: {
					type: 'datetime',
					dateTimeLabelFormats: {
						month: '%H:%M:%S',
						year: '%b',
					},
					labels: {
						style: {
							color: '#fff'
						}
					},
					title: {
						text: 'Date'
					}
				},
				yAxis: {
					title: {
						text: 'values',

					},
					labels: {
						style: {
							color: '#fff'
						}
					},

				},
				legend: {
					enabled: true,
					labels: {
						style: {
							color: '#fff'
						}
					},
				},
				plotOptions: {
					area: {
						fillColor: {
							linearGradient: {
								x1: 2,
								y1: 0,
								x2: 0,
								y2: 1
							},
							stops: [
								[0, Highcharts.getOptions().colors[0]],
								[1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(1).get('rgba')]
							]
						},
						marker: {
							radius: 2
						},
						lineWidth: 3,
						states: {
							hover: {
								lineWidth: 3
							}
						},
						threshold: null
					}
				},

				series: [

					<?php
					for ($i = 0; $i < $jparam; $i++) {
					?> {
							type: 'line',
							name: '<?php echo $param[$i] ?>',
							data: [
								<?php
								$select = mysqli_query($link, "SELECT *, SUBSTR(`waktu`,1,4) AS y, SUBSTR(`waktu`,6,2)-1 AS mm, SUBSTR(`waktu`,9,2) AS dd, SUBSTR(`waktu`,12,2) AS j, SUBSTR(`waktu`,15,2) AS m, SUBSTR(`waktu`,18,2) AS d FROM ( SELECT * FROM `maintb_data` WHERE `waktu` LIKE '%$tgl%'  ORDER BY `waktu` DESC ) sub ORDER BY `waktu` ASC");
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
		}
	);
</script>