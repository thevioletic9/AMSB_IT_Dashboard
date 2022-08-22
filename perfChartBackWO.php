<?php

require __DIR__ . '/database.php';
$db = DB();
$status = "";
$from_date = "";
$end_date = "";
 $year = "";
$dept = "";
$statementTitle = "" ;
//select  YEAR FROM DATABASE
$sqlYear = $db->prepare("   SELECT DISTINCT YEAR([AddDate]) as year 
                            FROM [AINDATA].[dbo].[SY_0600]
                            WHERE [AddDate] <> ''
                            ORDER BY YEAR([AddDate]) ASC 
                        ");
$sqlYear->execute();

//display all dept
$stmtDIC = $db->prepare("   SELECT DISTINCT [DIC]
                            FROM dbo.SY_0600
                            WHERE [DIC] IS NOT NULL
                            AND [DIC] <> ''    
                            AND [DIC] != 'All'        
                     ");
$stmtDIC->execute();

//display status
$stmtStatus = $db->prepare("    SELECT DISTINCT [Status]
                                FROM dbo.SY_0600
                                WHERE [Status] IS NOT NULL
                                AND [Status] <> ''              
                         ");
$stmtStatus->execute();



/*$statement = $db->prepare(" SELECT PIC , COUNT(FBNo) AS RECORD
                                   FROM [AINDATA].[dbo].[SY_0600]
                                   WHERE month(AddDate) =  DATEPART(month, getdate()) 
                                   AND YEAR(AddDate) = DATEPART(year, getdate())
                                   GROUp BY PIC"
                                );
                                
$statement->execute(); 


while ($row = $statement->fetch(PDO::FETCH_ASSOC)) { 

       
       $staff[] = $row['PIC'];
       $count[] = $row['RECORD'];
       $colour[] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
} */

if (isset($_POST['simpan'])) {

       $from_date = $_POST['from_date'];
       $end_date = $_POST['end_date'];
       $year = $_POST['year'];
       $dept = $_POST['DIC'];
       $status = $_POST['Status'];


       $stmtGeneral = "SELECT InCharge, COUNT(WorkNo) as record
                       FROM [AINDATA].[dbo].[IN_0080]";
       
       $stmtGeneral2 =  "SELECT *
                          FROM [AINDATA].[dbo].[IN_0080]  ";

       $stmtGeneral3 = "SELECT count(*)
                        FROM [AINDATA].[dbo].[IN_0080]";


       if ( ($from_date && $end_date) <> "" && $year == "" && $dept == "" && $status == ""  ) {

              $statement1 = $stmtGeneral . " 
                                          WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                                          GROUP BY InCharge
                                       ";
              $statement = $db->prepare($statement1);
             
              $statementModal1 = $stmtGeneral2 . 
                                   "WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                                   ORDER BY AddDate ASC
                                   "; 
              $statementModal = $db->prepare($statementModal1);

              $stmtCount1 = $stmtGeneral3 . "WHERE AddDate BETWEEN  '$from_date' AND '$end_date'";
              $stmtCount = $db->prepare($stmtCount1);
             // $statementTitle = "Bar Chart between $from_date and $end_date  ";
              
       } 
       if (($from_date && $end_date && $dept && $status) == "" && $year <> "") {
              
              $statement2 = $stmtGeneral . " 
                            WHERE year([AddDate]) = '$year'
                            GROUP BY InCharge ";
              $statement = $db->prepare($statement2);

              $statementModal2 = $stmtGeneral2 . 
                                   "WHERE year([AddDate]) = '$year'
                                   ORDER BY AddDate ASC
                                   "; 
              $statementModal = $db->prepare($statementModal2);

              $stmtCount2 = $stmtGeneral3 . "WHERE year([AddDate]) = '$year'";
              $stmtCount = $db->prepare($stmtCount2);

              //$statementTitle = "Bar Chart for the year : $year ";
                 
       }
       if (($from_date && $end_date && $year && $status) == "" && $dept <> "") {
              $statement3 = $stmtGeneral . " 
                            WHERE DIC = '$dept'
                            GROUP BY InCharge ";
              $statement = $db->prepare($statement3);

              $statementModal3 = $stmtGeneral2 . 
                                   "WHERE DIC = '$dept'
                                   ORDER BY AddDate ASC
                                   "; 
              $statementModal = $db->prepare($statementModal3);

              $stmtCount3 = $stmtGeneral3 . "WHERE DIC = '$dept'";
              $stmtCount = $db->prepare($stmtCount3);
             // $statementTitle = "Bar Chart for department : $dept ";
       } 
       if (($from_date && $end_date && $year && $dept) == "" && $status <> "") {
              
              $statement4 = $stmtGeneral . " 
                            WHERE Status = '$status'
                            GROUP BY InCharge ";
              $statement = $db->prepare($statement4);

              $statementModal4 = $stmtGeneral2 . 
                                   "WHERE Status = '$status'
                                   ORDER BY AddDate ASC
                                   "; 
              $statementModal = $db->prepare($statementModal4);

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

              $statementModal5 = $stmtGeneral2 . 
                                   "WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                                   AND DIC = '$dept'
                                   ORDER BY AddDate ASC
                                   "; 
              $statementModal = $db->prepare($statementModal5);

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

              $statementModal6 = $stmtGeneral2 . 
                                   "WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                                   AND Status = '$status'
                                   ORDER BY AddDate ASC
                                   "; 
              $statementModal = $db->prepare($statementModal6);

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

              $statementModal7 = $stmtGeneral2 . 
                                   "WHERE year([AddDate]) = '$year'
                                   AND DIC = '$dept'
                                   ORDER BY AddDate ASC
                                   "; 
              $statementModal = $db->prepare($statementModal7);

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

              $statementModal8 = $stmtGeneral2 . 
                                   "WHERE year([AddDate]) = '$year'
                                   AND Status = '$status'
                                   ORDER BY AddDate ASC
                                   "; 
              $statementModal = $db->prepare($statementModal8);

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

              $statementModal9 = $stmtGeneral2 . 
                                   "WHERE DIC = '$dept'
                                   AND Status = '$status'
                                   ORDER BY AddDate ASC
                                   "; 
              $statementModal = $db->prepare($statementModal9);

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
 
               $statementModal10 = $stmtGeneral2 . 
                                    " WHERE AddDate BETWEEN  '$from_date' AND '$end_date'
                                    AND DIC = '$dept'
                                    AND Status = '$status'
                                    ORDER BY AddDate ASC
                                    "; 
               $statementModal = $db->prepare($statementModal10);
 
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

              $statementModal11 = $stmtGeneral2 . 
                                   "  WHERE year([AddDate]) = '$year'
                                   AND DIC = '$dept'
                                   AND Status = '$status'
                                   ORDER BY AddDate ASC
                                   "; 
              $statementModal = $db->prepare($statementModal11);

              $stmtCount11 = $stmtGeneral3 . "   WHERE year([AddDate]) = '$year'
                                                AND DIC = '$dept'
                                                AND Status = '$status'";
              $stmtCount = $db->prepare($stmtCount11);

       } 
      

       $statement->execute();
       $statementModal->execute();
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

       $stmt = "";
       $counter = 1;
       //modal 
       while($row1 = $statementModal->fetch(PDO::FETCH_ASSOC)){

              $stmt .= "<tr><td>". $counter++ .  "</td>"
              ."<td>" . $row1['WorkNo'] . "</td>" 
              . "<td>" . $row1['Service'] . " </td>" 
              ."<td>" . $row1['EmpNo'] . "</br>" . $row1['EName'] . "</td>" 
              . "<td><small>" . $row1['Reason'] . "</small></td>" 
              . "<td style='width:100px;'>" . substr($row1['AddDate'], 0, 10) . "</td>"
              . "<td style='width:100px;'>" .  $row1['DIC'] . "</td>"
              . "<td >" .  $row1['Status'] . "</td>
              </tr>";
       }
       //echo "meow";
       //echo "<span class='btn btn-primary btn-m float-right' data-toggle='modal' data-target='#modal1' role='button'>View Datatable<span>";

















}
//fetch data from db 

/*$statementFCount = $db->prepare("  SELECT PIC, COUNT(fbno) as record
                                   FROM [AINDATA].[dbo].[SY_0600]
                                   WHERE AddDate >= '2022-01-01'
                                   AND Status = 'COMPLETED'
                                   group by PIC
                            
                              ");

$statementFCount->execute();
$count = [];
$staff = [];
$colour = [];*/

















































?>