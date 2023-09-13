<?php
require_once 'fpdf/fpdf.php';
session_start();

// Create a new PDF instance
$pdf = new FPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('Arial', 'B', 16);

// Calculate the vertical center position
$verticalCenter = ($pdf->GetPageHeight() - 210) / 2; // Adjust 210 based on your content height

// Set vertical position to center
$pdf->SetY($verticalCenter);

// Add an image as the background
$pdf->Image('image.jpg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());

// Calculate the width and height of the content
$contentWidth = 150; // Adjust based on your content
$contentHeight = 150; // Adjust based on your content

// Calculate the x and y positions to center the content
$xPos = ($pdf->GetPageWidth() - $contentWidth) / 2;
$yPos = ($pdf->GetPageHeight() - $contentHeight) / 2;

// Set fill color to white with transparency
$pdf->SetFillColor(255, 255, 255, 100); // Adjust alpha value here

// Fill the rectangle behind the content
$pdf->Rect($xPos, $yPos, $contentWidth, $contentHeight, 'DF');

// Set vertical position for content inside the rectangle
$pdf->SetY($yPos + 10);

// Add a title
$pdf->Cell(0, 10, 'Oasis Travel Ticket', 0, 1, 'C');

// Add ticket details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Departure: ' . $_SESSION['departure'], 0, 1, 'C');
$pdf->Cell(0, 10, 'Destination: ' . $_SESSION['destination'], 0, 1, 'C');
$pdf->Cell(0, 10, 'Date: ' . $_SESSION['date'], 0, 1, 'C');

$pdf->Cell(0, 10, 'Travel Mode: ' . $_SESSION['mode'], 0, 1, 'C');

// Add passenger details
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Passenger Details', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Passenger Name: ' . $_SESSION["username"], 0, 1, 'C');
$pdf->Cell(0, 10, 'Seat Number: ' . $_SESSION["seat"], 0, 1, 'C');

// Add fare details
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Fare Details', 0, 1, 'C');

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Fare Amount: Rs. ' . $_SESSION["amount"], 0, 1, 'C');
$pdf->Cell(0, 10, 'Payment Method: Credit Card', 0, 1, 'C');

// Add a thank you message
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Thank You for Choosing Oasis Travel!', 0, 1, 'C');

// Output the PDF to the browser
$pdf->Output('ticket.pdf', 'I');
?>
