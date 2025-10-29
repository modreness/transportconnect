<?php

function clean_text(?string $v): ?string {
    $v = trim((string)$v);
    return $v !== '' ? $v : null;
}
function normalize_nosilac(?string $v): ?string {
    return clean_text($v);
}
function validate_jmbg_optional(?string $jmbg): ?string {
    $jmbg = preg_replace('/\D+/', '', (string)$jmbg);
    if ($jmbg === '') return null;
    return (strlen($jmbg) === 13) ? $jmbg : null;
}

if (isset($_POST['dodajucenika'])) {
    $ime = $_POST['ime_ucenika'];
    $prezime = $_POST['prezime_ucenika'];
    $ime_oca = $_POST['ime_oca'];
    $ime_majke = $_POST['ime_majke'];
    $prezime_majke = $_POST['prezime_majke'];
    $datum_rodjenja = $_POST['datum_rodjenja'];
    $jmbg = $_POST['jmbg'];
    $spol = $_POST['spol'];
    $adresa = $_POST['adresa_stanovanja'];
    $mjesto = $_POST['mjesto_stanovanja'];
    $skolska_godina = $_POST['skolska_godina'];
    $razred = $_POST['razred'];
    $udaljenost = $_POST['udaljenost'];
    $iznos = $_POST['iznos'];
    $banka = $_POST['banka'];
    $ziro_racun = $_POST['ziro_racun'];
    $ustanova = $_POST['ustanova'];
    $status_uplate = $_POST['status_uplate'];
    $status = $_POST['status'];
    $napomena = $_POST['napomena'];

   // nova polja
   $nosilac_racuna = normalize_nosilac($_POST['nosilac_racuna'] ?? null);
   $jmbg_roditelja = validate_jmbg_optional($_POST['jmbg_roditelja'] ?? null);
    
   $dodajucenika = dodajUcenika(
       $ime, $prezime, $ime_oca, $ime_majke, $prezime_majke, $datum_rodjenja, $jmbg, $spol, $adresa, $mjesto, $skolska_godina, $razred, $udaljenost, $iznos, $banka, $ziro_racun, $ustanova, $status_uplate, $status, $napomena, $nosilac_racuna, $jmbg_roditelja );
    
       if ($dodajucenika) {
        // dohvati ID novog učenika 
        $ucenik_id = is_numeric($dodajucenika) ? (int)$dodajucenika : null;

        // fallback ako funkcija ne vraća ID
        if (!$ucenik_id) {
            global $db;
            $q = $db->prepare("
                SELECT id FROM ucenici
                WHERE jmbg = :jmbg AND obrazovna_ustanova_id = :ustanova AND skolska_godina = :skg
                ORDER BY id DESC LIMIT 1
            ");
            $q->execute([':jmbg'=>$jmbg, ':ustanova'=>$ustanova, ':skg'=>$skolska_godina]);
            $ucenik_id = (int)($q->fetchColumn() ?: 0);
        }

        //  NOVA polja
        if (!empty($ucenik_id)) {
            global $db;
            $sqlUp = "UPDATE ucenici SET
                nosilac_racuna      = :nosilac_racuna,
                jmbg_roditelja      = :jmbg_roditelja
              WHERE id = :id";
            $stmtUp = $db->prepare($sqlUp);
            $stmtUp->execute([
                ':nosilac_racuna'      => $nosilac_racuna,
                ':jmbg_roditelja'      => $jmbg_roditelja ?: null,
                ':id'                  => $ucenik_id
            ]);
        }

        header('Location: dashboard.php?status=ucenik-dodan');
        exit;
    } else {
        header('Location: dashboard.php?status=ucenik-greska');
        exit;
    }
}


/*IZMJENI STATUS ODOBRENJA NAKNADE UČENIKA*/
if(isset($_POST['izmjenistatus'])) {
    $id_ucenika = $_POST['id_ucenika'];
    $status = $_POST['status'];
    $napomena = $_POST['napomena'];
    $izmjenistatus = izmjenaStatusaOdobrenja($id_ucenika,$status,$napomena);
    if($izmjenistatus) {
        header('Location:dashboard.php?action=ucenik&status=odobrenje-azurirano&id=' . $id_ucenika);
    } else {
        header('Location:dashboard.php?action=ucenik&status=odobrenje-greska&id=' .$id_ucenika);
    }
}

/*UREDI UČENIKA*/
if (isset($_POST['urediucenika'])) {
    $id_ucenika = $_POST['id_ucenika'];
    $ime = $_POST['ime_ucenika'];
    $prezime = $_POST['prezime_ucenika'];
    $ime_oca = $_POST['ime_oca'];
    $ime_majke = $_POST['ime_majke'];
    $prezime_majke = $_POST['prezime_majke'];
    $datum_rodjenja = $_POST['datum_rodjenja'];
    $jmbg = $_POST['jmbg'];
    $spol = $_POST['spol'];
    $adresa = $_POST['adresa_stanovanja'];
    $mjesto = $_POST['mjesto_stanovanja'];
    $skolska_godina = $_POST['skolska_godina'];
    $razred = $_POST['razred'];
    $udaljenost = $_POST['udaljenost'];
    $iznos = $_POST['iznos'];
    $banka = $_POST['banka'];
    $ziro_racun = $_POST['ziro_racun'];
    $ustanova = $_POST['ustanova'];

    $nosilac_racuna = normalize_nosilac($_POST['nosilac_racuna'] ?? null);
    $jmbg_roditelja = validate_jmbg_optional($_POST['jmbg_roditelja'] ?? null);
    
    $urediucenika = urediUcenika($id_ucenika, $ime, $prezime, $ime_oca, $ime_majke, $prezime_majke, $datum_rodjenja, $jmbg, $spol, $adresa, $mjesto, $skolska_godina, $razred, $udaljenost, $iznos, $banka, $ziro_racun, $ustanova);
    if ($urediucenika) {
        global $db;
        $sqlUp = "UPDATE ucenici SET
        nosilac_racuna = :nosilac_racuna,
        jmbg_roditelja = :jmbg_roditelja
        WHERE id = :id_ucenika";
        $stmtUp = $db -> prepare($sqlUp);
        $stmtUp->execute([
            ':nosilac_racuna' => $nosilac_racuna,
            ':jmbg_roditelja' => $jmbg_roditelja ?: null,
            ':id_ucenika' => $id_ucenika
        ]);
        header('Location:dashboard.php?action=ucenik&status=edit-uspjesan&id=' . $id_ucenika);
    } else {

        header('Location:dashboard.php?action=ucenik&status=edit-greska&id=' . $id_ucenika);
    }
}

/*OBRIŠI UČENIKA*/
if(isset($_POST['obrisiucenika'])) {
    $id_ucenika = $_POST['id_ucenika'];
    $ustanova = $_POST['ustanova'];
    $skg = $_POST['skolska_godina'];
    $obrisiucenika = obrisiUcenika($id_ucenika, $ustanova, $skg);
    if($obrisiucenika) {
        header('Location:dashboard.php?action=lista&filter=skg&status=brisanje-uspjesno&ustanova='.$ustanova.'&skg='.$skg);
        exit;
    } else {
        header('Location: dashboard.php?action=ucenik&status=brisanje-greska&id='.$id_ucenika);
        exit;
    }
}

/*IZMJENI STATUS UPLATE NAKNADE ZA UČENIKA*/
if(isset($_POST['izmjenistatusuplate'])) {
    $id_ucenika = $_POST['id_ucenika'];
    $status_uplate = $_POST['status_uplate'];
    $izmjenistatus = izmjenaStatusaUplate($id_ucenika,$status_uplate);
    if($izmjenistatus) {
        header('Location:dashboard.php?action=ucenik&status=uplata-azurirano&id=' . $id_ucenika);
    } else {
        header('Location:dashboard.php?action=ucenik&status=uplata-greska&id=' .$id_ucenika);
    }
}

/*IZMJENA LOZINKE*/
if (isset($_POST['izmjenalozinke'])) {
     $id_korisnika = $_POST['id_korisnika'];
     $stara_lozinka = $_POST['stari_password'];
     $nova_lozinka = $_POST['password'];
     $potvrda_passworda = $_POST['potvrdi_password'];
     
     if ($nova_lozinka !== $potvrda_passworda) {
        header('Location: dashboard.php?profil=password&status=nepodudaranje-lozinke');
        exit;
    }
    $izmjenalozinke = promijeniLozinku($id_korisnika, $stara_lozinka, $nova_lozinka);
    if($izmjenalozinke) { 
      session_unset();
      session_destroy();
      header('Location: login.php?status=lozinka-izmjenjena');
      exit;
    } else { 
      header('Location: dashboard.php?profil=password&status=greska');
    }
 }
 
 /*UREDI PROFIL*/
 if (isset($_POST['urediprofil'])){
    $id_korisnika = $_POST['id_korisnika'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $uredi_profil = mojProfilIzmjena($id_korisnika, $email, $telefon);
    if($uredi_profil) { 
    session_unset();
      session_destroy();
      header('Location: login.php?profil=uredi&status=azurirano');
    } else { 
      header('Location: dashboard.php?profil=edit&status=greska');
    }
  }
  
/*DODAJ KORISNIKA/ADMINISTRATORA*/
 if(isset($_POST['dodajkorisnika'])) {
     $ustanova = isset($_POST['ustanova']) && $_POST['ustanova'] !== "" ? $_POST['ustanova'] : NULL;
     $password = $_POST['password'];
     $ime = $_POST['ime'];
     $prezime = $_POST['prezime'];
     $email = $_POST['email'];
     $telefon = $_POST['telefon'];
     $administrator = $_POST['administrator'];
     $dodajkorisnika = dodajKorisnika($ustanova, $password, $ime, $prezime, $email, $telefon, $administrator);
     if($dodajkorisnika) {
         header('Location: dashboard.php?profil=new&status=uspjesno');
     } else {
         header('Location: dashboard.php?profil=new&status=greska');
     }
 }
 


/*DODAJ ŠKOLSKU GODINU*/
if(isset($_POST['dodajskgod'])) {
    $skgod = $_POST['skolska_godina'];
    $cijena = $_POST['cijena_po_km'];
    $aktivno = $_POST['aktivno'];
    $dodajskg = dodajSKG($skgod, $cijena, $aktivno);
    if($dodajskg) {
        header('Location:dashboard.php?action=skolska-godina&status=kreirano');
    } else {
        header('Location:dashboard.php?action=skolska-godina&status=greska');
    }
}

/*UREDI ŠKOLSKU GODINU*/
if(isset($_POST['urediskgod'])) {
    $skgod = $_POST['skolska_godina'];
    $cijena = $_POST['cijena_po_km'];
    $aktivno = $_POST['aktivno'];
    $id_skgod = $_POST['id_godine'];
    $urediskg = urediSKG($skgod, $cijena, $aktivno, $id_skgod);
    if($urediskg) {
        header('Location:dashboard.php?action=skolska-godina&status=izmjena-uspjesna');
    } else {
        header('Location:dashboard.php?action=skolska-godina&status=izmjena-greska');
    }
}

/*OBRIŠI ŠKOLSKU GODINU*/
if(isset($_POST['obrisiskgod'])) {
    $id_godine = $_POST['id_godine'];
    $obrisigodinu = obrisiSKG($id_godine);
    if($obrisigodinu) {
        header('Location:dashboard.php?action=skolska-godina&status=obrisano');
    } else {
        header('Location:dashboard.php?action=skolska-godina&status=brisanje-greska');
    }
}



/*OBRIŠI KORISNIKA APLIKACIJE*/
if(isset($_POST['obrisikorisnika'])) {
    $id_korisnika = $_POST['id_korisnika'];
    $obrisikorisnika = obrisiKorisnika($id_korisnika);
    if($obrisikorisnika) {
        header('Location:dashboard.php?action=users&status=korisnik-obrisan');
        exit;
    } else {
        header('Location:dashboard.php?action=users&status=brisanje-korisnika-greska');
        exit;
    }
}

/*IZMJENI LOZINKU KORISNIKA*/
if(isset($_POST['izmjenipwdkorisnika'])) {
    $id_korisnika = $_POST['id_korisnika'];
    $password = $_POST['password'];
    $password_confirm = $_POST['potvrdi_password'];
    if ($password !== $password_confirm) {
        header ('Location: dashboard.php?action=users&user=pwd&status=password-greska&iduser=' .$id_korisnika);
        die();
    }
    $izmjenalozinke = izmjenaLozinkeKorisnika ($id_korisnika, $password);
    if($izmjenalozinke) {
        header('Location: dashboard.php?action=users&user=view&status=lozinka-izmjenjena&iduser=' .$id_korisnika);
        exit;
    } else {
         header('Location: dashboard.php?action=users&user=view&status=lozinka-greska&iduser=' .$id_korisnika);
        exit;
    }
}

/*IZMJENI PODATKE KORISNIKA*/
if(isset($_POST['izmjenikorisnika'])) {
    $id_korisnika = $_POST['id_korisnika'];
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    $telefon = $_POST['telefon'];
    $ustanova = isset($_POST['ustanova']) && $_POST['ustanova'] !== "" ? $_POST['ustanova'] : NULL;

    $administrator = $_POST['administrator'];
    $izmjenikorisnika = izmjeniKorisnika($id_korisnika, $ime, $prezime, $email, $telefon, $ustanova, $administrator);
    if($izmjenikorisnika) {
        header('Location:dashboard.php?action=users&user=view&status=korisnik-izmjenjen&iduser=' .$id_korisnika);
        exit;
    } else {
        header('Location:dashboard.php?action=users&user=view&status=korisnik-izmjena-greska&iduser=' .$id_korisnika);
        exit;
    }
}

/*DODAJ USTANOVU*/
if(isset($_POST['dodajustanovu'])) {
    $vrsta = $_POST['vrsta'];
    $npp = $_POST['tip'];
    $naziv = $_POST['naziv_ustanove'];
    $mjesto = $_POST['mjesto'];
    $telefon = $_POST['telefon'];
    $fax = $_POST['fax'];
    $email = $_POST['email'];
    $ravnatelj = $_POST['ravnatelj'];
    $mobitel_ravnatelja = $_POST['mobitel_ravnatelja'];
    $dodajustanovu = dodajUstanovu($vrsta, $npp, $naziv, $mjesto, $telefon, $fax, $email, $ravnatelj, $mobitel_ravnatelja);
    if($dodajustanovu) {
        header('Location:dashboard.php?action=ustanove&status=kreirano');
    } else {
        header('Location:dashboard.php?action=ustanove&status=greska');
    }
}

/*UREDI USTANOVU*/
if(isset($_POST['izmjeniustanovu'])) {
    $vrsta = $_POST['vrsta'];
    $npp = $_POST['npp'];
    $naziv = $_POST['naziv_ustanove'];
    $mjesto = $_POST['mjesto'];
    $telefon = $_POST['telefon'];
    $fax = $_POST['fax'];
    $email = $_POST['email'];
    $ravnatelj = $_POST['ravnatelj'];
    $mobitel_ravnatelja = $_POST['mobitel_ravnatelja'];
    $id_ustanove = $_POST['id_ustanova'];
    $urediustanovu = urediUstanovu($vrsta, $npp, $naziv, $mjesto, $telefon, $fax, $email, $ravnatelj, $mobitel_ravnatelja, $id_ustanove);
    if($urediustanovu) {
        header('Location:dashboard.php?action=ustanove&status=izmjena-uspjesna');
    } else {
        header('Location:dashboard.php?action=ustanove&status=izmjena-greska');
    }
}

/*OBRIŠI USTANOVU*/
if(isset($_POST['obrisiustanovu'])) {
    $id_ustanove = $_POST['id_ustanove'];
    $obrisiustanovu = obrisiUstanovu($id_ustanove);
    if($obrisiustanovu) {
        header('Location:dashboard.php?action=ustanove&status=obrisano');
    } else {
        header('Location:dashboard.php?action=ustanove&status=brisanje-greska');
    }
}

/*LISTING - ODABIR ŠKOLSKE GODINE ZA SPISAK*/
if(isset($_POST['odabirliste'])) {
    $ustanova = $_POST['ustanova'];
    $skg = $_POST['skolska_godina'];
    $filter = filterUcenika($ustanova, $skg);
    if($filter) {
        // Preusmeravanje sa parametrima
        header('Location:dashboard.php?action=lista&filter=skg&ustanova=' . $ustanova . '&skg=' . $skg);
        exit;
    } else {
        header('Location:dashboard.php?action=lista&filter=skg&ustanova=' . $ustanova . '&skg=' . $skg);
        exit;
    }
}
/*LISTING - ADMIN ODABIR ŠKOLSKE GODINE ZA SPISAK*/
if(isset($_POST['odabirlisteadmin'])) {
    $ustanova = $_POST['ustanova'];
    $skg = $_POST['skolska_godina'];
    $filter = filterUcenika($ustanova, $skg);
    if($filter) {
        // Preusmeravanje sa parametrima
        header('Location:dashboard.php?action=lista&filter=skg&ustanova=' . $ustanova . '&skg=' . $skg);
        exit;
    } else {
        header('Location:dashboard.php?action=lista&filter=skg&ustanova=' . $ustanova . '&skg=' . $skg);
        exit;
    }
}

/*PRETRAGA*/
if(isset($_POST['pretraga'])) {
    $ustanova = $_POST['ustanova'];
    $skg = $_POST['skolska_godina'];
    $ime = $_POST['ime_ucenika'];
    $jmbg = $_POST['jmbg'];
    $prezime = $_POST['prezime_ucenika'];
    $ime_oca = $_POST['ime_oca'];
    $ime_majke = $_POST['ime_majke'];
    $prezime_majke = $_POST['prezime_majke'];
    
    $pretraga = pretraga($ustanova, $skg, $ime, $jmbg, $prezime, $ime_oca, $ime_majke, $prezime_majke);
    
    // Provera da li ima rezultata
    $nema_rezultata = empty($pretraga);
    
    if($nema_rezultata) {
        // Ako nema rezultata, možete postaviti neku poruku ili prikazati praznu tabelu
        $pretraga = array(); // Postavljamo prazan niz kako bi se prikazala prazna tabela
    }

    // Preusmeravanje sa parametrima
    header('Location:dashboard.php?action=pretraga&pretraga=rezultat&ustanova=' . $ustanova . '&skg=' . $skg . '&ime=' . $ime . '&prezime=' . $prezime . '&jmbg=' . $jmbg . '&imeoca=' . $ime_oca . '&imemajke=' . $ime_majke . '&prezimemajke=' . $prezime_majke);
    exit;
}

/*ADMIN PRETRAGA*/
if(isset($_POST['adminpretraga'])) {
    $ustanova = $_POST['ustanova'];
    $skg = $_POST['skolska_godina'];
    $ime = $_POST['ime_ucenika'];
    $jmbg = $_POST['jmbg'];
    $prezime = $_POST['prezime_ucenika'];
    $ime_oca = $_POST['ime_oca'];
    $ime_majke = $_POST['ime_majke'];
    $prezime_majke = $_POST['prezime_majke'];
    
    $pretraga = pretraga($ustanova, $skg, $ime, $jmbg, $prezime, $ime_oca, $ime_majke, $prezime_majke);
    
    // Provera da li ima rezultata
    $nema_rezultata = empty($pretraga);
    
    if($nema_rezultata) {
        // Ako nema rezultata, možete postaviti neku poruku ili prikazati praznu tabelu
        $pretraga = array(); // Postavljamo prazan niz kako bi se prikazala prazna tabela
    }

    // Preusmeravanje sa parametrima
    header('Location:dashboard.php?action=pretraga&pretraga=rezultat&ustanova=' . $ustanova . '&skg=' . $skg . '&ime=' . $ime . '&prezime=' . $prezime . '&jmbg=' . $jmbg . '&imeoca=' . $ime_oca . '&imemajke=' . $ime_majke . '&prezimemajke=' . $prezime_majke);
    exit;
}

/*DODAJ OBAVIJEST*/
if(isset($_POST['dodajobavjestenje'])) {
    $naslov = $_POST['naslov'];
    $poruka = $_POST['poruka'];
    $aktivno = $_POST['aktivno'];
    $dodajobv = dodajObavjestenje($naslov, $poruka, $aktivno);
    if($dodajobv) {
        header('Location:dashboard.php?action=obavjestenja&status=kreirano');
    } else {
        header('Location:dashboard.php?action=obavjestenja&status=greska');
    }
}

/*UREDI OBAVIJEST*/
if(isset($_POST['urediobavjestenje'])) {
    $naslov = $_POST['naslov'];
    $poruka = $_POST['poruka'];
    $aktivno = $_POST['aktivno'];
    $id_obv = $_POST['id_obavjestenja'];
    $urediobv = urediObavjestenje($naslov, $poruka, $aktivno, $id_obv);
    if($urediobv) {
        header('Location:dashboard.php?action=obavjestenja&status=izmjena-uspjesna');
    } else {
        header('Location:dashboard.php?action=obavjestenja&status=izmjena-greska');
    }
}

/*OBRIŠI OBAVIJEST*/
if(isset($_POST['obrisiobavjestenje'])) {
    $id_obv = $_POST['id_obavjestenja'];
    $obrisiobavjestenje = obrisiObavjestenje($id_obv);
    if($obrisiobavjestenje) {
        header('Location:dashboard.php?action=obavjestenja&status=obrisano');
    } else {
        header('Location:dashboard.php?action=obavjestenja&status=brisanje-greska');
    }
}
?>
