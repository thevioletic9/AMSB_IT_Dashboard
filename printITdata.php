<?php
      include 'ITTaskBack.php';


    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    $PIC = $_GET['PIC'];
    $DIC = $_GET['DIC'];
    $Status = $_GET['Status'];
    $rows = $_GET['rows'];
    $countNoPic = $_GET['countNoPic'];
    $countWithPic =$_GET['countWithPic'];
    $countInProgress =$_GET['countInProgress'];
    $countComF = $_GET['countComF'];
    $countWaitingJustF = $_GET['countWaitingJustF'];
    $countPENDINGF = $_GET['countPENDINGF'];
    $countKIVF = $_GET['countKIVF'];
    $countUserTestingF = $_GET['countUserTestingF'];
    $countCancelF = $_GET['countCancelF'];
    $countstmtStatusNullF =  $_GET['countstmtStatusNullF'];
    $sort = $_GET['sort'];
    $order = $_GET['order'];

    //general statement 
    $stmt6 = " SELECT *
    FROM dbo.SY_0600
    WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'
";

//general statement to count
$stmt20 = "  SELECT COUNT(*) 
     FROM dbo.SY_0600 ";

if( ($from_date && $to_date ) <> "") 
{ 
 //echo "a1";
 //$stmt90 =  $stmt6 . "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
 $stmt66 = $stmt6 . "ORDER BY '$sort' $order ";
 $stmt7 =   $db->prepare($stmt66);
 //$stmt7->execute();
 $stmtA = $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'  ";
 $stmt21 = $db->prepare($stmtA);
 $category = "";
 $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if((($from_date && $to_date) && $Status) <> "")
{
 //echo "a3";
 $stmt9 =  $stmt6 . " AND ([Status] = '$Status') ORDER BY '$sort' $order";
 $stmt7 =   $db->prepare($stmt9);
 $stmtB = $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND ([Status] = '$Status') ";
 $stmt21 = $db->prepare($stmtB);
 //kiv
 //$category = "AND ([Status] = '$Status')";
// $date = "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if ((($from_date && $to_date) && $PIC) <> "") {
 //echo "a4";
 $stmt19 =  $stmt6 . " AND [PIC] = '$PIC' ORDER BY '$sort' $order";
 $stmt7 =   $db->prepare($stmt19);
 $stmtC = $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND [PIC] = '$PIC' ";
 $stmt21 = $db->prepare($stmtC);
 $category = " AND [PIC] = '$PIC'";
 $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";

}
if ((($from_date && $to_date) && $DIC) <> "") {
//echo "a4";
$stmtAQ =  $stmt6 . " AND [DIC] = '$DIC' ORDER BY '$sort' $order";
$stmt7 =   $db->prepare($stmtAQ);
$stmtAX = $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND [DIC] = '$DIC' ";
$stmt21 = $db->prepare($stmtAX);
$category = " AND [DIC] = '$DIC'";
$date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";

}
if ((($from_date && $to_date) && $PIC && $Status) <> "") {
 //echo "a4";
 $stmt67 =  $stmt6 . " AND [PIC] = '$PIC' AND ([Status] = '$Status') ORDER BY '$sort' $order";
 $stmt7 =   $db->prepare($stmt67);
 $stmtD = $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND [PIC] = '$PIC' AND ([Status] = '$Status') ";
 $stmt21 = $db->prepare($stmtD);
}
if ((($from_date && $to_date) && $DIC && $Status) <> "") {
  //echo "a4";
  $stmtBQ =  $stmt6 . " AND [DIC] = '$DIC' AND ([Status] = '$Status') ORDER BY '$sort' $order";
  $stmt7 =   $db->prepare($stmtBQ);
  $stmtBX = $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND [DIC] = '$DIC' AND ([Status] = '$Status') ";
  $stmt21 = $db->prepare($stmtBX);
}
if (($from_date && $to_date ) <> "" && $PIC == 'All Employee') {
 //echo "a8";
 $stmt12 =  $stmt6 . " ORDER BY '$sort' $order";
 $stmt7 =   $db->prepare($stmt12);
 $stmtE =  $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' ";
 $stmt21 = $db->prepare($stmtE);
 $category = "";
 $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) <> "" && $DIC == 'All Dept') {
  //echo "a8";
  $stmtCQ =  $stmt6 . " ORDER BY '$sort' $order";
  $stmt7 =   $db->prepare($stmtCQ);
  $stmtCX =  $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' ";
  $stmt21 = $db->prepare($stmtCX);
  $category = "";
  $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) <> "" && $Status == 'All Status') {
 //echo "a9";
 $stmt13 =  $stmt6 . " ORDER BY '$sort' $order";
 $stmt7 =   $db->prepare($stmt13);
 $stmtF = $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
 $stmt21 = $db->prepare($stmtF);
 $category = "";
 $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) <> "" && $PIC && $Status == 'All Status') {
 //echo "a12";
 $stmt15 =  $stmt6 . " AND [PIC] = '$PIC' ORDER BY '$sort' $order";
 $stmt7 =   $db->prepare($stmt15);
 $stmtG = $stmt20 .  " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND [PIC] = '$PIC' ";
 $stmt21 = $db->prepare($stmtG);
 $category = " AND [PIC] = '$PIC'";
 $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) <> "" && $DIC && $Status == 'All Status') {
//echo "a12";
$stmtDX =  $stmt6 . " AND [DIC] = '$DIC' ORDER BY '$sort' $order";
$stmt7 =   $db->prepare($stmtDX);
$stmtDS = $stmt20 .  "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND [DIC] = '$DIC' ";
$stmt21 = $db->prepare($stmtDS);
$category = " AND [DIC] = '$DIC'";
$date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) <> "" && $Status && $PIC == 'All Employee') {
 //echo "a12";
 $stmt78 =  $stmt6 . " AND ([Status] = '$Status') ORDER BY '$sort' $order";
 $stmt7 =   $db->prepare($stmt78);
 $stmtH =  $stmt20 . "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND ([Status] = '$Status') ";
 $stmt21 = $db->prepare($stmtH);
 $category = " AND ([Status] = '$Status')";
 $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) <> "" && $Status && $DIC == 'All Dept') {
//echo "a12";
$stmtDX =  $stmt6 . " AND ([Status] = '$Status') ORDER BY '$sort' $order";
$stmt7 =   $db->prepare($stmtDX);
$stmtDZ =  $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND ([Status] = '$Status') ";
$stmt21 = $db->prepare($stmtDZ);
$category = " AND ([Status] = '$Status')";
 $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) <> "" && $Status == 'All Status' && $PIC == 'All Employee') {
$stmt112 = $stmt6 . " ORDER BY '$sort' $order";
$stmt7 =   $db->prepare($stmt112);
 //$stmt7->execute();
 $stmtA = $stmt20 . "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
 $stmt21 = $db->prepare($stmtA);
 $category = "";
 $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) <> "" && $Status == 'All Status' && $DIC == 'All Dept') {
 $stmt113 = $stmt6 . " ORDER BY '$sort' $order";
 $stmt7 =   $db->prepare($stmt113);
 //$stmt7->execute();
 $stmtA = $stmt20 . " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
 $stmt21 = $db->prepare($stmtA);
 $category = "";
 $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) <> "" && $Status == 'OVERDUE') {
  
 $stmtOver =  $stmt6 . "AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' ORDER BY '$sort' $order";
$stmt7 =   $db->prepare($stmtOver);
 //$stmt7->execute();
 $stmtA = $stmt20 . "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL'";
 $stmt21 = $db->prepare($stmtA);
 $category = "";
 $date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) && $PIC <> "" && $Status == 'OVERDUE') {
    
$stmtOver =  $stmt6 . "AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' AND [PIC] = '$PIC' ORDER BY '$sort' $order";
$stmt7 =   $db->prepare($stmtOver);
//$stmt7->execute();
$stmtA = $stmt20 . "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' AND [PIC] = '$PIC'";
$stmt21 = $db->prepare($stmtA);
$category = "AND [PIC] = '$PIC'";
$date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) && $DIC <> "" && $Status == 'OVERDUE') {
    
$stmtOver =  $stmt6 . "AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' AND [DIC] = '$DIC' ORDER BY '$sort' $order";
$stmt7 =   $db->prepare($stmtOver);
//$stmt7->execute();
$stmtA = $stmt20 . "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' AND [DIC] = '$DIC'";
$stmt21 = $db->prepare($stmtA);
$category = "AND [DIC] = '$DIC'";
$date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) <> "" && $Status == 'OUTSTANDING') {
  
$stmtOver =  $stmt6 . "AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' ORDER BY '$sort' $order";
$stmt7 =   $db->prepare($stmtOver);
//$stmt7->execute();
$stmtA = $stmt20 . "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL'";
$stmt21 = $db->prepare($stmtA);
$category = "";
$date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) && $PIC <> "" && $Status == 'OUTSTANDING') {
    
$stmtOver =  $stmt6 . "AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' AND [PIC] = '$PIC' ORDER BY '$sort' $order";
$stmt7 =   $db->prepare($stmtOver);
//$stmt7->execute();
$stmtA = $stmt20 . "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' AND [PIC] = '$PIC'";
$stmt21 = $db->prepare($stmtA);
$category = "AND [PIC] = '$PIC'";
$date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}
if (($from_date && $to_date ) && $DIC <> "" && $Status == 'OUTSTANDING') {
    
$stmtOver =  $stmt6 . "AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' AND [DIC] = '$DIC' ORDER BY '$sort' $order";
$stmt7 =   $db->prepare($stmtOver);
//$stmt7->execute();
$stmtA = $stmt20 . "WHERE [AddDate] BETWEEN '$from_date' AND '$to_date' AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' AND [DIC] = '$DIC'";
$stmt21 = $db->prepare($stmtA);
$category = "AND [DIC] = '$DIC'";
$date = " WHERE [AddDate] BETWEEN '$from_date' AND '$to_date'";
}

     //OPEN&NOPIC
     $stmtNoPic = $stmt20 . $date .  " AND [PIC] IS NULL AND [Status] = 'OPEN'" . $category;
     $stmtNoPicA = $db->prepare($stmtNoPic);
     $stmtNoPicA->execute();
     $countNoPic = $stmtNoPicA->fetchColumn();

     //OPENWITHPIC
     $stmtWithPic = $stmt20 . $date .  "AND [PIC] IS NOT NULL AND [Status] = 'OPEN'" . $category;
     $stmtWithPicA = $db->prepare($stmtWithPic);
     $stmtWithPicA->execute();
     $countWithPic = $stmtWithPicA->fetchColumn();

     //IN-PROGRESS
     $stmtInProgress = $stmt20 . $date . "AND [Status] = 'IN-PROGRESS'". $category;
     $stmtInProgressF = $db->prepare($stmtInProgress);
     $stmtInProgressF->execute();
     $countInProgress = $stmtInProgressF->fetchColumn();

     //COMPLETED
     $stmtCom = $stmt20 . $date . "AND [Status] = 'COMPLETED'" . $category;
     $stmtComF = $db->prepare($stmtCom);
     $stmtComF->execute();
     $countComF = $stmtComF->fetchColumn();

     //Others
     $stmtOthers = $stmt20 . $date . " AND Status IN ('IT Testing','User Testing','KIV','Pending') " . $category;
     $stmtOthersF = $db->prepare($stmtOthers);
     $stmtOthersF->execute();
     $countOthersF = $stmtOthersF->fetchColumn();

     //CANCEL
     $stmtCancel = $stmt20 . $date . " AND [Status] = 'CANCEL' " . $category;
     $stmtCancelF = $db->prepare($stmtCancel);
     $stmtCancelF->execute();
     $countCancelF = $stmtCancelF->fetchColumn();

     //it testing
     $stmtItTesting = $stmt20 . $date . " AND [Status] = 'IT TESTING' " . $category;
     $stmtItTestingF = $db->prepare($stmtItTesting);
     $stmtItTestingF->execute();
     $countItTestingF = $stmtItTestingF->fetchColumn();

     //pending 
     $stmtPENDING = $stmt20 . $date ." AND [Status] = 'PENDING' " . $category;
     $stmtPENDINGF = $db->prepare($stmtPENDING);
     $stmtPENDINGF->execute();
     $countPENDINGF = $stmtPENDINGF->fetchColumn();

     //kiv
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
     $stmtOverdue = $stmt20 . $date . " AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' " . $category;
     $stmtOverdueF = $db->prepare($stmtOverdue);
     $stmtOverdueF->execute();
     $countOverdueF = $stmtOverdueF->fetchColumn();


     //null status
     $stmtStatusNull = $stmt20 . $date . "AND [Status] IS NULL " . $category;
     $stmtStatusNullF = $db->prepare($stmtStatusNull);
     $stmtStatusNullF->execute();

    $stmt7->execute();
    $stmt21->execute();
    $rows = $stmt21->fetchColumn();

       
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
        }

        thead {
            page-break-inside: avoid;
        }
        }

    </style>
    <body>
         <!-- Main content -->
    <div class="content">
      <div class="container-fluid" >
        <div class="row d-flex justify-content-center ">
          <div class="col-lg-20 ">
         
              <h4>IT Feedback Record <small>by PIC and by DIC</small></h4>
              <div class="row">
                <div class="col-sm ">
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
                            echo "</br>";
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
                            echo "</br>";
                        } 
                        else {
                            //echo "a8";
                            echo "Data display for date: " ."from " . date('d-M-Y',strtotime($from_date)) . " to " . date('d-M-Y',strtotime($to_date));
                            echo "</br>";
                            echo "$rows"." records found";
                            echo "</br>";
                            echo "Data display for status:" . " $Status";
                            echo "</br>";
                        }

                    ?>
                    <span class=""><small class="text-danger font-weight-bold">overdue,</small><small class="text-warning font-weight-bold">outstanding,</small><small class="text-success font-weight-bold">completed</small></span>
                    <button type="submit" name="submit" class="btn btn-primary btn-sm float-right noprint " onclick="printWithSpecialFileName()" >Print</button>
                </div>
            </div>
             <!-- DISPLAY TOTAL FOR EACH STATUSES -->
             <div class="row d-flex">
             <?php if ($Status == ("IT TESTING" && "PENDING" && "KIV" && "IN-PROGRESS" && "CANCEL" && "USER TESTING" 
                                  && "COMPLETED" && "OPEN") && $Status != "All Status" ) { ?>
                        <?php } else { ?>
                          <table class="table table-bordered table-hover mt-2" style="padding: 5 px;">
                            <tr>
                              <td><small>Open No PIC: <?php echo $countNoPic; ?></small></td> 
                              <td><small>Open With PIC: <?php echo $countWithPic;  ?></small></td> 
                              <td><small>In-Progress : <?php echo $countInProgress;  ?></small></td>
                              <td><small>Completed : <?php echo $countComF;  ?></small></td> 
                              <td><small>IT Testing : <?php echo  $countItTestingF; ?> </small></td> 
                              <td><small>Pending : <?php echo $countPENDINGF;  ?> </small></td> 
                              <td><small>KIV : <?php echo $countKIVF;  ?> </small></td> 
                              <td><small>User Testing : <?php echo $countUserTestingF;  ?> </small></td> 
                              <td><small>Cancel : <?php echo $countCancelF;  ?></small></td>
                              <td><small>Oustanding : <?php echo $countOutstandingF;  ?></small></td>
                              <td><small>Overdue : <?php echo $countOverdueF;  ?></small></td>
                              <td><small>Null Status: <?php echo $countstmtStatusNullF  ?></small></td>
                              <!--<td><label><small>Indicator :</small></label><small> red Overdue,yellow outstanding </small></td> -->
                            </tr>
                          </table>
                        <?php }  ?>
                      </div>
                    <div class="d-flex ">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                            <th>No</th>
                            <th>FBNo</th>
                            <th>Service</th>
                            <th>Feedback</th>
                            <th>PCNo</th>
                            <th>PIC</th>
                            <th>DIC</th>
                            <th>Status</th>
                            <th>Add Date</th>
                            <th>Last Update</th>
                            <th>Target Date</th>
                        </tr>
                      </thead>
                        <!-- display datatable -->
                        <?php
                        while($row = $stmt7->fetch(PDO::FETCH_ASSOC))
                        {

            ?>                <?php   $currentDate = date("Y/m/d");
                                    $time = date("Y/m/d",strtotime($row['TargetDate'])); 
                                    $statuss = $row['Status'];
                                    //adjust jugak 'Completed'
                                    if ($currentDate > $time && $statuss != 'COMPLETED' && $statuss != 'CANCEL' ) {
                                          $colour = "text-danger ";
                                    } elseif ($statuss != 'COMPLETED' && $statuss != 'CANCEL') {
                                        $colour = "text-warning ";
                                    } elseif ( $statuss == ('Completed' && 'COMPLETED') && $statuss != 'Cancel' ) {
                                        $colour = "text-success ";
                                    }
                                      else {
                                        $colour= "";
                                    } ?>
                            <tr>
                                <td class = <?php echo $colour; ?>><?php echo $counter++; ?></td>
                                <td class = <?php echo $colour; ?>><?php echo $row['FBNo']; ?></td>
                                <td class = <?php echo $colour; ?> style="max-width:130px;"><?php echo $row['Service']; ?></td>
                                <td class = <?php echo $colour; ?> style="max-width:150px;"><small><?php echo $row['Feedback']; ?></small></td>
                                <td class = <?php echo $colour; ?>><?php echo $row['PCNo']; ?></td>
                                <td class = <?php echo $colour; ?>><?php echo $row['PIC']; ?></td>
                                <td class = <?php echo $colour; ?>><?php echo $row['DIC']; ?></td>
                                <td class = <?php echo $colour; ?>><?php echo $row['Status']; ?></td>
                                <td class = <?php echo $colour; ?>><?php echo $time = date("Y/m/d",strtotime($row['AddDate'])); ?></td>
                                <td class = <?php echo $colour; ?>><?php echo $time = date("Y/m/d",strtotime($row['EditDate'])); ?></td>
                                <td class = <?php echo $colour; ?>><?php echo $time = date("Y/m/d",strtotime($row['TargetDate'])); ?></td>
                            </tr>       
            <?php 
                        }

                        }
            ?> 
                    </table>
                </div>
                <!-- /.d-flex -->


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
<script>
            function printWithSpecialFileName(){
                
                var tempTitle = document.title;
                document.title = "IT Feedback Record(datatable).pdf";
                window.print();
                document.title = tempTitle;
            }
</script>

          
        
    </body>
</html>