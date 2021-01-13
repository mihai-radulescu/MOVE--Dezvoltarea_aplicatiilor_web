<?php 
require('fpdf/fpdf.php');
require('includes/functions.php');
require('includes/db_config.php');

$code = $_POST["code"];
$row = checkCode($conn, $code);

$data = readOneAddress($conn, $row["userAddressId"]);
$address = mysqli_fetch_assoc($data);

$data = readUser($conn, $row["userId"]);
$userData = mysqli_fetch_assoc($data);

$data = readUser($conn, $row["courierId"]);
$courierData = mysqli_fetch_assoc($data);

$client = $row["clientName"] . "\n" . $address["country"] . ", " . $address["region"] . ", " . $address["city"] . "\n" . $row["clientStreet"] . "\n0" . $row["clientPhone"] . "\n" . $row["clientEmail"];;
$user = $userData["name"] . "\n" . $address["country"] . ", " . $address["region"] . ", " . $address["city"] . "\n" . $address["street"] . "\n0" . $userData["phone_number"] . "\n" . $userData["email"];;
$courier = $courierData["name"] . "\n0" . $courierData["phone_number"] . "\n" . $courierData["email"];

class Invoice extends FPDF{

    function Header(){
        $this->SetFont('Arial','B',24);
        $this->Cell(60);
        $this->Cell(60,10,' MOVE Courier');
        $this->Ln(10);
        $this->Line(0,20,$this->GetPageWidth(),20);
        $this->Ln(10);
        $this->SetFont('Arial','B',14);
        $this->Cell(70);
        $this->Cell(60,10,'DELIVERY INVOICE',1,1,'C',true);
        $this->Image('fpdf/logo.png',95,45,20);
        $this->Ln(10);
    }

    function add_from($str){
        $this->SetFont('Arial','',10);
        $this->setXY(10,50);
        $this->Cell(60,7,'From',1,2,'L',true);
        $this->MultiCell(60,8,$str,'LRB',1);
    }

    function add_to($str){
        $x = $this->GetX();
        $this->setXY($x+120,50);
        $this->Cell(60,7,'To',1,2,'L',true);
        $y = $this->GetY();
        $this->MultiCell(60,8,$str,'LRB',1);
        $this->Ln(10);
    }

    function add_order_detail($rdate,$cur){
        $this->Cell(50);
        $x=$this->GetX();
        $y=$this->GetY();
        $this->setXY($x,$y);
        $this->Cell(50,7,'Order date',1,2,'L',true);
        $this->Cell(50,8,$rdate,'LRB',1);
        $this->setXY($x+50,$y);
        $this->Cell(50,7,'Code',1,2,'L',true);
        $this->Cell(50,8,$cur,'LRB',1);
        $this->Ln(10);
    }

    function add_courier($str){
        $this->SetFont('Arial','',10);
        $x=$this->GetPageWidth()/2 - 30;
        $y=$this->GetY();
        $this->setXY($x,$y);
        $this->Cell(60,7,'Courier',1,2,'L',true);
        $this->MultiCell(60,8,$str,'LRB',1);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Copyright 2018 MOVE Courier. All Rights Reserved.',0,0,'C');
    }
}

$pdf = new Invoice();
$pdf->SetFillColor(214,214,214);

$pdf->AddPage();

$pdf->add_from($user);
$pdf->add_to($client);
$pdf->add_order_detail($row["date"], $row["code"]);
$pdf->add_courier($courier);

$pdf->Output();