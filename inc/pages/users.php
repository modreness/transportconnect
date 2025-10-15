<?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
 <?php  
if (isset($_GET['action']) && $_GET['action'] == 'users' && isset($_GET['user']) && $_GET['user'] == 'view') {
    $trenutni_nivo = $_SESSION['administrator']; 
    $korisnik_nivo = $detaljikorisnika['nivo'];

    // Provjera nivoa
    if ($trenutni_nivo == 1 && $korisnik_nivo == 2) {
        // Ako je logovani korisnik nivo 1 (admin) i korisnik kojeg se želi obrisati nivo 2 (super admin), prikaži poruku ili preusmjeri
        echo "<div class='content'>
                <div class='content-wrap'>
                <div class='content-left'>
                    <h2>Nedozvoljen pregled</h2>
                    <p>Nije vam dozvoljen pregled sadržaja.</p>
                    <a class='backdugme' href='dashboard.php?action=users&user=view&iduser=" . $detaljikorisnika['user_id'] . "'>Nazad</a>
                </div>
              </div>
              </div>";
    } else {
?>
<div class="content">
    <div class="content-wrap">
        <div class="content-left">
            <div class="bigfield">
                <h2>Podaci o korisniku aplikacije</h2>
            </div>
            <div class="predmet-wrap">
                <div class="predmet-flex">
                    <p>Tip: <?php
                            if ($detaljikorisnika['nivo'] == 2) {
                                echo 'Super administrator';
                            } elseif ($detaljikorisnika['nivo'] == 1) {
                                echo 'Administrator';
                            } 
                            else {
                                echo 'Unositelj';
                            }
                            ?>
                    </p>
                    
                    <p>Posljednja prijava: <?php echo $detaljikorisnika['lastlogin'] ? date('d.m.Y \u H:i\h', strtotime($detaljikorisnika['lastlogin'])) : 'Nikad'; ?>
                    </p>
                </div>
                <div class="predmet-details">
                    <h3>Ime i prezime: <?php echo $detaljikorisnika['ime'].' '.$detaljikorisnika['prezime'];?>
                    </h3>
                    <p>Obrazovna ustanova: <?php if (!empty($detaljikorisnika['ustanova_id'])) { 
                    echo $detaljikorisnika['naziv_ustanove'].', '.$detaljikorisnika['npp'];
                    }else echo "/";?></p>
                    <p>E-mail: <?php echo $detaljikorisnika['email'];?></p>
                    <p>Telefon: <?php echo $detaljikorisnika['telefon'];?></p>
                </div>
                <?php if($_SESSION['user_id'] != $detaljikorisnika['user_id']) {?>
                <a class="dugmecta btn-margin left-razmak" href="dashboard.php?action=users&user=edit&iduser=<?php echo $detaljikorisnika['user_id'];?>">Uredi korisnika</a> 
                <a class="dugmecta btn-margin left-razmak" href="dashboard.php?action=users&user=pwd&iduser=<?php echo $detaljikorisnika['user_id'];?>"><i class="fas fa-key"></i></a>
                    <a class="dugmectared btn-margin left-razmak" href="dashboard.php?action=users&user=delete&iduser=<?php echo $detaljikorisnika['user_id'];?>">Obriši korisnika</a>
                <?php }
                ?>
                <div class="bigfield btn-margin">
                    <h2>Lista unosa</h2>
                </div>
                <div class="tabela btn-margin">
            
                <table id="tabelausers" class="hover row-border no-wrap responsive" style="width:100%;">
                    <thead>
                    <tr>
                        <th>R.b.</th>
                        <th>Ime i prezime</th>
                        <th>Adresa</th>
                        <th>JMBG</th>
                        <th>Školska godina</th>
                        <th>Iznos</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($korisniklistaucenika as $ucenikpodaci) {?>
                          <tr onclick="window.location.href = 'dashboard.php?action=predmet&id=<?php echo $ucenikpodaci['id_ucenika'];?>';">
                            <td><?php echo $rownum++ ;?></td>
                            <td><?php echo $ucenikpodaci['ime_ucenika'].' '.$ucenikpodaci['prezime_ucenika'];?></td>
                            <td><?php echo $ucenikpodaci['adresa_stanovanja'].', '.$ucenikpodaci['mjesto_stanovanja'];?></td>
                            <td><?php echo $ucenikpodaci['jmbg'];?></td>
                            <td><?php echo $ucenikpodaci['skolska_godina'];?></td>
                            <td><?php echo $ucenikpodaci['iznos'].' KM'; ?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
                    
            </div>
        </div>
    </div>
</div>        
<?php }
}
elseif (isset($_GET['action']) && $_GET['action'] == 'users' && isset($_GET['user']) && $_GET['user'] == 'delete') { 
    $trenutni_nivo = $_SESSION['administrator']; 
    $korisnik_nivo = $detaljikorisnika['nivo'];

    // Provjera nivoa
    if ($trenutni_nivo == 1 && $korisnik_nivo == 2) {
        // Ako je logovani korisnik nivo 1 (admin) i korisnik kojeg se želi obrisati nivo 2 (super admin), prikaži poruku ili preusmjeri
        echo "<div class='content'>
                <div class='content-wrap'>
                <div class='content-left'>
                    <h2>Nedozvoljeno brisanje</h2>
                    <p>Nije vam dozvoljeno brisanje super administratora.</p>
                    <a class='backdugme' href='dashboard.php?action=users&user=view&iduser=" . $detaljikorisnika['user_id'] . "'>Nazad</a>
                </div>
              </div>
              </div>";
    } else {
?>
<div class="content">
    <div class="content-wrap">
      
        <form action="" method="post">
            <div class="content-left">
                <div class="bigfield">
                    <h2>Brisanje korisnika</h2>
                </div>
                <div class="predmet-wrap">
                    <div class="predmet-details">
                        <h4>Korisnik: <strong><?php echo $detaljikorisnika['ime'].' '.$detaljikorisnika['prezime'];?></strong>
                        </h4>
                    </div>
                    <div class="predmet-flex">
                        <h4>ID korisnika: <?php echo $detaljikorisnika['user_id'];?>
                        </h4>
                    </div>
                </div>
                <div class="form">
                     <div class="predmet-wrap">
                        <div class="predmet-details">
                            <h4>Jeste li sigurni da želite obrisati korisnika iz aplikacija?</h4>
                            <p>Unosi koje je unio korisnik ostat će u bazi jer su vezani direktno za obrazovnu ustanovu.</p>
                        </div>
                    </div>
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_korisnika" value="<?php echo $detaljikorisnika['user_id']; ?>">
                    <div class="smallfield">
                        <input type="submit" name="obrisikorisnika" class="button-red" value="Obriši korisnika"> 
                        <a class="backdugme" href="dashboard.php?action=users&user=view&iduser=<?php echo $detaljikorisnika['user_id'];?>">Nazad</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div> 

<?php }
}
elseif (isset($_GET['action']) && $_GET['action'] == 'users' && isset($_GET['user']) && $_GET['user'] == 'pwd') {
    $trenutni_nivo = $_SESSION['administrator']; 
    $korisnik_nivo = $detaljikorisnika['nivo'];

    // Provjera nivoa
    if ($trenutni_nivo == 1 && $korisnik_nivo == 2) {
        // Ako je logovani korisnik nivo 1 (admin) i korisnik kojeg se želi obrisati nivo 2 (super admin), prikaži poruku ili preusmjeri
        echo "<div class='content'>
                <div class='content-wrap'>
                <div class='content-left'>
                    <h2>Nedozvoljena radnja</h2>
                    <p>Nije vam dozvoljeno pristupiti uređivanju.</p>
                    <a class='backdugme' href='dashboard.php?action=users&user=view&iduser=" . $detaljikorisnika['user_id'] . "'>Nazad</a>
                </div>
              </div>
              </div>";
    } else {
?>
<div class="content">
    <div class="content-wrap">
      
            <form action="" method="post">
            <div class="content-left">
                <div class="bigfield">
                    <h2>Promjena lozinke za korisnika</h2>
                </div>
                <div class="predmet-wrap">
                    <div class="predmet-details">
                        <h4>Korisnik: <strong><?php echo $detaljikorisnika['ime'].' '.$detaljikorisnika['prezime'];?></strong>
                        </h4>
                         <p>Obrazovna ustanova: <?php if (!empty($detaljikorisnika['ustanova_id'])) { 
                    echo $detaljikorisnika['naziv_ustanove'].', '.$detaljikorisnika['npp'];
                    }else echo "/";?></p>
                    </div>
                    <div class="predmet-flex">
                        <h4>ID korisnika: <?php echo $detaljikorisnika['user_id'];?>
                        </h4>
                    </div>
                </div>
                <div class="form">
                    <div class="smallfield">
                        <input type="password" id="password" name="password" required placeholder="Unesite novu lozinku">
                    </div>
                    <div class="smallfield">
                        <input type="password" id="potvrdi_password" name="potvrdi_password" required placeholder="Potvrdite novu lozinku">
                    </div>
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_korisnika" value="<?php echo $detaljikorisnika['user_id']; ?>">
                    <div class="smallfield">
                        <input type="submit" name="izmjenipwdkorisnika" class="button" value="Spremi promjenu">  
                        <a class="backdugme" href="dashboard.php?action=users&user=view&iduser=<?php echo $detaljikorisnika['user_id'];?>">Nazad</a>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
</div>        
<?php }
}
elseif (isset($_GET['action']) && $_GET['action'] == 'users' && isset($_GET['user']) && $_GET['user'] == 'edit') {
    $trenutni_nivo = $_SESSION['administrator']; 
    $korisnik_nivo = $detaljikorisnika['nivo'];

    // Provjera nivoa
    if ($trenutni_nivo == 1 && $korisnik_nivo == 2) {
        // Ako je logovani korisnik nivo 1 (admin) i korisnik kojeg se želi obrisati nivo 2 (super admin), prikaži poruku ili preusmjeri
        echo "<div class='content'>
                <div class='content-wrap'>
                <div class='content-left'>
                    <h2>Nedozvoljena radnja</h2>
                    <p>Nije vam dozvoljeno pristupiti uređivanju.</p>
                    <a class='backdugme' href='dashboard.php?action=users&user=view&iduser=" . $detaljikorisnika['user_id'] . "'>Nazad</a>
                </div>
              </div>
              </div>";
    } else {
?>
<div class="content">
    <div class="content-wrap">
      
            <form action="" method="post">
            <div class="content-left">
                <div class="bigfield">
                    <h2>Uredi podatke o korisniku</h2>
                </div>
                <div class="predmet-wrap">
                    <div class="predmet-details">
                        <h4>Korisnik: <strong><?php echo $detaljikorisnika['ime'].' '.$detaljikorisnika['prezime'];?></strong>
                        </h4>
                    </div>
                    <div class="predmet-flex">
                        <h4>ID korisnika: <?php echo $detaljikorisnika['user_id'];?>
                        </h4>
                    </div>
                </div>
                <div class="form">
                    <div class="smallfield">
                        <input type="text" id="ime" name="ime" required placeholder="Ime" value="<?php echo $detaljikorisnika['ime'];?>">
                    </div>
                    <div class="smallfield">
                        <input type="text" id="prezime" name="prezime" required placeholder="Prezime" value="<?php echo $detaljikorisnika['prezime'];?>">
                    </div>
                    <div class="smallfield">
                        <input type="text" id="email" name="email" required placeholder="Email" value="<?php echo $detaljikorisnika['email'];?>">
                    </div>
                    <div class="smallfield">
                        <input type="text" id="telefon" name="telefon" required placeholder="Telefon" value="<?php echo $detaljikorisnika['telefon'];?>">
                    </div>
                    <div class="smallfield">
                        <select class="lista" name="ustanova" >
                        <option value="<?php if (!empty($detaljikorisnika['ustanova_id'])) { echo $detaljikorisnika['ustanova_id']; } 
                        else echo "";?>" selected><?php if (!empty($detaljikorisnika['ustanova_id'])) { 
                    echo $detaljikorisnika['naziv_ustanove'].', '.$detaljikorisnika['mjesto'];
                    }else echo "Obrazovna ustanova";?></option>
                        <?php
                        if (!isset($_SESSION['administrator']) || $_SESSION['administrator'] != 0) {
                            echo '<option value="">Ništa</option>';
                        }
                        ?>
                         <optgroup label="Osnovne škole koje NPP izvode na
                        hrvatskom jeziku">
                        <?php foreach ($skoleoshr as $skola) { ?>
                            <option value="<?php echo $skola['ustanova_id']; ?>"><?php echo $skola['naziv_ustanove']; ?>, <?php echo $skola['mjesto']; ?></option>
                            <?php } ?>
                        </optgroup>
                        <optgroup label="Osnovne škole koje NPP izvode na
                        bosanskom jeziku">
                        <?php foreach ($skoleosbh as $skola) { ?>
                        <option value="<?php echo $skola['ustanova_id']; ?>"><?php echo $skola['naziv_ustanove']; ?>, <?php echo $skola['mjesto']; ?></option>
                        <?php } ?>
                        </optgroup>
                        <optgroup label="Srednje škole koje NPP izvode na
                        hrvatskom jeziku">
                        <?php foreach ($skolesrhr as $skola) { ?>
                        <option value="<?php echo $skola['ustanova_id']; ?>"><?php echo $skola['naziv_ustanove']; ?>, <?php echo $skola['mjesto']; ?></option>
                        <?php } ?>
                        </optgroup>
                        <optgroup label="Srednje škole koje NPP izvode na
                        bosanskom jeziku">
                        <?php foreach ($skolesrbh as $skola) { ?>
                        <option value="<?php echo $skola['ustanova_id']; ?>"><?php echo $skola['naziv_ustanove']; ?>, <?php echo $skola['mjesto']; ?></option>
                        <?php } ?>
                        </optgroup>
                    </select>    
                    </div>
                    <div class="smallfield">
                        <select name="administrator" class="lista">
    <option value="0" <?php if ($detaljikorisnika['administrator'] == 0) echo 'selected'; ?>>Unositelj</option>
    <option value="1" <?php if ($detaljikorisnika['administrator'] == 1) echo 'selected'; ?>>Administrator</option>
    <?php
                        if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 2) {
                            echo '<option value="2">Super administrator</option>';
                        }
                        ?>
</select>

                    </div>
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_korisnika" value="<?php echo $detaljikorisnika['user_id']; ?>">
                    <div class="smallfield">
                        <input type="submit" name="izmjenikorisnika" class="button" value="Spremi promjenu">  
                        <a class="backdugme" href="dashboard.php?action=users&user=view&iduser=<?php echo $detaljikorisnika['user_id'];?>">Nazad</a>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
</div>

<?php } 
}
else { ?>
<div class="content">
    <a href="dashboard?profil=new" class="dugmecta">Dodaj korisnika</a>
    <div class="tabela">
    <table id="tabelausers" class="hover row-border no-wrap responsive" style="width:100%;">
        <thead>
        <tr>
            <th>R.br.</th>
            <th>Ime i prezime</th>
            <th>E-mail</th>
            <th>Telefon</th>
            <th>Ustanova</th>
            <th>Tip</th>
            <th>Prijava</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user) {
            if ($_SESSION['administrator'] == 1 && $user['nivo'] == 2) {
            continue; // Preskoči prikaz ovog korisnika
            }
            ?>
              <tr onclick="window.location.href = 'dashboard.php?action=users&user=view&iduser=<?php echo $user['user_id'];?>';">
                <td><?php echo $rownum; $rownum++ ?></td>
                <td><?php echo $user['ime']. ' ' . $user['prezime'];?></td>
                <td><?php echo $user['email'];?></td>
                <td><?php echo $user['telefon'];?></td>
                <td><?php echo $user['naziv_ustanove'];?></td>
                <td><?php
                            if ($user['nivo'] == 2) {
                                echo 'Super administrator';
                            } elseif ($user['nivo'] == 1) {
                                echo 'Administrator';
                            } 
                            else {
                                echo 'Unositelj';
                            }
                            ?></td>
                <td><?php echo $user['lastlogin'] ? date('d.m.Y \u H:i\h', strtotime($user['lastlogin'])) : 'Nikad'; ?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
    </div>
</div> 
<?php } 
?>
<?php } else {
    echo '<div class="greska">Nemate ovlaštenje za pristup ovom dijelu aplikacije</div>';
}
?>