<?php
require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir . '/pdflib.php');

require_login();
$id = required_param('id', PARAM_INT);
$request = $DB->get_record('local_training_letter', ['id' => $id], '*', MUST_EXIST);

$pdf = new pdf();
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(20, 20, 20);
$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 8, 'GURU NANAK DEV ENGINEERING COLLEGE', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(0, 5, 'TRAINING & PLACEMENT CELL | LUDHIANA', 0, 1, 'C');
$pdf->Ln(10);

$pdf->Cell(0, 6, 'To, ' . $request->orgname, 0, 1);
$pdf->MultiCell(0, 5, $request->orgaddress, 0, 'L');
$pdf->Ln(10);

$body = "Dear Sir/Madam,\n\n" .
"This is to certify that {$request->fullname} (URN: {$request->rollno}), student of {$request->branch}, " .
"is required to undergo {$request->duration} {$request->trainingtype} starting from " . date('d M Y', $request->joiningdate) . ".\n\n" .
"Kindly grant permission for training at your organization.";

$pdf->MultiCell(0, 6, $body, 0, 'L');
$pdf->Output('Training_Letter_' . $request->rollno . '.pdf', 'I');