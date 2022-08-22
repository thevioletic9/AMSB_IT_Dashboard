<?php
require __DIR__ . '/database.php';
//include 'testing.php';
$db = DB();

//new job 
/*$stmt0 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] >= DATEADD(day,-4,GETDATE())
                        AND [PIC] IS NULL
                     ");
$stmt0->execute();
$rows0 = $stmt0->fetchColumn();
//echo "New JOB = ". $rows0 . "\n";*/

//No PIC (STATUS=OPEN)
$stmt1 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [PIC] IS NULL
                     ");

$stmt1->execute();
$rows = $stmt1->fetchColumn();
//echo "No PIC = ". $rows . "\n";

//in-progress 
$stmt2 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'IN-PROGRESS'
                     ");

$stmt2->execute();
$rows2 = $stmt2->fetchColumn();
//echo "Working/In-progress = ". $rows2 . "\n";

//completed
$stmt3 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'COMPLETED'
                     ");

$stmt3->execute();
$rows3 = $stmt3->fetchColumn();
//echo "Completed = ". $rows3 . "\n";

//Outstanding
$stmt4 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] != 'COMPLETED'
                     ");

$stmt4->execute();
$rows4 = $stmt4->fetchColumn();
//echo "Outstanding = ". $rows4 . "\n";


//STATUS OPEN ADA PIC 
$stmt5 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [PIC] IS NOT NULL
                        AND [Status] = 'OPEN'
                     ");

$stmt5->execute();
$rows5 = $stmt5->fetchColumn();
//echo "No PIC WITH STATUS OPEN = ". $rows5 . "\n";

//OVERDUE USE COLUMN(TARGET DATE) TESTING
$stmt6 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] >= '2022-04-01'
                        AND CAST( GETDATE() AS Date )  > [TargetDate]
                        AND [Status] != 'COMPLETED'
                     ");

$stmt6->execute();
$rows6 = $stmt6->fetchColumn();
//echo "OVERDUE = ". $rows6 . "\n";

//count total for last 4 days; 
$stmt7 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        
                     ");

$stmt7->execute();
$rows7 = $stmt7->fetchColumn();
//echo "total feedbacks last 4 days = ". $rows7 . "\n";

//PERCENTAGE CALCULATION 
//for No PIC (STATUS=OPEN)
$perc1 = $rows/$rows7 * 100; 
$fperc1 = number_format($perc1, 2, '.', '');
//echo number_format($perc1, 2, '.', '');

//in-progress 
$perc2 = $rows2/$rows7 * 100; 
$fperc2 = number_format($perc2, 2, '.', '');
//echo number_format($perc2, 2, '.', '');

//completed
$perc3 = $rows3/$rows7 * 100;
$fperc3 = number_format($perc3, 2, '.', '');
//echo number_format($perc3, 2, '.', '');

//outstanding
$perc4 = $rows4/$rows7 * 100; 
$fperc4 = number_format($perc4, 2, '.', '');
//echo number_format($perc4, 2, '.', '');

//STATUS OPEN ADA PIC 
$perc5 = $rows5/$rows7 * 100; 
$fperc5 = number_format($perc5, 2, '.', '');
//echo number_format($perc5, 2, '.', '');

//OVERDUE
$perc6 = $rows6/$rows7 * 100; 
$fperc6 = number_format($perc6, 2, '.', '');
//echo number_format($perc6, 2, '.', '');



//BY DEPARTMENT

//ITO
//No PIC (STATUS=OPEN)
$stmtITO1 =  $db->prepare(" SELECT count([FBNo])
                            FROM dbo.SY_0600
                            WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                            AND [PIC] IS NULL
                            AND [DIC] = 'ITO'
                         ");

$stmtITO1->execute();
$rowsITO = $stmtITO1->fetchColumn();
//echo "No PIC ITO= ". $rowsITO . "\n";
//PERCENTAGE 
$ITOperc1 = $rowsITO/$rows7 * 100;
$fITOperc1 = number_format($ITOperc1, 2, '.', '');
//echo $fITOperc1;

//in-progress 
$stmtITO2 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'IN-PROGRESS'
                        AND [DIC] = 'ITO'
                     ");

$stmtITO2->execute();
$rows2ITO = $stmtITO2->fetchColumn();
//echo "Working/In-progress ITO= ". $rows2ITO . "\n";
//percentage
$ITOperc2 = $rows2ITO/$rows7 * 100;
$fITOperc2 = number_format($ITOperc2, 2, '.', '');
//echo $fITOperc2;

//completed
$stmtITO3 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'COMPLETED'
                        AND [DIC] = 'ITO'
                     ");

$stmtITO3->execute();
$rowsITO3 = $stmtITO3->fetchColumn();
//echo "Completed ITO= ". $rowsITO3 . "\n";
//percentage
$ITOperc3 = $rowsITO3/$rows7 * 100;
$fITOperc3 = number_format($ITOperc3, 2, '.', '');
//echo $fITOperc3;




//Outstanding
$stmtITO4 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] != 'COMPLETED'
                        AND [DIC] = 'ITO'
                     ");

$stmtITO4->execute();
$rowsITO4 = $stmtITO4->fetchColumn();
//echo "Outstanding ITO= ". $rowsITO4 . "\n";
//percentage
$ITOperc4 = $rowsITO4/$rows7 * 100;
$fITOperc4 = number_format($ITOperc4, 2, '.', '');
//echo $fITOperc4;




//STATUS OPEN ADA PIC 
$stmtITO5 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [PIC] IS NOT NULL
                        AND [Status] = 'OPEN'
                        AND [DIC] = 'ITO'
                     ");

$stmtITO5->execute();
$rowsITO5 = $stmtITO5->fetchColumn();
//echo " PIC WITH STATUS OPEN ITO = ". $rowsITO5 . "\n";
//percentage
$ITOperc5 = $rowsITO5/$rows7 * 100;
$fITOperc5 = number_format($ITOperc5, 2, '.', '');
//echo $fITOperc5;


//OVERDUE USE COLUMN(TARGET DATE) TESTING
$stmtITO6 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] >= '2022-04-01'
                        AND CAST( GETDATE() AS Date )  > [TargetDate]
                        AND [Status] != 'COMPLETED'
                        AND [DIC] = 'ITO'
                     ");

$stmtITO6->execute();
$rowsITO6 = $stmtITO6->fetchColumn();
//echo "OVERDUE = ". $rowsITO6 . "\n";
//percentage
$ITOperc6 = $rowsITO6/$rows7 * 100;
$fITOperc6 = number_format($ITOperc6, 2, '.', '');
//echo $fITOperc6;





//SDM
//No PIC (STATUS=OPEN)
$stmtSDM1 =  $db->prepare(" SELECT count([FBNo])
                            FROM dbo.SY_0600
                            WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                            AND [PIC] IS NULL
                            AND [DIC] = 'SDM'
                         ");

$stmtSDM1->execute();
$rowsSDM = $stmtSDM1->fetchColumn();
//echo "No PIC SDM = ". $rowsSDM . "\n";
//PERCENTAGE 
$SDMperc1 = $rowsSDM/$rows7 * 100;
$fSDMperc1 = number_format($SDMperc1, 2, '.', '');
//echo $fITOperc1;


//in-progress 
$stmtSDM2 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'IN-PROGRESS'
                        AND [DIC] = 'SDM'
                     ");

$stmtSDM2->execute();
$rows2SDM = $stmtSDM2->fetchColumn();
//echo "Working/In-progress SDM= ". $rows2SDM . "\n";
//percentage
$SDMperc2 = $rows2SDM/$rows7 * 100;
$fSDMperc2 = number_format($SDMperc2, 2, '.', '');
//echo $fSDMperc2;



//completed
$stmtSDM3 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'COMPLETED'
                        AND [DIC] = 'SDM'
                     ");

$stmtSDM3->execute();
$rowsSDM3 = $stmtSDM3->fetchColumn();
//echo "Completed SDM= ". $rowsSDM3 . "\n";
//percentage
$SDMperc3 = $rowsSDM3/$rows7 * 100;
$fSDMperc3 = number_format($SDMperc3, 2, '.', '');
//echo $fSDMperc3;



//Outstanding
$stmtSDM4 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] != 'COMPLETED'
                        AND [DIC] = 'SDM'
                     ");

$stmtSDM4->execute();
$rowsSDM4 = $stmtSDM4->fetchColumn();
//echo "Outstanding SDM= ". $rowsSDM4 . "\n";
//percentage
$SDMperc4 = $rowsSDM4/$rows7 * 100;
$fSDMperc4 = number_format($SDMperc4, 2, '.', '');
//echo $fSDMperc4;




//STATUS OPEN ADA PIC 
$stmtSDM5 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [PIC] IS NOT NULL
                        AND [Status] = 'OPEN'
                        AND [DIC] = 'SDM'
                     ");

$stmtSDM5->execute();
$rowsSDM5 = $stmtSDM5->fetchColumn();
//echo " PIC WITH STATUS OPEN SDM = ". $rowsSDM5 . "\n";
//percentage
$SDMperc5 = $rowsSDM5/$rows7 * 100;
$fSDMperc5 = number_format($SDMperc5, 2, '.', '');
//echo $fSDMperc5;



//OVERDUE USE COLUMN(TARGET DATE) TESTING
$stmtSDM6 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] >= '2022-04-01'
                        AND CAST( GETDATE() AS Date )  > [TargetDate]
                        AND [Status] != 'COMPLETED'
                        AND [DIC] = 'SDM'
                     ");

$stmtSDM6->execute();
$rowsSDM6 = $stmtSDM6->fetchColumn();
//echo "OVERDUE = ". $rowsSDM6 . "\n";
//percentage
$SDMperc6 = $rowsSDM6/$rows7 * 100;
$fSDMperc6 = number_format($SDMperc6, 2, '.', '');
//echo $fSDMperc6;




//MMD
//No PIC (STATUS=OPEN)
$stmtMMD1 =  $db->prepare(" SELECT count([FBNo])
                           FROM dbo.SY_0600
                            WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                           AND [PIC] IS NULL
                            AND [DIC] = 'MMD'
                        ");

$stmtMMD1->execute();
$rowsMMD = $stmtMMD1->fetchColumn();
//echo "No PIC MMD = ". $rowsMMD . "\n";
//PERCENTAGE 
$MMDperc1 = $rowsMMD/$rows7 * 100;
$fMMDperc1 = number_format($MMDperc1, 2, '.', '');
//echo $fMMDperc1;



//in-progress 
$stmtMMD2 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'IN-PROGRESS'
                        AND [DIC] = 'MMD'
                     ");

$stmtMMD2->execute();
$rows2MMD = $stmtMMD2->fetchColumn();
//echo "Working/In-progress MMD= ". $rows2MMD . "\n";
//percentage
$MMDperc2 = $rows2MMD/$rows7 * 100;
$fMMDperc2 = number_format($MMDperc2, 2, '.', '');
//echo $fMMDperc2;




//completed
$stmtMMD3 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'COMPLETED'
                        AND [DIC] = 'MMD'
                     ");

$stmtMMD3->execute();
$rowsMMD3 = $stmtMMD3->fetchColumn();
//echo "Completed MMD= ". $rowsMMD3 . "\n";
//percentage
$MMDperc3 = $rowsMMD3/$rows7 * 100;
$fMMDperc3 = number_format($MMDperc3, 2, '.', '');
//echo $fMMDperc3;



//Outstanding
$stmtMMD4 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] != 'COMPLETED'
                        AND [DIC] = 'MMD'
                     ");

$stmtMMD4->execute();
$rowsMMD4 = $stmtMMD4->fetchColumn();
//echo "Outstanding MMD= ". $rowsMMD4 . "\n";
//percentage
$MMDperc4 = $rowsMMD4/$rows7 * 100;
$fMMDperc4 = number_format($MMDperc4, 2, '.', '');
//echo $fMMDperc4;



//STATUS OPEN ADA PIC 
$stmtMMD5 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [PIC] IS NOT NULL
                        AND [Status] = 'OPEN'
                        AND [DIC] = 'MMD'
                     ");

$stmtMMD5->execute();
$rowsMMD5 = $stmtMMD5->fetchColumn();
//echo " PIC WITH STATUS OPEN MMD = ". $rowsMMD5 . "\n";
//percentage
$MMDperc5 = $rowsMMD5/$rows7 * 100;
$fMMDperc5 = number_format($MMDperc5, 2, '.', '');
//echo $fMMDperc5;



//OVERDUE USE COLUMN(TARGET DATE) TESTING
$stmtMMD6 =  $db->prepare(" SELECT count([FBNo])
                           FROM dbo.SY_0600
                           WHERE [AddDate] >= '2022-04-01'
                           AND CAST( GETDATE() AS Date )  > [TargetDate]
                           AND [Status] != 'COMPLETED'
                           AND [DIC] = 'MMD'
                        ");

$stmtMMD6->execute();
$rowsMMD6 = $stmtMMD6->fetchColumn();
//echo "OVERDUE = ". $rowsMMD6 . "\n";
//percentage
$MMDperc6 = $rowsMMD6/$rows7 * 100;
$fMMDperc6 = number_format($MMDperc6, 2, '.', '');
//echo $fMMDperc6;



//STD
//No PIC (STATUS=OPEN)
$stmtSTD1 =  $db->prepare(" SELECT count([FBNo])
                           FROM dbo.SY_0600
                            WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                           AND [PIC] IS NULL
                            AND [DIC] = 'STD'
                        ");

$stmtSTD1->execute();
$rowsSTD = $stmtSTD1->fetchColumn();
//echo "No PIC STD = ". $rowsSTD . "\n";
//PERCENTAGE 
$STDperc1 = $rowsSTD/$rows7 * 100;
$fSTDperc1 = number_format($STDperc1, 2, '.', '');
//echo $fSTDperc1;



//in-progress 
$stmtSTD2 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'IN-PROGRESS'
                        AND [DIC] = 'STD'
                     ");

$stmtSTD2->execute();
$rows2STD = $stmtSTD2->fetchColumn();
//echo "Working/In-progress STD= ". $rows2STD . "\n";
//percentage
$STDperc2 = $rows2STD/$rows7 * 100;
$fSTDperc2 = number_format($STDperc2, 2, '.', '');
//echo $fSTDperc2;




//completed
$stmtSTD3 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'COMPLETED'
                        AND [DIC] = 'STD'
                     ");

$stmtSTD3->execute();
$rowsSTD3 = $stmtSTD3->fetchColumn();
//echo "Completed STD= ". $rowsSTD3 . "\n";
//percentage
$STDperc3 = $rowsSTD3/$rows7 * 100;
$fSTDperc3 = number_format($STDperc3, 2, '.', '');
//echo $fSTDperc3;




//Outstanding
$stmtSTD4 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] != 'COMPLETED'
                        AND [DIC] = 'STD'
                     ");

$stmtSTD4->execute();
$rowsSTD4 = $stmtSTD4->fetchColumn();
//echo "Outstanding STD= ". $rowsSTD4 . "\n";
//percentage
$STDperc4 = $rowsSTD4/$rows7 * 100;
$fSTDperc4 = number_format($STDperc4, 2, '.', '');
//echo $fSTDperc4;


//STATUS OPEN ADA PIC 
$stmtSTD5 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [PIC] IS NOT NULL
                        AND [Status] = 'OPEN'
                        AND [DIC] = 'STD'
                     ");

$stmtSTD5->execute();
$rowsSTD5 = $stmtSTD5->fetchColumn();
//echo " PIC WITH STATUS OPEN STD = ". $rowsSTD5 . "\n";
//percentage
$STDperc5 = $rowsSTD5/$rows7 * 100;
$fSTDperc5 = number_format($STDperc5, 2, '.', '');
//echo $fSTDperc5;




//OVERDUE USE COLUMN(TARGET DATE) TESTING
$stmtSTD6 =  $db->prepare(" SELECT count([FBNo])
                           FROM dbo.SY_0600
                           WHERE [AddDate] >= '2022-04-01'
                           AND CAST( GETDATE() AS Date )  > [TargetDate]
                           AND [Status] != 'COMPLETED'
                           AND [DIC] = 'STD'
                        ");

$stmtSTD6->execute();
$rowsSTD6 = $stmtSTD6->fetchColumn();
//echo "OVERDUE = ". $rowsSTD6 . "\n";
//percentage
$STDperc6 = $rowsSTD6/$rows7 * 100;
$fSTDperc6 = number_format($STDperc6, 2, '.', '');
//echo $fSTDperc6;





//IFT
//No PIC (STATUS=OPEN)
$stmtIFT1 =  $db->prepare(" SELECT count([FBNo])
                           FROM dbo.SY_0600
                            WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                           AND [PIC] IS NULL
                            AND [DIC] = 'IFT'
                        ");

$stmtIFT1->execute();
$rowsIFT = $stmtIFT1->fetchColumn();
//echo "No PIC IFT = ". $rowsIFT . "\n";
//PERCENTAGE 
$IFTperc1 = $rowsIFT/$rows7 * 100;
$fIFTperc1 = number_format($IFTperc1, 2, '.', '');
//echo $fIFTperc1;



//in-progress 
$stmtIFT2 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'IN-PROGRESS'
                        AND [DIC] = 'IFT'
                     ");

$stmtIFT2->execute();
$rows2IFT = $stmtIFT2->fetchColumn();
//echo "Working/In-progress IFT= ". $rows2IFT . "\n";
//percentage
$IFTperc2 = $rows2IFT/$rows7 * 100;
$fIFTperc2 = number_format($IFTperc2, 2, '.', '');
//echo $fIFTperc2;



//completed
$stmtIFT3 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'COMPLETED'
                        AND [DIC] = 'IFT'
                     ");

$stmtIFT3->execute();
$rowsIFT3 = $stmtIFT3->fetchColumn();
//echo "Completed IFT= ". $rowsIFT3 . "\n";
//percentage
$IFTperc3 = $rowsIFT3/$rows7 * 100;
$fIFTperc3 = number_format($IFTperc3, 2, '.', '');
//echo $fIFTperc3;




//Outstanding
$stmtIFT4 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] != 'COMPLETED'
                        AND [DIC] = 'IFT'
                     ");

$stmtIFT4->execute();
$rowsIFT4 = $stmtIFT4->fetchColumn();
//echo "Outstanding IFT= ". $rowsIFT4 . "\n";
//percentage
$IFTperc4 = $rowsIFT4/$rows7 * 100;
$fIFTperc4 = number_format($IFTperc4, 2, '.', '');
//echo $fSTDperc4;



//STATUS OPEN ADA PIC 
$stmtIFT5 =  $db->prepare(" SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [PIC] IS NOT NULL
                        AND [Status] = 'OPEN'
                        AND [DIC] = 'IFT'
                     ");

$stmtIFT5->execute();
$rowsIFT5 = $stmtIFT5->fetchColumn();
//echo " PIC WITH STATUS OPEN IFT = ". $rowsIFT5 . "\n";
//percentage
$IFTperc5 = $rowsIFT5/$rows7 * 100;
$fIFTperc5 = number_format($IFTperc5, 2, '.', '');
//echo $fIFTperc5;




//OVERDUE USE COLUMN(TARGET DATE) TESTING
$stmtIFT6 =  $db->prepare(" SELECT count([FBNo])
                           FROM dbo.SY_0600
                           WHERE [AddDate] >= '2022-04-01'
                           AND CAST( GETDATE() AS Date )  > [TargetDate]
                           AND [Status] != 'COMPLETED'
                           AND [DIC] = 'IFT'
                        ");

$stmtIFT6->execute();
$rowsIFT6 = $stmtIFT6->fetchColumn();
//echo "OVERDUE = ". $rowsIFT6 . "\n";
//percentage
$IFTperc6 = $rowsIFT6/$rows7 * 100;
$fIFTerc6 = number_format($IFTperc6 , 2, '.', '');
//echo $fIFTerc6;




//display all list of employee
$stmtPIC = $db->prepare(" SELECT [empno],[empname]
                           FROM dbo.SY_0100
                           WHERE [ResignStatus] = 'NO'
                           AND [DivCode] = 'IFT' 
                           ORDER BY [empname] ASC                
                        ");
$stmtPIC->execute();


$stmtDIC = $db->prepare(" SELECT DISTINCT [DIC]
                        FROM dbo.SY_0600
                        WHERE [DIC] IS NOT NULL
                        AND [DIC] <> ''                
                     ");
$stmtDIC->execute();


//selection PIC
if(isset($_POST['submit']) ) { 

   $empno = $_POST['empno'];
   //$DIC = $_POST['DIC'];
      $stmtNoPicStatusOpen = "SELECT count([FBNo])
                              FROM dbo.SY_0600
                              WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                              AND [PIC] IS NULL ";

      $stmtWithPicStatusOpen = "SELECT count([FBNo])
                              FROM dbo.SY_0600
                              WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                              AND [PIC] IS NOT NULL
                              AND [Status] = 'OPEN' ";

      $stmtWorkingInProgress = "SELECT count([FBNo])
                              FROM dbo.SY_0600
                              WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                              AND [Status] = 'IN-PROGRESS' ";

      $stmtCompleted = "SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                        AND [Status] = 'COMPLETED'
                        AND [DIC] = 'ITO'";

      $stmtOutstanding = "SELECT count([FBNo])
                           FROM dbo.SY_0600
                           WHERE [AddDate] > DATEADD(day,-4,GETDATE())
                           AND [Status] != 'COMPLETED'";

      $stmtOverdue = "  SELECT count([FBNo])
                        FROM dbo.SY_0600
                        WHERE [AddDate] >= '2022-04-01'
                        AND CAST( GETDATE() AS Date )  > [TargetDate]
                        AND [Status] != 'COMPLETED'";


      if ($empno <> "") {
         
         $stmtCom = $stmtCompleted . "AND SUBSTRING([PIC],0,6) = '$empno'";
         $preCom = $db->prepare($stmtCom);
      }
      $preCom->execute();
      $fpreCom = $preCom->fetchColumn();


}  


?>