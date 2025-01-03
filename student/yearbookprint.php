<?php
require '../vendor/autoload.php';
include '../functions/conn.php';
$batchid = $_GET['batch'];
$sql = "SELECT * FROM batch WHERE id = '$batchid'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

use Mpdf\Mpdf;

// Initialize Mpdf with A4 Landscape
$mpdf = new Mpdf([
    'format' => 'Letter',
    'orientation' => 'P'
]);

$mpdf->SetDisplayMode('fullpage');
$mpdf->SetProtection(array('print'));
$mpdf->SetTitle('Yearbook');
$mpdf->SetAuthor('Yearbook');

// Start Output Buffering
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yearbook | <?php echo $row['year']?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lugrasimo&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Lugrasimo' !important;
            margin: 0;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            background-image: url('bggg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .title {
            text-align: center;
            position: absolute;
            top:22%;
            left: 22%;
            transform: translate(-22%, -22%);
            height: 100%;
        }

        h1 {
            font-size: 3rem;
            margin: 10px 0;
        }

        .title h2 {
            font-size: 28px;
            margin: 10px 0;
        }

        .title h3 {
            font-size: 22px;
            margin: 10px 0;
        }

        .guestspeaker {
            page-break-before: always; /* Force a page break before this content */
            text-align: center;
        }
        .outstanding{
            page-break-before: always; /* Force a page break before this content */
            text-align: center;
            
        }
        .alumnilist{
            page-break-before: always; /* Force a page break before this content */
            text-align: center;
        }

        .guestspeaker h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }

        .gimg {
            width:300px; /* Medium size */
            height: 300px;
            border-radius: 10px 10px 10px 10px;  /* Circle shape */
            object-fit: cover; /* Ensure the image fits nicely in the circle */
            margin-bottom: 10px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .guestspeaker p {
            font-style: italic;
            font-size: 16px;
            color: black;
            max-width: 80%; /* Limiting width for readability */
            margin: 0 auto; /* Center the paragraph */
        }
        .naming{
            font-size: 20px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="title">
        <h1>Lemery Colleges Inc.</h1>
        <h2>Yearbook <?php echo $row['year']?></h2>
        <h3></h3>
    </div>
    <?php
    $fsql = "SELECT * FROM facultymember WHERE BATCH = '$batchid' AND COURSE = 'President'";
    $fresult = $conn->query($fsql);
    foreach($fresult as $frow) {
    ?>

    <div class="guestspeaker">
        <h1>School President</h1>
        <img class="gimg" src="../administrator/images/<?php echo $frow['IMG']?>" alt="">
        <h2><?php echo htmlspecialchars($frow['FULLNAME']); ?></h2>
        <p>"<?php echo htmlspecialchars($frow['SPEECH']); ?>"</p>
    </div>
    <?php
    }
    ?>
    <?php
    $fsql = "SELECT * FROM facultymember WHERE BATCH = '$batchid' AND COURSE = 'School Administrator'";
    $fresult = $conn->query($fsql);
    foreach($fresult as $frow) {
    ?>

    <div class="guestspeaker">
        <h1>School Administrator</h1>
        <img class="gimg" src="../administrator/images/<?php echo $frow['IMG']?>" alt="">
        <h2><?php echo htmlspecialchars($frow['FULLNAME']); ?></h2>
        <p>"<?php echo htmlspecialchars($frow['SPEECH']); ?>"</p>
    </div>
    <?php
    }
    ?>

    <?php
    $fsql = "SELECT * FROM facultymember WHERE BATCH = '$batchid' AND ROLE = 'Guest Speaker'";
    $fresult = $conn->query($fsql);
    foreach($fresult as $frow) {
    ?>

    <div class="guestspeaker">
        <h1>Guest Speaker</h1>
        <img class="gimg" src="../administrator/images/<?php echo $frow['IMG']?>" alt="">
        <h2><?php echo htmlspecialchars($frow['FULLNAME']); ?></h2>
        <p>"<?php echo htmlspecialchars($frow['SPEECH']); ?>"</p>

    </div>
    <?php
    }
    ?>
    
    <?php
    $asql = "SELECT * FROM achievements";
    $aresult = $conn->query($asql);
    foreach($aresult as $arow) {
        $aid = $arow['id'];
        //check if there is an outstanding alumni for this achievement
        $osql = "SELECT * FROM outstandingalumni WHERE achievementid = '$aid' AND batch = '$batchid'";
        $oresult = $conn->query($osql);
        if($oresult->num_rows > 0){
            
            ?>
            <div class="outstanding">
                <h1><?php echo htmlspecialchars($arow['name']);?></h1>
                <?php
                foreach($oresult as $orow){
                  $alid = $orow['alumniid'];
                    $alumnisql = "SELECT * FROM alumnigallery WHERE ID = '$alid'";
                    $alumniresult = $conn->query($alumnisql);
                    $alrow = $alumniresult->fetch_assoc();
                    if($alrow['MIDDLENAME']==''){
                        $fullname = $alrow['FIRSTNAME'].' '.$alrow['LASTNAME'];
                    }else{
                        $fullname = $alrow['FIRSTNAME'].' '.$alrow['MIDDLENAME'][0].'. '.$alrow['LASTNAME'];
                    }
                    if(@$orow['specialawards']==''){
                        $specialawards = "<strong>".htmlspecialchars($fullname)."</strong>";
                    }else{
                        $specialawards = "<strong>".htmlspecialchars($fullname)."</strong>". " - ".htmlspecialchars($orow['specialawards']);
                    }
                    ?>
                    <p class="naming"><?php  echo $specialawards; ?></p>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        

    }
    ?>
    <div class="alumnilist">
    <h1>List of Graduates</h1>
    <?php
    $csql = "SELECT * FROM courses";
    $cresult = $conn->query($csql);
    foreach ($cresult as $crow) {
        $cid = $crow['id'];
        $cname = $crow['name'];
        $sql = "SELECT * FROM alumnigallery WHERE COURSE = '$cid' AND BATCHDATE = '$batchid' ORDER BY LASTNAME ASC";
        $result = $conn->query($sql);
    ?>
        <h4><?php echo htmlspecialchars($cname) ?></h4>
        <table style="width: 100%; text-align: center; border-collapse: collapse;">
            <tr>
                <?php
                $counter = 0;
                foreach ($result as $row) {
                    if ($row['MIDDLENAME'] == '') {
                        $fullname = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];
                    } else {
                        $fullname = $row['FIRSTNAME'] . ' ' . $row['MIDDLENAME'][0] . '. ' . $row['LASTNAME'];
                    }
                    
                    // Open a new table row every 4 pictures
                    if ($counter > 0 && $counter % 4 == 0) {
                        echo '</tr><tr>';
                    }
                ?>
                    <td style="padding: 10px;">
                        <img src="images/<?php echo htmlspecialchars($row['IMAGE']); ?>" alt="<?php echo htmlspecialchars($fullname); ?>" style="width: 150px; height: 150px; object-fit: cover; border-radius: 10px;">
                        <h5><?php echo htmlspecialchars($fullname); ?></h5>
                        <h6><?php echo htmlentities($row['ADDRESS'])?></h6>
                        <p><i>"<?php echo htmlspecialchars($row['MOTTO'])?>"</i></p>
                    </td>
                <?php
                    $counter++;
                }
                ?>
            </tr>
        </table>
    <?php
    }
    ?>
</div>

    <div class="alumnilist">
        <h1>List of Teaching Staff</h1>
        <?php
        $tsql = "SELECT * FROM courses";
        $tresult = $conn->query($tsql);
        foreach($tresult as $trow){
            $name = $trow['name'];
            $csql = "SELECT * FROM facultymember WHERE BATCH = '$batchid' AND COURSE = '$name'";
            $cresult = $conn->query($csql);
            ?>
            <h4><?php echo htmlspecialchars($name)?></h4>
            <?php
            foreach($cresult as $crow){
                ?>
                <p><?php echo htmlspecialchars($crow['FULLNAME'])?></p>
                <?php
            }
            ?>

            <?php
        }
        ?>
    </div>
    <div class="alumnilist">
        <h1>List of Non-Teaching Staff</h1>
        <?php
        $sql = "SELECT * FROM facultymember WHERE BATCH = '$batchid' AND ROLE = 'Non-Teaching Staff'";
        $result = $conn->query($sql);
        foreach($result as $row){
            ?>
            <p><?php echo htmlspecialchars($row['FULLNAME'])."-".htmlspecialchars($row['COURSE'])?></p>
            <?php
        }
        
        ?>
    </div>
    
</body>
</html>

<?php
// Get the HTML content from the output buffer and clean the buffer
$html = ob_get_clean();

// Write the HTML content to the PDF
$mpdf->WriteHTML($html);

// Output the PDF to the browser
$mpdf->Output('yearbook.pdf', \Mpdf\Output\Destination::INLINE);
exit;
?>
