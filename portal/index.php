
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <meta http-equiv="refresh" content="300" >
<title>Domotique Thomas</title>
<meta name="viewport" content="user-scalable=no, initial-scale = 1, minimum-scale = 1, maximum-scale = 1, width=device-width">

<!-- JS & CSS library includes for jQuerry -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" />
    
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
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/stock/highcharts-more.js"></script>
<script src="http://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="js/highcharts-gray-thomas.js"></script>
<!-- JS HIGHSTOCKS CODE -->

<?php
define('ROOT', dirname(__FILE__) . '/');
require_once (ROOT.'include/navbar.php');
$f_last_measure = json_decode(file_get_contents('./data/dernieres_mesures_5.json'),TRUE);
?>

<script type="text/javascript">

$(function() {
// *************** chart 1 ******************	

	var options1 = {};	
	options1.chart = {
			renderTo: 'container_gauge1',
			type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
			};
			
	options1.title = {
		text: 'Temp. puit canadien'
		};
		
	options1.credits = {
		enabled: false
		}; 	
		
	options1.pane= {
        startAngle: -150,
        endAngle: 150
	    };
	    
	options1.yAxis= {
	        min: -20,
	        max: 50,	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#848484',	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#6E6E6E',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	            },
	        title: {
	            text: '°C',
	            margin: 20,
	            style: {
					color: 'black',
					fontWeight: 'bold'
					}
	            },
	        plotBands: [
	                {
			            from: -20,
			            to: -10,
			            color: '#08088A' // blue
	                }, 
	                {
			            from: -10,
			            to: 0,
			            color: '#045FB4' // blue
	                }, 
	                {
			            from: 0,
			            to: 15,
			            color: '#81F7BE' // green
	                 },
	                {
			            from: 15,
			            to: 25,
			            color: '#3ADF00' // green
	                 }, 
	                {
			        	from: 25,
			            to: 35,
			            color: '#FF8000' // yellow
	                 },
	                 {
			            from: 35,
			            to: 50,
			            color: '#DF5353' // red
	                }
	            ]        
	        };
	        
	options1.navigation = {
        buttonOptions: {
            enabled: false
            }
        }        
	
	options1.tooltip = {
		valueSuffix: ' °C'
		}
        
	options1.series= [{
	        name: 'Temp. Puit canadien',
	        data: [<?php echo $f_last_measure[7][2]?>]	        
	    }];	    
	      
		
	var chart = new Highcharts.Chart(options1);
	
	
// *************** chart 2 ******************	
	var options2 = {};	
	options2.chart = {
			renderTo: 'container_gauge2',
			type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
			};
			
	options2.title = {
		text: 'Temp. pulsion VMC'
		};
		
	options2.credits = {
		enabled: false
		}; 	
		
	options2.pane= {
        startAngle: -150,
        endAngle: 150
	    };
	    
	options2.yAxis= {
	        min: -20,
	        max: 50,	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#848484',	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#6E6E6E',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	            },
	        title: {
	            text: '°C',
	            margin: 20,
	            style: {
					color: 'black',
					fontWeight: 'bold'
					}
	            },
	        plotBands: [
	                {
			            from: -20,
			            to: -10,
			            color: '#08088A' // blue
	                }, 
	                {
			            from: -10,
			            to: 0,
			            color: '#045FB4' // blue
	                }, 
	                {
			            from: 0,
			            to: 15,
			            color: '#81F7BE' // green
	                 },
	                {
			            from: 15,
			            to: 25,
			            color: '#3ADF00' // green
	                 }, 
	                {
			        	from: 25,
			            to: 35,
			            color: '#FF8000' // yellow
	                 },
	                 {
			            from: 35,
			            to: 50,
			            color: '#DF5353' // red
	                }
	            ]        
	        };
	        
	options2.navigation = {
        buttonOptions: {
            enabled: false
            }
        }        
	
	options2.tooltip = {
		valueSuffix: ' °C'
		}
        
	options2.series= [{
	        name: 'Temp. pulsion VMC',
	        data: [<?php echo round($f_last_measure[4][2],1)?>]	        
	    }];	    		
	var chart = new Highcharts.Chart(options2);	
	
// *************** chart 3 ******************	
	var options3 = {};	
	options3.chart = {
			renderTo: 'container_gauge3',
			type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
			};
			
	options3.title = {
		text: 'Temp. aspiration VMC'
		};
		
	options3.credits = {
		enabled: false
		}; 	
		
	options3.pane= {
        startAngle: -150,
        endAngle: 150
	    };
	    
	options3.yAxis= {
	        min: -20,
	        max: 50,	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#848484',	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#6E6E6E',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	            },
	        title: {
	            text: '°C',
	            margin: 20,
	            style: {
					color: 'black',
					fontWeight: 'bold'
					}
	            },
	        plotBands: [
	                {
			            from: -20,
			            to: -10,
			            color: '#08088A' // blue
	                }, 
	                {
			            from: -10,
			            to: 0,
			            color: '#045FB4' // blue
	                }, 
	                {
			            from: 0,
			            to: 15,
			            color: '#81F7BE' // green
	                 },
	                {
			            from: 15,
			            to: 25,
			            color: '#3ADF00' // green
	                 }, 
	                {
			        	from: 25,
			            to: 35,
			            color: '#FF8000' // yellow
	                 },
	                 {
			            from: 35,
			            to: 50,
			            color: '#DF5353' // red
	                }
	            ]        
	        };
	        
	options3.navigation = {
        buttonOptions: {
            enabled: false
            }
        }        
	
	options3.tooltip = {
		valueSuffix: ' °C'
		}
        
	options3.series= [{
	        name: 'Temp. aspiration VMC',
	        data: [<?php echo round($f_last_measure[8][2],1)?>]	        
	    }];	    		
	var chart = new Highcharts.Chart(options3);	
		
// *************** chart 4 ******************	
	var options4 = {};	
	options4.chart = {
			renderTo: 'container_gauge4',
			type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
			};
			
	options4.title = {
		text: 'Humidité aspiration VMC'
		};
		
	options4.credits = {
		enabled: false
		}; 	
		
	options4.pane= {
        startAngle: -150,
        endAngle: 150
	    };
	    
	options4.yAxis= {
	        min: 00,
	        max: 100,	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#848484',	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#6E6E6E',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	            },
	        title: {
	            text: '%',
	            margin: 20,
	            style: {
					color: 'black',
					fontWeight: 'bold'
					}
	            },
	        plotBands: [
	                {
			            from: 0,
			            to: 15,
			            color: '#DF5353' // blue
	                }, 
	                {
			            from: 15,
			            to: 40,
			            color: '#FF8000' // blue
	                }, 
	                {
			            from: 40,
			            to: 75,
			            color: '#3ADF00' // green
	                 },
	                {
			            from: 75,
			            to: 85,
			            color: '#FF8000' // green
	                 }, 
	                {
			        	from: 85,
			            to: 100,
			            color: '#DF5353' // yellow
	                 }
	            ]        
	        };
	        
	options4.navigation = {
        buttonOptions: {
            enabled: false
            }
        }        
	
	options4.tooltip = {
		valueSuffix: ' %'
		}
        
	options4.series= [{
	        name: 'Humidité aspiration VMC',
	        data: [<?php echo $f_last_measure[9][2]?>]	        
	    }];	    		
	var chart = new Highcharts.Chart(options4);	

// *************** chart 5 ******************	
	var options5 = {};	
	options5.chart = {
			renderTo: 'container_gauge5',
			type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
			};
			
	options5.title = {
		text: 'Temp. capteurs solaires'
		};
		
	options5.credits = {
		enabled: false
		}; 	
		
	options5.pane= {
        startAngle: -150,
        endAngle: 150
	    };
	    
	options5.yAxis= {
	        min: 00,
	        max: 100,	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#848484',	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#6E6E6E',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	            },
	        title: {
	            text: '°C',
	            margin: 20,
	            style: {
					color: 'black',
					fontWeight: 'bold'
					}
	            },
	        plotBands: [
	                {
			            from: 0,
			            to: 10,
			            color: '#045FB4' // blue
	                }, 
	               
	                {
			            from: 10,
			            to: 20,
			            color: '#81F7BE' // lighreen
	                 },
	                {
			            from: 20,
			            to: 30,
			            color: '#3ADF00' // green
	                 }, 
	                {
			        	from: 30,
			            to: 50,
			            color: '#F4FA58' // yellow
	                 },
	                 {
			        	from: 50,
			            to: 70,
			            color: '#FF8000' // yellow
	                 },
	                 {
			            from: 70,
			            to: 100,
			            color: '#DF5353' // red
	                }
	            ]    
	        };
	        
	options5.navigation = {
        buttonOptions: {
            enabled: false
            }
        }        
	
	options5.tooltip = {
		valueSuffix: ' %'
		}
        
	options5.series= [{
	        name: 'Temp. capteurs Solaires',
	        data: [<?php echo round($f_last_measure[13][2],1)?>]	        
	    }];	    		
	var chart = new Highcharts.Chart(options5);	
	
// *************** chart 6 ******************	
	var options6 = {};	
	options6.chart = {
			renderTo: 'container_gauge6',
			type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
			};
			
	options6.title = {
		text: 'Temp. balon solaire'
		};
		
	options6.credits = {
		enabled: false
		}; 	
		
	options6.pane= {
        startAngle: -150,
        endAngle: 150
	    };
	    
	options6.yAxis= {
	        min: 00,
	        max: 100,	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#848484',	
	        tickPixelInterval: 30,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#6E6E6E',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	            },
	        title: {
	            text: '°C',
	            margin: 20,
	            style: {
					color: 'black',
					fontWeight: 'bold'
					}
	            },
	        plotBands: [
	                {
			            from: 0,
			            to: 10,
			            color: '#045FB4' // blue
	                }, 
	               
	                {
			            from: 10,
			            to: 20,
			            color: '#81F7BE' // lighreen
	                 },
	                {
			            from: 20,
			            to: 30,
			            color: '#3ADF00' // green
	                 }, 
	                {
			        	from: 30,
			            to: 50,
			            color: '#F4FA58' // yellow
	                 },
	                 {
			        	from: 50,
			            to: 70,
			            color: '#FF8000' // yellow
	                 },
	                 {
			            from: 70,
			            to: 100,
			            color: '#DF5353' // red
	                }
	            ]    
	        };
	        
	options6.navigation = {
        buttonOptions: {
            enabled: false
            }
        }        
	
	options6.tooltip = {
		valueSuffix: ' %'
		}
        
	options6.series= [{
	        name: 'Temp. balon solaire',
	        data: [<?php echo round($f_last_measure[11][2],1)?>]	        
	    }];	    		
	var chart = new Highcharts.Chart(options6);		
	
// *************** chart 7 ******************	
	var options7 = {};	
	options7.chart = {
			renderTo: 'container_gauge7',
			type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
			};
			
	options7.title = {
		text: 'Puissance photovoltaïque'
		};
		
	options7.credits = {
		enabled: false
		}; 	
		
	options7.pane= {
        startAngle: -150,
        endAngle: 150
	    };
	    
	options7.yAxis= {
	        min: 00,
	        max: 2500,	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#848484',	
	        tickPixelInterval: 50,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#6E6E6E',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	            },
	        title: {
	            text: 'W',
	            margin: 20,
	            style: {
					color: 'black',
					fontWeight: 'bold'
					}
	            },
	        plotBands: [
	                {
			            from: 0,
			            to: 500,
			            color: '#045FB4' // blue
	                }, 
	               
	                {
			            from: 500,
			            to: 1000,
			            color: '#81F7BE' // lighreen
	                 },
	                {
			            from: 1000,
			            to: 1500,
			            color: '#3ADF00' // green
	                 }, 
	                {
			        	from: 1500,
			            to: 2000,
			            color: '#F4FA58' // yellow
	                 },
	                 {
			        	from: 2000,
			            to: 2500,
			            color: '#FF8000' // yellow
	                 }
	            ]    
	        };
	        
	options7.navigation = {
        buttonOptions: {
            enabled: false
            }
        }        
	
	options7.tooltip = {
		valueSuffix: ' W'
		}
        
	options7.series= [{
	        name: 'Puissance photovoltaïque',
	        data: [<?php echo round($f_last_measure[22][2],0)?>]	        
	    }];	    		
	var chart = new Highcharts.Chart(options7);			

// *************** chart 8 ******************	
	var options8 = {};	
	options8.chart = {
			renderTo: 'container_gauge8',
			type: 'gauge',
	        plotBackgroundColor: null,
	        plotBackgroundImage: null,
	        plotBorderWidth: 0,
	        plotShadow: false
			};
			
	options8.title = {
		text: 'Bilan électrique'
		};
		
	options8.credits = {
		enabled: false
		}; 	
		
	options8.pane= {
        startAngle: -150,
        endAngle: 150
	    };
	    
	options8.yAxis= {
	        min: -2500,
	        max: 9000,	        
	        minorTickInterval: 'auto',
	        minorTickWidth: 1,
	        minorTickLength: 10,
	        minorTickPosition: 'inside',
	        minorTickColor: '#848484',	
	        tickPixelInterval: 50,
	        tickWidth: 2,
	        tickPosition: 'inside',
	        tickLength: 10,
	        tickColor: '#6E6E6E',
	        labels: {
	            step: 2,
	            rotation: 'auto'
	            },
	        title: {
	            text: 'W',
	            margin: 20,
	            style: {
					color: 'black',
					fontWeight: 'bold'
					}
	            },
	        plotBands: [
	                {
			            from: -2500,
			            to: -1250,
			            color: '#088A29' // dark green
	                }, 
	               
	                {
			            from: -1250,
			            to: 00,
			            color: '#3ADF00' // lighreen
	                 },
	                {
			            from: 00,
			            to: 1500,
			            color: '#E1F5A9' // green
	                 }, 
	                {
			        	from: 1500,
			            to: 3000,
			            color: '#F4FA58' // yellow
	                 },
	                 {
			        	from: 3000,
			            to: 5000,
			            color: '#FAAC58' // yellow
	                 },
	                 {
			        	from: 5000,
			            to: 7000,
			            color: '#FF8000' // yellow
	                 }
	                 ,
	                 {
			        	from: 7000,
			            to: 9000,
			            color: '#B40404' // yellow
	                 }
	                 
	            ]    
	        };
	        
	options8.navigation = {
        buttonOptions: {
            enabled: false
            }
        }        
	
	options8.tooltip = {
		valueSuffix: ' W'
		}
        
	options8.series= [{
	        name: 'Bilan électrique',
	        data: [<?php echo round($f_last_measure[23][2]-$f_last_measure[22][2],0)?>]	        
	    }];	    		
	var chart = new Highcharts.Chart(options8);			
	
}); //end $(function)
    
</script> 
</head>
<body>

	<div class="container">
		<div class="row-fluid">
			<div class="span3">
				<div id="container_gauge1" style="width: 200px; height: 200px; margin: 0 auto"></div>
			</div>
			<div class="span3">
				<div id="container_gauge2" style="width: 200px; height: 200px; margin: 0 auto"></div>
			</div>
			<div class="span3">
				<div id="container_gauge3" style="width: 200px; height: 200px; margin: 0 auto"></div>
			</div>
			<div class="span3">
				<div id="container_gauge4" style="width: 200px; height: 200px; margin: 0 auto"></div>
			</div>
		</div><!--/row-->

		<div class="row-fluid">
			<div class="span3">
				<div id="container_gauge5" style="width: 200px; height: 200px; margin: 0 auto"></div>
			</div>
			<div class="span3">
				<div id="container_gauge6" style="width: 200px; height: 200px; margin: 0 auto"></div>
			</div>
			<div class="span3">
				<div id="container_gauge7" style="width: 200px; height: 200px; margin: 0 auto"></div>
			</div>
			<div class="span3">
				<div id="container_gauge8" style="width: 200px; height: 200px; margin: 0 auto"></div>
			</div>
		</div><!--/row-->
				
		
		<div class="row-fluid">
			<div class="span12">
	
			<?php 
			//print "<pre>";
			//print_r($f_last_measure);
			//print "</pre>";
			?>
			
			<hr>
			
		</div><!--/row-->
		
		<footer>
			<p>© Thomas 2013 - Dernières mesures le <?php echo ($f_last_measure[23][0])?></p>
			</footer>
	</div><!--/.fluid-container-->


</body>

</html>