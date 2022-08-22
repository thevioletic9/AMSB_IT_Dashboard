<?php
    include 'perFChartBackWO.php';
    include 'header.html';

?>
<style>
  
    @media screen and (min-width: 1000px)  {
        .modal-dialog {
          max-width: 1200px; 
        
        }
    } 
</style>
<script>
//Error Msg for input field
function validateForm() {

  let a = document.forms["formAct"]["from_date"].value;
  let b = document.forms["formAct"]["end_date"].value;
  let c = document.forms["formAct"]["year"].value;
  let e = document.forms["formAct"]["DIC"].value;
  let f = document.forms["formAct"]["Status"].value;
  
  if (a == "" && b == "" && c == "" && e == "" && f == "") {
   // alert("Please select...");
    //document.getElementById("errorMessage").innerHTML = "Please select first...";
    alert("Please select first...");
    event.preventDefault();
    location.reload();
    //return false;
  } else if (a != "" && b == "" ) {
    //document.getElementById("errorMessage").innerHTML = "Invalid selection";
    alert("Invalid selection");
    event.preventDefault();
    location.reload();
    //document.write("test");
    //return false;
  } else if (a != "" && b != "" && c != "") {
    //document.getElementById("errorMessage").innerHTML = "Invalid selection";
    alert("Invalid selection");
    event.preventDefault();
    location.reload();
    
  } else if (b != "" && c != "") {
    alert("Invalid selection");
    event.preventDefault();
    location.reload();
  }
  
}

function valid() {
               var fromdate = document.getElementById('from_date').value;
               var enddate = document.getElementById('end_date').value;
               var year = document.getElementById('year').value;

               if ( fromdate && enddate != '') {
                   document.getElementById('year').disabled = true; 
                  // document.getElementById('selectDIC').setAttribute("value","");
                } else if (year != '') {
                   document.getElementById('from_date').disabled  = true;
                   document.getElementById('end_date').disabled  = true;
                   //document.getElementById('selectPIC').setAttribute("value","");
                }
                            
        }

</script>
<div class="content">
      <div class="container-fluid" >
        <div class="row d-flex justify-content-center ">
          <div class="col-lg-15 ">
            <div class="card">
              <div class="card-body">
              <h4>Received Record for Work Order </h4>
              <form action="" method="POST" name="formAct" id="formAct" onsubmit="return validateForm()">
          
                    <div class="row">
                      <!-- DATE SELECTION -->
                    <div class="col-sm">
                        <label>Start Date</label>
<?php
                        if(isset($_POST['from_date'])){   ?>
                            
                          <input type="date" name="from_date" value="<?php if(isset($_POST['from_date'])){ echo $_POST['from_date']; } ?>" class="form-control" form="formAct" id="from_date" onchange="valid()">
<?php                   } else {  ?>
                          <input type="date" name="from_date" value="" class="form-control noprint" form="formAct" id="from_date" onchange="valid()">
<?php                   }
?>         
                    </div>
                    <div class="col-sm">
                        <label>End Date</label>
<?php                    if(isset($_POST['end_date'])) { ?>
                              <input type="date" name="end_date" value="<?php if(isset($_POST['end_date'])){ echo $_POST['end_date']; } ?>" class="form-control" form="formAct" id="end_date" onchange="valid()">
<?php                     }  else { ?>
                              <input type="date" name="end_date" value="" class="form-control" form="formAct" id="end_date" onchange="valid()">
<?php                     } ?>
                    </div>
                    <!-- YEAR SELECTION -->
                    <div class="col-sm">
                      <label for="">Year</label>
                      <select name="year" class="custom-select form-control-border border-width-2" form="formAct" id="year" onchange="valid()">
 <?php                   
                        if((isset($_POST['year']))){
?>
                          <option value="<?php { echo $_POST['year']; } ?>" > <?php  echo $_POST['year'];?>  </option>
<?php
                        }    
                        else { 
?>
                          <option value="" > select year  </option>
<?php                    }
                        
                        while($row3 = $sqlYear->fetch(PDO::FETCH_ASSOC))
                        {                    
?>                        
                          <option value="<?php echo $row3['year']; ?>">  <?php echo $row3['year']; ?> </option>
<?php                          
                        }
?>                        
                        </select>
                    </div>
                    <div class="col-sm">
                      <!-- DEPARTMENT SELECTION -->
                      <label for="">Department</label>
                      <select name="DIC" class="custom-select form-control-border border-width-2" form="formAct">
 <?php                  
                        if((isset($_POST['DIC']))){
?>
                            <option value="<?php { echo $_POST['DIC']; } ?>" > <?php  echo $_POST['DIC'];?>  </option>
<?php                   } else {
?>
                            <option value="" > select department </option>
<?php                       }
                        while($row4 = $stmtDIC->fetch(PDO::FETCH_ASSOC))
                        {                    
?>                        
                          <option value="<?php echo $row4['DIC']; ?>">  <?php echo $row4['DIC']; ?> </option>
<?php                          
                        }
?>                        <option value="All Data" >ALL</option>
                        </select>
                    </div>
                    <div class="col-sm">
                      <!-- STATUS SELECTION -->
                      <label for="">Status</label>
                      <select name="Status" class="custom-select form-control-border border-width-2" form="formAct">
<?php                   
                        if((isset($_POST['Status']))){
?>
                          <option value="<?php { echo $_POST['Status']; } ?>" > <?php  echo $_POST['Status'];?>  </option>
<?php                   }
                        else {
?>
                          <option value="" > select status </option>
<?php                        }
                        while($row5 = $stmtStatus->fetch(PDO::FETCH_ASSOC))
                        {                    
?>                        
                          <option value="<?php echo $row5['Status']; ?>">  <?php echo $row5['Status']; ?> </option>
<?php                          
                        }
?>                        <option value="All Data" >ALL</option>
                        </select>
                    </div>
                    <div class="col-sm">
                       </br>
                       <!-- BUTTONS -->
                        <button type="submit" name="simpan" class="btn btn-primary mr-10" onclick="validateForm()">Filter</button>
                        <!--<button type="submit" name="all" class="btn btn-primary">View All</button> -->
                        <a href="perfChartWO.php" class="btn btn-dark" >Reset</a></br>
                        <span class="text-danger" id="errorMessage"></span>
                    </div>
                </div>
              </form></br>
              <script>
                    document.querySelector("form").addEventListener("submit", function(e){
                      document.getElementById('from_date').disabled = false;
                      document.getElementById('end_date').disabled = false;
                      document.getElementById('year').disabled = false;
                }); 
            </script>

                <div class="col-md">
                <div class="col-sm">
                  <!-- DISPLAY BUTTON TO VIEW DATATABLE ONCE THE USER CLICKED THE SUBMIT-->
                  <?php if ( ($from_date || $end_date  ||  $year   || $dept  ||  $status) <> "") { ?>
                      <span class="btn btn-primary btn-m float-right" data-toggle="modal" data-target="#modal1" role="button">View Datatable</span>
                      <a href="perfChartPrintWO.php?from_date=<?php echo $from_date ?>&end_date=<?php echo $end_date ?>&year=<?php echo $year ?>&DIC=<?php echo $dept ?>&Status=<?php echo $status ?>" name="print" target="_blank" class="btn btn-secondary noprint float-right mr-2">Print</a>
                      <span style="align-items: center;justify-content: center;display: flex;font-weight:bold;"> <?php echo $statementTitle ?> </span>

                      <div>
                          <canvas id="canvas"></canvas>
                      </div>
                <?php   } ?>
                <!-- DISPLAY TITLE OF THE CHART (ACCORDING TO USER'S SELECTION) -->
                  
    
                </div>
                

                </div>
              <!--<div class="row">
                    <div class="col-5 col-sm-2 col-md-2 mx-auto">
                        <div class="info-box">
                            <div class="info-box-content">
                                <span class="info-box-text text-center font-weight-bold">Total Record</span>
                                <span class="info-box-number text-center">
                                
                               
                                </span>
                            </div>
                        /.info-box-content 
                        </div>
                         /.info-box 
              </div> -->

              
              </div>
            

               
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
<!-- MODAL -->
<div class="modal fade" id="modal1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detailed Data for <?php echo $statementTitle;  ?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <table class="table table-bordered table-hover">
                <tr>
                  <th>No.</th>
                  <th>WorkNo</th>
                  <th>Service</th>
                  <th>Add User</th>
                  <th >Feedback</th>
                  <th>Add Date</th>
                  <th>DIC</th>
                  <th>Status</th>
                </tr>
                <?php  echo $stmt;?>
              </table>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->

    
</div>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script> 
 <script src="https://rawgit.com/chartjs/chartjs.github.io/master/dist/master/Chart.min.js"></script> 
 <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-piechart-outlabels"></script> -->
<!-- SCRIPT USED FOR CHARTJS  -->
 <script src="chartjs28.js"></script>
<!--<script src="pluginOutlabel.js"></script> -->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script> -->

<script src="admins/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="admins/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="admins/dist/js/adminlte.js"></script>


<script type="text/javascript">
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



</script> 
<!-- OPTIONAL SCRIPTS -->
<!--<script src="admins/plugins/chart.js/Chart.min.js"></script> -->


<!-- AdminLTE for demo purposes -->
<!--<script src="admins/dist/js/demo.js"></script>
 AdminLTE dashboard demo (This is only for demo purposes) 
<script src="admins/dist/js/pages/dashboard3.js"></script> -->


</body>
</html>