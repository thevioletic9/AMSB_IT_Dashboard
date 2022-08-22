<?php
      include 'WorkOrderBack.php';
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

   if ($personInCharge <> "" && $deptInCharge == "" && $date == "") {
    //echo "aa";
    $category = " AND SUBSTRING([InCharge],0,6) = SUBSTRING('$personInCharge',0,6)";
    //SUBSTRING([AINDATA].[dbo].[SY_0600].PIC,0,6)
   // $date =  "AND [AddDate] >= DATEADD(day,-7,GETDATE())";
    $date2 = "WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";
    $titleChart = " of $personInCharge ";
    //$categoryforChart1 = " AND SUBSTRING([PIC],0,6) = '$empno'";   
    }
    elseif ($deptInCharge <> "" && $personInCharge == "" && $date == "") {
        //echo "aa5";
        $category = " AND [DIC] = '$deptInCharge'";
       // $date =  "AND [AddDate] >= DATEADD(day,-7,GETDATE())";
        $date2 =  "WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";
        $titleChart = " of $deptInCharge ";
        //$categoryforChart1 = " AND [DIC] = '$DIC'";
    }
    elseif ($personInCharge <> "" && $deptInCharge == "" && $date <> "") {
    //echo "aa6";
    $category = " AND SUBSTRING([InCharge],0,6) = SUBSTRING('$personInCharge',0,6)";
  //  $date =  "AND [AddDate] >= '$date' ";  
    $date2 =  "WHERE [AddDate] >= '$date' "; 
    $titleChart = " of $personInCharge and from ". date('d-M-Y',strtotime($date)) ." until $dateCurrent  ";
    //$categoryforChart1 = " AND SUBSTRING([PIC],0,6) = '$empno'";   
    }
    elseif ($deptInCharge <> "" && $personInCharge == "" && $date <> "") {
    //echo "aa7";
    $category = " AND [DIC] = '$deptInCharge'";
  //  $date =  "AND [AddDate] >= '$date'";
    $date2 =  "WHERE [AddDate] >= '$date'";
    $titleChart = " of $deptInCharge and from " . date('d-M-Y',strtotime($date)) ." until $dateCurrent  ";
    // $categoryforChart1 = " AND [DIC] = '$DIC'";
    }
    elseif($deptInCharge == "" && $personInCharge == "" && $date <> "") {
    //echo "aa8";
    $category = "";
  //  $date =  " AND [AddDate] >= '$date'";
    $date2 =  "  WHERE [AddDate] >= '$date'";
    $titleChart = " from " . date('d-M-Y',strtotime($date)) . " until $dateCurrent  ";
    //$categoryforChart1 = ""; 
    } else {

    $category = "";
    //  $date =  " AND [AddDate] >= '$date'";
    $date2 =  "  WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";
    $titleChart = " of last 7 days";
    }

     //execute the whole status pie chart
     $sqlStatus = $db->prepare (" SELECT COUNT(WorkNo) as count, Status
                                FROM [AINDATA].[dbo].[IN_0080] ".
                                $date2  .
                                $category .
                                " AND PROVIDER IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                AND STATUS <> ''
                                GROUP BY STATUS
                                ");
    $sqlStatus->execute();
    //passing data to jquery to generate pie chart
    $dataWStatus = array();
    $dataWStatus = [];
    $dataWStatus['colour'] = [];

    foreach($sqlStatus as $row) {

    $dataWStatus['label'][] = $row['Status'];
    $dataWStatus['data'][] = $row['count'];
    // $dataWStatus['colour'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
    $hexMin = 0;
    $hexMax = 9;
    $rgbMin = 0;
    $rgbMax = 153; // Hex 99 = 153 Decimal
    $dataWStatus['colour'][] = '#' . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax);
    }

    $dataWStatus['chartWStatus'] = json_encode($dataWStatus);

     //execute data for pie chart PIC 
     $sqlT = $db->prepare("  SELECT COUNT(InCharge) as record,InCharge
                            FROM [AINDATA].[dbo].[IN_0080]" .
                            $date2  .
                            $category .
                            " AND PROVIDER IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                            AND InCharge <> ''
                            GROUP BY InCharge
                        ");
    $sqlT->execute();

    //passing data to jquery to generate pie chart
    $data = array();
    $data = [];
    $data['colours'] = [];

    foreach($sqlT as $row) {

    $data['label'][] = $row['InCharge'];
    $data['data'][] = $row['record'];
    // $data['colours'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
    $hexMin = 0;
    $hexMax = 9;
    $rgbMin = 0;
    $rgbMax = 153; // Hex 99 = 153 Decimal
    $data['colours'][] = '#' . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax);

    }

    $data['chart_data'] = json_encode($data);   

    //execute data for bar chart by DIC

    $sqlU =  $db->prepare(" SELECT COUNT(DIC) AS RECORD , DIC
                        FROM [AINDATA].[dbo].[IN_0080] ". 
                        $date2  .
                        $category .
                        " AND PROVIDER IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                        AND DIC <> ''
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
                    size: 45cm 75cm;
                    margin: 1mm 1mm 1mm 1mm; /* change the margins as you want them to be. */
                }
            
    </style>
    <body>
            <!-- Main content -->
    <div class="content">
      <div class="container-fluid" >
        <div class="row d-flex justify-content-center ">
          <div class="col-lg-15 ">
            <div class="card">
              <div class="card-body">
              <h4>Work Order Record</h4>
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

              <!---CHARTS-->
              <div class="row">
                    <div class="col-lg-12">
                        <small style="text-align: center;font-weight:bold;" >Pie Chart filter by Status</small>
                        <canvas id="outlabeledChart" style="min-height: 400px; height: 250px;  max-width: 100%;"></canvas>
                    </div>
                    <div class="col-lg-12">
                        <small style="text-align: center;font-weight:bold;" >Pie Chart filter by PIC (person in-charge)</small>
                        <canvas id="outlabeledChart2" style="min-height: 400px; height: 250px;  max-width: 100%;"></canvas>
                    </div>
                    <div class="col-lg-12">
                        <small style="text-align: center;font-weight:bold;">Bar Chart filter by DIC (department in-charge)</small>
                        <canvas id="bar-chart" style="min-height: 400px; height: 250px;  max-width: 100%;"></canvas>
                    </div>
                    
                </div>
              </div>
        <!---DISPLAY THE COUNT OF THE STATUS, PERCENTAGE AND VIEW BUTTON(MODAL)-->
        <div class="row"> 
  <div class="col-md">
    <div class="card-group">
                      <!-- STATUS CONTAINERS (IT DISPLAYS COUNT AND PERCENTAGE)-->
                     <div class="card border-right">
                          <div class="card-body bg-light">
                              <div class="d-flex d-lg-flex d-md-block align-items-center">
                                  <div>
                                      <h6 class="text-dark mb-1 font-weight-bold">Open<small>No PIC</small></h6>
                                      <div class="d-inline-flex align-items-center">
                                          <h2 class="text-dark mb-1 font-weight-medium"><?php echo $noPic; ?></h2>
                                      </div></br>
                                      <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $percno; ?> % </small></span>
                                  </div>
                              </div>
                          </div>
                      </div>
  
                    <div class="card border-right">
                        <div class="card-body bg-light">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <h6 class="text-dark mb-1 font-weight-bold">Open <small>With PIC</small></h6>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $wPIC; ?></h2>
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $percpic; ?> % </small></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-right">
                        <div class="card-body" style="background-color: #D7FAF9!important;">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <h6 class="text-dark mb-1 font-weight-bold">In-progress</h6>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $InProgress; ?></h2>
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $inprog; ?> % </small></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body" style="background-color: #C0F1C7 !important;">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                    <h6 class="text-dark mb-1 font-weight-bold">Completed</h6>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $comp; ?></h2>
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $pcomp; ?> % </small></span>
                                </div> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body" style="background-color: #FFFFFF  !important;">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                      <h6 class="text-dark mb-1 font-weight-bold">Others &#42;</h6>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $others; ?></h2>
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $pothers; ?> % </small></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-right">
                        <div class="card-body" style="background-color: #DEDEDE  !important;">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                      <h6 class="text-dark mb-1 font-weight-bold">Cancel</h6>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $cancel; ?></h2>
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $pcancel; ?> % </small></span>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                    <div class="card border-right">
                        <div class="card-body" style="background-color: #EEEDAD  !important;">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                      <h6 class="text-dark mb-1 font-weight-bold">Outstanding &#42;</h6>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="mb-1 font-weight-bold text-danger" ><?php echo $outs; ?></h2>
                                    </div> </br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $outp; ?> % </small></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card border-right">
                        <div class="card-body" style="background-color: #ECA4A4  !important;">
                            <div class="d-flex d-lg-flex d-md-block align-items-center">
                                <div>
                                      <h6 class="text-dark mb-1 font-weight-bold">Overdue &#42;</h6>
                                    <div class="d-inline-flex align-items-center">
                                        <h2 class="text-danger mb-1 font-weight-bold"><?php echo $over; ?></h2>
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $overp; ?> % </small></span>
                                </div>
                            </div>
                        </div>
                    </div>
                     
    </div>

</div>
  
</div>        

<div class="col-sm">
      <small>&#42; Outstanding : incomplete work order status</small></br>
      <small>&#42; Overdue : incomplete work order task where task isn't completed within the due date</small></br>
      <small>&#42; Others : consist of KIV, User Testing, Waiting Justification</small>
  </div></br>

               
              </div>
            </div>
            <!-- /.card -->
            

          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!---SCRIPTS FOR CHARTJS-->
<script src="chartjs28.js"></script>
<script src="pluginOutlabel.js"></script>

<script src="admins/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="admins/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="admins/dist/js/adminlte.js"></script>

<script>
        //pie chart by status
        var cData1 =JSON.parse(`<?php echo $dataWStatus['chartWStatus']; ?>`);
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
                    zoomOutPercentage: 45, // makes chart 55% smaller (50% by default, if the preoprty is undefined)
                    plugins: {
                        legend: false,
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
                    zoomOutPercentage: 45, // makes chart 55% smaller (50% by default, if the preoprty is undefined)
                    plugins: {
                        legend: false,
                        outlabels: {
                            text: '%l \n %p.',
                            color: 'white',
                            stretch:10,
                            font: {
                                resizable: true,
                                minSize:12,
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
                }]
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 15,
                    bottom: 10
                }
            },
            legend: {
              display: false,
            },
				animation: {
				duration: 1,
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
                document.title = 'Work Order Record' + <?php echo json_encode($titleChart); ?> + '.pdf';
                window.print();
                document.title = tempTitle;
            }
         
</script>
</body>
</html>