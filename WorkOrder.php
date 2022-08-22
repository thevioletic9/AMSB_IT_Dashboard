<?php
      include 'WorkOrderBack.php';
      include 'header.html';

?>

<style>
    @media screen and (min-width: 1200px) {
        .modal-dialog {
          max-width: 2000px;
        }
    }

    @media print
    {
    .noprint {display:none;}
    }

</style>

<script>
    //Error Msg for input field
function validateForm() {
  let x = document.forms["formAct"]["PIC"].value;
  let y = document.forms["formAct"]["DIC"].value;
  let z = document.forms["formAct"]["from_date"].value;
  
  if (x == "" && y == "" && z == "") {
   // alert("Please select...");
    //document.getElementById("errorMessage").innerHTML = "Please select first...";
    event.preventDefault();
    alert("Please select first...");
    location.reload();
    return false;
  } else if (x != "" && y != "" && z != "") {
    //document.getElementById("errorMessage").innerHTML = "Invalid selection";
    //document.write("test");
    event.preventDefault();
    alert("Invalid selection.Please choose either PIC or DIC");
    location.reload();
    return false;
  } else if (x != "" && y != "" && z == "") {
    //document.getElementById("errorMessage").innerHTML = "Invalid selection";
    //document.write("test");
    event.preventDefault();
    alert("Invalid selection.Please choose either PIC or DIC");
    location.reload();
    return false;
  }
  
}
</script>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid" >
        <div class="row d-flex justify-content-center ">
          <div class="col-lg-15 ">
            <div class="card">
              <div class="card-body">
              <h4>Work Order Record</h4>
              <form action="" method="POST" name="formAct" id="formAct" onsubmit="return validateForm()">
                    <div class="row">
                      <!-- PIC SELECTION -->
                    <div class="col-sm">
                        <label class="noprint">PIC</label>
                        <select name="PIC" class="custom-select form-control-border border-width-2 noprint"
                         form="formAct" id="selectPIC" onchange="valid()" >
<?php                 
                         if((isset($_POST['PIC'])))
                        {
?>
                          <option value="<?php { echo $_POST['PIC']; } ?>" > <?php  echo $_POST['PIC'];?>  </option>
<?php                         
                        } else {
?>
                            <option value="" >select employee </option>
<?php
                        }
                        while($row3 = $stmtPIC->fetch(PDO::FETCH_ASSOC))
                        {                    
?>                        
                          <option value="<?php echo $row3['PIC'];?>"  >  <?php echo $row3['PIC']; ?> </option>
<?php                          
                        }
?>  

                        </select>
                    </div>
                    <!-- DEPARTMENT SELECTION-->
                    <div class="col-sm">
                        <label class="noprint" >Department</label>
                        <select name="DIC" class="custom-select form-control-border border-width-2 noprint" 
                        form="formAct" id="selectDIC" onchange="valid()">
<?php
                            if((isset($_POST['DIC'])))
                            {
?>
                              <option value="<?php { echo $_POST['DIC']; } ?>" > <?php  echo $_POST['DIC'];?>  </option>   
<?php
                            } else {
?>
                                <option value=""  selected="selected">select department </option>
<?php
                            }
                            while($row2 = $stmtDIC->fetch(PDO::FETCH_ASSOC))
                            {
?>
                              <option value="<?php  echo $row2['DIC'];?>" ><?php echo strtoupper($row2['DIC']); ?> </option>      
<?php
                            }
?>
                        </select>
                    </div>
                    <div class="col-sm">
                      <label class="noprint" for="">Date (selected date until <?php echo date('d-M-Y'); ?>)</label>
                      <?php
                      if((isset($_POST['from_date']))) 
                      {
?>
                          <input type="date" name="from_date" value="<?php if(isset($_POST['from_date'])){ echo $_POST['from_date']; } ?>" class="form-control noprint" id="date" onchange="valid()">
<?php
                      } else {
?>
                          <input type="date" name="from_date" value="" class="form-control noprint" form="formAct" id="date" onchange="valid()">
<?php
                      }
?>        

                    </div>
                    <div class="col-sm">
                          </br>
                          <!---BUTTONS-->
                        <button type="submit" name="simpan" class="btn btn-primary mr-10 noprint" onclick="validateForm()">Filter</button>
                        <!--<button type="submit" name="all" class="btn btn-primary">View All</button> -->
                        <a href="WorkOrder.php" class="btn btn-dark noprint mr-2" >Reset</a>
                        <!--<a href="woPrint.php?from_date=<?php echo $from_date ?>&PIC=<?php echo $PIC ?>&DIC=<?php echo $DIC ?>&rows=<?php echo $rows7?>&noPic=<?php echo $fpNoPic; ?>
                                 &wPIC=<?php echo $fpNPicOpen; ?>&InProgress=<?php echo $fpInProgress; ?>&comp=<?php echo $fpComF; ?>&others=<?php echo $fpOthersF; ?>&cancel=<?php echo $fpCancelF; ?>
                                 &outs=<?php echo $fpOutF; ?>&over=<?php echo $fpOverF; ?>&percno=<?php echo $fperc1; ?>&percpic=<?php echo $fperc2; ?>&inprog=<?php echo $fperc3; ?>&pcomp=<?php echo $fperc4; ?>&pothers=<?php echo $fperc12; ?>&pcancel=<?php echo $fperc7; ?>&outp=<?php echo $fperc5; ?>&overp=<?php echo $fperc6; ?>" name="print" target="_blank" class="btn btn-secondary noprint float-right" >Print</a> </br> -->
                      <div class="btn-group">
                        <button type="button" class="btn btn-secondary">Print</button>
                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown">
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">

                          <a class="dropdown-item" href="woPrint.php?from_date=<?php echo $from_date ?>&PIC=<?php echo $PIC ?>&DIC=<?php echo $DIC ?>&rows=<?php echo $rows7?>&noPic=<?php echo $fpNoPic; ?>
                                 &wPIC=<?php echo $fpNPicOpen; ?>&InProgress=<?php echo $fpInProgress; ?>&comp=<?php echo $fpComF; ?>&others=<?php echo $fpOthersF; ?>&cancel=<?php echo $fpCancelF; ?>
                                 &outs=<?php echo $fpOutF; ?>&over=<?php echo $fpOverF; ?>&percno=<?php echo $fperc1; ?>&percpic=<?php echo $fperc2; ?>&inprog=<?php echo $fperc3; ?>&pcomp=<?php echo $fperc4; ?>&pothers=<?php echo $fperc12; ?>&pcancel=<?php echo $fperc7; ?>&outp=<?php echo $fperc5; ?>&overp=<?php echo $fperc6; ?>"
                                  name="print" target="_blank" >Report 1</a>

                          <a class="dropdown-item" href="woPrint2.php?from_date=<?php echo $from_date ?>&PIC=<?php echo $PIC ?>&DIC=<?php echo $DIC ?>&rows=<?php echo $rows7?>&noPic=<?php echo $fpNoPic; ?>
                                 &wPIC=<?php echo $fpNPicOpen; ?>&InProgress=<?php echo $fpInProgress; ?>&comp=<?php echo $fpComF; ?>&others=<?php echo $fpOthersF; ?>&cancel=<?php echo $fpCancelF; ?>
                                 &outs=<?php echo $fpOutF; ?>&over=<?php echo $fpOverF; ?>&percno=<?php echo $fperc1; ?>&percpic=<?php echo $fperc2; ?>&inprog=<?php echo $fperc3; ?>&pcomp=<?php echo $fperc4; ?>&pothers=<?php echo $fperc12; ?>&pcancel=<?php echo $fperc7; ?>&outp=<?php echo $fperc5; ?>&overp=<?php echo $fperc6; ?>"
                                  name="print" target="_blank" >Report 2</a>

                          <a class="dropdown-item" href="PieChartWOprint1.php?from_date=<?php echo $from_date ?>&PIC=<?php echo $PIC ?>&DIC=<?php echo $DIC ?>&rows=<?php echo $rows7?>&noPic=<?php echo $fpNoPic; ?>
                                 &wPIC=<?php echo $fpNPicOpen; ?>&InProgress=<?php echo $fpInProgress; ?>&comp=<?php echo $fpComF; ?>&others=<?php echo $fpOthersF; ?>&cancel=<?php echo $fpCancelF; ?>
                                 &outs=<?php echo $fpOutF; ?>&over=<?php echo $fpOverF; ?>&percno=<?php echo $fperc1; ?>&percpic=<?php echo $fperc2; ?>&inprog=<?php echo $fperc3; ?>&pcomp=<?php echo $fperc4; ?>&pothers=<?php echo $fperc12; ?>&pcancel=<?php echo $fperc7; ?>&outp=<?php echo $fperc5; ?>&overp=<?php echo $fperc6; ?>"
                          name="print" target="_blank" >Pie Chart (Status)</a>

                          <a class="dropdown-item" href="PieChartWOprint2.php?from_date=<?php echo $from_date ?>&PIC=<?php echo $PIC ?>&DIC=<?php echo $DIC ?>&rows=<?php echo $rows7?>&noPic=<?php echo $fpNoPic; ?>
                                 &wPIC=<?php echo $fpNPicOpen; ?>&InProgress=<?php echo $fpInProgress; ?>&comp=<?php echo $fpComF; ?>&others=<?php echo $fpOthersF; ?>&cancel=<?php echo $fpCancelF; ?>
                                 &outs=<?php echo $fpOutF; ?>&over=<?php echo $fpOverF; ?>&percno=<?php echo $fperc1; ?>&percpic=<?php echo $fperc2; ?>&inprog=<?php echo $fperc3; ?>&pcomp=<?php echo $fperc4; ?>&pothers=<?php echo $fperc12; ?>&pcancel=<?php echo $fperc7; ?>&outp=<?php echo $fperc5; ?>&overp=<?php echo $fperc6; ?>"
                                  name="print" target="_blank" >Pie Chart (PIC)</a>

                          <a class="dropdown-item" href="barChartWOprint.php?from_date=<?php echo $from_date ?>&PIC=<?php echo $PIC ?>&DIC=<?php echo $DIC ?>&rows=<?php echo $rows7?>&noPic=<?php echo $fpNoPic; ?>
                                 &wPIC=<?php echo $fpNPicOpen; ?>&InProgress=<?php echo $fpInProgress; ?>&comp=<?php echo $fpComF; ?>&others=<?php echo $fpOthersF; ?>&cancel=<?php echo $fpCancelF; ?>
                                 &outs=<?php echo $fpOutF; ?>&over=<?php echo $fpOverF; ?>&percno=<?php echo $fperc1; ?>&percpic=<?php echo $fperc2; ?>&inprog=<?php echo $fperc3; ?>&pcomp=<?php echo $fperc4; ?>&pothers=<?php echo $fperc12; ?>&pcancel=<?php echo $fperc7; ?>&outp=<?php echo $fperc5; ?>&overp=<?php echo $fperc6; ?>"
                                  name="print" target="_blank" >Bar Chart (DIC)</a>
                        </div>
                      </div>
                    </div>
                </div>
              </form></br>
             <div class="col-sm">
              <!---DISPLAY DESCRIPTIONS-->
                   <?php if ($category <> "" && $from_date <> "") { ?> 
                            <span class="text-start">Filter by department/PIC : <?php echo $DIC?>  <?php echo $PIC?></span> </br>
                            <span class="text-start">Filter by date : <?php echo date('d-M-Y',strtotime($from_date));?> until <?php echo date('d-M-Y'); ?></span> 
                    <?php 
                         }
                         elseif ($category == "" && $from_date <> "") { ?>
                            <span class="text-start">Filter by date : <?php echo date('d-M-Y',strtotime($from_date));?> until <?php echo date('d-M-Y'); ?></span> 
                   <?php }
                          elseif ($category <> "" && $from_date == "") { ?>
                             <span class="text-start">Filter by department/PIC : <?php echo $DIC?>  <?php echo $PIC?>(last 7 days) </span>  
                    <?php }
                          else {
                            $from7 = date('d-M-Y', strtotime('-7 days')); 
                            $current = date('d-M-Y');
                            ?>
                          <span class="text-start ">General data (last 7 days) <small>from <?php echo $from7; ?> to <?php echo $current; ?></small></span> 
                    <?php } 
                   ?>  
                    <p class="float-leftfont-weight-bold"><?php echo $rows7; ?> records found <small>(Open No PIC : <?php echo $fpNoPic; ?>, Open with PIC : <?php echo $fpNPicOpen; ?>,
                                                                                                  In-progress: <?php echo $fpInProgress; ?>,Completed: <?php echo $fpComF; ?>,Others: <?php echo $fpOthersF; ?>,
                                                                                                  Cancel: <?php echo $fpCancelF; ?>)  </small></small> </p> </p>
                </div>

              <!---CHARTS-->
              <div class="row">
                    <div class="col-md">
                        <small style="text-align: center;font-weight:bold;" >Pie Chart filter by Status</small>
                        <canvas id="outlabeledChart" style="min-height: 400px; height: 250px;  max-width: 100%;"></canvas>
                        <span class="btn btn-primary btn-xs noprint" data-toggle="modal" data-target="#modal-zoom1" role="button">Zoom</span> 
                    </div>
                    <div class="col-md">
                        <small style="text-align: center;font-weight:bold;" >Pie Chart filter by PIC (person in-charge)</small>
                        <canvas id="outlabeledChart2" style="min-height: 400px; height: 250px;  max-width: 100%;"></canvas>
                        <span class="btn btn-primary btn-xs noprint" data-toggle="modal" data-target="#modal-zoom2" role="button">Zoom</span> 
                        <!--<a target = '_blank' href="test90.php?<?php echo $from_date   ?>" role="button" class="btn btn-primary btn-xs" >zoom</a> --> 
                    </div>
                    <div class="col-md">
                        <small style="text-align: center;font-weight:bold;">Bar Chart filter by DIC (department in-charge)</small>
                        <canvas id="bar-chart" style="min-height: 400px; height: 250px;  max-width: 100%;"></canvas>
                    </div>
                    
                </div>
              </div>
        <!---DISPLAY THE COUNT OF THE STATUS, PERCENTAGE AND VIEW BUTTON(MODAL)-->
<div class="row"> 
  <div class="col-md">
    <div class="card-group">
                      <div class="card border-right">
                          <div class="card-body bg-light">
                              <div class="d-flex d-lg-flex d-md-block align-items-center">
                                  <div>
                                      <h6 class="text-dark mb-1 font-weight-bold">Open <small>No PIC</small></h6>
                                      <div class="d-inline-flex align-items-center">
                                          <h2 class="text-dark mb-1 font-weight-medium"><?php echo $fpNoPic; ?></h2>
                                          <span class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none" data-toggle="modal" data-target="#modal-lg" role="button">View</span> 
                                      </div></br>
                                      <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $fperc1; ?> % </small></span>
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
                                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $fpNPicOpen; ?></h2>
                                        <span class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none" data-toggle="modal" data-target="#modal-2" role="button">View</span> 
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $fperc2; ?> % </small></span>
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
                                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $fpInProgress; ?></h2>
                                        <span class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none" data-toggle="modal" data-target="#modal-3" role="button">View</span> 
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $fperc3; ?>  % </small></span>
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
                                        <h2 class="text-dark mb-1 font-weight-medium"> <?php echo $fpComF; ?> </h2>
                                        <span class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none" data-toggle="modal" data-target="#modal-4" role="button">View</span> 
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $fperc4; ?>  % </small></span>
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
                                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $fpOthersF; ?></h2>
                                        <span class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none" data-toggle="modal" data-target="#modal-12" role="button">View</span> 
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $fperc12; ?> % </small></span>
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
                                        <h2 class="text-dark mb-1 font-weight-medium"><?php echo $fpCancelF; ?></h2>
                                        <span class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none" data-toggle="modal" data-target="#modal-7" role="button">View</span> 
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $fperc7; ?> % </small></span>
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
                                        <h2 class="mb-1 font-weight-bold text-danger" > <?php echo $fpOutF; ?></h2>
                                        <span class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none" data-toggle="modal" data-target="#modal-5" role="button">View</span> 
                                    </div> </br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $fperc5; ?> % </small></span>
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
                                        <h2 class="text-danger mb-1 font-weight-bold"><?php echo $fpOverF; ?></h2>
                                        <span class="badge bg-primary font-12 text-white font-weight-medium badge-pill ml-2 d-lg-block d-md-none" data-toggle="modal" data-target="#modal-6" role="button">View</span> 
                                    </div></br>
                                    <span ><small class=" font-weight-bold mb-0 w-100 text-truncate">Percentage: <?php echo $fperc6; ?> % </small></span>
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
<!---MODAL (FROM THE VIEW BUTTON)-->
<div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detailed Data for Open <small>no PIC </small></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-sm">
                <?php echo $fpNoPic; ?> records found
              </div>
              <div class="col-sm">
                <input type="search" placeholder="Search..." class="form-control search-input float-right" data-table="work-order" style="width:40%;"/>
              </div>
            </div>
              <table class="table table-bordered table-hover mt-2 work-order">
                <tr>
                  <th>No.</th> 
                  <th>WorkNo</th>
                  <th>EmpNo & EmpName</th>
                  <th>Reason</th>
                  <th>Service</th>
                  <th>DIC</th>
                  <th>In Charge</th>
                  <th>Last Update</th>
                  <th>Add Date</th>
                  <th>Due Date</th>
                </tr>
                <?php  echo $stmtT;?>
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

<div class="modal fade" id="modal-2">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detailed Data for Open <small>with PIC </small></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-sm">
                <?php echo $fpNPicOpen; ?> records found
              </div>
              <div class="col-sm">
                <input type="search" placeholder="Search..." class="form-control search-input float-right" data-table="work-order" style="width:40%;"/>
              </div>
            </div>
              <table class="table table-bordered table-hover mt-2 work-order">
                <tr>
                  <th>No.</th> 
                  <th>WorkNo</th>
                  <th>EmpNo & EmpName</th>
                  <th>Reason</th>
                  <th>Service</th>
                  <th>DIC</th>
                  <th>In Charge</th>
                  <th>Last Update</th>
                  <th>Add Date</th>
                  <th>Due Date</th>
                </tr>
                <?php  echo $stmtT2;?>
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


<div class="modal fade" id="modal-3">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detailed Data for In-Progress</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-sm">
                <?php echo $fpInProgress; ?> records found
              </div>
              <div class="col-sm">
                <input type="search" placeholder="Search..." class="form-control search-input float-right" data-table="work-order" style="width:40%;"/>
              </div>
            </div>
              <table class="table table-bordered table-hover mt-2 work-order">
                <tr>
                  <th>No.</th> 
                  <th>WorkNo</th>
                  <th>EmpNo & EmpName</th>
                  <th>Reason</th>
                  <th>Service</th>
                  <th>DIC</th>
                  <th>In Charge</th>
                  <th>Last Update</th>
                  <th>Add Date</th>
                  <th>Due Date</th>
                </tr>
                <?php  echo $stmtT3;?>
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

<div class="modal fade" id="modal-4">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detailed Data for Completed</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-sm">
                <?php echo $fpComF; ?> records found
              </div>
              <div class="col-sm">
                <input type="search" placeholder="Search..." class="form-control search-input float-right" data-table="work-order" style="width:40%;"/>
              </div>
            </div>
              <table class="table table-bordered table-hover mt-2 work-order">
                <tr>
                  <th>No.</th> 
                  <th>WorkNo</th>
                  <th>EmpNo & EmpName</th>
                  <th>Reason</th>
                  <th>Service</th>
                  <th>DIC</th>
                  <th>In Charge</th>
                  <th>Last Update</th>
                  <th>Add Date</th>
                  <th>Due Date</th>
                </tr>
                <?php  echo $stmtT4;?>
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

<div class="modal fade" id="modal-5">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detailed Data for Outstanding</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-sm">
                    <?php echo $fpOutF; ?> records found
              </div>
              <div class="col-sm">
                <input type="search" placeholder="Search..." class="form-control search-input float-right" data-table="work-order" style="width:40%;"/>
              </div>
            </div>
              <table class="table table-bordered table-hover mt-2 work-order">
                <tr>
                  <th>No.</th> 
                  <th>WorkNo</th>
                  <th>EmpNo & EmpName</th>
                  <th>Reason</th>
                  <th>Service</th>
                  <th>DIC</th>
                  <th>Status</th>
                  <th>In Charge</th>
                  <th>Last Update</th>
                  <th>Add Date</th>
                  <th>Due Date</th>
                </tr>
                <?php  echo $stmtT5;?>
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


<div class="modal fade" id="modal-6">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detailed Data for Overdue</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-sm">
                  <?php echo $fpOverF; ?> records found
              </div>
              <div class="col-sm">
                <input type="search" placeholder="Search..." class="form-control search-input float-right" data-table="work-order" style="width:40%;"/>
              </div>
            </div>
              <table class="table table-bordered table-hover mt-2 work-order">
                <tr>
                  <th>No.</th> 
                  <th>WorkNo</th>
                  <th>EmpNo & EmpName</th>
                  <th>Reason</th>
                  <th>Service</th>
                  <th>DIC</th>
                  <th>Status</th>
                  <th>In Charge</th>
                  <th>Last Update</th>
                  <th>Add Date</th>
                  <th>Due Date</th>
                </tr>
                <?php  echo $stmtT6;?>
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

<div class="modal fade" id="modal-7">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detailed Data for Cancel</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-sm">
                  <?php echo $fpCancelF; ?> records found
              </div>
              <div class="col-sm">
                <input type="search" placeholder="Search..." class="form-control search-input float-right" data-table="work-order" style="width:40%;"/>
              </div>
            </div>
              <table class="table table-bordered table-hover mt-2 work-order">
                <tr>
                  <th>No.</th> 
                  <th>WorkNo</th>
                  <th>EmpNo & EmpName</th>
                  <th>Reason</th>
                  <th>Service</th>
                  <th>DIC</th>
                  <th>In Charge</th>
                  <th>Last Update</th>
                  <th>Add Date</th>
                  <th>Due Date</th>
                </tr>
                <?php  echo $stmtT7;?>
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

<div class="modal fade" id="modal-12">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Detailed Data for Others</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <div class="row">
              <div class="col-sm">
              <?php echo $fpOthersF; ?> records found
              </div>
              <div class="col-sm">
                <input type="search" placeholder="Search..." class="form-control search-input float-right" data-table="work-order" style="width:40%;"/>
              </div>
            </div>
              <table class="table table-bordered table-hover mt-2 work-order">
                <tr>
                  <th>No.</th> 
                  <th>WorkNo</th>
                  <th>EmpNo & EmpName</th>
                  <th>Reason</th>
                  <th>Service</th>
                  <th>DIC</th>
                  <th>Status</th>
                  <th>In Charge</th>
                  <th>Edited At</th>
                  <th>Add Date</th>
                  <th>Due Date</th>
                </tr>
                <?php  echo $stmtT12;?>
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

<div class="modal fade" id="modal-zoom1">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pie chart by Status</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <span style="align-items: center;justify-content: center;display: flex;font-weight:bold;" >Pie chart filter by Status <?php echo $titleChart ?></span>
              <canvas id="outlabeledChart1" style="max-height: 700px;  max-width: 100%;"></canvas>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-zoom2">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pie chart by PIC</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="chart-container">
              <div class="container justify-content-center" style="max-height: 1000px;  max-width: 300%;">
                <span style="align-items: center;justify-content: center;display: flex;font-weight:bold;" >Pie chart filter by PIC <?php echo $titleChart ?></span>
                  <canvas id="outlabeledChartZ2"  ></canvas>
                </div>
              </div>
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
<!---SCRIPTS FOR CHARTJS-->
<script src="chartjs28.js"></script>
<script src="pluginOutlabel.js"></script>

<script src="admins/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="admins/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="admins/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<!--<script src="admins/plugins/chart.js/Chart.min.js"></script> -->

<script>
   function valid() {
               var PIC = document.getElementById('selectPIC').value;
               var DIC = document.getElementById('selectDIC').value;
               var date = document.getElementById('date').value;

               if ( PIC && date != '') {
                   document.getElementById('selectDIC').disabled = true; 
                   document.getElementById('selectDIC').setAttribute("value","");
                } else if (DIC && date != '') {
                   document.getElementById('selectPIC').disabled  = true;
                   document.getElementById('selectPIC').setAttribute("value","");
                }
                            
            } 

          document.querySelector("form").addEventListener("submit", function(e){
                document.getElementById('selectDIC').disabled = false;
                document.getElementById('selectPIC').disabled = false;
          });
  //SCRIPT FOR SEARCH BAR IN MODAL
(function(document) {
            'use strict';

            var TableFilter = (function(myArray) {
                var search_input;

                function _onInputSearch(e) {
                    search_input = e.target;
                    var tables = document.getElementsByClassName(search_input.getAttribute('data-table'));
                    myArray.forEach.call(tables, function(table) {
                        myArray.forEach.call(table.tBodies, function(tbody) {
                            myArray.forEach.call(tbody.rows, function(row) {
                                var text_content = row.textContent.toLowerCase();
                                var search_val = search_input.value.toLowerCase();
                                row.style.display = text_content.indexOf(search_val) > -1 ? '' : 'none';
                            });
                        });
                    });
                }

                return {
                    init: function() {
                        var inputs = document.getElementsByClassName('search-input');
                        myArray.forEach.call(inputs, function(input) {
                            input.oninput = _onInputSearch;
                        });
                    }
                };
            })(Array.prototype);

            document.addEventListener('readystatechange', function() {
                if (document.readyState === 'complete') {
                    TableFilter.init();
                }
            });

        })(document);



</script>
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
                    zoomOutPercentage: 55, // makes chart 55% smaller (50% by default, if the preoprty is undefined)
                    plugins: {
                        legend: false,
                        outlabels: {
                            text: '%l \n %p. ',
                            color: 'white',
                            stretch:10,
                            font: {
                                resizable: true,
                                minSize: 5,
                                maxSize: 10
                            }
                        }
                    }
                }
            });
            //zoom ver
            //pie chart by status
        var cDataZ =JSON.parse(`<?php echo $dataWStatus['chartWStatus']; ?>`);
            var chartZ = new Chart('outlabeledChart1', {
                type: 'outlabeledPie',
                data: {
                    labels: cDataZ.label,
                    datasets: [{
                        backgroundColor: cDataZ.colour,
                        data: cDataZ.data
                    }]
                },
                options: {
                    zoomOutPercentage: 40,
                    layout: {
                      padding:60
                    }, 
                    plugins: {
                        legend: false,
                        outlabels: {
                            text: '%l \n  %p. ',
                            color: 'white',
                            stretch:15,
                            font: {
                                resizable: true,
                                minSize: 10,
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
                    zoomOutPercentage: 55, // makes chart 55% smaller (50% by default, if the preoprty is undefined)
                    plugins: {
                        legend: false,
                        outlabels: {
                            text: '%l \n %p.',
                            color: 'white',
                            stretch:10,
                            font: {
                                resizable: true,
                                minSize: 5,
                                maxSize: 8
                            }
                        }
                    }
                }
            });

            //ZOOM VER
             //pie chart by PIC
        var cDataZ2 = JSON.parse(`<?php echo $data['chart_data']; ?>`);
            var chart = new Chart('outlabeledChartZ2', {
                type: 'outlabeledPie',
                data: {
                    labels: cDataZ2.label,
                    datasets: [{
                        backgroundColor: cDataZ2.colours,
                        data: cDataZ2.data
                    }]
                },
                options: {
                    zoomOutPercentage: 40, // makes chart 55% smaller (50% by default, if the preoprty is undefined)
                    //maintainAspectRatio: false,
                    layout: {
                      padding: 100
                    },
                    plugins: {
                      legend: false,
                        outlabels: {
                            text: '%l \n %p.',
                            color: 'white',
                            stretch:10,
                            font: {
                                resizable: true,
                                minSize: 9,
                                maxSize: 10,
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
                        display: true,
                        
                    }
                }]
            },
            layout: {
                padding: {
                    left: 10,
                    right: 10,
                    top: 10,
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

         
</script>
<!-- AdminLTE for demo purposes -->
<!--<script src="admins/dist/js/demo.js"></script>
 AdminLTE dashboard demo (This is only for demo purposes) 
<script src="admins/dist/js/pages/dashboard3.js"></script> -->
</body>
</html>


