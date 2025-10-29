<?php
ob_start();
session_start ();
require('../functions.php');
checkLogin ();
date_default_timezone_set('Europe/Zagreb');
$detaljiucenika = detaljiUcenika();
$id_ucenika = $detaljiucenika['id_ucenika'];
$godina = $detaljiucenika['skolska_godina'];
$ustanova = $detaljiucenika['naziv_ustanove'];
$mjesto = $detaljiucenika['mjesto'];
$npp = $detaljiucenika['npp'];
$vrsta = $detaljiucenika['vrsta'];
$ime = $detaljiucenika['ime_ucenika'];
$prezime = $detaljiucenika['prezime_ucenika'];
$ime_oca = $detaljiucenika['ime_oca'];
$ime_majke = $detaljiucenika['ime_majke'];
$razred = $detaljiucenika['razred'];
$prezime_majke = $detaljiucenika['prezime_majke'];
$roditelji = $detaljiucenika['ime_oca'].' i '.$detaljiucenika['ime_majke'].' '.$detaljiucenika['prezime_majke'];
$datum_rodjenja = date('d.m.Y', strtotime($detaljiucenika['datum_rodjenja']));
$banka = $detaljiucenika['banka'];
$ziro_racun = $detaljiucenika['broj_racuna'];
$datumunosa = date('d.m.Y \u H:i:s', strtotime($detaljiucenika['datum_dodavanja']));
$datum_izmjene = !empty($detaljipredmeta['datum_vrijeme_izmjene']) ? ', Posljednja izmjena: ' . date('d.m.Y \u H:i:s', strtotime($detaljiucenika['datumizmjene_podataka'])) : '';

$adresa = $detaljiucenika['adresa_stanovanja'];
$mjesto_stanovanja = $detaljiucenika['mjesto_stanovanja'];
$udaljenost = $detaljiucenika['udaljenost_do_skole'].' km';
$iznos = $detaljiucenika['iznos'];
$formatiraniIznos = number_format((float)$iznos, 2, '.', '') . ' KM';
$jmbg = $detaljiucenika['jmbg'];
$spol = $detaljiucenika['spol'];
$trenutno = date('d.m.Y \u H:i:s');
$trenutnidatum = date('d.m.Y');

$napomena = '';
if (!empty($detaljiucenika['napomena'])) {
    $prikaznapomene = $detaljiucenika['napomena'];
} else {
    $prikaznapomene = '/';
}

$status = '';
if ($detaljiucenika['status'] == 1) {
    $status = '<i class="fas fa-check zelena-ikona"></i> Da';
} else {
    $status = '<i class="fas fa-times crvena-ikona"></i> Ne';
}

$statusuplate = '';
if ($detaljiucenika['status_uplate'] == 1) {
    $statusuplate = '<i class="fas fa-check zelena-ikona"></i> Da';
} else {
    $statusuplate = '<i class="fas fa-times crvena-ikona"></i> Ne';
}

$nppJezik = '';

if ($detaljiucenika['npp'] == 'Hrvatski jezik') {
    $nppJezik = 'hrvatskom jeziku';
} elseif ($detaljiucenika['npp'] == 'Bosanski jezik') {
    $nppJezik = 'bosanskom jeziku';
}


/*OUTPUT PDF*/
$output = '';
$output .= '<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=DejaVu Sans:wght@500&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css?family=DejaVu Sans" rel="stylesheet">

    
    <title>'.$ime.' '.$prezime.' - '.$jmbg.' - '.$godina.'</title>
    <style>
    @font-face {
    font-family: DejaVu Sans;
    }
    html { margin: 25px}
    p {
        font-family:DejaVu Sans;
        line-height:1;
        margin:0;
    }
    body {
        padding: 20px;
        position:relative;
    }
    .zaglavlje {
        width:100%;
        border-bottom:1px solid #eeeeee;
    }
    .zaglavlje h4 {
        font-size:12px;
        line-height:1;
        font-weight:400;
        font-family:DejaVu Sans !important;
    }
    .zaglavlje img {
        width:50%;
        height:auto;
        margin-bottom:10px;
    }
    .content {
        margin-top:20px;
        display:block;
        width:100%;
    }
    .content h3 {
        font-family:DejaVu Sans;
        font-size:16px;
        font-weight:500;
        line-height:1.2;
        margin-bottom:10px;
        padding:0px 10px;
    }
    .content h2 {
        margin-top:50px;
        margin-bottom:10px;
        display:block;
        padding:5px 10px;
        font-family:DejaVu Sans;
        font-weight:400;
        background:#f7f7f7;
        font-size:16px;
        line-height:1;
    }
    .content p {
        font-size:14px;
        font-weight:400;
    }
    .text-border {
        padding:5px 10px;
        border-bottom:1px solid #f7f7f7;
    }
    .content-wrap {
        margin-top:15px;
        margin-bottom:15px;
        padding:5px 10px;
        background:#f7f7f7;
        height:20px;
        display:block;
    }
    .content-wrap p {
        margin-right:50px;
        display:inline-block;
        float:left;
        font-size:14px;
        font-family:DejaVu Sans;
        font-weight:400;
        line-height:1;
    }
    .prilozi {
        font-size:12px !important;
    }
    .footer {
        padding:10px;
        margin-top: 60px;
        position:absolute;
        left:0;
        bottom:0;
    }
    .footer p {
        font-size:12px;
        font-family:DejaVu Sans;
        font-weight:400;
        line-height:1.2;
        font-style:italic;
    }
    .potpis {
        position:absolute;
        bottom:150px;
        width:100%;
        display:block;
    }
    .potpis-lijevo, .potpis-desno, .potpis-pecat {
        width: 31%;
        display: inline-block;
    }

    .potpis-desno p, .potpis-lijevo p, .potpis-pecat p {
        font-size: 12px;
        line-height: 1;
        font-family: DejaVu Sans;
    }
    .potpis-pecat p {
        text-align:center;
    }
    .potpis-lijevo p {
        text-align:left;
    }
    .potpis-desno p {
        text-align:center;
    }

</style>
  </head>

  
  <body>
        <div class="zaglavlje">
           <img src="https://tc.mozks-ksb.ba/img/logo.png">
        </div>
        
        <div class="content">
            <p><strong>'.$ustanova.', '.$mjesto.'</strong></p>
            <p>'.$vrsta.', nastavni plan i program realizuje na '.$nppJezik.'</p>
            <div class="content-wrap">
                <p>ID broj: '.$id_ucenika.'</p>
                <p>Spol: '.$spol.'</p>
                <p>Razred: '.$razred.'</p>
                <p>Školska godina: '.$godina.'</p>
            </div>
            
            <h3><strong>Ime i prezime: '.$ime.' '.$prezime.'</strong></h3>
            <p class="text-border">Roditelji: '.$roditelji.'</p>
            <p class="text-border">Datum rođenja: '.$datum_rodjenja.'</p>
            <p class="text-border">JMBG: '.$jmbg.'</p>
            <p class="text-border">Adresa i mjesto stanovanja: '.$adresa.', '.$mjesto_stanovanja.'</p>
            
            <h2>Podaci za naknadu prevoza</h2>
            <p class="text-border">Udaljenost do škole: '.$udaljenost.'</p>
            <p class="text-border">Banka: '.$banka.'</p>
            <p class="text-border">Žiro račun: '.$ziro_racun.'</p>
            <p class="text-border">Iznos: '.$formatiraniIznos.'</p>
            
            <h2>Podaci o statusu</h2>
            <p class="text-border">Naknada odobrena: '.$status.'</p>
            <p class="text-border">Isplaćeno: '.$statusuplate.'</p>
            <p class="text-border">Napomena: '.$prikaznapomene.'</p>
            

            <div class="potpis">
                <div class="potpis-lijevo"><p>'.$trenutnidatum.' </p></div>
                <div class="potpis-pecat"><p>M.P.</p></div>
                <div class="potpis-desno"><p>Potpis</p></div>
            </div>
            
        </div>
        
        <div class="footer">
            <p>Datum unosa: '.$datumunosa.' '.$datum_izmjene.'</p>
            <p>Ispis generisan: '.$trenutno.'</p>
        </div>

  </body>
</html>';
// create pdf of invoice	
$invoiceFileName = ''.$ime.'-'.$prezime.'-'.$jmbg.'.pdf';
require_once 'dompdf/autoload.inc.php';
$tmp = sys_get_temp_dir();
use Dompdf\Dompdf;
$dompdf = new Dompdf([
    'logOutputFile' => '',
    // authorize DomPdf to download fonts and other Internet assets
    'isRemoteEnabled' => true,
    // all directories must exist and not end with /
    'fontDir' => $tmp,
    'fontCache' => $tmp,
    'tempDir' => $tmp,
    'chroot' => $tmp,
]);

$dompdf->loadHtml(html_entity_decode($output), 'utf-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));

?>