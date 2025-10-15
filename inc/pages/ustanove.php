<?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
 <?php  
if (isset($_GET['action']) && $_GET['action'] == 'ustanove' && isset($_GET['ustanova']) && $_GET['ustanova'] == 'view') {
?>
<div class="content">
    <div class="content-wrap">
        <div class="content-left">
            <div class="bigfield">
                <h2>Podaci o obrazovnoj ustanovi</h2>
            </div>
            <div class="predmet-wrap">
                
                <div class="predmet-details">
                    <h3><?php echo $detaljiustanove['naziv_ustanove'];?>
                    </h3>
                    <p>Mjesto: <?php echo $detaljiustanove['mjesto'];?></p>
                    <p>Vrsta: <?php echo $detaljiustanove['vrsta'].' ,NPP: '. $detaljiustanove['npp'];?></p>
                    <p>Ravnatelj/Direktor: <?php echo $detaljiustanove['ravnatelj'];?></p>
                    <p>Mobitel ravnatelja/direktora: <?php echo $detaljiustanove['mobitel_ravnatelja'];?></p>
                    <p>E-mail: <?php echo $detaljiustanove['email_skole'];?></p>
                    <p>Telefon: <?php echo $detaljiustanove['kontakt_tel'];?></p>
                    <p>Fax: <?php echo $detaljiustanove['fax'];?></p>
                </div>
                
                <a class="dugmecta btn-margin left-razmak" href="dashboard.php?action=ustanove&ustanova=edit&idustanove=<?php echo $detaljiustanove['ustanova_id'];?>">Uredi ustanovu</a> 
                    <a class="dugmectared btn-margin left-razmak" href="dashboard.php?action=ustanove&ustanova=delete&idustanove=<?php echo $detaljiustanove['ustanova_id'];?>">Obriši ustanovu</a>
                
                <div class="bigfield btn-margin">
                    <h2>Lista učenika za isplatu prevoza</h2>
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
                        <?php foreach($ustanovalistaucenika as $ucenikpodaci) {?>
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
elseif (isset($_GET['action']) && $_GET['action'] == 'ustanove' && isset($_GET['ustanova']) && $_GET['ustanova'] == 'delete') { 
?>
<div class="content">
    <div class="content-wrap">
      
        <form action="" method="post">
            <div class="content-left">
                <div class="bigfield">
                    <h2>Brisanje ustanove</h2>
                </div>
                <div class="predmet-wrap">
                    <div class="predmet-details">
                        <h4>Ustanova: <strong><?php echo $detaljiustanove['naziv_ustanove'].' NPP: '.$detaljiustanove['npp'];?></strong>
                        </h4>
                    </div>
                    <div class="predmet-flex">
                        <h4>ID ustanove: <?php echo $detaljiustanove['ustanova_id'];?>
                        </h4>
                    </div>
                </div>
                <div class="form">
                     <div class="predmet-wrap">
                        <div class="predmet-details">
                            <h4>Jeste li sigurni da želite obrisati obrazovnu ustanovu iz aplikacije?</h4>
                            <p>Unosi koji su vezani za ovu ustanovu će biti obrisani.</p>
                        </div>
                    </div>
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_ustanove" value="<?php echo $detaljiustanove['ustanova_id']; ?>">
                    <div class="smallfield">
                        <input type="submit" name="obrisiustanovu" class="button-red" value="Obriši ustanovu"> 
                        <a class="backdugme" href="dashboard.php?action=ustanove&ustanova=view&idustanove=<?php echo $detaljiustanove['ustanova_id'];?>">Nazad</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div> 
<?php }
elseif (isset($_GET['action']) && $_GET['action'] == 'ustanove' && isset($_GET['ustanova']) && $_GET['ustanova'] == 'edit') {
?>
<div class="content">
    <div class="content-wrap">
      
            <form action="" method="post">
            <div class="content-left">
                <div class="bigfield">
                    <h2>Uredi obrazovnu ustanovu</h2>
                </div>
                <div class="predmet-wrap">
                    <div class="predmet-details">
                        <h4>Ustanova: <strong><?php echo $detaljiustanove['naziv_ustanove'].', '.$detaljiustanove['mjesto'];?></strong>
                        </h4>
                        <p>Vrsta: <?php echo $detaljiustanove['vrsta'].', NPP: '.$detaljiustanove['npp'];?></p>
                    </div>
                    <div class="predmet-flex">
                        <h4>ID ustanove: <?php echo $detaljiustanove['ustanova_id'];?>
                        </h4>
                    </div>
                </div>
                <div class="form">
                    <div class="smallfield">
                        <select name="vrsta" class="lista">
                            <option value="Osnovna škola" <?php if ($detaljiustanove['vrsta'] == 'Osnovna škola') echo 'selected'; ?>>Osnovna škola</option>
                            <option value="Srednja škola" <?php if ($detaljiustanove['vrsta'] == 'Srednja škola') echo 'selected'; ?>>Srednja škola</option>
                        </select>
                    </div>
                    <div class="smallfield">
                        <select name="npp" class="lista">
                            <option value="Hrvatski jezik" <?php if ($detaljiustanove['npp'] == 'Hrvatski jezik') echo 'selected'; ?>>Hrvatski jezik</option>
                            <option value="Bosanski jezik" <?php if ($detaljiustanove['npp'] == 'Bosanski jezik') echo 'selected'; ?>>Bosanski jezik</option>
                        </select>
                    </div>
                    <div class="bigfield">
                        <input type="text" id="naziv_ustanove" name="naziv_ustanove" value="<?php echo htmlspecialchars($detaljiustanove['naziv_ustanove']);?>" required placeholder="Naziv ustanove">
                    </div>
                    <div class="smallfield">
                        <select class="lista" name="mjesto" required>
                            <option value="<?php echo $detaljiustanove['mjesto'];?>" selected><?php echo $detaljiustanove['mjesto'];?></option>
                            <option value="" disabled>Odaberite mjesto</option>
                            <option value="Općina Travnik">Općina Travnik</option>
                            <option value="Općina Novi Travnik">Općina Novi Travnik</option>
                            <option value="Općina Vitez">Općina Vitez</option>
                            <option value="Općina Bugojno">Općina Bugojno</option>
                            <option value="Općina Jajce">Općina Jajce</option>
                            <option value="Općina Donji Vakuf">Općina Donji Vakuf</option>
                            <option value="Općina G.Vakuf-Uskoplje">Općina G.Vakuf-Uskoplje</option>
                            <option value="Općina Fojnica">Općina Fojnica</option>
                            <option value="Općina Busovača">Općina Busovača</option>
                            <option value="Općina Kiseljak">Općina Kiseljak</option>
                            <option value="Općina Kreševo">Općina Kreševo</option>
                        </select>
                    </div>
                    <div class="smallfield">
                        <input type="text" id="telefon" name="telefon" value="<?php echo $detaljiustanove['kontakt_tel'];?>" required placeholder="Telefon">
                    </div>
                    <div class="smallfield">
                        <input type="text" id="fax" name="fax" required value="<?php echo $detaljiustanove['fax'];?>" placeholder="Fax">
                    </div>
                     <div class="smallfield">
                        <input type="text" id="email" name="email" required value="<?php echo $detaljiustanove['email_skole'];?>" placeholder="E-mail">
                    </div>
                    <div class="smallfield">
                        
                        <input type="text" id="ravnatelj" name="ravnatelj" required value="<?php echo $detaljiustanove['ravnatelj'];?>" placeholder="Ravnatelj/Direktor">    
                    </div>
                    <div class="smallfield">
                        
                        <input type="text" id="mobitel_ravnatelja" name="mobitel_ravnatelja" required value="<?php echo $detaljiustanove['mobitel_ravnatelja'];?>" placeholder="Broj mobitela od ravnatelja/direktora">
                    </div>
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_ustanova" value="<?php echo $detaljiustanove['ustanova_id']; ?>">
                    <div class="smallfield">
                        <input type="submit" name="izmjeniustanovu" class="button" value="Spremi promjenu">  
                        <a class="backdugme" href="dashboard.php?action=ustanove&ustanova=view&idustanove=<?php echo $detaljiustanove['ustanova_id'];?>">Nazad</a>
                    </div>
                    
                </div>
            </div>
        </form>
    </div>
</div>

<?php } 
else { ?>
<div class="content">
    <a href="dashboard?ustanova=new" class="dugmecta">Dodaj ustanovu</a>
    <div class="tabela">
    <table id="tabelausers" class="hover row-border no-wrap responsive" style="width:100%;">
        <thead>
         <tr>
            <th>Tip ustanove</th>
            <th>NPP izvedba:</th>
            <th>Naziv ustanove</th>
            <th>Mjesto</th>
            <th>Ravnatelj/Direktor</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($ustanove as $ustanova) {
            ?>
              <tr onclick="window.location.href = 'dashboard.php?action=ustanove&ustanova=view&idustanove=<?php echo $ustanova['ustanova_id'];?>';">
                <td><?php echo $ustanova['vrsta'];?></td>
                <td><?php echo $ustanova['npp'];?></td>
                <td><?php echo $ustanova['naziv_ustanove'];?></td>
                <td><?php echo $ustanova['mjesto'];?></td>
                <td><?php echo $ustanova['ravnatelj'];?></td>
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