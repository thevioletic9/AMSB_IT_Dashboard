<?php

        include 'ITTaskBack.php';
        //include 'header.html';
       // $print = $_POST['print'];
        //echo $print;
       
?>
<?php
        $date = $_GET['from_date'];
        $personInCharge = $_GET['PIC'];
       $deptInCharge = $_GET['DIC'];
       $rowss = $_GET['rows'];
       $noPic = $_GET['noPic'];
       $wPIC = $_GET['wPIC'];
       $InProgress = $_GET['InProgress'];
       $comp = $_GET['comp'];
       $others = $_GET['others'];
       $cancel = $_GET['cancel'];
       $outs = $_GET['outs'];
       $over = $_GET['over'];
       $percno = $_GET['percno'];
       $percpic = $_GET['percpic'];
       $inprog = $_GET['inprog'];
       $pcomp = $_GET['pcomp'];
       $pothers = $_GET['pothers'];
       $pcancel = $_GET['pcancel'];
       $outp = $_GET['outp'];
       $overp = $_GET['overp'];
       $dateCurrent = date('d-M-Y');
       $from7 = date('d-M-Y', strtotime('-7 days')); 



       //echo $date;
      // echo $personInCharge;
        //echo $deptInCharge; 

        if ($personInCharge <> "" && $deptInCharge == "" && $date == "") {
            //echo "aa";
             $category = " AND [PIC] = '$personInCharge'";
             $date2 =  "WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";
            $titleChart = " of $personInCharge (last 7 days)";
             //$categoryforChart1 = " AND SUBSTRING([PIC],0,6) = '$empno'";   
        }
        elseif ($deptInCharge <> "" && $personInCharge == "" && $date == "") {
            //echo "aa5";
            $category = " AND [DIC] = '$deptInCharge'";
            $date2 =  "WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";
            $titleChart = " of $deptInCharge (last 7 days)";
            //$categoryforChart1 = " AND [DIC] = '$DIC'";
        }
        elseif ($personInCharge <> "" && $deptInCharge == "" && $date <> "") {
           //echo "aa6";
           $category = " AND [PIC] = '$personInCharge'";
           $date2 =  "WHERE [AddDate] >= '$date' ";  
           $titleChart = " of $personInCharge and from ". date('d-M-Y',strtotime($date)) ." until $dateCurrent";
           //$categoryforChart1 = " AND SUBSTRING([PIC],0,6) = '$empno'";   
        }
        elseif ($deptInCharge <> "" && $personInCharge == "" && $date <> "") {
           //echo "aa7";
           $category = " AND [DIC] = '$deptInCharge'";
           $date2 =  "WHERE [AddDate] >= '$date'";
           $titleChart = " of $deptInCharge and from ". date('d-M-Y',strtotime($date)) ." until $dateCurrent";
          // $categoryforChart1 = " AND [DIC] = '$DIC'";
        }
        elseif( $deptInCharge == "" && $personInCharge == "" && $date <> "") {
         //echo "aa8";
         $category = "";
         $date2 =  "WHERE [AddDate] >= '$date'";
         $titleChart = " from ". date('d-M-Y',strtotime($date)) ." until $dateCurrent";
         //$categoryforChart1 = ""; 
        } else {
           // echo "ab";
         $category = "";
         $date2 =  " WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";
         $titleChart = " of last 7 days";
        }

        //echo $category;


         //execute the whole status pie chart
        $sqlStatus = $db->prepare (" SELECT COUNT(FBNo) as count, Status
                                FROM [AINDATA].[dbo].[SY_0600] ".
                                $date2  .
                                $category .
                                " AND STATUS <> ''
                                GROUP BY STATUS
                                ");
        $sqlStatus->execute();
        //passing data to jquery to generate pie chart
        $dataStatus = array();
        $dataStatus = [];
        $dataStatus['colour'] = [];

        foreach($sqlStatus as $row) {
        $dataStatus['label'][] = $row['Status'];
        $dataStatus['data'][] = $row['count'];
        //$dataStatus['colour'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        $hexMin = 0;
        $hexMax = 9;
        $rgbMin = 0;
        $rgbMax = 153; // Hex 99 = 153 Decimal
        $dataStatus['colour'][] = '#' . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax);
       /* $rgb = 'rgb(' . mt_rand($rgbMin,$rgbMax). ',' . mt_rand($rgbMin,$rgbMax).  ',' . mt_rand($rgbMin,$rgbMax).  ')'; */
        }

        $dataStatus['chartStatus'] = json_encode($dataStatus); 
 
        //execute data for pie chart PIC 
        $sqlT = $db->prepare("  SELECT COUNT(PIC) as record,PIC
                                FROM [AINDATA].[dbo].[SY_0600]" .
                                $date2  .
                                $category .
                                " AND PIC <> ''
                                GROUP BY PIC
                        ");
        $sqlT->execute();

        //passing data to jquery to generate pie chart
        $data = array();
        $data = [];
        $data['colours'] = [];

        foreach($sqlT as $row) {

        $data['label'][] = $row['PIC'];
        $data['data'][] = $row['record'];
        //$data['colours'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        $hexMin = 0;
        $hexMax = 9;
        $rgbMin = 0;
        $rgbMax = 153; // Hex 99 = 153 Decimal
        $data['colours'][] = '#' . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax);
       /* $rgb = 'rgb(' . mt_rand($rgbMin,$rgbMax). ',' . mt_rand($rgbMin,$rgbMax).  ',' . mt_rand($rgbMin,$rgbMax).  ')'; */

        }

        $data['chart_data'] = json_encode($data);
        
        //execute data for bar chart by DIC
        $sqlU =  $db->prepare("   SELECT COUNT(DIC) AS RECORD , DIC
                                FROM [AINDATA].[dbo].[SY_0600] ". 
                                $date2  .
                                $category .
                                " AND DIC <> ''
                                GROUP BY DIC
                                ");
         $sqlU->execute();
        $count = [];
        $dic = [];
        while ($row = $sqlU->fetch(PDO::FETCH_ASSOC)) { 

         $count[] = $row['RECORD'];
        $dic[] = $row['DIC'];
         }
        

?>

<html>
        <head>
        <link rel="stylesheet" href="admins/dist/css/adminlte.min.css">
        </head>
        <style>
              @media print
                {
                .noprint {display:none;}
                body {
                display:table;
                table-layout:fixed;
                padding-top:1cm;
                padding-bottom:1cm;
                padding-right:1cm;
                padding-left:1cm;
                -webkit-print-color-adjust:exact;
                }

                }
                @page {
                    size: 37cm 27cm;
                    margin: 1mm 1mm 1mm 1mm; /* change the margins as you want them to be. */
                }
            
        </style>
        <body>

          


<div class="content">
      <div class="container-fluid" >
        <div class="row d-flex justify-content-center ">
            <div class="card mt-2">
              <div class="card-body">
              <h4>IT Feedback Record</h4>
              <div class="col-sm">
              <span class="btn btn-primary btn-xs float-right noprint" onclick="printWithSpecialFileName()"  role="button">Print</span>
                <!-- DISPLAY THE DESCRIPTION (ACCORDING TO USER'S SELECTION) -->
                    <?php if ($category <> "" && $date <> "") { ?> 
                            <span class="text-start">Filter by department/PIC : <?php echo $deptInCharge?>  <?php echo $personInCharge?></span> </br>
                            <span class="text-start">Filter by date : <?php echo date('d-M-Y',strtotime($date));?> until <?php echo date('d-M-Y'); ?></span> 
                    <?php 
                         }
                         elseif ($category == "" && $date <> "") { ?>
                            <span class="text-start">Filter by date : <?php echo date('d-M-Y',strtotime($date));?> until <?php echo date('d-M-Y'); ?></span> 
                   <?php }
                          elseif ($category <> "" && $date == "") { ?>
                             <span class="text-start">Filter by department/PIC : <?php echo $deptInCharge?>  <?php echo $personInCharge?> (last 7 days)</span> 
                    <?php }
                          else {?>
                          <span class="text-start">General data (last 7 days) <small>from <?php echo $from7; ?> to <?php echo $dateCurrent; ?></small></span> 
                    <?php } ?>
                    <p class="float-leftfont-weight-bold"><?php echo $rowss; ?> records found <small>(Open No PIC : <?php echo $noPic; ?>, Open with PIC : <?php echo $wPIC; ?>,
                                                                                                  In-progress: <?php echo $InProgress; ?>,Completed: <?php echo $comp; ?>,Others: <?php echo $others; ?>,
                                                                                                  Cancel: <?php echo $cancel; ?>)  </small></small> </p>
                           
                         <!--<button type="submit" name="submit" class="btn btn-primary btn-sm float-right noprint " onclick="window.print()" >Print</button> -->
                </div>


              <!--<div class="row">
                    <div class="col-5 col-sm-2 col-md-2 mx-auto">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text text-center font-weight-bold">Total Record</span>
                                <span class="info-box-number text-center">
                                <?php echo $rows7; ?>
                               
                                </span>
                            </div>
                        /.info-box-content 
                        </div>
                         /.info-box 
              </div> -->
                                
              <div class="row">
                    <div class="col-lg">
              
                        <small style="text-align: center;font-weight:bold;" >Pie Chart filter by Status</small>
                        <div class="row" style="height:700px; width: 1300px;">
                            <canvas id="outlabeledChart" ></canvas>
                        </div>
                        <!--<span class="btn btn-primary btn-xs noprint" data-toggle="modal" data-target="#modal-zoom1" role="button">Zoom</span> -->
                    </div>
                 
                </div>



            </div>
          </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>

              <!--<table style="width:100%">
                <tr>
                   <td>
                        <canvas id="outlabeledChart" style="min-height: 400px; height: 250px;  max-width: 100%;"></canvas>
                  </td>
                   <td>
                        <canvas id="outlabeledChart2" style="min-height: 400px; height: 250px; max-width: 100%;"></canvas>
                   </td>
                   <td style= "padding: 40px; ">
                        <canvas id="bar-chart" style="min-height: 400px; height: 250px;  max-width: 100%;"></canvas>
                   </td>
                </tr>
              </table> --->
            


<script src="chartjs28.js"></script>
<script src="pluginOutlabel.js"></script>

<script src="admins/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="admins/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="admins/dist/js/adminlte.js"></script> 

<script>
//pie chart by status
 var cData1 =JSON.parse(`<?php echo $dataStatus['chartStatus']; ?>`);
     var chart = new Chart('outlabeledChart', {
         type: 'outlabeledPie',
         data: {
             labels: cData1.label,
             datasets: [{
                 backgroundColor: cData1.colour,
                 data: cData1.data
             }]
         },
         options: {
             zoomOutPercentage: 50, // makes chart 55% smaller (50% by default, if the preoprty is undefined)
             plugins: {
                 legend: false,
                 percentPrecision : 2,
                 outlabels: {
                     text: '%l \n %p. ',
                     color: 'white',
                     stretch:10,
                     font: {
                         resizable: true,
                         minSize: 12,
                         maxSize: 15,
                         weight: 'Bold'
                     }
                 }
             }
         }
     });

      //pie chart by PIC
      var cData2 = JSON.parse(`<?php echo $data['chart_data']; ?>`);
            var chart = new Chart('outlabeledChart2', {
                type: 'outlabeledPie',
                data: {
                    labels: cData2.label,
                    datasets: [{
                        backgroundColor: cData2.colours,
                        data: cData2.data
                    }]
                },
                options: {
                   zoomOutPercentage: 50,
                   // responsive: true,
                    //maintainAspectRatio: false,
                    plugins: {
                        legend: false,
                        outlabels: {
                            text: '%l \n %p.',
                            color: 'white',
                            stretch:3,
                            font: {
                                resizable: true,
                                minSize: 12,
                                maxSize: 15,
                                weight: 'Bold'
                            }
                        }
                    }
                }
            });

            //  bar chart
	var myData = {
		labels: <?php echo json_encode($dic); ?>,
		datasets: [{
			        label: "Department",
					fill: false,
					backgroundColor: ["#5969ff",
                                "#ff407b",
                                "#25d5f2",
                                "#ffc750",
                                "#2ec551",
                                "#7040fa",
                                "#ff004e"],
					borderColor: 'white',
					data: <?php echo json_encode($count); ?>,
				}]
			};
			// Options to display value on top of bars
			var myoption = {
				tooltips: {
					enabled: true
				},
				hover: {
					animationDuration: 1
				},
                scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {if (value % 1 === 0) {return value;}}
                        
                    },
                    scaleLabel: {
                        display: true
                    }
                }],
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 30,
                    bottom: 10
                }
            },
            legend: {
              display: false,
            },
	   animation: {
	   duration: 1,
        //count function to display on the bar
				onComplete: function () {
					var chartInstance = this.chart,
						ctx = chartInstance.ctx;
						ctx.textAlign = 'center';
						ctx.fillStyle = "rgba(0, 0, 0, 1)";
						ctx.textBaseline = 'center';

						this.data.datasets.forEach(function (dataset, i) {
							var meta = chartInstance.controller.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								var data = dataset.data[index];
								ctx.fillText(data, bar._model.x, bar._model.y - 5);
							});
						});
					}
				}
                                
			};
			//Code to draw Chart
			var ctx = document.getElementById('bar-chart').getContext('2d');
       
			var myChart = new Chart(ctx, {
				type: 'bar',    	// Define chart type
				data: myData,    	// Chart data
				options: myoption 	// Chart Options [This is optional paramenter use to add some extra things in the chart].
			});


            function printWithSpecialFileName(){
                
            var tempTitle = document.title;
            document.title = 'IT Feedback Record Pie Chart by Status ' + <?php echo json_encode($titleChart); ?> + '.pdf';
            window.print();
            document.title = tempTitle;
        }
    
</script>
</body>
</html>