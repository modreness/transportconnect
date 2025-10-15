<?php
if (isset($_GET['action']) && $_GET['action'] == 'lista' && isset($_GET['filter']) && $_GET['filter'] == 'skg' && isset($_GET['ustanova']) && isset($_GET['skg'])) {
    $ustanova = $_GET['ustanova'];
    $skg = $_GET['skg'];

    // Provera da li korisnik ima pristup traženoj ustanovi
    if ($korisnik['ustanova_id'] == $ustanova || $_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) {
        $filter = filterUcenika($ustanova, $skg);
        ?>
        <div class="content">
            <div class="tabela tabela-filter">
            <!-- TABELA -->
            <table id="tabelamoduli" class="hover row-border no-wrap responsive" style="width:100%;">
                <thead>
                <tr>
                    <th>Ime i prezime</th>
                    <th>Spol</th>
                    <th>Roditelji</th>
                    <th>Adresa</th>
                    <th>Mjesto</th>
                    <th>Žiro račun</th>
                    <th>Razred</th>
                    <th>Udaljenost</th>
                    <th>Iznos</th>
                    <th>Odobren</th>
                    <th>Uplaćeno</th>
                    
                </tr>
                </thead>
                <tbody>
                    <?php foreach($filter as $skg) { ?>
                      <tr onclick="window.location.href = 'dashboard.php?action=ucenik&id=<?php echo $skg['id_ucenika'];?>';">
                        
                        <td><?php echo $skg['ime_ucenika'].' '.$skg['prezime_ucenika'].'<br><em>JMBG: '.$skg['jmbg'].'</em>';?></td>
                        <td><?php echo $skg['spol'];?></td>
                        <td><?php echo $skg['ime_oca'].' i '.$skg['ime_majke'].' '.$skg['prezime_majke'];?></td>
                        <td><?php echo $skg['adresa_stanovanja'];?></td>
                       <td><?php echo $skg['mjesto_stanovanja'];?></td>
                       <td><?php echo $skg['banka'].'<br><em> '.$skg['broj_racuna'].'</em>';?></td>
                       <td><?php echo $skg['razred'];?></td>
                       <td><?php echo $skg['udaljenost_do_skole'].' km';?></td>
                       <td><?php $iznos=$skg['iznos'];
                       echo number_format((float)$iznos, 2, '.', '').' KM';?></td>
                       <td><?php if ($skg['status'] == 1) { echo '<i class="fas fa-check zelena-ikona"></i> Da'; } else { echo '<i class="fas fa-times crvena-ikona"></i> Ne';}?></td>
                       <td><?php if ($skg['status_uplate'] == 1) { echo '<i class="fas fa-check zelena-ikona"></i> Da'; } else { echo '<i class="fas fa-times crvena-ikona"></i> Ne';}?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            </div>
        </div>
        <?php 
    } else {
        // Ako korisnik nema pristup, preusmeravamo ga ili prikazujemo poruku o grešci
        echo '<div class="greska">Nemate ovlaštenje za pristup informacijama ove ustanove</div>';
    }
} else { 

if ($_SESSION['administrator'] == 0) { ?>
    <!--FILTER-->
    <form action="" method="post">
        <div class="content">
            <div class="form-wrap">
                <div class="form">
                    <div class="bigfield">
                        <h2><?php echo $korisnik['naziv_ustanove'].', '.$korisnik['mjesto'];?></h2>
                        <p>Vrsta: <?php echo $korisnik['vrsta'];?>, nastavni plan i program realizuje na <?php if ($korisnik['npp'] == 'Hrvatski jezik') { echo 'hrvatskom jeziku'; } elseif ($korisnik['npp'] == 'Bosanski jezik') { echo 'bosanskom jeziku'; 
                        }?></p>
                    </div>
                    <div class="smallfield">
                        <label for="skolska_godina">Školska godina</label>
                         <select name="skolska_godina" class="lista" id="skolska_godina">
                            
                            <?php foreach ($skolskegodine as $skg) { ?>
                            <option value="<?php echo $skg['id_godine']; ?>"><?php echo $skg['skolska_godina']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-wrap">
                <div class="xsfield btn-margin">
                <input type="hidden" name="ustanova" value="<?php echo $korisnik['ustanova_id'];?>">
                 <input type="submit" name="odabirliste" class="button" value="Prikaži spisak">  
            </div>
    </div>
        </div>
    </form>
    <?php } elseif ($_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
    <form action="" method="post">
        <div class="content">
            <div class="form-wrap">
                <div class="form">
                    <div class="bigfield">
                        <h2>Pregled spiskova učenika za naknadu prevoza</h2>
                        <p>Izaberite obrazovnu ustanovu i školsku godinu</p>
                    </div>
                    <div class="smallfield">
                         <select name="skolska_godina" class="lista" id="skolska_godina" required>
                            <option value="" selected disabled>Školska godina</option>
                            <?php foreach ($skolskegodine as $skg) { ?>
                            <option value="<?php echo $skg['id_godine']; ?>"><?php echo $skg['skolska_godina']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="smallfield">
                         <select class="lista" name="ustanova" required>
                        <option value="" disabled selected>Obrazovna ustanova</option>
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
                </div>
            </div>
            <div class="form-wrap">
                <div class="xsfield btn-margin">
                
                 <input type="submit" name="odabirlisteadmin" class="button" value="Prikaži spisak">  
            </div>
    </div>
        </div>
    </form>
    
<?php 
}
} ?>