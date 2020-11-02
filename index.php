<?php
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

require_once('FPDF/fpdf.php');
require_once('FPDI/src/autoload.php');
include('PHPQRCODE/qrlib.php');

$reasons = $_GET['reasons'];
$name = $_GET['name'];

if($reasons == ''){
	$reasons = 'achats';
}

if($name == ''){
	$name = 'prenom1';
}

$ys = [
    "travail" => 87.7,
    "achats" => 103.7,
    "sante" => 123.2,
    "famille" => 138.2,
    "handicap" => 153,
    "sport_animaux" => 166,
    "convocation" => 187.8,
    "missions" => 201.8,
    "enfants" => 217.8
    ,
];

if($name == 'prenom1'){
	$profil = [
	    "lastname" => "NOM1",
	    "firstname" => "Prenom1",
		"birthday" => "DDN1",
		"placeofbirth" => "Ville_Naissance1",
		"address" => "Adresse1",
		"zipcode" => "CP1",
		"city" => "Ville1",
	];	
}

if($name == 'prenom2'){
	$profil = [
	    "lastname" => "NOM2",
	    "firstname" => "Prenom2",
		"birthday" => "DDN2",
		"placeofbirth" => "Ville_Naissance2",
		"address" => "Adresse2",
		"zipcode" => "CP2",
		"city" => "Ville2",
	];	
}

$creationDate = date("d/m/Y");
$creationHour = date('H:i');


$data = [
    "Cree le: ".$creationDate." a ".$creationHour,
    "Nom: ".$profil['lastname'],
    "Prenom: ".$profil['firstname'],
    "Naissance: ".$profil['birthday']." a ".$profil['placeofbirth'],
    "Adresse: ".$profil['address']." ".$profil['zipcode']." ".$profil['city'],
    "Sortie: ".$creationDate." a ".$creationHour,
    "Motifs: ".$reasons
  ];

$QRcodeContents = implode(";\n",$data);
$tempDir = getcwd()."/";
$fileName = md5($QRcodeContents).'.png';
$pngAbsoluteFilePath = $tempDir.$fileName;

$pdf = new Fpdi();

$pageCount = $pdf->setSourceFile('certificate.d1673940.pdf');

for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
    $templateId = $pdf->importPage($pageNo);
    $pdf->AddPage();
    $pdf->useTemplate($templateId, ['adjustPageSize' => true]);
}

    $pdf->SetFont('Helvetica');
    $pdf->SetXY(40, 46.25);
    $pdf->Write(8, $profil["firstname"]." ".$profil["lastname"]);

    $pdf->SetXY(40, 54.25);
    $pdf->Write(8, $profil["birthday"]);

    $pdf->SetXY(104, 54.25);
    $pdf->Write(8, $profil["placeofbirth"]);

    $pdf->SetXY(45, 61.90);
    $pdf->Write(8, $profil["address"]." ".$profil["zipcode"]." ".$profil["city"]);

    $pdf->SetXY(36.50, 230.25);
    $pdf->Write(8, $profil["city"]);

    $array_reasons = explode(",", $reasons);
    foreach ($array_reasons as $reason) {
    	$pdf->SetXY(26.8, $ys[$reason]);
    	$pdf->Write(8, 'X');
	}

    $pdf->SetXY(32, 238.50);
    $pdf->Write(8, date("d/m/Y"));

    $pdf->SetXY(89, 238.50);
    $pdf->Write(8, date('H:i'));

     if (!file_exists($pngAbsoluteFilePath)) {
         QRcode::png($QRcodeContents, $pngAbsoluteFilePath);
     }

    $pdf->Image($pngAbsoluteFilePath,140,220,42);

    $pdf->AddPage();

    $pdf->Image($pngAbsoluteFilePath,0,0,100);
    // Output the new PDF
    $pdf->Output($tempDir.md5($QRcodeContents).".pdf",'F');
    header('Content-Type: application/json');
    echo(json_encode($tempDir.md5($QRcodeContents).".pdf"));
?>