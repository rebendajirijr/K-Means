<?php

require __DIR__ . '/../src/JR/KMeans/KMeans.php';

use JR\KMeans\KMeans;

$data = array(
	array(1, 2),
	array(2, 1),
	array(3, 3),
	array(1, 2),
	array(4, 3),
	array(2, 2),
	array(6, 9),
	array(1, 1),
	array(10, 6),
	array(5, 2),
	array(10, 9),
	array(7, 8),
);
//$data = array();
//for ($i = 0; $i < 20; $i++) {
//	$row = array();
//	for ($j = 0; $j < 2; $j++) {
//		$row[] = mt_rand(1, 50);
//	}
//	$data[] = $row;
//}
$clusterCount = 2;

$kMeans = new KMeans($data);

$clusteredData = $kMeans->cluster($clusterCount);
$plotData = array();
foreach (array_combine(range(0, $clusterCount - 1), $clusteredData) as $clusterIndex => $cluster) {
	$plotData[$clusterIndex] = array(
		'name' => 'Cluster ' . ($clusterIndex + 1),
		'data' => array(),
	);
	foreach ($cluster as $dataPointIndex => $dataPoint) {
		$plotData[$clusterIndex]['data'][$dataPointIndex] = array();
		foreach ($dataPoint as $val) {
			$plotData[$clusterIndex]['data'][$dataPointIndex][] = $val;
		}
	}
}
$plotData = json_encode($plotData);
//print_r($plotData);
//exit;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="http://code.highcharts.com/highcharts.js"></script>
	</head>
	<body>
		<!--<table>
		<?php foreach ($data as $dataPoint): ?>
			<tr>
				<?php foreach ($dataPoint as $val): ?>
				<td><?php echo $val; ?></td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
		</table>-->
		
		<div id="chartdiv" style="width: 900px; height: 500px;"></div>
		
		<script type="text/javascript">
			$(function () {
				$('#chartdiv').highcharts({
					chart: {
						type: 'scatter',
						zoomType: 'xy'
					},
					title: {
						text: 'Height Versus Weight of 507 Individuals by Gender'
					},
//					subtitle: {
//						text: 'Source: Heinz  2003'
//					},
					xAxis: {
						title: {
							enabled: true,
							text: 'x'
						},
						startOnTick: true,
						endOnTick: true,
						showLastLabel: true
					},
					yAxis: {
						title: {
							text: 'y'
						}
					},
					legend: {
						layout: 'vertical',
						align: 'left',
						verticalAlign: 'top',
						x: 100,
						y: 70,
						floating: true,
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
						borderWidth: 1
					},
					plotOptions: {
						scatter: {
							marker: {
								radius: 5,
								states: {
									hover: {
										enabled: true,
										lineColor: 'rgb(100,100,100)'
									}
								}
							},
							states: {
								hover: {
									marker: {
										enabled: false
									}
								}
							},
							tooltip: {
								headerFormat: '<b>{series.name}</b><br>',
								pointFormat: '{point.x} cm, {point.y} kg'
							}
						}
					},
					series: <?php echo $plotData; ?>
				});
			});
		</script>
	</body>
</html>