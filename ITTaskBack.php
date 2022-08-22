
<?php

require __DIR__ . '/database.php';
//include 'testing.php';
$db = DB();
$PIC = "";
$DIC = "";
$from_date = "";

// Set session variables
//$_SESSION['PIC']=  $_POST['PIC'];
//$_SESSION['DIC']= $_POST['DIC'];
//$_SESSION['from_date']= $_POST['from_date'];

//echo $_SESSION['empno'];

//display all list of employee
$stmtPIC = $db->prepare("   SELECT DISTINCT [AINDATA].[dbo].[SY_0600].PIC
                            FROM [AINDATA].[dbo].[SY_0600]
                            INNER JOIN [AINDATA].[dbo].[SY_0100] 
                            ON SUBSTRING([AINDATA].[dbo].[SY_0600].PIC,0,6) = [AINDATA].[dbo].[SY_0100].empno
                            WHERE [AINDATA].[dbo].[SY_0100].[DivCode] = 'IFT' 
                            AND [AINDATA].[dbo].[SY_0100].[ResignStatus] = 'NO'
                            AND YEAR([AINDATA].[dbo].[SY_0600].AddDate) >= DATEPART(year, getdate())         
                        ");
$stmtPIC->execute();
                          /*SELECT [empno],[empname]
                           FROM dbo.SY_0100
                           WHERE [ResignStatus] = 'NO'
                           AND [DivCode] = 'IFT' 
                           ORDER BY [empname] ASC */
//display list of department
$stmtDIC = $db->prepare(" SELECT DISTINCT [DIC]
                        FROM dbo.SY_0600
                        WHERE [DIC] IS NOT NULL
                        AND [DIC] <> ''    
                        AND [DIC] != 'All'        
                     ");
$stmtDIC->execute();
$counter = 1;
$category = "";
$from_date = "";
$titleChart = "General data (last 7 days)";
/***************************************************************************START DATA DISPLAY BEFORE USER'S SELECTION (DISPLAY ONLY CURRENT LAST 7 DAYS) */
//general statement 1 to count for each status
$stmt1 = "   SELECT count([FBNo])
                 FROM dbo.SY_0600
                WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";

//general statement 2 (for datatable display only)
$stmtTest = " SELECT *
              FROM dbo.SY_0600
              WHERE [AddDate] >= DATEADD(day,-7,GETDATE()) ";

/*$stmt2Over = "SELECT *
              FROM dbo.SY_0600
              WHERE year([AddDate]) = '$CurrentYear'
              AND  month([AddDate]) = '$CurrentMonth' ";

$stmtOverdue = " SELECT count([FBNo])
                  FROM dbo.SY_0600
                  WHERE year([AddDate]) = '$CurrentYear'
                  AND  month([AddDate]) = '$CurrentMonth' ";*/

//count total for last 7 days; 
$stmt7 =  $db->prepare(" SELECT count([FBNo])
                          FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-7,GETDATE())
                        AND Status IS NOT NULL");
$stmt7->execute();
$rows7 = $stmt7->fetchColumn();

//OPEN BUT NO PIC
$stmtNoPic =  $stmt1 . "AND [PIC] IS NULL AND [Status] = 'OPEN' ";
$stmtNoPicF = $db->prepare($stmtNoPic);
$stmtNoPicF->execute();
$fpNoPic = $stmtNoPicF->fetchColumn();
//statement for select to view datatable
$stmtdata1 = $stmtTest . "AND [PIC] IS NULL AND [Status] = 'OPEN' ORDER BY [FBNo] ASC";
$stmtdata1F = $db->prepare($stmtdata1);
$stmtdata1F->execute();
$stmtT = "";
//display datatable in modal
    while($row3 = $stmtdata1F->fetch(PDO::FETCH_ASSOC)){

        $stmtT .= "<tr><td>". $counter++ .  "</td>"
                  ."<td>" . $row3['FBNo'] . "</td>" 
                  . "<td>" . $row3['Service'] . " </td>" 
                  . "<td>" . $row3['AddUser'] . "</td>"
                  . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                  . "<td>" . $row3['DIC']  . "</td>"
                  . "<td>" . $row3['PIC']  . "</td>"
                  . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                  . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                  . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                  </tr>";
    }
//PERCENTAGE NO PIC

if ($rows7 != 0) {
  $perc1 = $fpNoPic/$rows7 * 100; 
  $fperc1 = number_format($perc1, 1, '.', '');  
}
else {
  $fperc1 = 0;
}

//OPEN WITH PIC
$stmtPicOpen = $stmt1 . " AND [PIC] IS NOT NULL AND [Status] = 'OPEN' ";
$stmtPicOpenF = $db->prepare($stmtPicOpen);
$stmtPicOpenF->execute();
$fpNPicOpen = $stmtPicOpenF->fetchColumn();
//statement for select to view datatable
$stmtdata2 = $stmtTest . "AND [PIC] IS NOT NULL AND [Status] = 'OPEN' ORDER BY [FBNo] ASC";
$stmtdata2F = $db->prepare($stmtdata2);
$stmtdata2F->execute();

$stmtT2 = "";
$counter = 1;
//display datatable in modal
    while($row3 = $stmtdata2F->fetch(PDO::FETCH_ASSOC)){

        $stmtT2 .= "<tr><td>". $counter++ .  "</td>"
                    ."<td>" . $row3['FBNo'] . "</td>" 
                    . "<td>" . $row3['Service'] . " </td>" 
                    . "<td>" . $row3['AddUser'] . "</td>"
                    . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                    . "<td>" . $row3['DIC']  . "</td>"
                    . "<td>" . $row3['PIC']  . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                    </tr>";
    }
//PERCENTAGE WITH PIC STATUS OPEN
if ($rows7 != 0) {
  $perc2 = $fpNPicOpen/$rows7 * 100; 
  $fperc2 = number_format($perc2, 1, '.', '');
    
}
else {
  $fperc2 = 0;
}

//IN-PROGRESS  

$stmtInProgress = $stmt1 . "AND [Status] = 'IN-PROGRESS'";
$stmtInProgressF = $db->prepare($stmtInProgress);
$stmtInProgressF->execute();
$fpInProgress = $stmtInProgressF->fetchColumn();
//statement for select to view datatable
$stmtdata3 = $stmtTest . "AND [Status] = 'IN-PROGRESS' ORDER BY [FBNo] ASC";
$stmtdata3F = $db->prepare($stmtdata3);
$stmtdata3F->execute();

$stmtT3 = "";
$counter = 1;
//display datatable in modal
    while($row3 = $stmtdata3F->fetch(PDO::FETCH_ASSOC)){

        $stmtT3 .= "<tr><td>". $counter++ .  "</td>"
                    ."<td>" . $row3['FBNo'] . "</td>" 
                    . "<td>" . $row3['Service'] . " </td>" 
                    . "<td>" . $row3['AddUser'] . "</td>"
                    . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                    . "<td>" . $row3['DIC']  . "</td>"
                    . "<td>" . $row3['PIC']  . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                    </tr>";
    }
//PERCENTAGE IN PROGRESS
if ($rows7 != 0) {
  $perc3 = $fpInProgress/$rows7 * 100; 
  $fperc3 = number_format($perc3, 1, '.', '');
        
}
else {
  $fperc3 = 0;
}

//COMPLETED
$stmtCom = $stmt1 . "AND [Status] = 'COMPLETED'";
$stmtComF = $db->prepare($stmtCom);
$stmtComF->execute();
$fpComF = $stmtComF->fetchColumn();
//statement for select to view datatable
$stmtdata4 = $stmtTest . "AND [Status] = 'COMPLETED' ORDER BY [FBNo] ASC";
$stmtdata4F = $db->prepare($stmtdata4);
$stmtdata4F->execute();

$stmtT4 = "";
$counter = 1;
//display datatable in modal
    while($row3 = $stmtdata4F->fetch(PDO::FETCH_ASSOC)){

        $stmtT4 .=  "<tr><td>". $counter++ .  "</td>"
                    ."<td>" . $row3['FBNo'] . "</td>" 
                    . "<td>" . $row3['Service'] . " </td>" 
                    . "<td>" . $row3['AddUser'] . "</td>"
                    . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                    . "<td>" . $row3['DIC']  . "</td>"
                    . "<td>" . $row3['PIC']  . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                    </tr>";
    }
//PERCENTAGE COMPLETED
if ($rows7 != 0) {
  $perc4 = $fpComF/$rows7 * 100; 
  $fperc4 = number_format($perc4, 1, '.', '');
              
}
else {
  $fperc4 = 0;
}
   
//OUTSTANDING
$stmtOut = $stmt1 . "AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL'";
$stmtOutF =  $db->prepare($stmtOut);
$stmtOutF->execute();
$fpOutF = $stmtOutF->fetchColumn();
//statement for select to view datatable
$stmtdata5 = $stmtTest . "AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' ORDER BY [FBNo] ASC";
$stmtdata5F = $db->prepare($stmtdata5);
$stmtdata5F->execute();

$stmtT5 = "";
$counter = 1;
//display datatable in modal
    while($row3 = $stmtdata5F->fetch(PDO::FETCH_ASSOC)){

         $stmtT5 .=  "<tr><td>". $counter++ .  "</td>"
                      ."<td>" . $row3['FBNo'] . "</td>" 
                      . "<td>" . $row3['Service'] . " </td>" 
                      . "<td>" . $row3['AddUser'] . "</td>"
                      . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                      . "<td>" . $row3['DIC']  . "</td>"
                      . "<td>" . $row3['PIC']  . "</td>"
                      . "<td>" . $row3['Status']  . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                      </tr>";
      }
//PERCENTAGE OUTSTANDING
if ($rows7 != 0) {
  $perc5 = $fpOutF/$rows7 * 100; 
  $fperc5 = number_format($perc5, 1, '.', '');
                    
}
else {
  $fperc5 = 0;
}
      
//OVERDUE 
$stmtOver = $stmt1 . "AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL'";
$stmtOverF =  $db->prepare($stmtOver);
$stmtOverF->execute();
$fpOverF = $stmtOverF->fetchColumn();
//statement for select to view datatable
$stmtdata6 = $stmtTest . "AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' ORDER BY [FBNo] ASC";
$stmtdata6F = $db->prepare($stmtdata6);
$stmtdata6F->execute();

$stmtT6 = "";
$counter = 1;
//display datatable in modal
    while($row3 = $stmtdata6F->fetch(PDO::FETCH_ASSOC)){

        $stmtT6 .=  "<tr><td>". $counter++ .  "</td>"
                    ."<td>" . $row3['FBNo'] . "</td>" 
                    . "<td>" . $row3['Service'] . " </td>" 
                    . "<td>" . $row3['AddUser'] . "</td>"
                    . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                    . "<td>" . $row3['DIC']  . "</td>"
                    . "<td>" . $row3['PIC']  . "</td>"
                    . "<td>" . $row3['Status']  . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                    </tr>";
    }
//PERCENTAGE OVERDUE
if ($rows7 != 0) {
  $perc6 = $fpOverF/$rows7 * 100; 
  $fperc6 = number_format($perc6, 1, '.', '');
                          
}
else {
  $fperc6 = 0;
}
//CANCEL
$stmtCancel = $stmt1 . " AND [Status] = 'CANCEL' " . $category;
$stmtCancelF = $db->prepare($stmtCancel);
$stmtCancelF->execute();
$fpCancelF = $stmtCancelF->fetchColumn();
//statement for select datatable
$stmtdata7 = $stmtTest ." AND [Status] = 'CANCEL' " . $category . "ORDER BY [FBNo] ASC";
$stmtdata7F = $db->prepare($stmtdata7);
$stmtdata7F->execute();

$stmtT7 = "";
$counter = 1;
//display datatable in modal
      while($row3 = $stmtdata7F->fetch(PDO::FETCH_ASSOC)){

          $stmtT7 .=  "<tr><td>". $counter++ .  "</td>"
                      ."<td>" . $row3['FBNo'] . "</td>" 
                      . "<td>" . $row3['Service'] . " </td>" 
                      . "<td>" . $row3['AddUser'] . "</td>"
                      . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                      . "<td>" . $row3['DIC']  . "</td>"
                      . "<td>" . $row3['PIC']  . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                      </tr>";
      }
//PERCENTAGE CANCEL
if ($rows7 != 0) {
    $perc7 = $fpCancelF/$rows7 * 100; 
    $fperc7 = number_format($perc7, 1, '.', '');
}
else {
    $fperc7 = 0;
}

//others
$stmtOthers = $stmt1 . " AND Status IN ('IT Testing','User Testing','KIV','Pending') " . $category;
$stmtOthersF = $db->prepare($stmtOthers);
$stmtOthersF->execute();
$fpOthersF = $stmtOthersF->fetchColumn();
//statement for select datatable
$stmtdata12 = $stmtTest . " AND Status IN ('IT Testing','User Testing','KIV','Pending') " . $category . "ORDER BY [FBNo] ASC";
$stmtdata12F = $db->prepare($stmtdata12);
$stmtdata12F->execute();
 
$stmtT12 = "";
$counter = 1; 
//display datatable in modal
     while($row3 = $stmtdata12F->fetch(PDO::FETCH_ASSOC)){
 
          $stmtT12 .=  "<tr><td>". $counter++ .  "</td>"
                        ."<td>" . $row3['FBNo'] . "</td>" 
                        . "<td>" . $row3['Service'] . " </td>" 
                        . "<td>" . $row3['AddUser'] . "</td>"
                        . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                        . "<td>" . $row3['DIC']  . "</td>"
                        . "<td>" . $row3['PIC']  . "</td>"
                        . "<td>" . $row3['Status']  . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                        </tr>";
        }
//PERCENTAGE others
if ($rows7 != 0) {
    $perc12 = $fpOthersF/$rows7 * 100; 
    $fperc12 = number_format($perc12, 1, '.', '');
}
else {
    $fperc12 = 0;
}
      //execute the whole status pie chart
      $sqlStatus = $db->prepare (" SELECT COUNT(FBNo) as count, Status
                                   FROM [AINDATA].[dbo].[SY_0600]
                                   WHERE [AddDate] >= DATEADD(day,-7,GETDATE())
                                   AND STATUS <> ''
                                   GROUP BY STATUS
                                ");
       $sqlStatus->execute();
        //passing data to jquery to generate pie chart
        $dataStatus = array();
        $dataStatus[] = [];
  
        foreach($sqlStatus as $row) {

           $dataStatus['label'][] = $row['Status'];
           $dataStatus['data'][] = $row['count'];
           //generate random colours
           $hexMin = 0;
           $hexMax = 9;
           $rgbMin = 0;
           $rgbMax = 153; // Hex 99 = 153 Decimal
           $dataStatus['colour'][] = '#' . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax);
      
            //$dataStatus['colour'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6); 
        }
       
         $dataStatus['chartStatus'] = json_encode($dataStatus);

      //execute data for pie chart PIC 
      $sqlT = $db->prepare("  SELECT COUNT(PIC) as record,PIC
                            FROM [AINDATA].[dbo].[SY_0600]
                            WHERE [AddDate] >= DATEADD(day,-7,GETDATE())
                            AND PIC <> ''
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
       // $data['colours'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6); 
       $hexMin = 0;
           $hexMax = 9;
           $rgbMin = 0;
           $rgbMax = 153; // Hex 99 = 153 Decimal
           $data['colours'][] = '#' . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax);
      }


        $data['chart_data'] = json_encode($data);     


      //execute data for bar chart by DIC
      $sqlU =  $db->prepare("   SELECT COUNT(DIC) AS RECORD , DIC
                                FROM [AINDATA].[dbo].[SY_0600]
                                WHERE [AddDate] >= DATEADD(day,-7,GETDATE())
                                
                                GROUP BY DIC
                            ");
      $sqlU->execute();
      //passing data to jquery to generate bar chart
    
      // Prepare the data for returning with the view
      $chartsData="";

         while ($row = $sqlU->fetch(PDO::FETCH_ASSOC)) { 
 
            $count[]  = $row['RECORD']  ;
            $dic[] = $row['DIC'];
        }

      


      
/***************************************************************************END DATA DISPLAY BEFORE USER'S SELECTION (DISPLAY ONLY CURRENT LAST 7 DAYS) */
/***************************************************************************START DATA FILTRATION (ONCE USER SELECTED) */
      if(isset($_POST['simpan']) ) { 

         $PIC = $_POST['PIC'];
         $DIC = $_POST['DIC'];
         $from_date = $_POST['from_date'];
      
         //GENERAL STATEMENT TO COUNT EACH STATUS
         $stmt1 = " SELECT count([FBNo])
                    FROM dbo.SY_0600 ";
        //GENERAL STATEMENT TO DISPLAY DATATABLE
        $stmtTest = " SELECT *
                      FROM dbo.SY_0600 ";
        
        $dateCurrent = date('d-M-Y');
         
        //CONDITIONS BASED ON USER'S SELECTION
         if ($PIC <> "" && $DIC == "" && $from_date == "") {
             //echo "aa";
              $category = " AND [PIC] = '$PIC'";
              $date =  "WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";
              $titleChart = "for $PIC";
              //$categoryforChart1 = " AND SUBSTRING([PIC],0,6) = '$empno'";   
         }
         elseif ($DIC <> "" && $PIC == "" && $from_date == "") {
             //echo "aa5";
             $category = " AND [DIC] = '$DIC'";
             $date =  "WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";
             $titleChart = "for $DIC";
             //$categoryforChart1 = " AND [DIC] = '$DIC'";
         }
         elseif ($PIC <> "" && $DIC == "" && $from_date <> "") {
            //echo "aa6";
            $category = " AND [PIC] = '$PIC'";
            $date =  "WHERE [AddDate] >= '$from_date' ";  
            $titleChart = "for $PIC and from ". date('d-M-Y',strtotime($from_date)) ." until $dateCurrent";
            //$categoryforChart1 = " AND SUBSTRING([PIC],0,6) = '$empno'";   
         }
         elseif ($DIC <> "" && $PIC == "" && $from_date <> "") {
            //echo "aa7";
            $category = " AND [DIC] = '$DIC'";
            $date =  "WHERE [AddDate] >= '$from_date'";
            $titleChart = "for $DIC and from ". date('d-M-Y',strtotime($from_date)) ." until $dateCurrent";
           // $categoryforChart1 = " AND [DIC] = '$DIC'";
         }
         elseif($DIC == "" && $PIC == "" && $from_date <> "") {
          //echo "aa8";
          $category = "";
          $date =  "WHERE [AddDate] >= '$from_date'";
          $titleChart = "from ". date('d-M-Y',strtotime($from_date)) ." until $dateCurrent";
          //$categoryforChart1 = ""; 
         } 

         //count total according to date selection
          $stmtByDateCount = "  SELECT count([FBNo])
                                FROM dbo.SY_0600
                                 ";
          $stmt7 = $stmtByDateCount . $date . $category . "AND Status IS NOT NULL  ";
          $stmt7Ex = $db->prepare($stmt7);
          $stmt7Ex->execute();
          $rows7 = $stmt7Ex->fetchColumn();
        
          //STATEMENT NO PIC BUT OPEN
          $stmtNoPic =  $stmt1 . $date . "  AND [PIC] IS NULL AND [Status] = 'OPEN'" . $category;
          $stmtNoPicF = $db->prepare($stmtNoPic);
          $stmtNoPicF->execute();
          $fpNoPic = $stmtNoPicF->fetchColumn();
          //statement for select to view datatable
          $stmtdata1 = $stmtTest . $date . " AND [PIC] IS NULL AND [Status] = 'OPEN' " . $category . "ORDER BY [FBNo] ASC";
          $stmtdata1F = $db->prepare($stmtdata1);
          $stmtdata1F->execute();
          $stmtT = "";
          $counter = 1;
          //DISPLAY DATATABLE
          while($row3 = $stmtdata1F->fetch(PDO::FETCH_ASSOC)){

            $stmtT .=  "<tr><td>". $counter++ .  "</td>"
                        ."<td>" . $row3['FBNo'] . "</td>" 
                        . "<td>" . $row3['Service'] . " </td>" 
                        . "<td>" . $row3['AddUser'] . "</td>"
                        . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                        . "<td>" . $row3['DIC']  . "</td>"
                        . "<td>" . $row3['PIC']  . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                        </tr>";
          }
          //PERCENTAGE NO PIC
          if ($rows7 != 0) {
            $perc1 = $fpNoPic/$rows7 * 100; 
            $fperc1 = number_format($perc1, 1, '.', '');
          
          } else {
            $fperc1 = 0;
          }
      
          //STATEMENT WITH PIC BUT OPEN
          $stmtPicOpen = $stmt1 . $date . " AND [PIC] IS NOT NULL AND [Status] = 'OPEN'" . $category;
          $stmtPicOpenF = $db->prepare($stmtPicOpen);
          $stmtPicOpenF->execute();
          $fpNPicOpen = $stmtPicOpenF->fetchColumn();
          //statement for select to view datatable
          $stmtdata2 = $stmtTest . $date . "AND [PIC] IS NOT NULL AND [Status] = 'OPEN' " . $category . "ORDER BY [FBNo] ASC";
          $stmtdata2F = $db->prepare($stmtdata2);
          $stmtdata2F->execute();

          $stmtT2 = "";
          $counter = 1;
          //DISPLAY DATATABLE
            while($row3 = $stmtdata2F->fetch(PDO::FETCH_ASSOC)){

              $stmtT2 .=  "<tr><td>". $counter++ .  "</td>"
                          ."<td>" . $row3['FBNo'] . "</td>" 
                          . "<td>" . $row3['Service'] . " </td>" 
                          . "<td>" . $row3['AddUser'] . "</td>"
                          . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                          . "<td>" . $row3['DIC']  . "</td>"
                          . "<td>" . $row3['PIC']  . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                          </tr>";
            }

          //PERCENTAGE WITH PIC STATUS OPEN
          if ($rows7 != 0) {
              $perc2 = $fpNPicOpen/$rows7 * 100; 
              $fperc2 = number_format($perc2, 1, '.', '');
          } else {
              $fperc2 = 0;
          }
         
          //IN-PROGRESS
          $stmtInProgress = $stmt1 . $date . "AND [Status] = 'IN-PROGRESS'". $category;
          $stmtInProgressF = $db->prepare($stmtInProgress);
          $stmtInProgressF->execute();
          $fpInProgress = $stmtInProgressF->fetchColumn();
          //statement for select to view datatable
          $stmtdata3 = $stmtTest . $date . "AND [Status] = 'IN-PROGRESS' " . $category . "ORDER BY [FBNo] ASC";
          $stmtdata3F = $db->prepare($stmtdata3);
          $stmtdata3F->execute();

          $stmtT3 = "";
          $counter = 1;
          //DISPLAY DATATABLE
            while($row3 = $stmtdata3F->fetch(PDO::FETCH_ASSOC)){

              $stmtT3 .=  "<tr><td>". $counter++ .  "</td>"
                          ."<td>" . $row3['FBNo'] . "</td>" 
                          . "<td>" . $row3['Service'] . " </td>" 
                          . "<td>" . $row3['AddUser'] . "</td>"
                          . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                          . "<td>" . $row3['DIC']  . "</td>"
                          . "<td>" . $row3['PIC']  . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                          </tr>";
            }
          //PERCENTAGE IN PROGRESS
          if ($rows7 != 0) {
              $perc3 = $fpInProgress/$rows7 * 100; 
              $fperc3 = number_format($perc3, 1, '.', '');
          } else {
              $fperc3 = 0;
          }
         
          //COMPLETED
          $stmtCom = $stmt1 . $date . "AND [Status] = 'COMPLETED'" . $category;
          $stmtComF = $db->prepare($stmtCom);
          $stmtComF->execute();
          $fpComF = $stmtComF->fetchColumn();
          //statement for select to view datatable
          $stmtdata4 = $stmtTest . $date . "AND [Status] = 'COMPLETED'"  . $category . "ORDER BY [FBNo] ASC";
          $stmtdata4F = $db->prepare($stmtdata4);
          $stmtdata4F->execute();

          $stmtT4 = "";
          $counter = 1;
          //DISPLAY DATATABLE
            while($row3 = $stmtdata4F->fetch(PDO::FETCH_ASSOC)){

              $stmtT4 .=  "<tr><td>". $counter++ .  "</td>"
                          ."<td>" . $row3['FBNo'] . "</td>" 
                          . "<td>" . $row3['Service'] . " </td>" 
                          . "<td>" . $row3['AddUser'] . " </td>" 
                          . "<td style='max-width:200px;'><small>" . $row3['Feedback'] . "</small></td>" 
                          . "<td>" . $row3['DIC']  . "</td>"
                          . "<td>" . $row3['PIC']  . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                          </tr>";
            }
          //PERCENTAGE COMPLETED
          if ($rows7 != 0) {
              $perc4 = $fpComF/$rows7 * 100; 
              $fperc4 = number_format($perc4, 1, '.', '');
          } else {
              $fperc4 = 0;
          }
          
          //OUTSTANDING
          $stmtOut = $stmt1 . $date . "AND [Status] != 'COMPLETED'  AND [Status] != 'CANCEL' " . $category;
          $stmtOutF =  $db->prepare($stmtOut);
          $stmtOutF->execute();
          $fpOutF = $stmtOutF->fetchColumn();
          //statement for select to view datatable
          $stmtdata5 = $stmtTest . $date . "AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' " . $category . "ORDER BY [FBNo] ASC";
          $stmtdata5F = $db->prepare($stmtdata5);
          $stmtdata5F->execute();

          $stmtT5 = "";
          $counter = 1;
          //DISPLAY DATATABLE
            while($row3 = $stmtdata5F->fetch(PDO::FETCH_ASSOC)){

              $stmtT5 .=  "<tr><td>". $counter++ .  "</td>"
                          ."<td>" . $row3['FBNo'] . "</td>" 
                          . "<td>" . $row3['Service'] . " </td>" 
                          . "<td>" . $row3['AddUser'] . "</td>"
                          . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                          . "<td>" . $row3['DIC']  . "</td>"
                          . "<td>" . $row3['PIC']  . "</td>"
                          . "<td>" . $row3['Status'] . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                          </tr>";
            }
          //PERCENTAGE OUTSTANDING
          if ($rows7 != 0) {
              $perc5 = $fpOutF/$rows7 * 100; 
              $fperc5 = number_format($perc5, 1, '.', '');
          } else {
              $fperc5 = 0;
          }
         
          //overdue
          $stmtOver = $stmt1 . $date . "AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' " . $category;
          $stmtOverF =  $db->prepare($stmtOver);
          $stmtOverF->execute();
          $fpOverF = $stmtOverF->fetchColumn();
          //statement for select to view datatable
          $stmtdata6 = $stmtTest . $date . "AND CAST( GETDATE() AS Date )  > [TargetDate] AND [Status] != 'COMPLETED' AND [Status] != 'CANCEL' " . $category . "ORDER BY [FBNo] ASC";
          $stmtdata6F = $db->prepare($stmtdata6);
          $stmtdata6F->execute();

          $stmtT6 = "";
          $counter = 1;
          //DISPLAY DATATABLE
            while($row3 = $stmtdata6F->fetch(PDO::FETCH_ASSOC)){

              $stmtT6 .=  "<tr><td>". $counter++ .  "</td>"
                            ."<td>" . $row3['FBNo'] . "</td>" 
                            . "<td>" . $row3['Service'] . " </td>" 
                            . "<td>" . $row3['AddUser'] . "</td>"
                            . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                            . "<td>" . $row3['DIC']  . "</td>"
                            . "<td>" . $row3['PIC']  . "</td>"
                            . "<td>" . $row3['Status'] . "</td>"
                            . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                            . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                            . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                            </tr>";
            }
          //PERCENTAGE OVERDUE
          if ($rows7 != 0) {
              $perc6 = $fpOverF/$rows7 * 100; 
              $fperc6 = number_format($perc6, 1, '.', '');
          }
          else {
              $fperc6 = 0;
          }

          //CANCEL
          $stmtCancel = $stmt1 . $date . " AND [Status] = 'CANCEL' " . $category;
          $stmtCancelF = $db->prepare($stmtCancel);
          $stmtCancelF->execute();
          $fpCancelF = $stmtCancelF->fetchColumn();
          //statement for select datatable
          $stmtdata7 = $stmtTest . $date . " AND [Status] = 'CANCEL' " . $category . "ORDER BY [FBNo] ASC";
          $stmtdata7F = $db->prepare($stmtdata7);
          $stmtdata7F->execute();

          $stmtT7 = "";
          $counter = 1;
          //DISPLAY DATATABLE
            while($row3 = $stmtdata7F->fetch(PDO::FETCH_ASSOC)){

              $stmtT7 .= "<tr><td>". $counter++ .  "</td>"
                          ."<td>" . $row3['FBNo'] . "</td>" 
                          . "<td>" . $row3['Service'] . " </td>" 
                          . "<td>" . $row3['AddUser'] . "</td>"
                          . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                          . "<td>" . $row3['DIC']  . "</td>"
                          . "<td>" . $row3['PIC']  . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                          </tr>";
            }

            //PERCENTAGE CANCEL
            if ($rows7 != 0) {
              $perc7 = $fpCancelF/$rows7 * 100; 
              $fperc7 = number_format($perc7, 1, '.', '');
            }
            else {
                $fperc7 = 0;
            }


      //others
      $stmtOthers = $stmt1 . $date . " AND Status IN ('IT Testing','User Testing','KIV','Pending') " . $category;
      $stmtOthersF = $db->prepare($stmtOthers);
      $stmtOthersF->execute();
        $fpOthersF = $stmtOthersF->fetchColumn();
        //statement for select datatable
        $stmtdata12 = $stmtTest . $date . " AND Status IN ('IT Testing','User Testing','KIV','Pending') " . $category . "ORDER BY [FBNo] ASC";
       $stmtdata12F = $db->prepare($stmtdata12);
       $stmtdata12F->execute();
 
       $stmtT12 = "";
       $counter = 1; 
       //DISPLAY DATATABLE
         while($row3 = $stmtdata12F->fetch(PDO::FETCH_ASSOC)){
 
          $stmtT12 .=  "<tr><td>". $counter++ .  "</td>"
                      ."<td>" . $row3['FBNo'] . "</td>" 
                      . "<td>" . $row3['Service'] . " </td>" 
                      . "<td>" . $row3['AddUser'] . "</td>"
                      . "<td><small>" . $row3['Feedback'] . "</small></td>" 
                      . "<td>" . $row3['DIC']  . "</td>"
                      . "<td>" . $row3['PIC']  . "</td>"
                      . "<td>" . $row3['Status'] . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['TargetDate'], 0, 10) . "</td>
                      </tr>";
         }
 
       //PERCENTAGE others
       if ($rows7 != 0) {
         $perc12 = $fpOthersF/$rows7 * 100; 
         $fperc12 = number_format($perc12, 1, '.', '');
      }
      else {
         $fperc12 = 0;
      }

      //execute the whole status pie chart
      $sqlStatus = $db->prepare (" SELECT COUNT(FBNo) as count, Status
                                   FROM [AINDATA].[dbo].[SY_0600] ".
                                   $date  .
                                   $category .
                                   "AND STATUS <> ''
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
          /* $rgb = 'rgb(' . mt_rand($rgbMin,$rgbMax). ',' . mt_rand($rgbMin,$rgbMax).  ',' . mt_rand($rgbMin,$rgbMax).  ')';
           = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6); */
        }

         $dataStatus['chartStatus'] = json_encode($dataStatus);

       //execute data for pie chart PIC 
      $sqlT = $db->prepare("  SELECT COUNT(PIC) as record,PIC
                              FROM [AINDATA].[dbo].[SY_0600]" .
                              $date  .
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
       /* $rgb = 'rgb(' . mt_rand($rgbMin,$rgbMax). ',' . mt_rand($rgbMin,$rgbMax).  ',' . mt_rand($rgbMin,$rgbMax).  ')';
        = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6); */
            
      }

        $data['chart_data'] = json_encode($data);       

    //execute data for bar chart by DIC
    $sqlU =  $db->prepare("   SELECT COUNT(DIC) AS RECORD , DIC
                              FROM [AINDATA].[dbo].[SY_0600] ". 
                              $date  .
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

 
         
}
    

?>