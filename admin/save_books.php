<?php
// Input


require('fpdf.php');

//Connect to your database
require_once("models/config.php");

// Fetch All Student Details
$allDetails=fetchBookList();

///// Header & Footer /////
class PDF extends FPDF
{
// Page header
function Header()
{
	// Logo
	$this->Image('logo.png',10,6,30);
	// Arial bold 15
	$this->SetFont('Arial','B',15);
	// Move to the right
	$this->Cell(50);
	// Title
	$this->Cell(100,10,'Government Polytechnic, Adityapur',1,0,'C');
	// Line break
	$this->Ln(20);
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	// Page number
	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
// Title
function ChapterTitle($label)
{
	// Arial 12
	$this->SetFont('Arial','',12);
	// Background color
	$this->SetFillColor(200,220,255);
	// Title
	$this->Cell(0,6,"$label",0,1,'L',true);
	// Line break
	$this->Ln(4);
}
}
/*
//Create new pdf file
    $pdf=new FPDF();

    //Open file
    $pdf->Open();

    //Disable automatic page break
    $pdf->SetAutoPageBreak(false);

	$pdf->AliasNbPages();
	
    //Add first page
    $pdf->AddPage();

    //set initial y axis position per page
    $y_axis_initial = 25;

    //print column titles for the actual page
    $pdf->SetFillColor(232, 232, 232);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetY($y_axis_initial);
    $pdf->SetX(5);
    $pdf->Cell(20, 6, 'TYPE', 1, 0, 'C', 1);
    $pdf->Cell(20, 6, 'POINT', 1, 0, 'C', 1);
    $pdf->Cell(150, 6, 'DESCRIPTION', 1, 0, 'C', 1);
    $row_height = 6;
    $y_axis = $y_axis_initial + $row_height;


    //initialize counter
    $i = 0;

    //Set maximum rows per page
    $max = 40;

    //Set Row Height
   // $row_height = 6;

    foreach ($allDetails as $details)
    {
        //If the current row is the last one, create new page and print column title
        if ($i == $max)
        {
            $pdf->AddPage();

            //print column titles for the current page
            $pdf->SetY($y_axis_initial);
            $pdf->SetX(4);
            $pdf->Cell(20, 6, 'TYPE', 1, 0, 'C', 1);
            $pdf->Cell(20, 6, 'POINT', 1, 0, 'C', 1);
            $pdf->Cell(150, 6, 'DESCRIPTION', 1, 0, 'C', 1);

            //Go to next row
            $y_axis = $y_axis + $row_height;

            //Set $i variable to 0 (first row)
            $i = 0;
        }

       // $name = $row['name'];
        //$father_name = $row['father_name'];
        //$mobile1= $row['mobile_1'];

        $pdf->SetY($y_axis);
        $pdf->SetX(5);
        $pdf->Cell(20, 6, $details['type'], 1, 0, 'C', 1);
        $pdf->Cell(20, 6, $details['point'], 1, 0, 'C', 1);
        $pdf->Cell(150, 6, $details['description'], 1, 0, 'L', 1);

        //Go to next row
        $y_axis = $y_axis + $row_height;
        $i = $i + 1;
    }


    //Create file
    $pdf->Output();
	*/
	// Instanciation of inherited class
$myTitle="Library Book Details";
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->ChapterTitle($myTitle);
$pdf->SetFont('Times','',12);
//set initial y axis position per page
    $y_axis_initial = 40;

    //print column titles for the actual page
    // Background Color
	$pdf->SetFillColor(200,220,255);
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->SetY($y_axis_initial);
    $pdf->SetX(10);
    $pdf->Cell(80, 6, 'BOOK', 1, 0, 'L', 1);
            $pdf->Cell(40, 6, 'AUTHOR', 1, 0, 'C', 1);
            $pdf->Cell(40, 6, 'PUBLISHER', 1, 0, 'C', 1);
			$pdf->Cell(5, 6, 'ED', 1, 0, 'C', 1);
			$pdf->Cell(7, 6, 'PG', 1, 0, 'C', 1);
			$pdf->Cell(10, 6, 'PRICE', 1, 0, 'C', 1);
			$pdf->Cell(7, 6, 'PLA', 1, 0, 'C', 1);
    $row_height = 6;
    $y_axis = $y_axis_initial + $row_height;


    //initialize counter
    $i = 0;

    //Set maximum rows per page
    $max = 38;


    //Set Row Height
   // $row_height = 6;

    foreach ($allDetails as $details)
    {
        //If the current row is the last one, create new page and print column title
        if ($i == $max)
        {
            $pdf->AddPage();
			$pdf->ChapterTitle($myTitle);
            //print column titles for the current page
			// Background Color
			$pdf->SetFillColor(200,220,255);
    		$pdf->SetFont('Arial', 'B', 7);
            $pdf->SetY($y_axis_initial);
            $pdf->SetX(10);
            $pdf->Cell(80, 6, 'BOOK', 1, 0, 'L', 1);
            $pdf->Cell(40, 6, 'AUTHOR', 1, 0, 'C', 1);
            $pdf->Cell(40, 6, 'PUBLISHER', 1, 0, 'C', 1);
			$pdf->Cell(5, 6, 'ED', 1, 0, 'C', 1);
			$pdf->Cell(7, 6, 'PG', 1, 0, 'C', 1);
			$pdf->Cell(10, 6, 'PRICE', 1, 0, 'C', 1);
			$pdf->Cell(7, 6, 'PLA', 1, 0, 'C', 1);

            //Go to next row
            $y_axis = $y_axis_initial + $row_height;

            //Set $i variable to 0 (first row)
            $i = 0;
        }
		
		///////////// Date Format Change
		$singlePlace=fetchSinglePlace($details['pid']);
       
        $pdf->SetY($y_axis);
		// Background Color
		$pdf->SetFillColor(255,255,255);
		// Set Font - Name, Style I-Italic, B-Bold, Size
		$pdf->SetFont('Arial','',6);
        $pdf->SetX(10);
        $pdf->Cell(80, 6, $details['bname'], 1, 0, 'L', 1);
        $pdf->Cell(40, 6, $details['author'], 1, 0, 'L', 1);
        $pdf->Cell(40, 6, $details['publisher'], 1, 0, 'L', 1);
		$pdf->Cell(5, 6, $details['edition'], 1, 0, 'C', 1);
		$pdf->Cell(7, 6, $details['nop'], 1, 0, 'C', 1);
		$pdf->Cell(10, 6, $details['price'], 1, 0, 'C', 1);
		$pdf->Cell(7, 6, $singlePlace['pcode'], 1, 0, 'C', 1);

        //Go to next row
        $y_axis = $y_axis + $row_height;
        $i = $i + 1;
    }
$pdf->Output();
    ?>
