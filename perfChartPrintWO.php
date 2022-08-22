<?php

require __DIR__ . '/database.php';
$db = DB();

$from_date = $_GET['from_date'];
$end_date = $_GET['end_date'];
$year = $_GET['year'];
$dept = $_GET['DIC'];
$status = $_GET['Status'];

        $stmtGeneral = "SELECT InCharge, COUNT(WorkNo) as record
                       FROM [AINDATA].[dbo].[IN_0080]";
       
    
        $stmtGeneral3 = "SELECT count(*)
                        FROM [AINDATA].[dbo].[IN_0080]";


       if ( ($from_date && $end_date) <> "" && $year == "" && $dept == "" && $status == ""  ) {

              $statement1 = $stmtGeneral . " 
                                          WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                                          GROUP BY InCharge
                                       ";
              $statement = $db->prepare($statement1);
             
              $stmtCount1 = $stmtGeneral3 . "WHERE AddDate BETWEEN  '$from_date' AND '$end_date'";
              $stmtCount = $db->prepare($stmtCount1);
             // $statementTitle = "Bar Chart between $from_date and $end_date  ";
              
       } 
       if (($from_date && $end_date && $dept && $status) == "" && $year <> "") {
              
              $statement2 = $stmtGeneral . " 
                            WHERE year([AddDate]) = '$year'
                            GROUP BY InCharge ";
              $statement = $db->prepare($statement2);

              $stmtCount2 = $stmtGeneral3 . "WHERE year([AddDate]) = '$year'";
              $stmtCount = $db->prepare($stmtCount2);

              //$statementTitle = "Bar Chart for the year : $year ";
                 
       }
       if (($from_date && $end_date && $year && $status) == "" && $dept <> "") {
              $statement3 = $stmtGeneral . " 
                            WHERE DIC = '$dept'
                            GROUP BY InCharge ";
              $statement = $db->prepare($statement3);

              $stmtCount3 = $stmtGeneral3 . "WHERE DIC = '$dept'";
              $stmtCount = $db->prepare($stmtCount3);
             // $statementTitle = "Bar Chart for department : $dept ";
       } 
       if (($from_date && $end_date && $year && $dept) == "" && $status <> "") {
              
              $statement4 = $stmtGeneral . " 
                            WHERE Status = '$status'
                            GROUP BY InCharge ";
              $statement = $db->prepare($statement4);

              $stmtCount4 = $stmtGeneral3 . "WHERE Status = '$status'";
              $stmtCount = $db->prepare($stmtCount4);

             // $statementTitle = "Bar Chart for status : $status ";

       } 
       if (($from_date && $end_date) <> "" && $year == "" && $dept <> "" && $status == "") {
              //echo "aa";
              $statement5 = $stmtGeneral . " 
                            WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                            AND DIC = '$dept'
                            GROUP BY InCharge
                            ";
              $statement = $db->prepare($statement5);

              $stmtCount5 = $stmtGeneral3 . "WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                                             AND DIC = '$dept'";
              $stmtCount = $db->prepare($stmtCount5);

             // $statementTitle = "Bar Chart between $from_date and $end_date and department : $dept  ";

       } 
       if (($from_date && $end_date) <> "" && $year == "" && $dept == "" && $status <> "") {

              $statement6 = $stmtGeneral . " 
                            WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                            AND Status = '$status'
                            GROUP BY InCharge
                            ";
              $statement = $db->prepare($statement6);

              $stmtCount6 = $stmtGeneral3 . "WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                                             AND Status = '$status'";
              $stmtCount = $db->prepare($stmtCount6);

            //  $statementTitle = "Bar Chart between $from_date and $end_date and status : $status  ";
       } 
       if (($from_date && $end_date) == "" && $year <> "" && $dept <> "" && $status == "") {

              $statement7 = $stmtGeneral . " 
                            WHERE year([AddDate]) = '$year'
                            AND DIC = '$dept'
                            GROUP BY InCharge ";
              $statement = $db->prepare($statement7);

              $stmtCount7 = $stmtGeneral3 . "WHERE year([AddDate]) = '$year'
                                                 AND DIC = '$dept'";
              $stmtCount = $db->prepare($stmtCount7);

              //$statementTitle = "Bar Chart for the year: $year and department : $dept  ";

       } 
       if (($from_date && $end_date) == "" && $year <> "" && $dept == "" && $status <> "") {

               $statement8 = $stmtGeneral . " 
                                   WHERE year([AddDate]) = '$year'
                                   AND Status = '$status'
                                   GROUP BY InCharge ";
              $statement = $db->prepare($statement8);

              $stmtCount8 = $stmtGeneral3 . "WHERE year([AddDate]) = '$year'
                                             AND Status = '$status'";
              $stmtCount = $db->prepare($stmtCount8);

             // $statementTitle = "Bar Chart for the year: $year and status : $status  ";

       } 
       if (($from_date && $end_date && $year ) == "" && $status <> "" && $dept <> "") {

             // echo "ab";
              $statement9 = $stmtGeneral . " 
                                   WHERE DIC = '$dept'
                                   AND Status = '$status'
                                   GROUP BY InCharge ";
              $statement = $db->prepare($statement9);

              $stmtCount9 = $stmtGeneral3 . " WHERE DIC = '$dept'
                                                 AND Status = '$status'";
              $stmtCount = $db->prepare($stmtCount9);

             // $statementTitle = "Bar Chart for the department : $dept and status : $status  ";

       } 
       if (($from_date && $end_date && $dept && $status ) <> "" && $year == "") {

               //echo "ab";
               $statement10 = $stmtGeneral . " 
                                    WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                                    AND DIC = '$dept'
                                    AND Status = '$status'
                                    GROUP BY InCharge ";
               $statement = $db->prepare($statement10);

               $stmtCount10 = $stmtGeneral3 . "  WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                                                 AND DIC = '$dept'
                                                 AND Status = '$status'";
               $stmtCount = $db->prepare($stmtCount10);
 
        } 
        if (($year && $dept && $status ) <> "" && ($from_date && $end_date) == "") {

              //echo "ab";
              $statement11 = $stmtGeneral . " 
                                   WHERE year([AddDate]) = '$year'
                                   AND DIC = '$dept'
                                   AND Status = '$status'
                                   GROUP BY InCharge ";
              $statement = $db->prepare($statement11);

              $stmtCount11 = $stmtGeneral3 . "   WHERE year([AddDate]) = '$year'
                                                AND DIC = '$dept'
                                                AND Status = '$status'";
              $stmtCount = $db->prepare($stmtCount11);

       } 
      

       $statement->execute();
       $stmtCount->execute();
       $rows = $stmtCount->fetchColumn();

        //statement for title
        $formatFromDate = date('d-M-Y',strtotime($from_date));
        $formatEndDate = date('d-M-Y',strtotime($end_date));
        if (! $rows) {
 
               $statementTitle  = "No record found";
               # code...
        } else {
               if (($from_date && $end_date) <> "" && $year == "" && $dept == "" && $status == "") {
                      $statementTitle = "Bar Chart between $formatFromDate and $formatEndDate  ";
               }
               if (($from_date && $end_date && $dept && $status) == "" && $year <> "") {
                      $statementTitle = "Bar Chart for the year : $year ";
               } 
               if (($from_date && $end_date && $year && $status) == "" && $dept <> "") {
                      $statementTitle = "Bar Chart for department : $dept ";
               } 
               if (($from_date && $end_date && $year && $dept) == "" && $status <> "") {
                      $statementTitle = "Bar Chart for status : $status ";
               }
               if (($from_date && $end_date) <> "" && $year == "" && $dept <> "" && $status == "") {
                      $statementTitle = "Bar Chart between $formatFromDate and $formatEndDate and department : $dept  ";
               } 
               if (($from_date && $end_date) <> "" && $year == "" && $dept == "" && $status <> "") {
                      $statementTitle = "Bar Chart between $formatFromDate and $formatEndDate and status : $status  ";
               }
               if (($from_date && $end_date) == "" && $year <> "" && $dept <> "" && $status == "") {
                      $statementTitle = "Bar Chart for the year: $year and department : $dept  ";
               } 
               if (($from_date && $end_date) == "" && $year <> "" && $dept == "" && $status <> "") {
                      $statementTitle = "Bar Chart for the year: $year and status : $status  ";
               } 
               if (($from_date && $end_date && $year ) == "" && $status <> "" && $dept <> "") {
                     //echo "aaa";
                      $statementTitle = "Bar Chart for the department : $dept and status : $status  ";
               } 
               if (($from_date && $end_date && $dept && $status ) <> "" && $year == "") {
                      $statementTitle = "Bar Chart between $formatFromDate and $formatEndDate and department : $dept and status : $status  ";
               }
               if (($year && $dept && $status ) <> "" && ($from_date && $end_date) == "") {
                      $statementTitle = "Bar Chart for the year : $year and department : $dept and status : $status";
               }
        }
      
       while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { 

       
              $staff[] = $row['InCharge'];
              $count[] = $row['record'];
              $colour[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
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
            @page {
                    size: 35cm 23.7cm;
                    margin: 1mm 1mm 1mm 1mm; /* change the margins as you want them to be. */
                }
        }
    </style>
    <body>
    <div class="content">
      <div class="container-fluid" >
        <div class="row d-flex justify-content-center ">
            <div class="card mt-2">
              <div class="card-body">
                    <h4>Received Record for Work Order</h4>
                    <div class="row">
                        <div class="col-lg">
                            <span style="align-items: center;justify-content: center;display: flex;font-weight:bold;"> <?php echo $statementTitle ?> </span>
                            <button type="submit" name="submit" class="btn btn-primary btn-sm float-right noprint " onclick="printWithSpecialFileName()" >Print</button>
                            <div id="container">
                            <canvas id="canvas" style="min-height: 500px; height: 550px;  max-width: 100%;"></canvas>
                            </div>
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
        
    </body>
<script src="chartjs28.js"></script>
<script>
    new Chart(document.getElementById("canvas"), {
    type: 'horizontalBar',
    data: {
      labels:<?php echo json_encode($staff); ?>,
      datasets: [
        {
          label: "No. of feedback",
          backgroundColor: <?php echo json_encode($colour); ?>,
          data: <?php echo json_encode($count); ?>
        }
      ]
    },
    options: {
      responsive : true,
      legend: { display: false },
      title: {
        display: true,
        text: ''
      },
      tooltips: {
					enabled: true
				},
				hover: {
					animationDuration: 1
				},
        scales: {
                xAxes: [{
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
                    left: 0,
                    right: 20,
                    top: 0,
                    bottom: 0
                }
      },
     
      animation: {
				duration: 1,
				onComplete: function () {
					var chartInstance = this.chart,
						ctx = chartInstance.ctx;
						ctx.textAlign = 'left';
						ctx.fillStyle = "rgba(0, 0, 0, 1)";
						ctx.textBaseline = 'center';
						this.data.datasets.forEach(function (dataset, i) {
							var meta = chartInstance.controller.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								var data = dataset.data[index];
								ctx.fillText(data, bar._model.x, bar._model.y -1);
							});
						});
					}
				}
    }
}); 

        function printWithSpecialFileName(){
                
                var tempTitle = document.title;
                document.title = 'Received Record for Work Order '+ <?php echo json_encode($statementTitle); ?> +'.pdf';
                window.print();
                document.title = tempTitle;
            }

</script>

</html>