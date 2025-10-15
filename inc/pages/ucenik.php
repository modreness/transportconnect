
<div class="content">
    
    <div class="content-wrap">
        
        <?php  
        if (isset($_GET['action']) && $_GET['action'] == 'ucenik' && isset($_GET['do']) && $_GET['do'] == 'status') {?>
        <?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
        <form action="" method="post">
            <div class="content-left">
                <div class="bigfield">
                    <h2>Status odobrenja naknade za učenika ID broj: <?php echo $detaljiucenika['id_ucenika'];?></h2>
                </div>
                <div class="predmet-wrap">
                    <div class="predmet-details">
                        
                        <h3><?php echo $detaljiucenika['ime_ucenika'].' '.$detaljiucenika['prezime_ucenika'];?>
                    </h3>
                    <p>JMBG: <?php echo $detaljiucenika['jmbg'];?></p>
                    <p>Adresa i mjesto stanovanja: <?php echo $detaljiucenika['adresa_stanovanja'].', '.$detaljiucenika['mjesto_stanovanja'];?></p>
                    <h4><?php echo $detaljiucenika['naziv_ustanove'].', '.$detaljiucenika['mjesto'];?>
                    </h4>
                    <p><?php echo $detaljiucenika['vrsta'];?>, nastavni plan i program realizuje na <?php if ($detaljiucenika['npp'] == 'Hrvatski jezik') { echo 'hrvatskom jeziku'; } elseif ($detaljiucenika['npp'] == 'Bosanski jezik') { echo 'bosanskom jeziku'; 
                        }?>
                    </p>
                    <p>Udaljenost do škole: <?php echo $detaljiucenika['udaljenost_do_skole'].' km';?></p>
                    <p>Iznos: <?php $iznos=$detaljiucenika['iznos']; 
                    echo number_format((float)$iznos, 2, '.', '').' KM';?></p>
                    </div>
                    
                    
                </div>
                <div class="form">
                     <div class="xsfield">
                         <label for="status">Izaberi status</label>
                        <select name="status" class="lista">
                            <option value="0" <?php if ($detaljiucenika['status'] == 0) echo 'selected'; ?>>Naknada nije odobrena</option>
                            <option value="1" <?php if ($detaljiucenika['status'] == 1) echo 'selected'; ?>>Naknada odobrena</option>
                        </select>
                    </div>
                    <div class="bigfield">
                        <label for="napomena">Napomena:</label>
                        <textarea name="napomena" rows="6"><?php echo $detaljiucenika['napomena'];?></textarea>
                    </div>
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_ucenika" value="<?php echo $detaljiucenika['id_ucenika']; ?>">
                    <div class="smallfield">
                        <input type="submit" name="izmjenistatus" class="button" value="Spremi izmjene">  
                        <a class="backdugme" href="dashboard.php?action=ucenik&id=<?php echo $detaljiucenika['id_ucenika'];?>">Nazad</a>
                    </div>
                </div>
            </div>
        </form>
        <?php } else {
        echo 'Nemate ovlaštenje za pristup ovom dijelu aplikacije';
        } ?>
        <?php }
        elseif (isset($_GET['action']) && $_GET['action'] == 'ucenik' && isset($_GET['do']) && $_GET['do'] == 'status-uplate') {?>
        <?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
        <form action="" method="post">
            <div class="content-left">
                <div class="bigfield">
                    <h2>Status odobrenja naknade za učenika ID broj: <?php echo $detaljiucenika['id_ucenika'];?></h2>
                </div>
                <div class="predmet-wrap">
                    <div class="predmet-details">
                        
                        <h3><?php echo $detaljiucenika['ime_ucenika'].' '.$detaljiucenika['prezime_ucenika'];?>
                    </h3>
                    <p>JMBG: <?php echo $detaljiucenika['jmbg'];?></p>
                    <p>Adresa i mjesto stanovanja: <?php echo $detaljiucenika['adresa_stanovanja'].', '.$detaljiucenika['mjesto_stanovanja'];?></p>
                    <h4><?php echo $detaljiucenika['naziv_ustanove'].', '.$detaljiucenika['mjesto'];?>
                    </h4>
                    <p><?php echo $detaljiucenika['vrsta'];?>, nastavni plan i program realizuje na <?php if ($detaljiucenika['npp'] == 'Hrvatski jezik') { echo 'hrvatskom jeziku'; } elseif ($detaljiucenika['npp'] == 'Bosanski jezik') { echo 'bosanskom jeziku'; 
                        }?>
                    </p>
                    <p>Udaljenost do škole: <?php echo $detaljiucenika['udaljenost_do_skole'].' km';?></p>
                    <p>Iznos: <?php $iznos=$detaljiucenika['iznos']; 
                    echo number_format((float)$iznos, 2, '.', '').' KM';?></p>
                    </div>
                    
                    
                </div>
                <div class="form">
                     <div class="xsfield">
                         <label for="status_uplate">Izaberi status uplate</label>
                        <select name="status_uplate" class="lista">
                            <option value="0" <?php if ($detaljiucenika['status_uplate'] == 0) echo 'selected'; ?>>Nije uplaćeno</option>
                            <option value="1" <?php if ($detaljiucenika['status_uplate'] == 1) echo 'selected'; ?>>Uplaćeno</option>
                        </select>
                    </div>
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_ucenika" value="<?php echo $detaljiucenika['id_ucenika']; ?>">
                    <div class="smallfield">
                        <input type="submit" name="izmjenistatusuplate" class="button" value="Spremi izmjene">  
                        <a class="backdugme" href="dashboard.php?action=ucenik&id=<?php echo $detaljiucenika['id_ucenika'];?>">Nazad</a>
                    </div>
                </div>
            </div>
        </form>
        <?php } else {
        echo 'Nemate ovlaštenje za pristup ovom dijelu aplikacije';
        } ?>
        <?php }
        elseif (isset($_GET['action']) && $_GET['action'] == 'ucenik' && isset($_GET['do']) && $_GET['do'] == 'delete') {?>
        <?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 0 && $_SESSION['ustanova_id'] == $detaljiucenika['ustanova_id']) { ?>
        <form action="" method="post">
            <div class="content-left">
                <div class="bigfield">
                    <h2>Brisanje ucenika iz baze sa ID: <?php echo $detaljiucenika['id_ucenika'];?></h2>
                </div>
                <div class="predmet-wrap">
                    <div class="predmet-details">
                        
                        <h3><?php echo $detaljiucenika['ime_ucenika'].' '.$detaljiucenika['prezime_ucenika'];?>
                    </h3>
                    <p>JMBG: <?php echo $detaljiucenika['jmbg'];?></p>
                    <p>Adresa i mjesto stanovanja: <?php echo $detaljiucenika['adresa_stanovanja'].', '.$detaljiucenika['mjesto_stanovanja'];?></p>
                    <h4><?php echo $detaljiucenika['naziv_ustanove'].', '.$detaljiucenika['mjesto'];?>
                    </h4>
                    <p><?php echo $detaljiucenika['vrsta'];?>, nastavni plan i program realizuje na <?php if ($detaljiucenika['npp'] == 'Hrvatski jezik') { echo 'hrvatskom jeziku'; } elseif ($detaljiucenika['npp'] == 'Bosanski jezik') { echo 'bosanskom jeziku'; 
                        }?>
                    </p>
                    <p>Udaljenost do škole: <?php echo $detaljiucenika['udaljenost_do_skole'].' km';?></p>
                    <p>Iznos: <?php $iznos=$detaljiucenika['iznos']; 
                    echo number_format((float)$iznos, 2, '.', '').' KM';?></p>
                    </div>
                </div>
                <div class="form">
                     <div class="predmet-wrap">
                        <div class="predmet-details">
                            <h4>Jeste li sigurni da želite obrisati učenika sa spiska za školsku godinu <?php echo $detaljiucenika['skolska_godina'];?>?</h4>
                            <p>Ukoliko ste sigurni da želite obrisati učenika (greškom unesen ili sl.) kliknite na dugme ispod. Nakon brisanja radnja se ne može vratiti.</p>
                        </div>
                    </div>
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_ucenika" value="<?php echo $detaljiucenika['id_ucenika']; ?>">
                    <input type="hidden" name="ustanova" value="<?php echo $detaljiucenika['ustanova_id'];?>">
                    <input type="hidden" name="skolska_godina" value="<?php echo $detaljiucenika['id_godine'];?>">
                    <div class="smallfield">
                        <input type="submit" name="obrisiucenika" class="button-red" value="Obriši učenika">  
                    </div>
                </div>
            </div>
        </form>
        <?php } else {
        echo 'Nemate ovlaštenje pristup ovom dijelu aplikacije';
        } ?>
        <?php }
        elseif (isset($_GET['action']) && $_GET['action'] == 'ucenik' && isset($_GET['do']) && $_GET['do'] == 'edit') {?>
        <?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 0 && $_SESSION['ustanova_id'] == $detaljiucenika['ustanova_id']) { ?>
        <form action="" method="post">
            <div class="content-left">
                <div class="bigfield">
                    <h2>Uređivanje podataka o učeniku pod ID brojem: <?php echo $detaljiucenika['id_ucenika'];?></h2>
                </div>
                <div class="form">
                    <div class="smallfield">
                    <label for="skolska_godina">Školska godina</label>
                    <select name="skolska_godina" id="skolska_godina" class="lista" onchange="calculateIznos()">
                        <option value="<?php echo $detaljiucenika['id_godine'];?>" data-cijena="<?php echo $detaljiucenika['cijena_po_km'];?>" selected><?php echo $detaljiucenika['skolska_godina'];?></option>
                        <?php foreach ($skolskegodine as $skg) { ?>
                        <option value="<?php echo $skg['id_godine']; ?>" data-cijena="<?php echo $skg['cijena_po_km']; ?>"><?php echo $skg['skolska_godina']; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                 <div class="bigfield">
                    <h2>Osnovni podaci o učeniku</h2>
                </div>
                
                <div class="smallfield">
                    <input type="text" id="ime" name="ime_ucenika" required placeholder="Ime" value="<?php echo $detaljiucenika['ime_ucenika'];?>">
                </div>
                <div class="smallfield">
                    <input type="text" id="prezime" name="prezime_ucenika" required placeholder="Prezime" value="<?php echo $detaljiucenika['prezime_ucenika'];?>">
                </div>
                <div class="smallfield">
                    <input type="text" id="ime_oca" name="ime_oca" required placeholder="Ime oca" value="<?php echo $detaljiucenika['ime_oca'];?>">
                </div>
                <div class="smallfield">
                    <input type="text" id="ime_majke" name="ime_majke" required placeholder="Ime majke" value="<?php echo $detaljiucenika['ime_majke'];?>">
                </div>
                <div class="smallfield">
                    <input type="text" id="prezime_majke" name="prezime_majke" required placeholder="Prezime majke" value="<?php echo $detaljiucenika['prezime_majke'];?>">
                </div>
                <div class="smallfield">
                    <input type="text" id="jmbg" name="jmbg" required placeholder="JMBG učenika" value="<?php echo $detaljiucenika['jmbg'];?>">
                </div>
                <div class="smallfield">
                    <label for="datum_rodjenja">Datum rođenja</label>
                    <input type="date" id="datum_rodjenja" name="datum_rodjenja" required placeholder="Datum rođenja" value="<?php echo $detaljiucenika['datum_rodjenja'];?>">
                </div>
                <div class="smallfield">
                    <label for="spol">Izaberi spol</label>
                    <select name="spol" class="lista">
                    <option value="Muški" <?php if ($detaljiucenika['spol'] == 'Muški') echo 'selected'; ?>>Muški</option>
                    <option value="Ženski" <?php if ($detaljiucenika['spol'] == 'Ženski') echo 'selected'; ?>>Ženski</option>
                    </select>
                </div>
                <div class="bigfield">
                    <input type="text" id="adresa_stanovanja" name="adresa_stanovanja" required placeholder="Adresa stanovanja" value="<?php echo $detaljiucenika['adresa_stanovanja'];?>">
                </div>
                <div class="smallfield">
                    <input type="text" id="mjesto_stanovanja" name="mjesto_stanovanja" required placeholder="Mjesto stanovanja" value="<?php echo $detaljiucenika['mjesto_stanovanja'];?>">
                </div>
                <div class="bigfield">
                    <div class="smallfield">
                         <div class="smallfield">
                             <label for="razred">Razred</label>
                            <input type="text" id="razred" name="razred" required placeholder="Razred" value="<?php echo $detaljiucenika['razred'];?>">
                        </div>
                    </div>
                </div>
                <div class="bigfield">
                    <div class="smallfield">
                         <div class="smallfield">
                             <label for="udaljenost">Udaljenost u km</label>
                            <input type="number" id="udaljenost" name="udaljenost" required placeholder="Udaljenost do škole" oninput="calculateIznos()" value="<?php echo $detaljiucenika['udaljenost_do_skole'];?>">
                        </div>
                    </div>
                </div>
                <div class="bigfield">
                    <div class="smallfield">
                         <div class="smallfield">
                             <label for="iznos">Iznos u KM</label>
                            <input type="text" id="iznos" name="iznos" required placeholder="Iznos" value="<?php echo $detaljiucenika['iznos'];?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="bigfield">
                    <h2>Bankovni račun</h2>
                </div>
                <div class="smallfield">
                     <input type="text" id="banka" name="banka" required placeholder="Naziv banke" value="<?php echo $detaljiucenika['banka'];?>">
                </div>
                <div class="smallfield">
                    <input type="text" id="ziro_racun" name="ziro_racun" required placeholder="Broj tekućeg računa" value="<?php echo $detaljiucenika['broj_racuna'];?>">
                </div>
        </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_ucenika" value="<?php echo $detaljiucenika['id_ucenika']; ?>">
                    <input type="hidden" name="ustanova" value="<?php echo $detaljiucenika['ustanova_id']; ?>">
                    <div class="smallfield">
                        <input type="submit" name="urediucenika" class="button" value="Spremi izmjene">  
                    </div>
                </div>
            </div>
        </form>
        <script>
            function calculateIznos() {
                var skolskaGodinaSelect = document.getElementById('skolska_godina');
                var selectedOption = skolskaGodinaSelect.options[skolskaGodinaSelect.selectedIndex];
                var cijenaPoKm = selectedOption.getAttribute('data-cijena');
                var udaljenost = document.getElementById('udaljenost').value;
                
                if (cijenaPoKm && udaljenost) {
                    var iznos = cijenaPoKm * udaljenost;
                    document.getElementById('iznos').value = iznos.toFixed(2);
                } else {
                    document.getElementById('iznos').value = '';
                }
            }
        </script>
        <?php } else {
        echo 'Nemate ovlaštenje pristup ovom dijelu aplikacije';
        } ?>
        <?php }
        else { ?>
        <div class="content-left">
            <?php
            // Provjera nivoa administratora
            if ($_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) {
                // Administrator nivo 1 ili 2 - može vidjeti podatke
                $prikaziPodatke = true;
            } elseif ($_SESSION['administrator'] == 0 && $_SESSION['ustanova_id'] == $detaljiucenika['ustanova_id']) {
                // Korisnik nivo 0 - može vidjeti podatke ako je ustanova_id isti
                $prikaziPodatke = true;
            } else {
                // Nije ispunjen nijedan uslov - ne prikazivati podatke
                $prikaziPodatke = false;
            }
        
            if ($prikaziPodatke) { 
            ?>
            <div class="bigfield">
                <h2>Detalji učenika</h2>
            </div>
            <div class="predmet-wrap">
                <div class="predmet-details">
                    <h4><?php echo $detaljiucenika['naziv_ustanove'].', '.$detaljiucenika['mjesto'];?>
                    </h4>
                    <p><?php echo $detaljiucenika['vrsta'];?>, nastavni plan i program realizuje na <?php if ($detaljiucenika['npp'] == 'Hrvatski jezik') { echo 'hrvatskom jeziku'; } elseif ($detaljiucenika['npp'] == 'Bosanski jezik') { echo 'bosanskom jeziku'; 
                        }?></p>
                </div>
                <div class="predmet-flex">
                    <h4>ID broj: <?php echo $detaljiucenika['id_ucenika'];?>
                    </h4>
                    <h4>Spol: <?php echo $detaljiucenika['spol'];?></h4>
                    <h4>Razred: <strong><?php echo $detaljiucenika['razred'];?></strong>
                    </h4>
                    <h4>Školska godina: <?php echo $detaljiucenika['skolska_godina'];?></h4>
                </div>
                <div class="predmet-details">
                    <h3>Ime i prezime: <?php echo $detaljiucenika['ime_ucenika'].' '.$detaljiucenika['prezime_ucenika'];?>
                    </h3>
                    <p>Roditelji: <?php echo $detaljiucenika['ime_oca'].' i '.$detaljiucenika['ime_majke'].' '.$detaljiucenika['prezime_majke'];?></p>
                    <p>Datum rođenja: <?php echo date('d.m.Y', strtotime($detaljiucenika['datum_rodjenja']));?></p>
                    <p>JMBG: <?php echo $detaljiucenika['jmbg'];?></p>
                    <p>Adresa i mjesto stanovanja: <?php echo $detaljiucenika['adresa_stanovanja'].', '.$detaljiucenika['mjesto_stanovanja'];?></p>
                    
                </div>
                <div class="predmet-flex btn-margin">
                    <h4>Podaci za naknadu prevoza</h4>
                </div>
                <div class="predmet-details">
                    <p>Udaljenost do škole: <?php echo $detaljiucenika['udaljenost_do_skole'].' km';?></p>
                    <p>Banka: <?php echo $detaljiucenika['banka'];?></p>
                    <p>Žiro račun: <?php echo $detaljiucenika['broj_racuna'];?></p>
                    <p>Iznos: <?php $iznos=$detaljiucenika['iznos']; 
                    echo number_format((float)$iznos, 2, '.', '').' KM';?></p>
                </div>
                <div class="predmet-flex btn-margin">
                    <h4>Podaci o statusu</h4>
                </div>
                <div class="predmet-details">
                    <p>Naknada odobrena: <strong><?php if ($detaljiucenika['status'] == 1) { echo '<i class="fas fa-check zelena-ikona"></i> Da'; } else { echo '<i class="fas fa-times crvena-ikona"></i> Ne';}?></strong></p>
                    <p>Isplaćeno: <strong><?php if ($detaljiucenika['status_uplate'] == 1) { echo '<i class="fas fa-check zelena-ikona"></i> Da'; } else { echo '<i class="fas fa-times crvena-ikona"></i> Ne';}?></strong></p>
                    <p>Napomena: <?php if (empty($detaljiucenika['napomena'])) { echo '/'; } else { echo $detaljiucenika['napomena']; }?></p>
                    
                </div>
                <div class="predmet-details btn-margin">
                    <p>
                        <em>
                            Datum unosa: <?php echo date('d.m.Y \u H:i:s', strtotime($detaljiucenika['datum_dodavanja'])); ?>
                            <?php if (!empty($detaljiucenika['datum_izmjene_podataka'])) : ?>
                                <br>Posljednja izmjena: <?php echo date('d.m.Y H:i:s', strtotime($detaljiucenika['datum_izmjene_podataka'])); ?>
                            <?php endif; ?>
                        </em>
                    </p>
                </div>
                
                
                <?php if ($_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
                    <a class="dugmecta btn-margin" href="dashboard.php?action=ucenik&do=status&id=<?php echo $detaljiucenika['id_ucenika'];?>">Uredi odobrenje</a>
                    <a class="dugmecta btn-margin left-razmak" href="dashboard.php?action=ucenik&do=status-uplate&id=<?php echo $detaljiucenika['id_ucenika'];?>">Uredi status uplate</a>
                    <?php } 
                    elseif ($_SESSION['administrator'] == 0) { ?>
                    <a class="dugmecta btn-margin left-razmak" href="dashboard.php?action=ucenik&do=edit&id=<?php echo $detaljiucenika['id_ucenika'];?>">Uredi podatke</a>
                    <a class="dugmectared btn-margin left-razmak" href="dashboard.php?action=ucenik&do=delete&id=<?php echo $detaljiucenika['id_ucenika'];?>">Obriši učenika</a>
                    <?php }?>
                <a class="dugmecta btn-margin left-razmak" target="_blank" href="inc/print/print.php?id=<?php echo $detaljiucenika['id_ucenika'];?>">Print</a>
            </div>
            <?php 
            } else {
                echo '<p>Niste ovlašteni za pregledavanje ovih podataka.</p>';
            }
            ?>
        </div>
        <?php } 
        ?>
        
        
    </div>

</div>
