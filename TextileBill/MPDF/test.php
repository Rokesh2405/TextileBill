<?php
require_once 'vendor/autoload.php'; // Include the mPDF autoload file
error_reporting(1);
ini_set('display_errors','1');
error_reporting(E_ALL);
// Create an mPDF instance
$mpdf = new \Mpdf\Mpdf();

// HTML content that you want to convert to PDF
$html = '<html>
            <body>
                <h1>Hello, this is a PDF generated from PHP!</h1>
            </body>
        </html>';

// Add the HTML content to the PDF
$mpdf->WriteHTML($html);

// Output the PDF to the browser or save it to a file
$mpdf->Output('example.pdf', 'i'); // 'D' means force download, 'I' means inline display

// You can also save the PDF to a file using 'F':
// $mpdf->Output('example.pdf', 'F');
?>