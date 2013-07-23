<!DOCTYPE HTML>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domotique</title>
    <meta http-equiv="refresh" content="300" >

 <?php
define('ROOT', dirname(__FILE__) . '/');
require_once (ROOT.'include/init.php');

$sonde_id = $_GET['sonde_id'];
if ($sonde_id && !preg_match('/^[0-9]+$/', $sonde_id))	{
		die('</head><body>Paramètre sonde_id manquant ou erroné: '.$sonde_id."</body></html>");  
		}

$sql = "SELECT t_sondes.nom as nom, t_sondes.label_unite as unite, t_sondes.y_axe_max as y_axe_max, t_sondes.y_axe_min as y_axe_min, t_zones.nom AS zone, t_sondes.description as description, t_grandeurs.nom AS grandeur
FROM (t_sondes LEFT JOIN t_zones ON t_sondes.zone_id = t_zones.id) LEFT JOIN t_grandeurs ON t_sondes.grandeur_id = t_grandeurs.id WHERE t_sondes.id ='$sonde_id'";

$result = mysqli_query($DBCon,$sql) or die ("Echec de la requête: " . mysqli_error($DBCon));
$row = mysqli_fetch_array($result) or die ("pas de sonde déclarée avec un id:".$sonde_id);
$sonde_nom=utf8_encode($row["nom"]);
$sonde_unite=utf8_encode($row["unite"]);
$sonde_zone=utf8_encode($row["zone"]);
$y_axe_min=$row["y_axe_min"];
$y_axe_max=$row["y_axe_max"];
$sonde_description=str_replace("'","\'",utf8_encode($row["description"]));
$sonde_grandeur=utf8_encode($row["grandeur"]);

mysqli_close($DBCon); 
?>

    <!-- JS & CSS library includes for jQuerry -->
   	<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" /> 
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
   
    	
	<!-- JS & CSS library includes for Bootstrap -->
	<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
	<style type="text/css">
	      body {
	        padding-top: 60px;
	        padding-bottom: 40px;
			color:white;
			background-color:black;
			background-image:url(img/background.png);
	      }
	      .sidebar-nav {
	        padding: 9px 0;
	      }
	
	

	      @media (max-width: 980px) {
	        /* Enable use of floated navbar text */
	        .navbar-text.pull-right {
	          float: none;
	          padding-left: 5px;
	          padding-right: 5px;
	        }
	      }
		</style>
	    
	<!-- JS & CSS library includes for highstocks -->  
    <script src="http://code.highcharts.com/stock/highstock.js"></script>
	<script src="http://code.highcharts.com/stock/highcharts-more.js"></script>
    <script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
	<script src="js/highcharts-gray-thomas.js"></script>
	<!-- JS HIGHSTOCKS CODE -->
     <script type="text/javascript">
	$(function() {
		
		var chart;
		var start = new Date();// Create a timer
		
		// ************** general chart options *****************
		var general_options = {};
		
		general_options.lang = {
			months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
			weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
			decimalPoint: ",",
			downloadPNG: "Télécharger en image PNG",
			downloadJPEG: "Télécharger en image JPEG",
			downloadPDF: "Télécharger en document PDF",
			downloadSVG: "Télécharger en document Vectoriel",
			exportButtonTitle: "Export du graphique",
			loading: "Chargement en cours...",
			printChart: "Imprimer le graphique",
			resetZoom: "Réinitialiser le zoom",
			resetZoomTitle: "Réinitialiser le zoom au niveau 1:1",
			thousandsSep: ".",
			rangeSelectorFrom: "Du",
			rangeSelectorTo: "à",
			};
		
		general_options.global = {
			useUTC: false
			};			
		
		Highcharts.setOptions(general_options);		
		
		// ************** chart options *****************
		var options = {};	
			
		options.chart = {
			renderTo: 'container_chart',
			zoomType : 'x',
			events: {
					load: function(chart) {
						this.setTitle(null,{text: '<br>Graphe généré en '+ (new Date() - start)/1000 +'s'});
						//console.log(this);
						//showLastPointTooltip(this);
						},
					redraw: function(chart){
						//showLastPointTooltip(this);
						this.setTitle(null,{text: '<br>Graphe généré en '+ (new Date() - start)/1000 +'s'});
						showStat(this);
						}
					}
			};

		options.credits = {
			enabled: false
			}; 
			
		options.rangeSelector = {
			buttons : [
				{
					type: 'second',
					count: <?php echo (time() - strtotime("today")); ?>,
					text: '00h'
				},
				{
					type: 'day',
					count: 1,
					text: '24h'
				},
				{
					type: 'week',
					count: 1,
					text: '1s'
				},	{
					type: 'month',
					count: 1,
					text: '1m'
				}, {
					type: 'month',
					count: 3,
					text: '3m'
				}, {
					type: 'month',
					count: 6,
					text: '6m'
				}, {
					type: 'ytd',
					text: 'YTD'
				}, {
					type: 'year',
					count: 1,
					text: '1an'
				}, {
					type: 'all',
					text: 'Tout'
				}],
			selected : 7,
			inputDateFormat: '%d-%m-%Y',
			inputEditDateFormat: '%d-%m-%Y'
			};
			
		options.navigator = {
			adaptToUpdatedData: false,
			height: 30,
			series : {
				data : []						
				}
			};
					
		options.scrollbar = {
			liveRedraw: false //to avoid refreshing the chart when scrolling into date
			};
			
		options.xAxis = {
			type: 'datetime',
			//maxZoom: 1 * 1 * 3600*1000, // maximal zoom is 1 hour
			title: {
				text: 'Période'
				},
			lineWidth: 2,
			//minorTickInterval: 'auto',
			//minTickInterval: 5*60*1000,
			dateTimeLabelFormats: {
				day: '%e %B'
				},
			 events : {
				afterSetExtremes : afterSetExtremes
				},	
			};
					
		options.title = {
			//text : '<?php echo $sonde_description;?>',
			useHTML: true
			};
		
		options.yAxis = { // Primary yAxis
			labels: {
				formatter: function() {
					return this.value +'<?php echo $sonde_unite;?>';
					},
				startOnTick: false,
				minorTickInterval: 'auto',
				showFirstLabel: true,
				//style: {color: '#89A54E'}
				},
			//lineColor: 'red',
			lineWidth: 2,
			<?php
			 if (!is_null($y_axe_min)) { echo "min: $y_axe_min,\n";}
			 if (!is_null($y_axe_max)) {echo "\t\t\tmax: $y_axe_max,\n";}
			?>
			//maxPadding: 0.1,
			title: {
				text: '<?php echo $sonde_grandeur;?>',
				//style: {color: '#89A54E'}
				}	
			};
		
		options.tooltip = {
			shared: true,
			valueSuffix: '<?php echo $sonde_unite;?>'
			//crosshairs: [true, true], 
			/*formatter: function() {
				var text = '<b>'+ Highcharts.dateFormat('%A %e %B %Y à %H:%M:%S', this.x) +'</b>';
				text += '<br/><b> Zone: <?php echo $sonde_zone;?></b>';
				text += '<br/> <?php echo $sonde_grandeur;?>: '+ this.points[0].y +' <?php echo $sonde_unite;?>';
				console.dir (this);
				text += '<br/> Min: '+ this.points[1].point.low +' <?php echo $sonde_unite;?>';
				text += '<br/> Max: '+ this.points[1].point.high +' <?php echo $sonde_unite;?>';
				return text;
				}*/
			};
			
		options.legend = {
			enabled: true,
			borderWidth: 2,
			align: 'center',
			borderColor: 'black',
			backgroundColor: '#FCFFC5',
			verticalAlign: 'top',
			shadow: true,
			itemStyle: {
				color: '#000000',
				fontWeight: 'bold',
				fontSize: '16px'
				}
			};
					
		options.series = [
			{
				data : [],
				name : '<?php echo $sonde_description;?>',
				type:'<?php 
					if ($sonde_grandeur<>"Compteur") {
						echo 'spline';
					}
					else {	
						echo 'column';
					}
					?>',
				dataGrouping: {
	                groupPixelWidth: 40,
	                //approximation: "average",
	                enabled: true,
	                units: [
	                    ['minute',[5, 10, 15, 30]],
	                    ['hour',[1,6,12,24]],
	                    ['day',[1]],
	                    ['week',[1]],
	                    ['month',[1]],
	                    ]
		        	},
        	
				tooltip: {
					valueDecimals: 2
					},
				zIndex: 1	
			}, {
				data :[],
				name : 'Range',
				type : 'arearange',
				linkedTo: ':previous',
				fillOpacity: 0.3,
		    	zIndex: 0
			}
			];
		
		//console.log(options);
						
		// *************** Data collecting ****************
		var url = 'sonde_exp_json.php?sonde_id=<?php echo $sonde_id?>&callback=a' ; 
			
		console.log ('initial:' + url);
		
		$.getJSON(url, function (json_data) {
			console.log (json_data);
			//console.log (JSON.stringify(json_data));
			options.series[0].data = json_data.average;
			options.navigator.series = json_data.average;
			//console.log ('series[0]');
			//console.log(options.series[0].data);
			//console.log ('Nb points:' + (options.series[0].data.length-1));
			
			if (typeof json_data.range != 'undefined') {
				options.series[1].data = json_data.range;
				//console.log ('series[1]');
				//console.log(options.series[1].data);
				}
			
			// *************** chart creation ******************		
			chart = new Highcharts.StockChart(options,
				function(chart){
					// apply the date pickers
					 setTimeout(function(){
						$('input.highcharts-range-selector', $('#'+chart.options.chart.renderTo)).datepicker()},0)	;
					showStat(chart);
					//showLastPointTooltip(chart);
					}
			);
		}); //end getJSON
	
		// Set the datepicker's date format
		$.datepicker.setDefaults({
			//dateFormat: 'yy-mm-dd',
			dateFormat: 'dd-mm-yy',
			dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"],
			monthNames: [ "Janvier", "Février", "MArs", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre" ],
			dayNames: [  "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
			firstDay: 1,
			onSelect: function(dateText) {
				this.onchange();
				this.onblur();
				console.log (dateText);
				}
			});
			
		// Get data update after zoom	
		function afterSetExtremes(e) {
			
			chart.setTitle(null,{text: null});
			start = new Date();
			var currentExtremes = this.getExtremes(),range = e.max - e.min;
			url = 'sonde_exp_json.php?sonde_id=<?php echo $sonde_id?>&start='+ Math.round(e.min) + '&end='+ Math.round(e.max) +'&callback=a' ;  
			//console.log ('AfterSetExtremes:' + url);
			$.getJSON(url, function(json_data) {
				//chart.showLoading('Chargement des données...');	
				//console.log (json_data);
				chart.series[0].setData(json_data.average);
				if (typeof json_data.range != 'undefined') chart.series[1].setData(json_data.range);
				//console.log ('Nb points:' + (chart.series[0].data.length-1));
				});
			//showLastPointTooltip(chart);	
			//chart.setTitle(null,{text: '<br>Graphe généré en '+ (new Date() - start) +'ms'});
			//chart.hideLoading();
			}
						
		// show tooltip for last point   
		function showLastPointTooltip(objHighStockchart){
			var i=0;
			var objHighStockchart
			if(objHighStockchart)	{
				i = objHighStockchart.series[0].data.length-1;
				console.log ('Nb points:' + i);
				//console.log(objHighStockchart.series[0].data);
				objHighStockchart.tooltip.refresh([objHighStockchart.series[0].points[i]]);
				}
			}					
		
		// compute and show stats for displayed datapoints
		function showStat(objHighStockchart) {
			//Average computation	
			var seriesAvg=0;
			var seriesMin=Math.min.apply(null, objHighStockchart.series[0].yData);
			var seriesMax=Math.max.apply(null, objHighStockchart.series[0].yData);
			var i=0
			var total=0;
			for (i = 0; i < objHighStockchart.series[0].yData.length; i++) {
				total += objHighStockchart.series[0].yData[i];
				}
			seriesAvg = (total / objHighStockchart.series[0].yData.length).toFixed(2); // fix decimal to 4 places
			$('#container_stat').html(
				'<b>Minimum:</b>: ' + seriesMin + '<?php echo $sonde_unite;?><br>'+
				'<b>Moyenne:</b>: '+ seriesAvg + '<?php echo $sonde_unite;?><br>'+
				'<b>Maximum:</b>: ' + seriesMax + '<?php echo $sonde_unite;?><br>'+
				<?php
				if (($sonde_grandeur=='Compteur')) echo "'<b>Total:</b>: ' + (total).toFixed(2) + '$sonde_unite<br>'+"; //total displayed only for some types of probes
				?>
				'<b>Sonde_id</b>: <?php echo $sonde_id;?><br>' 
				);
			}
	}); // end of jQuery
	</script>

	</head>
<body>

<?php
define('ROOT', dirname(__FILE__) . '/');
require_once (ROOT.'include/navbar.php');
?>
  
    <div id="container_chart" style="height: 400px; min-width: 500px"></div>
	<div id="container_stat" </div>
  </body>
</html>
