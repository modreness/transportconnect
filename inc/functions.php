<?php
date_default_timezone_set('Europe/Zagreb');

/*KONEKCIJA NA BAZU*/
function dbConnect() {
    $host = "localhost"; // Promenite na vaš host
    $username = "tcmozks_prevozucenika"; // Promjenite na vaše korisničko ime
    $password = "^*0zv2_BG@{L"; // Promjenite na vašu lozinku
    $database = "tcmozks_transport"; // Promjenite na vaš naziv baze

    // Konekcija na bazu
    $conn = new mysqli($host, $username, $password, $database);
    $conn->set_charset("utf8");
    // Provera konekcije
    if ($conn->connect_error) {
        die("Greška pri konekciji na bazu: " . $conn->connect_error);
    }

    return $conn;
}

/*LOGIN PROVJERA*/
function checklogin() {
   session_start();

    // Povezivanje s bazom podataka
    $conn = dbConnect();

    // Provera da li je korisnik prijavljen (koristite vaše pristupne podatke i logiku za proveru prijave)
    if (!isset($_SESSION["email"])) {
        header("Location: ../login.php");
        exit;
    } 
}


/*KORISNIK*/
function korisnikpodaci(){
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // Konekcija na bazu
        $conn = dbConnect();

        // Upit za dohvaćanje podataka o korisniku s danom email adresom
        $sql = "SELECT * FROM users LEFT JOIN obrazovne_ustanove ON users.ustanova_id = obrazovne_ustanove.ustanova_id WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);

        // Izvršavanje upita
        $stmt->execute();
        $result = $stmt->get_result();

        // Provjera da li postoje podaci
        if ($result->num_rows > 0) {
            // Dohvatanje podataka o korisniku
            $row = $result->fetch_assoc();
            return $row;
        } else {
            // Ako nema rezultata, možete vratiti prazan niz ili neki drugi odgovor prema vašim potrebama
            return array();
        }

        // Zatvaranje veze s bazom
        $stmt->close();
        $conn->close();
    } else {
        // Ako email sesija nije postavljena, također možete vratiti prazan niz ili neki drugi odgovor
        return array();
    }
}



/*DODAJ UČENIKA*/
function dodajUcenika($ime, $prezime, $ime_oca, $ime_majke, $prezime_majke, $datum_rodjenja, $jmbg, $spol, $adresa, $mjesto, $skolska_godina, $razred, $udaljenost, $iznos, $banka, $ziro_racun, $ustanova, $status_uplate, $status, $napomena)
{
    $conn = dbConnect();
    
    $sql_check_jmbg = "SELECT COUNT(*) AS broj_unosa FROM ucenici WHERE jmbg = ? AND ustanova_id = ?";
    $stmt_check_jmbg = mysqli_prepare($conn, $sql_check_jmbg);
    mysqli_stmt_bind_param($stmt_check_jmbg, "si", $jmbg, $ustanova);
    mysqli_stmt_execute($stmt_check_jmbg);
    $result_check_jmbg = mysqli_stmt_get_result($stmt_check_jmbg);
    $row_check_jmbg = mysqli_fetch_assoc($result_check_jmbg);
    if ($row_check_jmbg['broj_unosa'] > 0) {
        // Unos sa istim JMBG-om već postoji, izbaci grešku i prekini daljnje izvršenje
        $stmt_check_jmbg->close();
        $conn->close();
        header('Location: dashboard.php?action=ucenici&status=jmbg-postoji');
        exit;
    }

    // Unos ucenika u bazu podataka za skolsku godinu
    $sql = "INSERT INTO ucenici (ime_ucenika, prezime_ucenika, ime_oca, ime_majke, prezime_majke, jmbg, datum_rodjenja, spol, mjesto_stanovanja, adresa_stanovanja, udaljenost_do_skole, razred, banka, broj_racuna, iznos, status_uplate, ustanova_id, id_godine, status, napomena) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssisssiiiiis", $ime, $prezime, $ime_oca, $ime_majke, $prezime_majke, $jmbg, $datum_rodjenja, $spol, $mjesto, $adresa, $udaljenost, $razred, $banka, $ziro_racun, $iznos, $status_uplate, $ustanova, $skolska_godina, $status, $napomena);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}


/*DETALJI UČENIKA*/
function detaljiUcenika() {
    if (isset($_GET['id'])) {
        $id_ucenika = $_GET['id'];
        $conn = dbConnect();

        // Sanitizacija ulaznih podataka
        $id_predmet = mysqli_real_escape_string($conn, $id_ucenika);

        // Priprema upita s pripremljenom izjavom
        $sql = "SELECT ucenici.*, skolske_godine.*, obrazovne_ustanove.* FROM ucenici LEFT JOIN skolske_godine ON ucenici.id_godine = skolske_godine.id_godine LEFT JOIN obrazovne_ustanove ON ucenici.ustanova_id = obrazovne_ustanove.ustanova_id WHERE id_ucenika = '$id_ucenika'";

        $result = $conn->query($sql);

        // Provera da li postoje podaci
        if ($result->num_rows == 1) {
            // Vraćamo samo jedan red podataka kao asocijativni niz
            $row = $result->fetch_assoc();
            $conn->close();
            return $row;
        } else {
            $conn->close();
            return null; // Vraćamo null ako nema podataka ili ako je više od jedne prijave s istim id-om
        }
    } else {
        return null; // Ako indeks "id" nije postavljen u GET zahtjevu
    }
}

/*IZMJENA STATUSA ODOBRENJA UČENIKA*/
function izmjenaStatusaOdobrenja($id_ucenika, $status, $napomena) {
    $conn = dbConnect();
    
    $sql = "UPDATE ucenici SET status=?, napomena=? WHERE id_ucenika=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isi", $status, $napomena, $id_ucenika);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}
/*IZMJENA STATUSA UPLATE NAKNADE ZA  UČENIKA*/
function izmjenaStatusaUplate($id_ucenika, $status_uplate) {
    $conn = dbConnect();
    
    $sql = "UPDATE ucenici SET status_uplate=? WHERE id_ucenika=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $status_uplate, $id_ucenika);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}
/*UREDI UČENIKA*/
function urediUcenika($id_ucenika, $ime, $prezime, $ime_oca, $ime_majke, $prezime_majke, $datum_rodjenja, $jmbg, $spol, $adresa, $mjesto, $skolska_godina, $razred, $udaljenost, $iznos, $banka, $ziro_racun, $ustanova) {
    $conn = dbConnect();
    
    // Provera da li se jmbg promjenio
    $jmbg_check_sql = "SELECT jmbg FROM ucenici WHERE id_ucenika = ?";
    $stmt_jmbg_check = $conn->prepare($jmbg_check_sql);
    $stmt_jmbg_check->bind_param("i", $id_ucenika);
    $stmt_jmbg_check->execute();
    $result_jmbg_check = $stmt_jmbg_check->get_result();
    $old_jmbg = $result_jmbg_check->fetch_assoc()['jmbg'];

    // Ako se jmbg promjenio, provjeravamo da li novi jmbg već postoji u bazi
    if ($old_jmbg != $jmbg) {
        $jmbg_check_sql = "SELECT COUNT(*) AS num FROM ucenici WHERE jmbg = ? AND id_godine = ?";
        $stmt_jmbg_check = $conn->prepare($jmbg_check_sql);
        $stmt_jmbg_check->bind_param("si", $jmbg, $skolska_godina);
        $stmt_jmbg_check->execute();
        $result_jmbg_check = $stmt_jmbg_check->get_result();
        $jmbg_check_row = $result_jmbg_check->fetch_assoc();

        if ($jmbg_check_row['num'] > 0) {
            $stmt_jmbg_check->close();
            $conn->close();
            header('Location:dashboard.php?action=ucenik&status=jmbg-greska&id=' . $id_ucenika);
            exit;
        }
    }
    
    $sql = "UPDATE ucenici SET ime_ucenika=?, prezime_ucenika=?, ime_oca=?, ime_majke=?, prezime_majke=?, datum_rodjenja=?, jmbg=?, spol=?, adresa_stanovanja=?, mjesto_stanovanja=?, id_godine=?, razred=?, udaljenost_do_skole=?, iznos=?, banka=?, broj_racuna=? WHERE id_ucenika=? AND ustanova_id=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssisiissii", $ime, $prezime, $ime_oca, $ime_majke, $prezime_majke, $datum_rodjenja, $jmbg, $spol, $adresa, $mjesto, $skolska_godina, $razred, $udaljenost, $iznos, $banka, $ziro_racun,$id_ucenika, $ustanova);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

/*OBRIŠI UČENIKA*/
function obrisiUcenika($id_ucenika, $ustanova, $skg) {
    $conn = dbConnect();

    // Sanitizacija ulaznih podataka
    $id_ucenika = mysqli_real_escape_string($conn, $id_ucenika);

    // Provjeri postoji li školska godina
    $sql_check = "SELECT * FROM ucenici WHERE id_ucenika = '$id_ucenika' AND ustanova_id = '$ustanova' AND id_godine = '$skg'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 1) {
        // Ako postoji skolska godina izbriši je iz baze
        $sql_delete = "DELETE FROM ucenici WHERE id_ucenika = '$id_ucenika'";
        if ($conn->query($sql_delete) === TRUE) {
            $conn->close();
            return true; // Uspješno obrisan zapis
        } else {
            $conn->close();
            return false; // Greška pri brisanju
        }
    } else {
        $conn->close();
        return false;
    }
}


/*promjena lozinke*/
function promijeniLozinku($id_korisnika, $stara_lozinka, $nova_lozinka) {
    $conn = dbConnect();

    $sql = "SELECT password FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_korisnika);
    $stmt->execute();
    $rezultat = $stmt->get_result();
    
    if ($rezultat->num_rows == 1) {
        $red = $rezultat->fetch_assoc();
        $pohranjena_lozinka = $red['password'];
        
        if (sha1($stara_lozinka) === $pohranjena_lozinka) {

            $hash_lozinka = sha1($nova_lozinka);
            
            $sql_update = "UPDATE users SET password = ? WHERE user_id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("si", $hash_lozinka, $id_korisnika);
            
            if ($stmt_update->execute()) {
                $stmt->close();
                $stmt_update->close();
                $conn->close();
                return true;
            } else {
                $stmt->close();
                $stmt_update->close();
                $conn->close();
                return false;
            }
        } else {
            $stmt->close();
            $conn->close();
            return false;
        }
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

/* uredi profil */
function mojProfilIzmjena($id_korisnika, $email, $telefon) {
    $conn = dbConnect();

    // Provera da li se e-mail adresa promenila
    $email_check_sql = "SELECT email FROM users WHERE user_id = ?";
    $stmt_email_check = $conn->prepare($email_check_sql);
    $stmt_email_check->bind_param("i", $id_korisnika);
    $stmt_email_check->execute();
    $result_email_check = $stmt_email_check->get_result();
    $old_email = $result_email_check->fetch_assoc()['email'];

    // Ako se e-mail adresa promenila, proveravamo da li nova e-mail adresa već postoji u bazi
    if ($old_email != $email) {
        $email_check_sql = "SELECT COUNT(*) AS num FROM users WHERE email = ?";
        $stmt_email_check = $conn->prepare($email_check_sql);
        $stmt_email_check->bind_param("s", $email);
        $stmt_email_check->execute();
        $result_email_check = $stmt_email_check->get_result();
        $email_check_row = $result_email_check->fetch_assoc();

        if ($email_check_row['num'] > 0) {
            $stmt_email_check->close();
            $conn->close();
            header('Location: index.php?profil=edit&status=email-postoji');
            exit;
        }
    }
    
    
    // Priprema upita sa placeholders (?)
    $sql = "UPDATE users SET email= ?, telefon= ? WHERE user_id= ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $email, $telefon, $id_korisnika);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

/*DODAJ KORISNIKA*/

function dodajKorisnika($ustanova, $password, $ime, $prezime, $email, $telefon, $administrator) {
    // Enkripcija lozinke
    $enkriptovan = sha1($password);

    // Datum registracije
    $datum_registracije = date("Y-m-d H:i:s");

    // Povezivanje na bazu podataka
    $conn = dbConnect();

    // Provera da li email već postoji
    $email_check_sql = "SELECT COUNT(*) AS num FROM users WHERE email = ?";
    $stmt_email_check = $conn->prepare($email_check_sql);
    $stmt_email_check->bind_param("s", $email);
    $stmt_email_check->execute();
    $result_email_check = $stmt_email_check->get_result();
    $email_check_row = $result_email_check->fetch_assoc();
    if ($email_check_row['num'] > 0) {
        // E-mail adresa već postoji, prikaži grešku i prekini registraciju
        $stmt_email_check->close();
        $conn->close();
        header('Location: dashboard.php?profil=new&status=email-postoji');
        exit;
    }
    
    // Priprema SQL upita sa placeholders (?)
    $sql = "INSERT INTO users (email, password, ime, prezime, telefon, ustanova_id, nivo, datum_registracije, lastlogin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NULL)";

    // Priprema statementa
    $stmt = $conn->prepare($sql);

    // Provera da li je priprema uspela
    if (!$stmt) {
        // Ako priprema nije uspela, vraćamo false
        $conn->close();
        return false;
    }

    // Bindovanje parametara
    $stmt->bind_param("sssssiis", $email, $enkriptovan, $ime, $prezime, $telefon, $ustanova, $administrator, $datum_registracije );

    // Izvršavanje upita
    if ($stmt->execute()) {
        // Ako je upit uspeo, zatvaramo statement i vraćamo true
        $stmt->close();
        $conn->close();
        return true;
    } else {
        // Ako upit nije uspeo, zatvaramo statement i vraćamo false
        $stmt->close();
        $conn->close();
        return false;
    }
}


/*LISTA UNOSITELJA/ADMINISTRATORA*/
function userlist() {
    $conn = dbConnect();
    $sql = "SELECT * FROM users LEFT JOIN obrazovne_ustanove ON users.ustanova_id=obrazovne_ustanove.ustanova_id ORDER BY user_id DESC";
    $result = $conn->query($sql);

    // Provera da li postoje podaci
    if ($result) {
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    } else {
        $users = array(); // Vraćamo prazan niz ako nema podataka ili je došlo do greške
    }

    $conn->close();

    return $users;
}

/*DETALJI ADMINISTRATORA/UNOSITELJA*/
function detaljiKorisnika() {
    if (isset($_GET['iduser'])) {
        $id_korisnika = $_GET['iduser'];
        $conn = dbConnect();

        // Sanitizacija ulaznih podataka
        $id_korisnika = mysqli_real_escape_string($conn, $id_korisnika);

        // Priprema upita s pripremljenom izjavom
        $sql = "SELECT users.*, obrazovne_ustanove.* FROM users LEFT JOIN obrazovne_ustanove ON users.ustanova_id=obrazovne_ustanove.ustanova_id WHERE user_id = '$id_korisnika'";

        $result = $conn->query($sql);

        // Provera da li postoje podaci
        if ($result->num_rows == 1) {
            // Vraćamo samo jedan red podataka kao asocijativni niz
            $row = $result->fetch_assoc();
            $conn->close();
            return $row;
        } else {
            $conn->close();
            return null; // Vraćamo null ako nema podataka ili ako je više od jedne prijave s istim id-om
        }
    } else {
        return null; // Ako indeks "id" nije postavljen u GET zahtjevu
    }
}

/*LISTA PREDMETA ZA KORISNIKA*/
function listaUcenikaUsera() {
    if (isset($_GET['iduser'])) {
        $conn = dbConnect();
        $id_korisnika = $_GET['iduser'];
       
        $sql = "SELECT ucenici.*, skolske_godine.*, obrazovne_ustanove.* FROM ucenici LEFT JOIN skolske_godine ON ucenici.id_godine = skolske_godine.id_godine LEFT JOIN obrazovne_ustanove ON ucenici.ustanova_id = obrazovne_ustanove.ustanova_id WHERE ustanova_id= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_korisnika);

        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            
            return array(); 
        }

        $predmeti = array();
        while ($row = $result->fetch_assoc()) {
            $predmeti[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $predmeti;
    } else {
        
        return array(); 
    }
}

/*OBRIŠI KORISNIKA*/
function obrisiKorisnika($id_korisnika) {
    $conn = dbConnect();

    // Sanitizacija ulaznih podataka
    $id_korisnika = mysqli_real_escape_string($conn, $id_korisnika);

    // Provjeri postoji li korisnik s danim ID-om
    $sql_check = "SELECT * FROM users WHERE user_id = '$id_korisnika'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 1) {
        // Ako postoji korisnik, obriši ga iz baze podataka
        $sql_delete = "DELETE FROM users WHERE user_id = '$id_korisnika'";
        if ($conn->query($sql_delete) === TRUE) {
            $conn->close();
            return true; // Uspješno obrisan zapis
        } else {
            $conn->close();
            return false; // Greška pri brisanju
        }
    } else {
        $conn->close();
        return false;
    }
}

/*IZMJENI LOZINKU KORISNIKA*/
function izmjenaLozinkeKorisnika($id_korisnika, $password) {
    $conn = dbConnect();
    $lozinka = sha1($password);
    $sql_update = "UPDATE users SET password = ? WHERE user_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("si", $lozinka, $id_korisnika);
    if ($stmt_update->execute()) {
        $stmt_update->close();
        $conn->close();
        return true;
    } else {
        $stmt_update->close();
        $conn->close();
        return false;
    }
}

/*IZMJENI PODATKE KORISNIKA*/
function izmjeniKorisnika($id_korisnika, $ime, $prezime, $email, $telefon, $ustanova, $administrator) {
    $conn = dbConnect();

    // Provera da li se e-mail adresa promenila
    $email_check_sql = "SELECT email FROM users WHERE user_id = ?";
    $stmt_email_check = $conn->prepare($email_check_sql);
    $stmt_email_check->bind_param("i", $id_korisnika);
    $stmt_email_check->execute();
    $result_email_check = $stmt_email_check->get_result();
    $old_email = $result_email_check->fetch_assoc()['email'];

    // Ako se e-mail adresa promenila, proveravamo da li nova e-mail adresa već postoji u bazi
    if ($old_email != $email) {
        $email_check_sql = "SELECT COUNT(*) AS num FROM users WHERE email = ?";
        $stmt_email_check = $conn->prepare($email_check_sql);
        $stmt_email_check->bind_param("s", $email);
        $stmt_email_check->execute();
        $result_email_check = $stmt_email_check->get_result();
        $email_check_row = $result_email_check->fetch_assoc();

        if ($email_check_row['num'] > 0) {
            $stmt_email_check->close();
            $conn->close();
            header('Location: dashboard.php?action=users&user=edit&status=greska-email-postoji&iduser=' .$id_korisnika);
            exit;
        }
    }
    
    
    // Priprema upita sa placeholders (?)
    $sql = "UPDATE users SET ime=?, prezime=?, email= ?, telefon= ?, ustanova_id= ?, nivo=? WHERE user_id= ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiii", $ime, $prezime, $email, $telefon, $ustanova, $administrator, $id_korisnika);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}



/*DODAJ ŠKOLSKU GODINU*/
function dodajSKG($skgod, $cijena, $aktivno) {
    $conn = dbConnect();
    
    $sql = "INSERT INTO skolske_godine (skolska_godina, cijena_po_km, aktivno) VALUES (?, ?, ?)";

    // Priprema statementa
    $stmt = $conn->prepare($sql);

    // Provera da li je priprema uspela
    if (!$stmt) {
        // Ako priprema nije uspela, vraćamo false
        $conn->close();
        return false;
    }

    // Bindovanje parametara
    $stmt->bind_param("sii", $skgod, $cijena, $aktivno);

    // Izvršavanje upita
    if ($stmt->execute()) {
        // Ako je upit uspeo, zatvaramo statement i vraćamo true
        $stmt->close();
        $conn->close();
        return true;
    } else {
        // Ako upit nije uspeo, zatvaramo statement i vraćamo false
        $stmt->close();
        $conn->close();
        return false;
    }
}

/*LISTA ŠKOLSKIH GODINA*/
function listaSkGod() {
    $conn = dbConnect();
    $sql = "SELECT * FROM skolske_godine ORDER BY id_godine DESC";
    $result = $conn->query($sql);
    if ($result) {
        $sk = array();
        while ($row = $result->fetch_assoc()) {
            $sk[] = $row;
        }
    } else {
        $sk = array(); 
    }
    $conn->close();
    return $sk;
}

/*DETALJI ŠKOLSKE GODINE ZA EDIT*/
function detaljiSkGod() {
    if (isset($_GET['id'])) {
        $id_skg = $_GET['id'];
        $conn = dbConnect();

        // Sanitizacija ulaznih podataka
        $id_skg = mysqli_real_escape_string($conn, $id_skg);

        // Priprema upita s pripremljenom izjavom
        $sql = "SELECT * FROM skolske_godine
            WHERE id_godine = '$id_skg'";

        $result = $conn->query($sql);

        // Provera da li postoje podaci
        if ($result->num_rows == 1) {
            // Vraćamo samo jedan red podataka kao asocijativni niz
            $row = $result->fetch_assoc();
            $conn->close();
            return $row;
        } else {
            $conn->close();
            return null; // Vraćamo null ako nema podataka ili ako je više od jedne prijave s istim id-om
        }
    } else {
        return null; // Ako indeks "id" nije postavljen u GET zahtjevu
    }
}



/*UREDI ŠKOLSKU GODINU*/
function urediSKG($skgod, $cijena, $aktivno, $id_skgod) {
    $conn = dbConnect();
    
    $sql = "UPDATE skolske_godine SET skolska_godina=?, cijena_po_km=?, aktivno=? WHERE id_godine=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii", $skgod, $cijena, $aktivno, $id_skgod);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

/*OBRIŠI ŠKOLSKU GODINU*/
function obrisiSKG($id_godine) {
    $conn = dbConnect();

    // Sanitizacija ulaznih podataka
    $id_godine = mysqli_real_escape_string($conn, $id_godine);

    // Provjeri postoji li školska godina
    $sql_check = "SELECT * FROM skolske_godine WHERE id_godine = '$id_godine'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 1) {
        // Ako postoji skolska godina izbriši je iz baze
        $sql_delete = "DELETE FROM skolske_godine WHERE id_godine = '$id_godine'";
        if ($conn->query($sql_delete) === TRUE) {
            $conn->close();
            return true; // Uspješno obrisan zapis
        } else {
            $conn->close();
            return false; // Greška pri brisanju
        }
    } else {
        $conn->close();
        return false;
    }
}



/*OBRAZOVNE USTANOVE LISTINZI*/
function skoleOSBH() {
    $conn = dbConnect();
    $sql = "SELECT * FROM obrazovne_ustanove WHERE vrsta = 'Osnovna škola' AND npp = 'Bosanski jezik'"; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $skole = array();
        while ($row = $result->fetch_assoc()) {
            $skole[] = $row;
        }
    } else {
        $skole = array(); 
    }
    $conn->close();
    return $skole;
}
function skoleOSHR() {
    $conn = dbConnect();
    $sql = "SELECT * FROM obrazovne_ustanove WHERE vrsta = 'Osnovna škola' AND npp = 'Hrvatski jezik'"; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $skole = array();
        while ($row = $result->fetch_assoc()) {
            $skole[] = $row;
        }
    } else {
        $skole = array(); 
    }
    $conn->close();
    return $skole;
}
function skoleSRBH() {
    $conn = dbConnect();
    $sql = "SELECT * FROM obrazovne_ustanove WHERE vrsta = 'Srednja škola' AND npp = 'Bosanski jezik'"; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $skole = array();
        while ($row = $result->fetch_assoc()) {
            $skole[] = $row;
        }
    } else {
        $skole = array(); 
    }
    $conn->close();
    return $skole;
}
function skoleSRHR() {
    $conn = dbConnect();
    $sql = "SELECT * FROM obrazovne_ustanove WHERE vrsta = 'Srednja škola' AND npp = 'Hrvatski jezik'"; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $skole = array();
        while ($row = $result->fetch_assoc()) {
            $skole[] = $row;
        }
    } else {
        $skole = array(); 
    }
    $conn->close();
    return $skole;
}

/*lista ustanova*/
function listaUstanova() {
    $conn = dbConnect();
    $sql = "SELECT * FROM obrazovne_ustanove 
            ORDER BY ustanova_id";
        
    $result = $conn->query($sql);

    // Provera da li postoje podaci
    if ($result->num_rows > 0) {
        // Smestanje podataka u niz $seminari
        $ustanove = array();
        while ($row = $result->fetch_assoc()) {
            $ustanove[] = $row;
        }
    } else {
        $ustanove = array(); // Vraćamo prazan niz ako nema podataka
    }

    $conn->close();

    return $ustanove;
}

/*detalji ustanove*/
function detaljiUstanove() {
    if (isset($_GET['idustanove'])) {
        $id_ust = $_GET['idustanove'];
        $conn = dbConnect();

        // Sanitizacija ulaznih podataka
        $id_ust = mysqli_real_escape_string($conn, $id_ust);

        // Priprema upita s pripremljenom izjavom
        $sql = "SELECT * FROM obrazovne_ustanove
            WHERE ustanova_id = '$id_ust'";

        $result = $conn->query($sql);

        // Provera da li postoje podaci
        if ($result->num_rows == 1) {
            // Vraćamo samo jedan red podataka kao asocijativni niz
            $row = $result->fetch_assoc();
            $conn->close();
            return $row;
        } else {
            $conn->close();
            return null; // Vraćamo null ako nema podataka ili ako je više od jedne prijave s istim id-om
        }
    } else {
        return null; // Ako indeks "id" nije postavljen u GET zahtjevu
    }
}


/*dodaj ustanovu*/
function dodajUstanovu($vrsta, $npp, $naziv, $mjesto, $telefon, $fax, $email, $ravnatelj, $mobitel_ravnatelja) {
    $conn = dbConnect();
    
    $sql = "INSERT INTO obrazovne_ustanove (vrsta, naziv_ustanove, npp, mjesto, ravnatelj, mobitel_ravnatelja, email_skole, kontakt_tel, fax) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Priprema statementa
    $stmt = $conn->prepare($sql);

    // Provera da li je priprema uspela
    if (!$stmt) {
        // Ako priprema nije uspela, vraćamo false
        $conn->close();
        return false;
    }

    // Bindovanje parametara
    $stmt->bind_param("sssssssss", $vrsta, $naziv, $npp, $mjesto, $ravnatelj, $mobitel_ravnatelja, $email, $telefon, $fax);

    // Izvršavanje upita
    if ($stmt->execute()) {
        // Ako je upit uspeo, zatvaramo statement i vraćamo true
        $stmt->close();
        $conn->close();
        return true;
    } else {
        // Ako upit nije uspeo, zatvaramo statement i vraćamo false
        $stmt->close();
        $conn->close();
        return false;
    }
}

/*uredi ustanovu*/
function urediUstanovu($vrsta, $npp, $naziv, $mjesto, $telefon, $fax, $email, $ravnatelj, $mobitel_ravnatelja, $id_ustanove) {
    $conn = dbConnect();
    
    $sql = "UPDATE obrazovne_ustanove SET vrsta=?, npp=?, naziv_ustanove=?, mjesto=?, ravnatelj=?, mobitel_ravnatelja=?, email_skole=?, kontakt_tel=?, fax=? WHERE ustanova_id=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssi", $vrsta, $npp, $naziv, $mjesto, $ravnatelj, $mobitel_ravnatelja, $email, $telefon, $fax, $id_ustanove);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

/*obriši ustanovu*/
function obrisiUstanovu($id_ustanove) {
    $conn = dbConnect();

    // Sanitizacija ulaznih podataka
    $id_ustanove = mysqli_real_escape_string($conn, $id_ustanove);

    // Provjeri postoji li školska godina
    $sql_check = "SELECT * FROM obrazovne_ustanove WHERE ustanova_id = '$id_ustanove'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 1) {
        // Ako postoji skolska godina izbriši je iz baze
        $sql_delete = "DELETE FROM obrazovne_ustanove WHERE ustanova_id = '$id_ustanove'";
        if ($conn->query($sql_delete) === TRUE) {
            $conn->close();
            return true; // Uspješno obrisan zapis
        } else {
            $conn->close();
            return false; // Greška pri brisanju
        }
    } else {
        $conn->close();
        return false;
    }
}

/*lista učenika iz te ustanove*/
function listaUcenikaUstanove() {
    if (isset($_GET['idustanove'])) {
        $conn = dbConnect();
        $id_ustanove = $_GET['idustanove'];
       
        $sql = "SELECT ucenici.*, skolske_godine.*, obrazovne_ustanove.* FROM ucenici LEFT JOIN skolske_godine ON ucenici.id_godine = skolske_godine.id_godine LEFT JOIN obrazovne_ustanove ON ucenici.ustanova_id = obrazovne_ustanove.ustanova_id WHERE ucenici.ustanova_id= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_ustanove);

        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            
            return array(); 
        }

        $ustanove = array();
        while ($row = $result->fetch_assoc()) {
            $ustanove[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $ustanove;
    } else {
        
        return array(); 
    }
}

/*lista učenika korisnika*/
function listaUcenikaKorisnika() {
    if (isset($_GET['idustanove'])) {
        $conn = dbConnect();
        $id_ustanove = $_GET['idustanove'];
       
        $sql = "SELECT ucenici.*, skolske_godine.*, obrazovne_ustanove.* FROM ucenici LEFT JOIN skolske_godine ON ucenici.id_godine = skolske_godine.id_godine LEFT JOIN obrazovne_ustanove ON ucenici.ustanova_id = obrazovne_ustanove.ustanova_id WHERE ucenici.ustanova_id= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_ustanove);

        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            
            return array(); 
        }

        $ustanove = array();
        while ($row = $result->fetch_assoc()) {
            $ustanove[] = $row;
        }

        $stmt->close();
        $conn->close();

        return $ustanove;
    } else {
        
        return array(); 
    }
}

/*Filter učenika po ustanovi i školskoj godini*/
function filterUcenika($ustanova, $skg) {
    $conn = dbConnect();
   
    $sql = "SELECT ucenici.*, skolske_godine.*, obrazovne_ustanove.* FROM ucenici LEFT JOIN skolske_godine ON ucenici.id_godine = skolske_godine.id_godine LEFT JOIN obrazovne_ustanove ON ucenici.ustanova_id = obrazovne_ustanove.ustanova_id WHERE ucenici.ustanova_id= ? AND ucenici.id_godine=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $ustanova, $skg);

    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        return array(); 
    }

    $ustanove = array();
    while ($row = $result->fetch_assoc()) {
        $ustanove[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $ustanove;
}

/*PRETRAGA PARAMETRI*/
function prikaziTrazeneParametre($parametri) {
    $params = array();
    if (isset($parametri['ustanova']) && !empty($parametri['ustanova'])) {
        $nazivUstanove = getNazivUstanove($parametri['ustanova']);
        $params[] = "Ustanova: " . $nazivUstanove;
    }
    if (isset($parametri['skg']) && !empty($parametri['skg'])) {
        $skolskaGodina = getNazivSkolskeGodine($parametri['skg']);
        $params[] = "Školska godina: " . $skolskaGodina;
    }
    /*
    if (isset($parametri['ustanova']) && !empty($parametri['ustanova'])) $params[] = "Ustanova: " . $parametri['ustanova'];
    if (isset($parametri['skg']) && !empty($parametri['skg'])) $params[] = "Školska godina: " . $parametri['skg'];
    */
    if (isset($parametri['ime']) && !empty($parametri['ime'])) $params[] = "Ime učenika: " . $parametri['ime'];
    if (isset($parametri['prezime']) && !empty($parametri['prezime'])) $params[] = "Prezime učenika: " . $parametri['prezime'];
    if (isset($parametri['jmbg']) && !empty($parametri['jmbg'])) $params[] = "JMBG: " . $parametri['jmbg'];
    if (isset($parametri['imeoca']) && !empty($parametri['imeoca'])) $params[] = "Ime oca: " . $parametri['imeoca'];
    if (isset($parametri['imemajke']) && !empty($parametri['imemajke'])) $params[] = "Ime majke: " . $parametri['imemajke'];
    if (isset($parametri['prezimemajke']) && !empty($parametri['prezimemajke'])) $params[] = "Prezime majke: " . $parametri['prezimemajke'];

    return implode(', ', $params);
}

/*Pretraga*/
function pretraga($ustanova, $skg, $ime, $jmbg, $prezime, $ime_oca, $ime_majke, $prezime_majke) {
    $conn = dbConnect();
   
    $sql = "SELECT ucenici.*, skolske_godine.*, obrazovne_ustanove.* FROM ucenici 
            LEFT JOIN skolske_godine ON ucenici.id_godine = skolske_godine.id_godine 
            LEFT JOIN obrazovne_ustanove ON ucenici.ustanova_id = obrazovne_ustanove.ustanova_id 
            WHERE ucenici.ustanova_id = ?";

    $params = array($ustanova);
    $types = 'i';
    
    if (!empty($skg)) {
        $sql .= " AND ucenici.id_godine = ?";
        $params[] = $skg;
        $types .= 'i';
    }
    
    if (!empty($ime)) {
        $sql .= " AND ucenici.ime_ucenika LIKE ?";
        $params[] = '%' . $ime . '%';
        $types .= 's';
    }
    
    if (!empty($jmbg)) {
        $sql .= " AND (ucenici.jmbg = ? OR ucenici.jmbg LIKE ?)";
        $params[] = $jmbg;
        $params[] = '%' . $jmbg . '%';
        $types .= 'ss';
    }
    
    if (!empty($prezime)) {
        $sql .= " AND ucenici.prezime_ucenika LIKE ?";
        $params[] = '%' . $prezime . '%';
        $types .= 's';
    }
    
    if (!empty($ime_oca)) {
        $sql .= " AND ucenici.ime_oca LIKE ?";
        $params[] = '%' . $ime_oca . '%';
        $types .= 's';
    }
    
    if (!empty($ime_majke)) {
        $sql .= " AND ucenici.ime_majke LIKE ?";
        $params[] = '%' . $ime_majke . '%';
        $types .= 's';
    }
    
    if (!empty($prezime_majke)) {
        $sql .= " AND ucenici.prezime_majke LIKE ?";
        $params[] = '%' . $prezime_majke . '%';
        $types .= 's';
    }
    
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();

    $ustanove = array();
    while ($row = $result->fetch_assoc()) {
        $ustanove[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $ustanove;
}


/* Izvlačenje naziva ustanove */
function getNazivUstanove($ustanova) {
    $conn = dbConnect();
    $sql = "SELECT naziv_ustanove FROM obrazovne_ustanove WHERE ustanova_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ustanova);
    $stmt->execute();
    $result = $stmt->get_result();
    $naziv = $result->fetch_assoc()['naziv_ustanove'];
    $stmt->close();
    $conn->close();
    return $naziv;
}

/* Izvlačenje naziva školske godine */
function getNazivSkolskeGodine($skg) {
    $conn = dbConnect();
    $sql = "SELECT skolska_godina FROM skolske_godine WHERE id_godine = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $skg);
    $stmt->execute();
    $result = $stmt->get_result();
    $skolska_godina = $result->fetch_assoc()['skolska_godina'];
    $stmt->close();
    $conn->close();
    return $skolska_godina;
}


/*OBAVJEŠTENJA*/
/*DETALJI OBAVJEŠTENJA ZA EDIT*/
function detaljiObavjestenja() {
    if (isset($_GET['id'])) {
        $id_obv = $_GET['id'];
        $conn = dbConnect();

        // Sanitizacija ulaznih podataka
        $id_skg = mysqli_real_escape_string($conn, $id_obv);

        // Priprema upita s pripremljenom izjavom
        $sql = "SELECT * FROM obavjestenja
            WHERE id_obavjestenja = '$id_obv'";

        $result = $conn->query($sql);

        // Provera da li postoje podaci
        if ($result->num_rows == 1) {
            // Vraćamo samo jedan red podataka kao asocijativni niz
            $row = $result->fetch_assoc();
            $conn->close();
            return $row;
        } else {
            $conn->close();
            return null; // Vraćamo null ako nema podataka ili ako je više od jedne prijave s istim id-om
        }
    } else {
        return null; // Ako indeks "id" nije postavljen u GET zahtjevu
    }
}

/*LISTA OBAVJEŠTENJA*/
function listaObavjestenja() {
    $conn = dbConnect();
    $sql = "SELECT * FROM obavjestenja ORDER BY id_obavjestenja DESC";
    $result = $conn->query($sql);
    if ($result) {
        $obv = array();
        while ($row = $result->fetch_assoc()) {
            $obv[] = $row;
        }
    } else {
        $obv = array(); 
    }
    $conn->close();
    return $obv;
}

/*DODAJ OBAVJEŠTENJE*/
function dodajObavjestenje($naslov, $poruka, $aktivno) {
    $conn = dbConnect();
    
    $sql = "INSERT INTO obavjestenja (naslov, poruka, status) VALUES (?, ?, ?)";

    // Priprema statementa
    $stmt = $conn->prepare($sql);

    // Provera da li je priprema uspela
    if (!$stmt) {
        // Ako priprema nije uspela, vraćamo false
        $conn->close();
        return false;
    }

    // Bindovanje parametara
    $stmt->bind_param("ssi", $naslov, $poruka, $aktivno);

    // Izvršavanje upita
    if ($stmt->execute()) {
        // Ako je upit uspeo, zatvaramo statement i vraćamo true
        $stmt->close();
        $conn->close();
        return true;
    } else {
        // Ako upit nije uspeo, zatvaramo statement i vraćamo false
        $stmt->close();
        $conn->close();
        return false;
    }
}

/*UREDI OBAVJEŠTENJE*/
function urediObavjestenje($naslov, $poruka, $aktivno, $id_obv) {
    $conn = dbConnect();
    
    $sql = "UPDATE obavjestenja SET naslov=?, poruka=?, status=? WHERE id_obavjestenja=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $naslov, $poruka, $aktivno, $id_obv);
    
    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}

/*OBRIŠI OBAVJEŠTENJE*/
function obrisiObavjestenje($id_obv) {
    $conn = dbConnect();

    // Sanitizacija ulaznih podataka
    $id_obv = mysqli_real_escape_string($conn, $id_obv);

    // Provjeri postoji li školska godina
    $sql_check = "SELECT * FROM obavjestenja WHERE id_obavjestenja = '$id_obv'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows == 1) {
        // Ako postoji skolska godina izbriši je iz baze
        $sql_delete = "DELETE FROM obavjestenja WHERE id_obavjestenja = '$id_obv'";
        if ($conn->query($sql_delete) === TRUE) {
            $conn->close();
            return true; // Uspješno obrisan zapis
        } else {
            $conn->close();
            return false; // Greška pri brisanju
        }
    } else {
        $conn->close();
        return false;
    }
}

/*LISTA OBAVJEŠTENJA ZA KORISNIKE UNOSITELJE*/
function listaObavjestenjaUnositelj() {
    $conn = dbConnect();
    $sql = "SELECT * FROM obavjestenja WHERE status = 1 ORDER BY id_obavjestenja DESC";
    $result = $conn->query($sql);
    if ($result) {
        $obv = array();
        while ($row = $result->fetch_assoc()) {
            $obv[] = $row;
        }
    } else {
        $obv = array(); 
    }
    $conn->close();
    return $obv;
}