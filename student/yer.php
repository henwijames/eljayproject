<?php
require '../vendor/autoload.php';
include '../functions/conn.php';

use Mpdf\Mpdf;

// Initialize Mpdf with A4 Landscape
$mpdf = new Mpdf([
    'format' => 'A4',
    'orientation' => 'L',

]);
$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Yearbook - <?= htmlspecialchars($startYear) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        /* Custom Card Styles */
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-body {
            padding: 1.5rem;
            text-align: center;
        }
        .card-title {
            margin-bottom: 0.5rem;
            font-size: 1.25rem;
            font-weight: bold;
        }
        .card-text {
            color: #555;
            margin-bottom: 0.25rem;
        }
        .wrapper {
            padding: 20px;
        }
        /* Responsive Adjustment for Smaller Screens */
        @media (max-width: 768px) {
            .card-img-top {
                height: 150px;
            }
        }
        /* Custom Print Button */
        .print-btn {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 0.75rem 1rem;
            cursor: pointer;
        }
        .print-btn:hover {
            background-color: #0056b3;
        }
        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact;
            }
            .container {
                padding: 0;
            }
            .row {
                display: grid !important;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }
            .col {
                float: none !important;
                width: auto !important;
                padding: 0;
            }
            .card {
                width: 250px;
                height: 350px;
                border: 1px solid #000;
                padding: 10px;
                background-color: #fff;
                box-sizing: border-box;
                page-break-inside: avoid;
            }
            .course-section {
                page-break-before: always; /* Start each course on a new page */
            }
            /* Hide unnecessary elements for print */
            .print-btn, .btn-link, .card-header {
                display: none;
            }
        }

        /* Center the Mission and Vision section */
        .mission-vision {
            text-align: center; /* Center align the text */
            margin: 20px 0; /* Add some vertical spacing */
        }
        .mission-vision ol {
            list-style-position: inside; /* Position the numbers/dots inside */
            padding: 0; /* Remove default padding */
        }

        .mission-vision li {
            text-align: center; /* Center align the text of each list item */
        }
        .mission-vision ul {
            list-style-position: inside; /* Position the dots inside */
            padding: 0; /* Remove default padding */
        }

        .mission-vision ul li {
            text-align: center; /* Center align the text of each list item */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1 class="mt-4">Yearbook for Batch (<?= htmlspecialchars($startYear) ?>)</h1>
        <!-- Mission and Vision Section -->
        <div class="mission-vision mb-4">
            <h2>Vision</h2>
            <p>Expanding the Right Choice for Real-Life Education in Southern Luzon.</p>
            
            <h2>Mission</h2>
            <ol>
                <li>Provide holistic higher education and technical-vocational programs which are valued by the stakeholders.</li>
                <li>Transform the youth into world-class professionals who creatively respond to the ever-changing world of works.</li>
                <li>Advance research production to improve human life and address societal needs.</li>
                <li>Engage in various projects that aim to build strong community relations and involvement.</li>
                <li>Promote compliance with quality assurance in both service delivery and program development.</li>
            </ol>

            <h2>Core Values</h2>
            <ul>
                <li><strong>L</strong> - Love of God</li>
                <li><strong>C</strong> - Cs (Competent, Committed, and Compassionate) in service</li>
                <li><strong>I</strong> - Innovative Minds</li>
                <li><strong>A</strong> - Aspiring People</li>
                <li><strong>N</strong> - Noble Dreams</li>
            </ul>
        </div>

        <?php foreach ($studentsByCourse as $courseName => $students): ?>
            <div class="course-section">
                <h2><?= htmlspecialchars($courseName) ?></h2>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">
                    <?php foreach ($students as $student): ?>
                        <div class="col">
                        <div class="card h-100">
                            <div class="card-img-top img-fluid" style="background-image: url(); background-size: cover; background-position: center; height: 250px;"></div>
                            <div class="card-body text-center">
                            
                            </div>
                        </div>
                        </div>
                        <div class="col">
                        <div class="card h-100">
                            <div class="card-img-top img-fluid" style="background-image: url(); background-size: cover; background-position: center; height: 250px;"></div>
                            <div class="card-body text-center">
                            
                            </div>
                        </div>
                        </div>
                        <div class="col">
                        <div class="card h-100">
                            <div class="card-img-top img-fluid" style="background-image: url(); background-size: cover; background-position: center; height: 250px;"></div>
                            <div class="card-body text-center">
                            
                            </div>
                        </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
   
</body>
</html>
';

// Write the HTML content
$mpdf->WriteHTML($html);

// Output the PDF
$mpdf->Output('loan_receipt.pdf', 'I');
?>