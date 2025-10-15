<!--Obavijesti-->
    <?php 
        if (isset($_GET['status']) && $_GET['status'] === 'ucenik-dodan') {
        echo '<div class="uspjesno">
            <center>Učenik uspješno dodan u na spisak za odabranu školsku godinu</center>
        </div>';
    } elseif (isset($_GET['profil']) && $_GET['profil'] === 'edit' && isset($_GET['status']) && $_GET['status'] === 'email-postoji') {
        echo '<div class="greska">
            <center>Dogodila se greška. Email već postoji u bazi. Pokušajte ponovo sa drugim email-om.</center>
        </div>';
    } elseif (isset($_GET['profil']) && $_GET['profil'] === 'edit' && isset($_GET['status']) && $_GET['status'] === 'greska') {
        echo '<div class="greska">
            <center>Dogodila se greška. Kontaktirajte administratora aplikacije.</center>
        </div>';
    } elseif (isset($_GET['profil']) && $_GET['profil'] === 'new' && isset($_GET['status']) && $_GET['status'] === 'uspjesno') {
        echo '<div class="uspjesno">
            <center>Uspješno ste kreirali novi korisnički račun</center>
        </div>';
    } elseif (isset($_GET['profil']) && $_GET['profil'] === 'new' && isset($_GET['status']) && $_GET['status'] === 'greska') {
        echo '<div class="greska">
            <center>Dogodila se greška. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['profil']) && $_GET['profil'] === 'new' && isset($_GET['status']) && $_GET['status'] === 'email-postoji') {
        echo '<div class="greska">
            <center>Dogodila se greška. Email već postoji u bazi. Pokušajte ponovo sa drugim email-om.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ustanove' && isset($_GET['status']) && $_GET['status'] === 'kreirano') {
        echo '<div class="uspjesno">
            <center>Uspješno dodana nova obrazovna ustanova.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ustanove' && isset($_GET['status']) && $_GET['status'] === 'greska') {
        echo '<div class="greska">
            <center>Dogodila se greška pri kreiranju nove ustanove. Pokušajte ponovo ili se obratite administratoru.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ustanove' && isset($_GET['status']) && $_GET['status'] === 'izmjena-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška pri izmjeni obrazovne ustanove. Pokušajte ponovo ili se obratite administratoru.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ustanove' && isset($_GET['status']) && $_GET['status'] === 'izmjena-uspjesna') {
        echo '<div class="uspjesno">
            <center>Uspješno izvršena izmjena obrazovne ustanove.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ustanove' && isset($_GET['status']) && $_GET['status'] === 'obrisano') {
        echo '<div class="uspjesno">
            <center>Ustanova uspješno obrisana.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ustanove' && isset($_GET['status']) && $_GET['status'] === 'brisanje-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška pri brisanju ustanove. Pokušajte ponovo ili se obratite administratoru.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'skolska-godina' && isset($_GET['status']) && $_GET['status'] === 'kreirano') {
        echo '<div class="uspjesno">
            <center>Uspješno otvorena školska godina.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'skolska-godina' && isset($_GET['status']) && $_GET['status'] === 'greska') {
        echo '<div class="greska">
            <center>Dogodila se greška pri kreiranju školske godine. Pokušajte ponovo ili se obratite administratoru.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'skolska-godina' && isset($_GET['status']) && $_GET['status'] === 'obrisano') {
        echo '<div class="uspjesno">
            <center>Školska godina uspješno obrisana.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'skolska-godina' && isset($_GET['status']) && $_GET['status'] === 'brisanje-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška pri brisanju školske godine. Pokušajte ponovo ili se obratite administratoru.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'skolska-godina' && isset($_GET['status']) && $_GET['status'] === 'izmjena-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška pri izmjeni školske godine. Pokušajte ponovo ili se obratite administratoru.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'skolska-godina' && isset($_GET['status']) && $_GET['status'] === 'izmjena-uspjesna') {
        echo '<div class="uspjesno">
            <center>Uspješno izvršena izmjena školske godine.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ucenik' && isset($_GET['status']) && $_GET['status'] === 'odobrenje-azurirano') {
        echo '<div class="uspjesno">
            <center>Uspješno ste ažurirali status odobrenja naknade za učenika</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ucenik' && isset($_GET['status']) && $_GET['status'] === 'odobrenje-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ucenik' && isset($_GET['status']) && $_GET['status'] === 'uplata-azurirano') {
        echo '<div class="uspjesno">
            <center>Uspješno ste ažurirali status uplate naknade za učenika</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ucenik' && isset($_GET['status']) && $_GET['status'] === 'uplata-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'obavjestenja' && isset($_GET['status']) && $_GET['status'] === 'greska') {
        echo '<div class="greska">
            <center>Dogodila se greška. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'obavjestenja' && isset($_GET['status']) && $_GET['status'] === 'kreirano') {
        echo '<div class="uspjesno">
            <center>Uspješno ste dodali obavještenje.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'obavjestenja' && isset($_GET['status']) && $_GET['status'] === 'izmjena-uspjesna') {
        echo '<div class="uspjesno">
            <center>Uspješno ste uredili obavještenje.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'obavjestenja' && isset($_GET['status']) && $_GET['status'] === 'izmjena-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'obavjestenja' && isset($_GET['status']) && $_GET['status'] === 'obrisano') {
        echo '<div class="uspjesno">
            <center>Uspješno ste obrisali obavještenje.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'obavjestenja' && isset($_GET['status']) && $_GET['status'] === 'brisanje-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ucenici' && isset($_GET['status']) && $_GET['status'] === 'jmbg-postoji') {
        echo '<div class="greska">
            <center>Dogodila se greška. Već postoji učenik sa istim JMBG-om za odabranu školsku godinu.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'ucenik' && isset($_GET['status']) && $_GET['status'] === 'brisanje-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška prilikom brisanja učenika. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'lista' && isset($_GET['status']) && $_GET['status'] === 'brisanje-uspjesno') {
        echo '<div class="uspjesno">
            <center>Uspješno ste obrisali učenika sa spiska.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'users' && isset($_GET['status']) && $_GET['status'] === 'korisnik-obrisan') {
        echo '<div class="uspjesno">
            <center>Uspješno ste obrisali korisnika aplikacije</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'users' && isset($_GET['status']) && $_GET['status'] === 'brisanje-korisnika-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška prilikom brisanja korisnika iz aplikacije. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'users' && isset($_GET['status']) && $_GET['status'] === 'lozinka-izmjenjena') {
        echo '<div class="uspjesno">
            <center>Uspješno ste izmjenili lozinku korisnika</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'users' && isset($_GET['status']) && $_GET['status'] === 'lozinka-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška prilikom izmjene lozinke. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'users' && isset($_GET['status']) && $_GET['status'] === 'password-greska') {
        echo '<div class="greska">
            <center>Lozinke se ne podudaraju. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'users' && isset($_GET['status']) && $_GET['status'] === 'korisnik-izmjenjen') {
        echo '<div class="uspjesno">
            <center>Uspješno ste uredili podatke o korisniku aplikacije</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'users' && isset($_GET['status']) && $_GET['status'] === 'korisnik-izmjena-greska') {
        echo '<div class="greska">
            <center>Dogodila se greška prilikom uređivanja podataka korisnika. Pokušajte ponovo.</center>
        </div>';
    } elseif (isset($_GET['action']) && $_GET['action'] === 'users' && isset($_GET['status']) && $_GET['status'] === 'greska-email-postoji') {
        echo '<div class="greska">
            <center>Već postoji korisnik sa unesenom email adresom.</center>
        </div>';
    } 
    ?>
<!--END obavijesti-->