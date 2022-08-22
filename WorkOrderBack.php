<?php

require __DIR__ . '/database.php';
//include 'testing.php';
$db = DB();

//display list all list 
$stmtPIC = $db->prepare("   SELECT DISTINCT [AINDATA].[dbo].[SY_0600].PIC
                            FROM [AINDATA].[dbo].[SY_0600]
                            INNER JOIN [AINDATA].[dbo].[SY_0100] 
                            ON SUBSTRING([AINDATA].[dbo].[SY_0600].PIC,0,6) = [AINDATA].[dbo].[SY_0100].empno
                            WHERE [AINDATA].[dbo].[SY_0100].[DivCode] = 'IFT' 
                            AND [AINDATA].[dbo].[SY_0100].[ResignStatus] = 'NO'
                            AND YEAR([AINDATA].[dbo].[SY_0600].AddDate) >= DATEPART(year, getdate())         
                        ");
$stmtPIC->execute();

//display list of department
$stmtDIC = $db->prepare(" SELECT DISTINCT [DIC]
                        FROM dbo.SY_0600
                        WHERE [DIC] IS NOT NULL
                        AND [DIC] <> ''    
                        AND [DIC] != 'All'        
                     ");
$stmtDIC->execute();

//$counter = 1;
$category = "";
$from_date = "";
$titleChart = "General data (last 7 days)";
/***************************************************************************START DATA DISPLAY BEFORE USER'S SELECTION (DISPLAY ONLY CURRENT LAST 7 DAYS) */
//main statement for count 
$stmt1 = "   SELECT count([WorkNo])
                 FROM dbo.IN_0080
                WHERE [AddDate] >= DATEADD(day,-7,GETDATE())
                AND Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')";
//main statement for display detailed data
$stmtTest = " SELECT *
              FROM dbo.IN_0080
              WHERE [AddDate] >= DATEADD(day,-7,GETDATE())
              AND Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY') ";

//count total for last 7 days; 
$stmt7 =  $db->prepare(" SELECT count([WorkNo])
                         FROM dbo.IN_0080
                         WHERE [AddDate] > DATEADD(day,-7,GETDATE())
                         AND Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                         " );
$stmt7->execute();
$rows7 = $stmt7->fetchColumn();


//OPEN WITH NO PIC
    $stmtNoPic =  $stmt1 . "AND [InCharge] IS NULL AND [Status] = 'OPEN' ";
    $stmtNoPicF = $db->prepare($stmtNoPic);
    $stmtNoPicF->execute();
    $fpNoPic = $stmtNoPicF->fetchColumn();
    //statement for select to view datatable
    $stmtdata1 = $stmtTest . "AND [InCharge] IS NULL AND [Status] = 'OPEN' ORDER BY [WorkNo] ASC";
    $stmtdata1F = $db->prepare($stmtdata1);
    $stmtdata1F->execute();
    $stmtT = "";
    $counter = 1;
      while($row3 = $stmtdata1F->fetch(PDO::FETCH_ASSOC)){

        $stmtT .=  "<tr><td>". $counter++ .  "</td>"
                  ."<td>" . $row3['WorkNo'] . "</td>" 
                  ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                  . "<td><small>" . $row3['Reason'] . "</small></td>" 
                  . "<td>" . $row3['Service'] . "</td>"
                  . "<td>" . $row3['DIC'] . "</td>" 
                  . "<td>" . $row3['InCharge'] . "</td>"
                  . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                  . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                  . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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
    $stmtPicOpen = $stmt1 . " AND [InCharge] IS NOT NULL AND [Status] = 'OPEN' ";
    $stmtPicOpenF = $db->prepare($stmtPicOpen);
    $stmtPicOpenF->execute();
    $fpNPicOpen = $stmtPicOpenF->fetchColumn();
    //statement for select to view datatable
    $stmtdata2 = $stmtTest . "AND [InCharge] IS NOT NULL AND [Status] = 'OPEN' ORDER BY [WorkNo] ASC";
    $stmtdata2F = $db->prepare($stmtdata2);
    $stmtdata2F->execute();

    $stmtT2 = "";
    $counter = 1;
      while($row3 = $stmtdata2F->fetch(PDO::FETCH_ASSOC)){

        $stmtT2 .=  "<tr><td>". $counter++ .  "</td>"
                    ."<td>" . $row3['WorkNo'] . "</td>" 
                    ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                    . "<td><small>" . $row3['Reason'] . "</small></td>" 
                    . "<td>" . $row3['Service'] . "</td>"
                    . "<td>" . $row3['DIC'] . "</td>" 
                    . "<td>" . $row3['InCharge'] . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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

//IN PROGRESS
    $stmtInProgress = $stmt1 . "AND [Status] = 'In Progress'";
    $stmtInProgressF = $db->prepare($stmtInProgress);
    $stmtInProgressF->execute();
    $fpInProgress = $stmtInProgressF->fetchColumn();
    //statement for select to view datatable
    $stmtdata3 = $stmtTest . "AND [Status] = 'In Progress' ORDER BY [WorkNo] ASC";
    $stmtdata3F = $db->prepare($stmtdata3);
    $stmtdata3F->execute();

    $stmtT3 = "";
    $counter = 1;
      while($row3 = $stmtdata3F->fetch(PDO::FETCH_ASSOC)){

        $stmtT3 .=   "<tr><td>". $counter++ .  "</td>"
                      ."<td>" . $row3['WorkNo'] . "</td>" 
                      ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                      . "<td><small>" . $row3['Reason'] . "</small></td>" 
                      . "<td>" . $row3['Service'] . "</td>"
                      . "<td>" . $row3['DIC'] . "</td>" 
                      . "<td>" . $row3['InCharge'] . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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
    $stmtCom = $stmt1 . "AND [Status] = 'Completed'";
    $stmtComF = $db->prepare($stmtCom);
    $stmtComF->execute();
    $fpComF = $stmtComF->fetchColumn();
    //statement for select to view datatable
    $stmtdata4 = $stmtTest . "AND [Status] = 'Completed' ORDER BY [WorkNo] ASC";
    $stmtdata4F = $db->prepare($stmtdata4);
    $stmtdata4F->execute();

    $stmtT4 = "";
    $counter = 1;
      while($row3 = $stmtdata4F->fetch(PDO::FETCH_ASSOC)){

        $stmtT4 .=   "<tr><td>". $counter++ .  "</td>"
                      ."<td>" . $row3['WorkNo'] . "</td>" 
                      ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                      . "<td><small>" . $row3['Reason'] . "</small></td>" 
                      . "<td>" . $row3['Service'] . "</td>"
                      . "<td>" . $row3['DIC'] . "</td>" 
                      . "<td>" . $row3['InCharge'] . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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

//Oustanding
    $stmtOut = $stmt1 . "AND [Status] != 'Completed' AND [Status] != 'CANCEL'";
    $stmtOutF =  $db->prepare($stmtOut);
    $stmtOutF->execute();
    $fpOutF = $stmtOutF->fetchColumn();
     //statement for select to view datatable
     $stmtdata5 = $stmtTest . "AND [Status] != 'Completed' AND [Status] != 'CANCEL' ORDER BY [WorkNo] ASC";
     $stmtdata5F = $db->prepare($stmtdata5);
     $stmtdata5F->execute();

     $stmtT5 = "";
     $counter = 1;
       while($row3 = $stmtdata5F->fetch(PDO::FETCH_ASSOC)){

         $stmtT5 .=    "<tr><td>". $counter++ .  "</td>"
                        ."<td>" . $row3['WorkNo'] . "</td>" 
                        ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                        . "<td><small>" . $row3['Reason'] . "</small></td>" 
                        . "<td>" . $row3['Service'] . "</td>"
                        . "<td>" . $row3['DIC'] . "</td>" 
                        . "<td>" . $row3['Status']  . "</td>"
                        . "<td>" . $row3['InCharge'] . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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
$stmtOver = $stmt1 . "AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL' ";
    $stmtOverF =  $db->prepare($stmtOver);
    $stmtOverF->execute();
    $fpOverF = $stmtOverF->fetchColumn();
    //statement for select to view datatable
    $stmtdata6 = $stmtTest . "AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL' ORDER BY [WorkNo] ASC";
    $stmtdata6F = $db->prepare($stmtdata6);
    $stmtdata6F->execute();

    $stmtT6 = "";
    $counter = 1;
      while($row3 = $stmtdata6F->fetch(PDO::FETCH_ASSOC)){

        $stmtT6 .=    "<tr><td>". $counter++ .  "</td>"
                      ."<td>" . $row3['WorkNo'] . "</td>" 
                      ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                      . "<td><small>" . $row3['Reason'] . "</small></td>" 
                      . "<td>" . $row3['Service'] . "</td>"
                      . "<td>" . $row3['DIC'] . "</td>" 
                      . "<td>" . $row3['Status']  . "</td>"
                      . "<td>" . $row3['InCharge'] . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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
       $stmtCancel = $stmt1 . " AND [Status] = 'Cancel' " . $category;
       $stmtCancelF = $db->prepare($stmtCancel);
       $stmtCancelF->execute();
       $fpCancelF = $stmtCancelF->fetchColumn();
       //statement for select datatable
       $stmtdata7 = $stmtTest ." AND [Status] = 'Cancel' " . $category . "ORDER BY [WorkNo] ASC";
      $stmtdata7F = $db->prepare($stmtdata7);
      $stmtdata7F->execute();

      $stmtT7 = "";
      $counter = 1;
        while($row3 = $stmtdata7F->fetch(PDO::FETCH_ASSOC)){

          $stmtT7 .=   "<tr><td>". $counter++ .  "</td>"
                        ."<td>" . $row3['WorkNo'] . "</td>" 
                        ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                        . "<td><small>" . $row3['Reason'] . "</small></td>" 
                        . "<td>" . $row3['Service'] . "</td>"
                        . "<td>" . $row3['DIC'] . "</td>" 
                        . "<td>" . $row3['InCharge'] . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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
//KIV
      $stmtKIV = $stmt1 . " AND [Status] = 'KIV' " . $category;
      $stmtKIVF = $db->prepare($stmtKIV);
      $stmtKIVF->execute();
        $fpKIVF = $stmtKIVF->fetchColumn();
        //statement for select datatable
        $stmtdata10 = $stmtTest . " AND [Status] = 'KIV' " . $category . "ORDER BY [WorkNo] ASC";
       $stmtdata10F = $db->prepare($stmtdata10);
       $stmtdata10F->execute();
 
       $stmtT10 = "";
       $counter = 1; 
         while($row3 = $stmtdata10F->fetch(PDO::FETCH_ASSOC)){
 
          $stmtT10 .=   "<tr><td>". $counter++ .  "</td>"
                        ."<td>" . $row3['WorkNo'] . "</td>" 
                        ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                        . "<td><small>" . $row3['Reason'] . "</small></td>" 
                        . "<td>" . $row3['Service'] . "</td>"
                        . "<td>" . $row3['DIC'] . "</td>" 
                        . "<td>" . $row3['Status']  . "</td>"
                        . "<td>" . $row3['InCharge'] . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
                        </tr>";
         }
 
       //PERCENTAGE KIV
       if ($rows7 != 0) {
         $perc10 = $fpKIVF/$rows7 * 100; 
         $fperc10 = number_format($perc10, 1, '.', '');
      }
      else {
         $fperc10 = 0;
      }

//USER-TESTING
    $stmtUserTesting = $stmt1 . " AND [Status] = 'User Testing' " . $category;
      $stmtUserTestingF = $db->prepare($stmtUserTesting);
      $stmtUserTestingF->execute();
        $fpUserTestingF = $stmtUserTestingF->fetchColumn();
        //statement for select datatable
        $stmtdata9 = $stmtTest . " AND [Status] = 'User Testing' " . $category . "ORDER BY [WorkNo] ASC";
       $stmtdata9F = $db->prepare($stmtdata9);
       $stmtdata9F->execute();
 
       $stmtT9 = "";
       $counter = 1; 
         while($row3 = $stmtdata9F->fetch(PDO::FETCH_ASSOC)){
 
           $stmtT9 .=    "<tr><td>". $counter++ .  "</td>"
                          ."<td>" . $row3['WorkNo'] . "</td>" 
                          ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                          . "<td><small>" . $row3['Reason'] . "</small></td>" 
                          . "<td>" . $row3['Service'] . "</td>"
                          . "<td>" . $row3['DIC'] . "</td>" 
                          . "<td>" . $row3['Status']  . "</td>"
                          . "<td>" . $row3['InCharge'] . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                          . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
                          </tr>";
         }
 
       //PERCENTAGE USER-TESTING
       if ($rows7 != 0) {
         $perc9 = $fpUserTestingF/$rows7 * 100; 
         $fperc9 = number_format($perc9, 1, '.', '');
      }
      else {
         $fperc9 = 0;
      }

//Waiting Justification
    $stmtWait = $stmt1 . " AND [Status] = 'Waiting Justification' " . $category;
      $stmtWaitF = $db->prepare($stmtWait);
      $stmtWaitF->execute();
        $fpWaitF =  $stmtWaitF->fetchColumn();
        //statement for select datatable
        $stmtdata11 = $stmtTest . " AND [Status] = 'Waiting Justification' " . $category . "ORDER BY [WorkNo] ASC";
       $stmtdata11F = $db->prepare($stmtdata10);
       $stmtdata11F->execute();
 
       $stmtT11 = "";
       $counter = 1; 
         while($row3 = $stmtdata11F->fetch(PDO::FETCH_ASSOC)){
 
           $stmtT11 .=   "<tr><td>". $counter++ .  "</td>"
                        ."<td>" . $row3['WorkNo'] . "</td>" 
                        ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                        . "<td><small>" . $row3['Reason'] . "</small></td>" 
                        . "<td>" . $row3['Service'] . "</td>"
                        . "<td>" . $row3['DIC'] . "</td>" 
                        . "<td>" . $row3['Status']  . "</td>"
                        . "<td>" . $row3['InCharge'] . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
                        </tr>";
         }
 
       //PERCENTAGE USER-TESTING
       if ($rows7 != 0) {
         $perc11 = $fpWaitF/$rows7 * 100; 
         $fperc11 = number_format($perc11, 1, '.', '');
      }
      else {
         $fperc11 = 0;
      }
      
//others
        $stmtOthers = $stmt1 . " AND Status IN ('Waiting Justification','User Testing','KIV','') " . $category;
      $stmtOthersF = $db->prepare($stmtOthers);
      $stmtOthersF->execute();
        $fpOthersF = $stmtOthersF->fetchColumn();
        //statement for select datatable
        $stmtdata12 = $stmtTest . " AND Status IN ('Waiting Justification','User Testing','KIV','') " . $category . "ORDER BY [WorkNo] ASC";
       $stmtdata12F = $db->prepare($stmtdata12);
       $stmtdata12F->execute();
 
       $stmtT12 = "";
       $counter = 1; 
         while($row3 = $stmtdata12F->fetch(PDO::FETCH_ASSOC)){
 
          $stmtT12 .=  "<tr><td>". $counter++ .  "</td>"
                      ."<td>" . $row3['WorkNo'] . "</td>" 
                      ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                      . "<td><small>" . $row3['Reason'] . "</small></td>" 
                      . "<td>" . $row3['Service'] . "</td>"
                      . "<td>" . $row3['DIC'] . "</td>" 
                      . "<td>" . $row3['Status']  . "</td>"
                      . "<td>" . $row3['InCharge'] . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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

//EXECUTE GRAPHS***************************************************************

 //execute the whole status pie chart
    $sqlStatus = $db->prepare (" SELECT COUNT(WorkNo) as count, Status
                                FROM [AINDATA].[dbo].[IN_0080]
                                WHERE [AddDate] >= DATEADD(day,-7,GETDATE())
                                AND STATUS <> ''
                                AND PROVIDER IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                GROUP BY STATUS
                                ");
    $sqlStatus->execute();
    //passing data to jquery to generate pie chart
    $dataWStatus = array();
    $dataWStatus[] = [];

    foreach($sqlStatus as $row) {

      $dataWStatus['label'][] = $row['Status'];
      $dataWStatus['data'][] = $row['count'];
      //$dataWStatus['colour'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
      $hexMin = 0;
      $hexMax = 9;
      $rgbMin = 0;
      $rgbMax = 153; // Hex 99 = 153 Decimal
      $dataWStatus['colour'][] = '#' . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin,$hexMax) . mt_rand($hexMin, $hexMax) . mt_rand($hexMin, $hexMax);
    }

    $dataWStatus['chartWStatus'] = json_encode($dataWStatus);

//execute data for pie chart PIC 
    $sqlT = $db->prepare("  SELECT COUNT(InCharge) as record,InCharge
                            FROM [AINDATA].[dbo].[IN_0080]
                            WHERE [AddDate] >= DATEADD(day,-7,GETDATE())
                            AND InCharge <> ''
                            AND PROVIDER IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
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

    /*for ($i=0; $i<=$row['record']; $i++) {

    }*/
    $data['chart_data'] = json_encode($data);     

 //execute data for bar chart by DIC

    $sqlU =  $db->prepare("   SELECT COUNT(DIC) AS RECORD , DIC
                                FROM [AINDATA].[dbo].[IN_0080]
                                WHERE [AddDate] >= DATEADD(day,-7,GETDATE())
                                AND DIC <> ''
                                AND PROVIDER IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                GROUP BY DIC
                                ");
    $sqlU->execute();
    //passing data to jquery to generate bar chart

    // Prepare the data for returning with the view
    $chartsData="";
   //$colourss = array();
   //$colourss[] = [];
    while ($row = $sqlU->fetch(PDO::FETCH_ASSOC)) { 
    
      $count[]  = $row['RECORD']  ;
      $dic[] = $row['DIC'];
    
    //$colourss[][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6); 
    }

    $dateCurrent =  date('d-M-Y');

   



















/***************************************************************************END DATA DISPLAY BEFORE USER'S SELECTION (DISPLAY ONLY CURRENT LAST 7 DAYS) */
    if(isset($_POST['simpan']) ) { 

         $PIC = $_POST['PIC'];
         $DIC = $_POST['DIC'];
         $from_date = $_POST['from_date'];
      
         $stmt1 = " SELECT count([WorkNo])
                    FROM dbo.IN_0080
                    WHERE Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY') ";

        $stmtTest = " SELECT *
                        FROM dbo.IN_0080
                        WHERE Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY') ";



        if ($PIC <> "" && $DIC == "" && $from_date == "") {
            //echo "aa";
            $category = " AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6)";
            //SUBSTRING([AINDATA].[dbo].[SY_0600].PIC,0,6)
            $date =  "AND [AddDate] >= DATEADD(day,-7,GETDATE())";
            $date2 = "WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";
            $titleChart = "for $PIC ";
            //$categoryforChart1 = " AND SUBSTRING([PIC],0,6) = '$empno'";   
        }
        elseif ($DIC <> "" && $PIC == "" && $from_date == "") {
            //echo "aa5";
            $category = " AND [DIC] = '$DIC'";
            $date =  "AND [AddDate] >= DATEADD(day,-7,GETDATE())";
            $date2 =  "WHERE [AddDate] >= DATEADD(day,-7,GETDATE())";
            $titleChart = "for $DIC ";
            //$categoryforChart1 = " AND [DIC] = '$DIC'";
        }
        elseif ($PIC <> "" && $DIC == "" && $from_date <> "") {
        //echo "aa6";
        $category = " AND SUBSTRING([InCharge],0,6) = SUBSTRING('$PIC',0,6)";
        $date =  "AND [AddDate] >= '$from_date' ";  
        $date2 =  "WHERE [AddDate] >= '$from_date' "; 
        $titleChart = "for $PIC and from " . date('d-M-Y',strtotime($from_date)) . " until $dateCurrent  ";
        //$categoryforChart1 = " AND SUBSTRING([PIC],0,6) = '$empno'";   
        }
        elseif ($DIC <> "" && $PIC == "" && $from_date <> "") {
        //echo "aa7";
        $category = " AND [DIC] = '$DIC'";
        $date =  "AND [AddDate] >= '$from_date'";
        $date2 =  "WHERE [AddDate] >= '$from_date'";
        $titleChart = "for $DIC and from " . date('d-M-Y',strtotime($from_date)) . " until $dateCurrent  ";
        // $categoryforChart1 = " AND [DIC] = '$DIC'";
        }
        elseif($DIC == "" && $PIC == "" && $from_date <> "") {
        //echo "aa8";
        $category = "";
        $date =  " AND [AddDate] >= '$from_date'";
        $date2 =  "WHERE [AddDate] >= '$from_date'";
        $titleChart = "from " . date('d-M-Y',strtotime($from_date)) ." until $dateCurrent  ";
        //$categoryforChart1 = ""; 
        }

        //count total for according to date selection
        $stmtByDateCount = "  SELECT count([WorkNo])
                                FROM dbo.IN_0080
                                WHERE Provider IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
                                ";
        $stmt7 = $stmtByDateCount . $date . $category;
        $stmt7Ex = $db->prepare($stmt7);
        $stmt7Ex->execute();
        $rows7 = $stmt7Ex->fetchColumn();

    //OPEN WITH NO PIC
    $stmtNoPic =  $stmt1 . $date . " AND [InCharge] IS NULL AND [Status] = 'OPEN' " . $category;
    $stmtNoPicF = $db->prepare($stmtNoPic);
    $stmtNoPicF->execute();
    $fpNoPic = $stmtNoPicF->fetchColumn();
    //statement for select to view datatable
    $stmtdata1 = $stmtTest . " AND [InCharge] IS NULL AND [Status] = 'OPEN' " . $category . " ORDER BY [WorkNo] ASC";
    $stmtdata1F = $db->prepare($stmtdata1);
    $stmtdata1F->execute();
    $stmtT = "";
      while($row3 = $stmtdata1F->fetch(PDO::FETCH_ASSOC)){

        $stmtT .=  "<tr><td>". $counter++ .  "</td>"
                    ."<td>" . $row3['WorkNo'] . "</td>" 
                    ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                    . "<td><small>" . $row3['Reason'] . "</small></td>" 
                    . "<td>" . $row3['Service'] . "</td>"
                    . "<td>" . $row3['DIC'] . "</td>" 
                    . "<td>" . $row3['InCharge'] . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
                    </tr>";
        }
    //PERCENTAGE NO PIC
    if ($rows7 != 0) {
        $perc1 = $fpNoPic/$rows7 * 100; 
        $fperc1 = number_format($perc1, 1, '.', '');
      
      } else {
        $fperc1 = 0;
      }

//OPEN WITH PIC
    $stmtPicOpen = $stmt1 . $date . " AND [InCharge] IS NOT NULL AND [Status] = 'OPEN' " . $category;
    $stmtPicOpenF = $db->prepare($stmtPicOpen);
    $stmtPicOpenF->execute();
    $fpNPicOpen = $stmtPicOpenF->fetchColumn();
    //statement for select to view datatable
    $stmtdata2 = $stmtTest . $date . "AND [InCharge] IS NOT NULL AND [Status] = 'OPEN'" . $category . " ORDER BY [WorkNo] ASC";
    $stmtdata2F = $db->prepare($stmtdata2);
    $stmtdata2F->execute();

    $stmtT2 = "";
    $counter = 1;
      while($row3 = $stmtdata2F->fetch(PDO::FETCH_ASSOC)){

        $stmtT2 .=  "<tr><td>". $counter++ .  "</td>"
                    ."<td>" . $row3['WorkNo'] . "</td>" 
                    ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                    . "<td><small>" . $row3['Reason'] . "</small></td>" 
                    . "<td>" . $row3['Service'] . "</td>"
                    . "<td>" . $row3['DIC'] . "</td>" 
                    . "<td>" . $row3['InCharge'] . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
                    </tr>";
      }
    //PERCENTAGE WITH PIC STATUS OPEN
    if ($rows7 != 0) {
        $perc2 = $fpNPicOpen/$rows7 * 100; 
        $fperc2 = number_format($perc2, 1, '.', '');
    } else {
        $fperc2 = 0;
    }

//IN PROGRESS
    $stmtInProgress = $stmt1 . $date . "AND [Status] = 'In Progress'" . $category ;
    $stmtInProgressF = $db->prepare($stmtInProgress);
    $stmtInProgressF->execute();
    $fpInProgress = $stmtInProgressF->fetchColumn();
    //statement for select to view datatable
    $stmtdata3 = $stmtTest . $date . "AND [Status] = 'In Progress'" . $category . " ORDER BY [WorkNo] ASC";
    $stmtdata3F = $db->prepare($stmtdata3);
    $stmtdata3F->execute();

    $stmtT3 = "";
    $counter = 1;
      while($row3 = $stmtdata3F->fetch(PDO::FETCH_ASSOC)){

        $stmtT3 .=  "<tr><td>". $counter++ .  "</td>"
                    ."<td>" . $row3['WorkNo'] . "</td>" 
                    ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                    . "<td><small>" . $row3['Reason'] . "</small></td>" 
                    . "<td>" . $row3['Service'] . "</td>"
                    . "<td>" . $row3['DIC'] . "</td>" 
                    . "<td>" . $row3['InCharge'] . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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
    $stmtCom = $stmt1 . $date . "AND [Status] = 'Completed'" . $category;
    $stmtComF = $db->prepare($stmtCom);
    $stmtComF->execute();
    $fpComF = $stmtComF->fetchColumn();
    //statement for select to view datatable
    $stmtdata4 = $stmtTest . $date . "AND [Status] = 'Completed'" . $category . " ORDER BY [WorkNo] ASC";
    $stmtdata4F = $db->prepare($stmtdata4);
    $stmtdata4F->execute();

    $stmtT4 = "";
    $counter = 1;
      while($row3 = $stmtdata4F->fetch(PDO::FETCH_ASSOC)){

        $stmtT4 .=   "<tr><td>". $counter++ .  "</td>"
                      ."<td>" . $row3['WorkNo'] . "</td>" 
                      ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                      . "<td><small>" . $row3['Reason'] . "</small></td>" 
                      . "<td>" . $row3['Service'] . "</td>"
                      . "<td>" . $row3['DIC'] . "</td>" 
                      . "<td>" . $row3['InCharge'] . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
                      </tr>";
      }
    //PERCENTAGE COMPLETED
    if ($rows7 != 0) {
        $perc4 = $fpComF/$rows7 * 100; 
        $fperc4 = number_format($perc4, 1, '.', '');
    } else {
        $fperc4 = 0;
    }

//Oustanding
    $stmtOut = $stmt1 . $date . "AND [Status] != 'Completed'  AND [Status] != 'CANCEL'" . $category;
    $stmtOutF =  $db->prepare($stmtOut);
    $stmtOutF->execute();
    $fpOutF = $stmtOutF->fetchColumn();
     //statement for select to view datatable
     $stmtdata5 = $stmtTest . $date . "AND [Status] != 'Completed'  AND [Status] != 'CANCEL'"  . $category ." ORDER BY [WorkNo] ASC";
     $stmtdata5F = $db->prepare($stmtdata5);
     $stmtdata5F->execute();

     $stmtT5 = "";
     $counter = 1;
       while($row3 = $stmtdata5F->fetch(PDO::FETCH_ASSOC)){

         $stmtT5 .=   "<tr><td>". $counter++ .  "</td>"
                        ."<td>" . $row3['WorkNo'] . "</td>" 
                        ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                        . "<td><small>" . $row3['Reason'] . "</small></td>" 
                        . "<td>" . $row3['Service'] . "</td>"
                        . "<td>" . $row3['DIC'] . "</td>" 
                        . "<td>" . $row3['Status']  . "</td>"
                        . "<td>" . $row3['InCharge'] . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
                        </tr>";
       }
    //PERCENTAGE OUTSTANDING
    if ($rows7 != 0) {
        $perc5 = $fpOutF/$rows7 * 100; 
        $fperc5 = number_format($perc5, 1, '.', '');
    } else {
        $fperc5 = 0;
    }

//OVERDUE 
$stmtOver = $stmt1 . $date . "AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL'" . $category;
    $stmtOverF =  $db->prepare($stmtOver);
    $stmtOverF->execute();
    $fpOverF = $stmtOverF->fetchColumn();
    //statement for select to view datatable
    $stmtdata6 = $stmtTest . $date . "AND CAST( GETDATE() AS Date )  > [DueDate] AND [Status] != 'Completed' AND [Status] != 'CANCEL' " . $category . " ORDER BY [WorkNo] ASC";
    $stmtdata6F = $db->prepare($stmtdata6);
    $stmtdata6F->execute();

    $stmtT6 = "";
    $counter = 1;
      while($row3 = $stmtdata6F->fetch(PDO::FETCH_ASSOC)){

        $stmtT6 .=  "<tr><td>". $counter++ .  "</td>"
                    ."<td>" . $row3['WorkNo'] . "</td>" 
                    ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                    . "<td><small>" . $row3['Reason'] . "</small></td>" 
                    . "<td>" . $row3['Service'] . "</td>"
                    . "<td>" . $row3['DIC'] . "</td>" 
                    . "<td>" . $row3['Status']  . "</td>"
                    . "<td>" . $row3['InCharge'] . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                    . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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
       $stmtCancel = $stmt1 . $date . " AND [Status] = 'Cancel' " . $category;
       $stmtCancelF = $db->prepare($stmtCancel);
       $stmtCancelF->execute();
       $fpCancelF = $stmtCancelF->fetchColumn();
       //statement for select datatable
       $stmtdata7 = $stmtTest . $date ." AND [Status] = 'Cancel' " . $category . "ORDER BY [WorkNo] ASC";
      $stmtdata7F = $db->prepare($stmtdata7);
      $stmtdata7F->execute();

      $stmtT7 = "";
      $counter = 1;
        while($row3 = $stmtdata7F->fetch(PDO::FETCH_ASSOC)){

          $stmtT7 .=  "<tr><td>". $counter++ .  "</td>"
                      ."<td>" . $row3['WorkNo'] . "</td>" 
                      ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                      . "<td><small>" . $row3['Reason'] . "</small></td>" 
                      . "<td>" . $row3['Service'] . "</td>"
                      . "<td>" . $row3['DIC'] . "</td>" 
                      . "<td>" . $row3['InCharge'] . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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
//KIV
      /*$stmtKIV = $stmt1 . $date . " AND [Status] = 'KIV' " . $category;
      $stmtKIVF = $db->prepare($stmtKIV);
      $stmtKIVF->execute();
        $fpKIVF = $stmtKIVF->fetchColumn();
        //statement for select datatable
        $stmtdata10 = $stmtTest . $date . " AND [Status] = 'KIV' " . $category . "ORDER BY [WorkNo] ASC";
       $stmtdata10F = $db->prepare($stmtdata10);
       $stmtdata10F->execute();
 
       $stmtT10 = "";
       $counter = 1; 
         while($row3 = $stmtdata10F->fetch(PDO::FETCH_ASSOC)){
 
          $stmtT10 .=  "<tr><td>". $counter++ .  "</td>"
                      ."<td>" . $row3['WorkNo'] . "</td>" 
                      ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                      . "<td><small>" . $row3['Reason'] . "</small></td>" 
                      . "<td>" . $row3['Service'] . "</td>"
                      . "<td>" . $row3['DIC'] . "</td>" 
                      . "<td>" . $row3['Status']  . "</td>"
                      . "<td>" . $row3['InCharge'] . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                      . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
                      </tr>";
         }
 
       //PERCENTAGE KIV
       if ($rows7 != 0) {
         $perc10 = $fpKIVF/$rows7 * 100; 
         $fperc10 = number_format($perc10, 1, '.', '');
      }
      else {
         $fperc10 = 0;
      }

//USER-TESTING
    $stmtUserTesting = $stmt1 . $date . " AND [Status] = 'User Testing' " . $category;
      $stmtUserTestingF = $db->prepare($stmtUserTesting);
      $stmtUserTestingF->execute();
        $fpUserTestingF = $stmtUserTestingF->fetchColumn();
        //statement for select datatable
        $stmtdata9 = $stmtTest . $date . " AND [Status] = 'User Testing' " . $category . "ORDER BY [WorkNo] ASC";
       $stmtdata9F = $db->prepare($stmtdata9);
       $stmtdata9F->execute();
 
       $stmtT9 = "";
       $counter = 1; 
         while($row3 = $stmtdata9F->fetch(PDO::FETCH_ASSOC)){
 
           $stmtT9 .=    "<tr><td>". $counter++ .  "</td>"
                        ."<td>" . $row3['WorkNo'] . "</td>" 
                        ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                        . "<td><small>" . $row3['Reason'] . "</small></td>" 
                        . "<td>" . $row3['Service'] . "</td>"
                        . "<td>" . $row3['DIC'] . "</td>" 
                        . "<td>" . $row3['Status']  . "</td>"
                        . "<td>" . $row3['InCharge'] . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
                        </tr>";
         }
 
       //PERCENTAGE USER-TESTING
       if ($rows7 != 0) {
         $perc9 = $fpUserTestingF/$rows7 * 100; 
         $fperc9 = number_format($perc9, 1, '.', '');
      }
      else {
         $fperc9 = 0;
      }

//Waiting Justification
    $stmtWait = $stmt1 . $date . " AND [Status] = 'Waiting Justification' " . $category;
      $stmtWaitF = $db->prepare($stmtWait);
      $stmtWaitF->execute();
        $fpWaitF =  $stmtWaitF->fetchColumn();
        //statement for select datatable
        $stmtdata11 = $stmtTest . $date . " AND [Status] = 'Waiting Justification' " . $category . "ORDER BY [WorkNo] ASC";
       $stmtdata11F = $db->prepare($stmtdata10);
       $stmtdata11F->execute();
 
       $stmtT11 = "";
       $counter = 1; 
         while($row3 = $stmtdata11F->fetch(PDO::FETCH_ASSOC)){
 
           $stmtT11 .=  "<tr><td>". $counter++ .  "</td>"
                        ."<td>" . $row3['WorkNo'] . "</td>" 
                        ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                        . "<td><small>" . $row3['Reason'] . "</small></td>" 
                        . "<td>" . $row3['Service'] . "</td>"
                        . "<td>" . $row3['DIC'] . "</td>" 
                        . "<td>" . $row3['Status']  . "</td>"
                        . "<td>" . $row3['InCharge'] . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
                        </tr>";
         }
 
       //PERCENTAGE USER-TESTING
       if ($rows7 != 0) {
         $perc11 = $fpWaitF/$rows7 * 100; 
         $fperc11 = number_format($perc11, 1, '.', '');
      }
      else {
         $fperc11 = 0;
      } */
      
//others
        $stmtOthers = $stmt1 . $date . " AND Status IN ('Waiting Justification','User Testing','KIV','') " . $category;
      $stmtOthersF = $db->prepare($stmtOthers);
      $stmtOthersF->execute();
        $fpOthersF = $stmtOthersF->fetchColumn();
        //statement for select datatable
        $stmtdata12 = $stmtTest . $date . " AND Status IN ('Waiting Justification','User Testing','KIV','') " . $category . "ORDER BY [WorkNo] ASC";
       $stmtdata12F = $db->prepare($stmtdata12);
       $stmtdata12F->execute();
 
       $stmtT12 = "";
       $counter = 1; 
         while($row3 = $stmtdata12F->fetch(PDO::FETCH_ASSOC)){
 
          $stmtT12 .=  "<tr><td>". $counter++ .  "</td>"
                        ."<td>" . $row3['WorkNo'] . "</td>" 
                        ."<td>" . $row3['EmpNo'] . "</br>" . $row3['EName'] . "</td>" 
                        . "<td><small>" . $row3['Reason'] . "</small></td>" 
                        . "<td>" . $row3['Service'] . "</td>"
                        . "<td>" . $row3['DIC'] . "</td>" 
                        . "<td>" . $row3['Status']  . "</td>"
                        . "<td>" . $row3['InCharge'] . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['EditDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['AddDate'], 0, 10) . "</td>"
                        . "<td style='width:100px;'>" . substr($row3['DueDate'], 0, 10) . "</td>
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

      //EXECUTE GRAPHSSS
            //execute the whole status pie chart
            $sqlStatus = $db->prepare (" SELECT COUNT(WorkNo) as count, Status
                                        FROM [AINDATA].[dbo].[IN_0080] ".
                                        $date2  .
                                        $category .
                                        "AND PROVIDER IN ('MGMT INFO SYSTEM','INFORMATION TECHNOLOGY')
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









    }






















?>