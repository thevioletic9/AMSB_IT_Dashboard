<?php
      include 'WorkOrderBack.php';
      include 'header.html';

?>
<script>

     //Error Msg for input field
function validateForm() {
  let x = document.forms["formAct"]["PIC"].value;
  let y = document.forms["formAct"]["DIC"].value;
  let z = document.forms["formAct"]["from_date"].value;
  let a = document.forms["formAct"]["to_date"].value;
  let b = document.forms["formAct"]["Status"].value;

  if (a == "" && z == "" && x == "" && y == "" && b == "") {
   // alert("Please select...");
    	//document.getElementById("errorMessage").innerHTML = "Please select first...";
      //setTimeout("location.reload(true);", 400);
      event.preventDefault();
       alert("Please select the date");
       location.reload();
    	return false;
  } else if (z != "" && a == "" && x == "" && y == "" && b == ""  ){
        //document.getElementById("errorMessage").innerHTML = "Please select to date ";
        //setTimeout("location.reload(true);", 400);
      event.preventDefault();
       alert("Please select to date");
       location.reload();

    	return false;				
  } else if (z == "" && a == "" && x != "" && y == "" && b == ""  ) {
    	//document.getElementById("errorMessage").innerHTML = "Please select the date";
      //setTimeout("location.reload(true);", 600);
      event.preventDefault();
       alert("Please select the date");
       location.reload();
    	return false;
  } else if (z == "" && a == "" && x == "" && y != "" && b == ""  ) {
		  //document.getElementById("errorMessage").innerHTML = "Please select the date";
      event.preventDefault();
       alert("Please select the date");
       location.reload();
    	return false;
  } else if (z == "" && a == "" && x == "" && y == "" && b != ""  ) {
      //document.getElementById("errorMessage").innerHTML = "Please select the date";
      //setTimeout("location.reload(true);", 600);
      event.preventDefault();
       alert("Please select the date");
       location.reload();
    	return false;
  } else if (z == "" && a != "" && x == "" && y == "" && b == ""  ) {
      //document.getElementById("errorMessage").innerHTML = "Please select from date";
      //setTimeout("location.reload(true);", 600);
      event.preventDefault();
       alert("Please select from date");
       location.reload();
    	return false;
  } else if (z != "" && a != "" && x != "" && y != "" && b == ""  ) {
      //document.getElementById("errorMessage").innerHTML = "Invalid selection. Do not select PIC with DIC";
      //setTimeout("location.reload(true);", 600);
      event.preventDefault();
       alert("Invalid selection. Do not select PIC with DIC");
       location.reload();
    	return false;
  } else if (z == "" && a == "" && x != "" && y != "" && b == ""  ) {
      //document.getElementById("errorMessage").innerHTML = "Invalid selection. Do not select PIC with DIC";
      //setTimeout("location.reload(true);", 600);
      event.preventDefault();
       alert("Invalid selection. Do not select PIC with DIC");
       location.reload();
    	return false;
  } else if (z != "" && a != "" && x != "" && y != "" && b != ""  ) {
      //document.getElementById("errorMessage").innerHTML = "Invalid selection. Do not select PIC with DIC";
      //setTimeout("location.reload(true);", 600);
      event.preventDefault();
       alert("Invalid selection. Do not select PIC with DIC");
       location.reload();
    	return false;
  }
}
</script>
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
      }

      thead {
        page-break-inside: avoid;
      }
    }
  
</style>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid" >
        <div class="row d-flex justify-content-center ">
          <div class="col-lg-20 ">
            <div class="card">
              <div class="card-body">
              <h4>Work Order <small>by PIC and by DIC</small></h4>
              <form action="" method="POST" name="formAct" id="formAct" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col-sm">
                      <!--DATE SELECTION -->
                        <label>From Date</label>
                        <input type="date" name="from_date" value="<?php if(isset($_POST['from_date'])){ echo $_POST['from_date']; } ?>" class="form-control" 
                        form="formAct">
                    </div>
                    <div class="col-sm">
                        <label>To Date</label>
                        <input type="date" name="to_date" value="<?php if(isset($_POST['to_date'])){ echo $_POST['to_date']; } ?>" class="form-control" 
                        form="formAct" >
                    </div>
<?php
                     
                    //select employee
                    $stmt3 = $db->prepare(" SELECT DISTINCT [AINDATA].[dbo].[SY_0600].PIC
                                            FROM [AINDATA].[dbo].[SY_0600]
                                            INNER JOIN [AINDATA].[dbo].[SY_0100] 
                                            ON SUBSTRING([AINDATA].[dbo].[SY_0600].PIC,0,6) = [AINDATA].[dbo].[SY_0100].empno
                                            WHERE [AINDATA].[dbo].[SY_0100].[DivCode] = 'IFT' 
                                            AND [AINDATA].[dbo].[SY_0100].[ResignStatus] = 'NO'
                                            AND YEAR([AINDATA].[dbo].[SY_0600].AddDate) >= DATEPART(year, getdate())                 
                                          ");
                    $stmt3->execute();                   
                     //select status
                     $stmt5 = $db->prepare(" SELECT DISTINCT [Status]
                                              FROM dbo.IN_0080
                                              WHERE [Status] IS NOT NULL
                                              AND [Status] <> ''              
                                          ");
                      $stmt5->execute();

                      //display list of department
                      $stmtDIC = $db->prepare(" SELECT DISTINCT [DIC]
                      FROM dbo.SY_0600
                      WHERE [DIC] IS NOT NULL
                      AND [DIC] <> ''    
                      AND [DIC] != 'All'        
                      ");
                      $stmtDIC->execute();


?>

                      <!-- PIC SELECTION -->
                    <div class="col-sm">
                        <label>PIC</label>
                        <select name="PIC" class="custom-select form-control-border border-width-2" 
                        form="formAct" id="selectPIC" onchange="valid()" >
<?php
                          if((isset($_POST['PIC'])))
                          {
?>
                            <option value="<?php { echo $_POST['PIC']; } ?>" > <?php  echo $_POST['PIC'];?>  </option>
<?php   
                          }
                          else {                
?>
                            <option value="" selected="selected" >select employee</option>
<?php    
                         }                 
                        while($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
                        {                    
?>                      
                          <option value="<?php echo $row3['PIC'];?>" ><?php echo $row3['PIC']; ?></option>
<?php                          
                        }
?>                        <option value="All Employee">All</option>
                        </select>
                    </div>

                    <!-- DEPT SELECTION-->
                    <div class="col-sm">
                      <label>DIC</label>
                      <select name="DIC" class="custom-select form-control-border border-width-2"
                       form="formAct" id="selectDIC" onchange="valid()">
                        
<?php                    if((isset($_POST['DIC']))) 
                         {
?>
                             <option value="<?php { echo $_POST['DIC']; } ?>" > <?php  echo strtoupper($_POST['DIC']) ;?>  </option>
<?php
                         }
                         else {
?>
                            <option value="">select dept</option>
<?php                    }
                          while ($rowA = $stmtDIC->fetch(PDO::FETCH_ASSOC)) 
                          {
?>
                            <option value="<?php  echo $rowA['DIC'];?>"><?php echo strtoupper($rowA['DIC']); ?> </option>
<?php                     } 
?>                        <option value="All Dept">All</option>
                      </select>

                    </div>
                    <!-- STATUS SELECTION-->
                    <div class="col-sm">
                        <label>Status</label>
                        <select name="Status" id="" class="custom-select form-control-border border-width-2" 
                         form="formAct" id="selectStatus">
<?php
                            if((isset($_POST['Status'])))
                            {
?>
                              <option value="<?php { echo $_POST['Status']; } ?>" > <?php  echo strtoupper($_POST['Status']) ;?>  </option>
<?php
                            }
                            else { 
?>
                                <option value="" selected="selected" >select status</option>
<?php
                            }
                            while($row2 = $stmt5->fetch(PDO::FETCH_ASSOC))
                            {
?>
                            <option value="<?php  echo $row2['Status'];?>"><?php echo strtoupper($row2['Status']); ?> </option>      
<?php
                            }
                            
?>                          <option value="OVERDUE">OVERDUE</option>
                            <option value="OUTSTANDING">OUTSTANDING</option>
                            <option value="All Status">All</option>
                        </select>
                    </div>
                    <div class="col-sm">
                      <label>Sort By</label>
                      <select name="sort" id="" class="custom-select form-control-border border-width-2">
<?php                   if((isset($_POST['sort'])))  { ?>
                                <option value="<?php { echo $_POST['sort']; } ?>" > <?php  echo $_POST['sort'] ;?>  </option>
<?php                     }?>
                        <option value="WorkNo">WorkNo</option>
                        <option value="InCharge">In Charge A</option>
                        <option value="Status">Status</option>
                        <option value="AddDate">Add Date</option>
                        <option value="EditDate">Edited At</option>
                        <option value="DueDate">Target Date</option>
                      </select>
                    </div>
                    <div class="col-sm">
                      <label>Order</label>
                      <select name="order" id="" class="custom-select form-control-border border-width-2">
<?php                    if((isset($_POST['order'])))  {     ?>
                            <option value="<?php { echo $_POST['order']; } ?>" > <?php  echo $_POST['order'] ;?>  </option>
<?php                    } ?>
                        <option value="ASC">Ascending</option>
                        <option value="DESC">Descending</option>
                      </select>
                    </div>
                    
                    <div class="col-sm">
                      <!-- BUTTONS -->
                        <label class="noprint">Click to Filter</label> </br>
                        <button type="submit" name="submit" class="btn btn-primary noprint" onclick="validateForm()">Filter</button>
                        <a href="WorkOrderData.php" class="btn btn-dark noprint" >Reset</a> </br>

                        <span class="text-danger" id="errorMessage"></span>
                      
                    </div>
                </div>
              </form>
              <div class="row">
                <div class="col-sm ">
            <?php
    
                if(isset($_POST['submit']))
                {
                  $from_date = $_POST['from_date'];
                  $to_date = $_POST['to_date'];
                  $PIC = $_POST['PIC'];
                  $DIC = $_POST['DIC'];
                  $Status = $_POST['Status'];
                  $sort = $_POST['sort'];
                  $order = $_POST['order'];

                    //GENERAL STATEMENT
                    $stmt6 = " SELECT *
                                FROM dbo.IN_0080
                                WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'
                                AND Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                    ";

                    //GENERAL STATEMENT 
                    $stmt20 = "  SELECT COUNT(*) 
                                 FROM dbo.IN_0080
                                 WHERE Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                  ";
                
                    if( ($from_date && $to_date ) <> "") 
                    { 
                             //echo "a1";
                             $stmt90 =  $stmt6 . "ORDER BY '$sort' $order ";
                             $stmt7 =   $db->prepare($stmt90);
                             //$stmt7->execute();
                             $stmtA = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' ";
                             $stmt21 = $db->prepare($stmtA);
                             $category = "";
                             $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                    }
                    if((($from_date && $to_date) && $Status) <> "")
                    {
                             //echo "a3";
                             $stmt9 =  $stmt6 . "AND ([Status] = '$Status') ORDER BY '$sort' $order ";
                             $stmt7 =   $db->prepare($stmt9);
                             $stmtB = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND ([Status] = '$Status') ";
                             $stmt21 = $db->prepare($stmtB);
                             
                    }
                    if ((($from_date && $to_date) && $PIC) <> "") {
                             //echo "a4";
                             $stmt19 =  $stmt6 . "AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6) ORDER BY '$sort' $order ";
                             $stmt7 =   $db->prepare($stmt19);
                             $stmtC = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6) ";
                             $stmt21 = $db->prepare($stmtC);
                             $category = "AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6)";
                             $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";

                    }
                    if ((($from_date && $to_date) && $DIC) <> "") {
                            //echo "a4";
                            $stmtAQ =  $stmt6 . "AND [DIC] = '$DIC' ORDER BY '$sort' $order ";
                            $stmt7 =   $db->prepare($stmtAQ);
                            $stmtAX = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND [DIC] = '$DIC' ";
                            $stmt21 = $db->prepare($stmtAX);
                            $category = "AND [DIC] = '$DIC'";
                            $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                            

                    }
                    if ((($from_date && $to_date) && $PIC && $Status) <> "") {
                             //echo "a4";
                             $stmt67 =  $stmt6 . "AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6) AND ([Status] = '$Status') ORDER BY '$sort' $order ";
                             $stmt7 =   $db->prepare($stmt67);
                             $stmtD = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6) AND ([Status] = '$Status') ";
                             $stmt21 = $db->prepare($stmtD);
                     }
                     if ((($from_date && $to_date) && $DIC && $Status) <> "") {
                              //echo "a4";
                              $stmtBQ =  $stmt6 . "AND [DIC] = '$DIC' AND ([Status] = '$Status') ORDER BY '$sort' $order ";
                              $stmt7 =   $db->prepare($stmtBQ);
                              $stmtBX = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND [DIC] = '$DIC' AND ([Status] = '$Status') ";
                              $stmt21 = $db->prepare($stmtBX);
                              $category = "AND [DIC] = '$DIC'";
                              $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                     }
                     if (($from_date && $to_date ) <> "" && $PIC == 'All Employee') {
                             //echo "a8";
                             $stmt12 =  $stmt6 . "ORDER BY '$sort' $order ";
                             $stmt7 =   $db->prepare($stmt12);
                             $stmtE =  $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' ";
                             $stmt21 = $db->prepare($stmtE);
                             $category = "";
                             $date = "AND[AddDate] BETWEEN '$from_date' AND '$to_date'";
                     }
                     if (($from_date && $to_date ) <> "" && $DIC == 'All Dept') {
                              //echo "a8";
                              $stmtCQ =  $stmt6 . "ORDER BY '$sort' $order ";
                              $stmt7 =   $db->prepare($stmtCQ);
                              $stmtCX =  $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' ";
                              $stmt21 = $db->prepare($stmtCX);
                              $category = "";
                             $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                     }
                     if (($from_date && $to_date ) <> "" && $Status == 'All Status') {
                             //echo "a9";
                             $stmt13 =  $stmt6 . "ORDER BY '$sort' $order ";
                             $stmt7 =   $db->prepare($stmt13);
                             $stmtF = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                             $stmt21 = $db->prepare($stmtF);
                             $category = "";
                             $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                     }
                     if (($from_date && $to_date ) <> "" && $PIC && $Status == 'All Status') {
                             //echo "a12";
                             $stmt15 =  $stmt6 . "AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6) ORDER BY '$sort' $order ";
                             $stmt7 =   $db->prepare($stmt15);
                             $stmtG = $stmt20 .  "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6) ";
                             $stmt21 = $db->prepare($stmtG);
                             $category = "AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6)";
                             $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                     }
                     if (($from_date && $to_date ) <> "" && $DIC && $Status == 'All Status') {
                            //echo "a12";
                            $stmtDX =  $stmt6 . "AND [DIC] = '$DIC' ORDER BY '$sort' $order ";
                            $stmt7 =   $db->prepare($stmtDX);
                            $stmtDS = $stmt20 .  "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND [DIC] = '$DIC' ";
                            $stmt21 = $db->prepare($stmtDS);
                            $category = "AND [DIC] = '$DIC'";
                             $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                     }
                     if (($from_date && $to_date ) <> "" && $Status && $PIC == 'All Employee') {
                             //echo "a12";
                             $stmt78 =  $stmt6 . "AND ([Status] = '$Status') ORDER BY '$sort' $order ";
                             $stmt7 =   $db->prepare($stmt78);
                             $stmtH =  $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND ([Status] = '$Status') ";
                             $stmt21 = $db->prepare($stmtH);
                             $category = "AND ([Status] = '$Status')";
                             $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                     }
                     if (($from_date && $to_date ) <> "" && $Status && $DIC == 'All Dept') {
                            //echo "a12";
                            $stmtDX =  $stmt6 . "AND ([Status] = '$Status') ORDER BY '$sort' $order ";
                            $stmt7 =   $db->prepare($stmtDX);
                            $stmtDZ =  $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND ([Status] = '$Status') ";
                            $stmt21 = $db->prepare($stmtDZ);
                            $category = "AND ([Status] = '$Status')";
                             $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                    }
                    if (($from_date && $to_date ) <> "" && $Status == 'All Status' && $DIC == 'All Dept') {
                      //echo "a12";
                            $stmt112 = $stmt6 . "ORDER BY '$sort' $order ";
                             $stmt7 =   $db->prepare($stmt112);
                             //$stmt7->execute();
                             $stmtA = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' ";
                             $stmt21 = $db->prepare($stmtA);
                             $category = "";
                             $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";  
                    } 
                    if (($from_date && $to_date ) <> "" && $Status == 'All Status' && $PIC == 'All Employee') {
                      //echo "a12";
                            $stmt113 = $stmt6 . "ORDER BY '$sort' $order ";
                            $stmt7 =   $db->prepare($stmt113);
                             //$stmt7->execute();
                             $stmtA = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' ";
                             $stmt21 = $db->prepare($stmtA);
                             $category = "";
                             $date = "AND [AddDate] BETWEEN '$from_date' AND '$to_date'";  
                    } 
                    if (($from_date && $to_date ) <> "" && $Status == 'OVERDUE') {
                              
                      $stmtOver =  $stmt6 . "AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL' ORDER BY '$sort' $order ";
                     $stmt7 =   $db->prepare($stmtOver);
                      //$stmt7->execute();
                      $stmtA = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL'";
                      $stmt21 = $db->prepare($stmtA);
                      $category = "";
                      $date = " AND[AddDate] BETWEEN '$from_date' AND '$to_date'";
                }
                if (($from_date && $to_date ) && $PIC <> "" && $Status == 'OVERDUE') {
                            
                        $stmtOver =  $stmt6 . "AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL' AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6) ORDER BY '$sort' $order";
                        $stmt7 =   $db->prepare($stmtOver);
                        //$stmt7->execute();
                        $stmtA = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL' AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6)";
                        $stmt21 = $db->prepare($stmtA);
                        $category = "AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6)";
                        $date = " AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                }
                if (($from_date && $to_date ) && $DIC <> "" && $Status == 'OVERDUE') {
                            
                        $stmtOver =  $stmt6 . "AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL' AND [DIC] = '$DIC' ORDER BY '$sort' $order";
                        $stmt7 =   $db->prepare($stmtOver);
                        //$stmt7->execute();
                        $stmtA = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL' AND [DIC] = '$DIC'";
                        $stmt21 = $db->prepare($stmtA);
                        $category = "AND [DIC] = '$DIC'";
                        $date = " AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                }
                if (($from_date && $to_date ) <> "" && $Status == 'OUTSTANDING') {
                          
                      $stmtOver =  $stmt6 . "AND [Status] != 'Completed'  AND [Status] != 'CANCEL' ORDER BY '$sort' $order";
                      $stmt7 =   $db->prepare($stmtOver);
                      //$stmt7->execute();
                      $stmtA = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND [Status] != 'Completed'  AND [Status] != 'CANCEL'";
                      $stmt21 = $db->prepare($stmtA);
                      $category = "";
                      $date = " AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                }
                if (($from_date && $to_date ) && $PIC <> "" && $Status == 'OUTSTANDING') {
                            
                      $stmtOver =  $stmt6 . "AND [Status] != 'Completed'  AND [Status] != 'CANCEL' AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6) ORDER BY '$sort' $order";
                      $stmt7 =   $db->prepare($stmtOver);
                      //$stmt7->execute();
                      $stmtA = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND [Status] != 'Completed'  AND [Status] != 'CANCEL' AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6)";
                      $stmt21 = $db->prepare($stmtA);
                      $category = "AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6)";
                      $date = " AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                }
                if (($from_date && $to_date ) && $DIC <> "" && $Status == 'OUTSTANDING') {
                            
                      $stmtOver =  $stmt6 . "AND [Status] != 'Completed'  AND [Status] != 'CANCEL' AND [DIC] = '$DIC' ORDER BY '$sort' $order";
                      $stmt7 =   $db->prepare($stmtOver);
                      //$stmt7->execute();
                      $stmtA = $stmt20 . "AND [AddDate] BETWEEN '$from_date' AND '$to_date' AND [Status] != 'Completed'  AND [Status] != 'CANCEL' AND [DIC] = '$DIC'";
                      $stmt21 = $db->prepare($stmtA);
                      $category = "AND [DIC] = '$DIC'";
                      $date = " AND [AddDate] BETWEEN '$from_date' AND '$to_date'";
                }




                    //OPEN&NOPIC
                    $stmtNoPic = $stmt20 . $date .  "AND [InCharge] IS NULL AND [Status] = 'Open'" . $category;
                    $stmtNoPicA = $db->prepare($stmtNoPic);
                    $stmtNoPicA->execute();
                    $countNoPic = $stmtNoPicA->fetchColumn();

                    //OPENWITHPIC
                    $stmtWithPic = $stmt20 . $date .  "AND [InCharge] IS NOT NULL AND [Status] = 'Open'" . $category;
                    $stmtWithPicA = $db->prepare($stmtWithPic);
                    $stmtWithPicA->execute();
                    $countWithPic = $stmtWithPicA->fetchColumn();

                    //IN-PROGRESS
                    $stmtInProgress = $stmt20 . $date . "AND [Status] = 'In Progress'". $category;
                    $stmtInProgressF = $db->prepare($stmtInProgress);
                    $stmtInProgressF->execute();
                    $countInProgress = $stmtInProgressF->fetchColumn();

                    //COMPLETED
                    $stmtCom = $stmt20 . $date . "AND [Status] = 'Completed'" . $category;
                    $stmtComF = $db->prepare($stmtCom);
                    $stmtComF->execute();
                    $countComF = $stmtComF->fetchColumn();

                    //Others
                    /*$stmtOthers = $stmt20 . $date . " AND Status IN ('IT Testing','User Testing','KIV','Pending') " . $category;
                    $stmtOthersF = $db->prepare($stmtOthers);
                    $stmtOthersF->execute();
                    $countOthersF = $stmtOthersF->fetchColumn(); */

                    //CANCEL
                    $stmtCancel = $stmt20 . $date . " AND [Status] = 'CANCEL' " . $category;
                    $stmtCancelF = $db->prepare($stmtCancel);
                    $stmtCancelF->execute();
                    $countCancelF = $stmtCancelF->fetchColumn();

                    //Waiting Justification
                    $stmtWaitingJust = $stmt20 . $date . " AND [Status] = 'Waiting Justification' " . $category;
                    $stmtWaitingJustF = $db->prepare($stmtWaitingJust);
                    $stmtWaitingJustF->execute();
                    $countWaitingJustF = $stmtWaitingJustF->fetchColumn();

                    //Pass to Supplier
                    $stmtPENDING = $stmt20 . $date ." AND [Status] = 'Pass to Supplier' " . $category;
                    $stmtPENDINGF = $db->prepare($stmtPENDING);
                    $stmtPENDINGF->execute();
                    $countPENDINGF = $stmtPENDINGF->fetchColumn();

                    //kiv
                    //KIV
                    $stmtKIV = $stmt20 . $date ." AND [Status] = 'KIV' " . $category;
                    $stmtKIVF = $db->prepare($stmtKIV);
                    $stmtKIVF->execute();
                    $countKIVF = $stmtKIVF->fetchColumn();

                    //user testing
                    $stmtUserTesting = $stmt20 . $date . " AND [Status] = 'USER TESTING' " . $category;
                    $stmtUserTestingF = $db->prepare($stmtUserTesting);
                    $stmtUserTestingF->execute();
                    $countUserTestingF = $stmtUserTestingF->fetchColumn();

                     //outstanding
                     $stmtOutstanding = $stmt20 . $date . " AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' " . $category;
                     $stmtOutstandingF = $db->prepare($stmtOutstanding);
                     $stmtOutstandingF->execute();
                     $countOutstandingF = $stmtOutstandingF->fetchColumn();
 
                     //overdue
                     $stmtOverdue = $stmt20 . $date . " AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL' " . $category;
                     $stmtOverdueF = $db->prepare($stmtOverdue);
                     $stmtOverdueF->execute();
                     $countOverdueF = $stmtOverdueF->fetchColumn();

                    //null status
                    $stmtStatusNull = $stmt20 . $date . "AND [Status] IS NULL " . $category;
                    $stmtStatusNullF = $db->prepare($stmtStatusNull);
                    $stmtStatusNullF->execute();
                    $countstmtStatusNullF = $stmtStatusNullF->fetchColumn();

                    $stmt7->execute();
                    $stmt21->execute();
                    $rows = $stmt21->fetchColumn();
            ?>   
            <!-- DISPLAY DESCRIPTIONS -->      
            <?php
                $counter = 1;

                  if(! $rows)
                  {
                  //echo "</br>";
                  echo "$rows"." records found";
                  }
                  else
                  {
                  if (($from_date && $to_date) <> "" && $PIC == "" && $DIC == "" && $Status == "") {
                      //echo "</br>";
                      echo "$rows"." records found";
                      echo "</br>";
                      echo "Data display for date: " ."from " . date('d-M-Y',strtotime($from_date)) . " to " . date('d-M-Y',strtotime($to_date));
                      echo "</br>";
                      
                  }
                  elseif ($PIC <> "" && $Status == "") {
                      //echo "a";
                    // echo "</br>";
                      echo "$rows"." records found";
                      echo "</br>";
                      echo "Data display for date: " ."from " . date('d-M-Y',strtotime($from_date)) . " to " . date('d-M-Y',strtotime($to_date));
                      echo "</br>";
                      echo "Data display for employee :" . " $PIC";
                      echo "</br>";
                  } 
                  elseif ($DIC <> "" && $Status == "") {
                      //echo "a";
                    // echo "</br>";
                      echo "$rows"." records found";
                      echo "</br>";
                      echo "Data display for date: " ."from " . date('d-M-Y',strtotime($from_date)) . " to " . date('d-M-Y',strtotime($to_date));
                      echo "</br>";
                      echo "Data display for department :" . " $DIC";
                      echo "</br>";
                  } 
                  elseif ($Status <> "" && $DIC <>"") {
                      //echo "a2";
                    // echo "</br>";
                      echo "$rows"." records found";
                      echo "</br>";
                      echo "Data display for date: " ."from " . date('d-M-Y',strtotime($from_date)) . " to " . date('d-M-Y',strtotime($to_date));
                      echo "</br>";
                      echo "Data display for department :" . " $DIC";
                      echo "</br>";
                      echo "Data display for status:" . " $Status";
                  } 
                  elseif  ($Status <> "" && $PIC <> ""){
                      //echo "a3";
                    // echo "</br>";
                      echo "$rows"." records found";
                      echo "</br>";
                      echo "Data display for date: " ."from " . date('d-M-Y',strtotime($from_date)) . " to " . date('d-M-Y',strtotime($to_date));
                      echo "</br>";
                      echo "Data display for employee :" . " $PIC";
                      echo "</br>";
                      echo "Data display for status:" . " $Status";
                  } 
                  else {
                      //echo "a8";
                      echo "Data display for date: " ."from " . date('d-M-Y',strtotime($from_date)) . " to " . date('d-M-Y',strtotime($to_date));
                      echo "</br>";
                      echo "$rows"." records found";
                      echo "</br>";
                      echo "Data display for status:" . " $Status";
                  }
      
                        ?>
                        </br>
                       
                        <span class=""><small class="text-danger font-weight-bold">overdue,</small><small class="text-warning font-weight-bold">outstanding,</small><small class="text-success font-weight-bold">completed</small></span>
                        <a href="printWOdata.php?from_date=<?php echo $from_date ?>&to_date=<?php echo $to_date ?>&PIC=<?php echo $PIC ?>&DIC=<?php echo $DIC ?>&rows=<?php echo $rows?>&Status=<?php echo $Status ?>&countNoPic=<?php echo $countNoPic; ?>&countWithPic=<?php echo $countWithPic; ?>&countInProgress=<?php echo $countInProgress; ?>&countComF=<?php echo $countComF;?>&countWaitingJustF=<?php echo  $countWaitingJustF; ?>&countPENDINGF=<?php echo $countPENDINGF; ?>&countKIVF=<?php echo $countKIVF; ?>&countUserTestingF=<?php echo $countUserTestingF; ?>&countCancelF=<?php echo $countCancelF; ?>&countstmtStatusNullF=<?php echo $countstmtStatusNullF; ?>&sort=<?php echo $sort; ?>&order=<?php echo $order; ?>" name="print" target="_blank" class="btn btn-primary btn-sm noprint float-right">Print</a>
                      </div>
                      </div>
                      <!-- DISPLAY TOTAL FOR EACH STATUSES -->
                      <div class="row d-flex">
                        <?php if ($Status == ("Waiting Justification" && "Pass to Supplier" && "KIV" && "IN-PROGRESS" && "CANCEL" && "USER TESTING" 
                                  && "COMPLETED" && "OPEN") && $Status != "All Status" ) { ?>
                             
                        <?php } else { ?>
                          <table class="table table-bordered table-hover mt-2" style="padding: 2px;">
                            <tr>
                              <td><small>Open No PIC: <?php echo $countNoPic; ?></small></td> 
                              <td><small>Open With PIC: <?php echo $countWithPic;  ?></small></td> 
                              <td><small>In-Progress : <?php echo $countInProgress;  ?></small></td>
                              <td><small>Completed : <?php echo $countComF;  ?></small></td> 
                              <td><small>Waiting Justification : <?php echo  $countWaitingJustF; ?> </small></td> 
                              <td><small>Pass to Supplier : <?php echo $countPENDINGF;  ?> </small></td> 
                              <td><small>KIV : <?php echo $countKIVF;  ?> </small></td> 
                              <td><small>User Testing : <?php echo $countUserTestingF;  ?> </small></td> 
                              <td><small>Cancel : <?php echo $countCancelF;  ?></small></td>
                              <td><small>Overdue : <?php echo $countOverdueF;  ?></small></td>
                              <td><small>Outstanding : <?php echo $countOutstandingF;  ?></small></td>
                              <td><small>Null Status : <?php echo $countstmtStatusNullF;  ?></small></td>
                            </tr>
                          </table>

                        <?php }  ?>
                      </div>

                    <div class="d-flex">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                            <th>No</th>
                            <th>WorkNo</th>
                            <th>EmpNo & EmpName</th>
                            <th>Reason</th>
                            <th>Service</th>
                            <th>DIC</th>
                            <th>In Charge</th>
                            <th>Status</th>
                            <th>Add Date</th>
                            <th>Edited At</th>
                            <th>Due Date</th>
                        </tr>
                        </thead>
                        <?php

                        //DISPLAY DATATABLE
                        while($row = $stmt7->fetch(PDO::FETCH_ASSOC))
                        {
            ?>             
                            <tr>
                              <?php $currentDate = date("Y/m/d");
                                    $time = date("Y/m/d",strtotime($row['DueDate'])); 
                                    $statuss = $row['Status'];
                                  //adjust jugak as 'Completed'
                                if ($currentDate > $time && $statuss != 'Completed' && $statuss != 'Cancel' ) {
                                      $colour = "text-danger";
                                 } elseif ($statuss != 'Completed' && $statuss != 'Cancel') {
                                    $colour = "text-warning";
                                    //XJDI NI KENO DUA2 MASUK
                                 } elseif ($statuss == ('Completed' && 'COMPLETED') && $statuss != 'Cancel' ) {
                                    $colour = "text-success";
                                 }
                                  else {
                                    $colour = "";
                                 } ?>
                                <td class = <?php echo $colour; ?> ><?php echo $counter++; ?></td>
                                <td class= <?php echo $colour;  ?> ><?php echo $row['WorkNo']; ?></td>
                                <td class= <?php echo $colour;  ?> ><?php echo $row['EmpNo']; ?> </br> <?php echo $row['EName']; ?></td>
                                <td class= <?php echo $colour;  ?> style="max-width:150px;"><small><?php echo $row['Reason']; ?></small></td>
                                <td class= <?php echo $colour;  ?> ><?php echo $row['Service']; ?></td>
                                <td class= <?php echo $colour;  ?> ><?php echo $row['DIC']; ?></td>
                                <td class= <?php echo $colour;  ?> ><?php echo $row['InCharge']; ?></td>
                                <td class= <?php echo $colour;  ?> ><?php echo $row['Status']; ?></td>
                                <td class= <?php echo $colour;  ?> ><?php echo $time = date("Y/m/d",strtotime($row['AddDate'])); ?></td>
                                <td class= <?php echo $colour;  ?> ><?php echo $time = date("Y/m/d",strtotime($row['EditDate'])); ?></td>
                                <td class= <?php echo $colour;  ?> ><?php echo $time = date("Y/m/d",strtotime($row['DueDate'])); ?></td>
                            </tr>         
            <?php 
                        }

                        }
                  } 
   
            ?> 
                    </table>
                </div>
                <!-- /.d-flex -->
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

<script src="admins/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="admins/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="admins/dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="admins/plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!--<script src="admins/dist/js/demo.js"></script>
 AdminLTE dashboard demo (This is only for demo purposes) 
<script src="admins/dist/js/pages/dashboard3.js"></script> -->
<script>
   function valid() {
                            var PIC = document.getElementById('selectPIC').value;
                            var DIC = document.getElementById('selectDIC').value;
                            
                            if ( PIC  != '') {
                                document.getElementById('selectDIC').disabled = true; 
                                document.getElementById('selectDIC').setAttribute("value","");
                              } else if (DIC != '') {
                                document.getElementById('selectPIC').disabled  = true;
                                document.getElementById('selectPIC').setAttribute("value","");
                              }
                                          
                          } 

          document.querySelector("form").addEventListener("submit", function(e){
                document.getElementById('selectDIC').disabled = false;
                document.getElementById('selectPIC').disabled = false;
          });
</script>
</body>
</html>
