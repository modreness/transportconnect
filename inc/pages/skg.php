<?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
<div class="content">
    
    <div class="content-wrap">
        <div class="content-left">
        <div class="bigfield"><h2>Školske godine</h2></div>
        <div class="tabela">
        <table id="tabelamoduli" class="hover row-border no-wrap responsive" style="width:100%;">
            <thead>
            <tr>
                <th>R.b.</th>
                <th>Školska godina</th>
                <th>Cijena po km</th>
                <th>Aktivna</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($skolskegodine as $skg) {?>
                  <tr>
                    <td><?php echo $rownum; $rownum++ ?></td>
                    <td><?php echo $skg['skolska_godina'];?></td>
                    </td>
                    <td><?php echo $skg['cijena_po_km'].' KM';?></td>
                    <td><?php if (!empty($skg['aktivno']) && $skg['aktivno'] == 1) {
                        echo 'Da';
                        } else { 
                            echo 'Ne';
                        }
                        ?></td>
                    <td><a href="dashboard.php?action=skolska-godina&skg=edit&id=<?php echo $skg['id_godine'];?>"><i class="fas fa-pen"></i></a> <a href="dashboard.php?action=skolska-godina&skg=del&id=<?php echo $skg['id_godine'];?>"><i class="fas fa-trash"></i></a></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        </div>
        </div>
        
        <!--EDIT-->
        <?php  
        if (isset($_GET['action']) && $_GET['action'] == 'skolska-godina' && isset($_GET['skg']) && $_GET['skg'] == 'edit') {?>
        <form action="" method="post">
        <div class="content-right">
                <div class="form">
                <div class="bigfield">
                    <h2>Uredi školsku godinu: <?php echo $detaljiskgod['skolska_godina'];?></h2>
                </div>
                 <div class="bigfield">
                    <input type="text" id="skolska_godina" name="skolska_godina" required placeholder="npr. 2024/2025" value="<?php echo $detaljiskgod['skolska_godina'];?>">
                </div>
                <div class="bigfield">
                    <label for="cijena_po_km">Cijena po kilometru</label>
                    <input type="text" id="cijena_po_km" name="cijena_po_km" required placeholder="Npr. 2 (samo broj, bez KM)" value="<?php echo $detaljiskgod['cijena_po_km'];?>">
                </div>
                <div class="bigfield">
                    <select name="aktivno" class="lista">
                            <option value="1" <?php if ($detaljiskgod['aktivno'] == 1) echo 'selected'; ?>>Aktivno</option>
                            <option value="0" <?php if ($detaljiskgod['aktivno'] == 0) echo 'selected'; ?>>Nije aktivno</option>
                        </select>
                </div>
                
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_godine" value="<?php echo $detaljiskgod['id_godine']; ?>">
                    <input type="submit" name="urediskgod" class="button" value="Spremi izmjene">  
                </div>
        </div>
        </form>
        <!--DELETE-->
        <?php }
        elseif (isset($_GET['action']) && $_GET['action'] == 'skolska-godina' && isset($_GET['skg']) && $_GET['skg'] == 'del') {?>
        <form action="" method="post">
        <div class="content-right">
                <div class="form">
                <div class="bigfield">
                    <h2>Brisanje školske godine: <br><?php echo $detaljiskgod['skolska_godina'];?></h2>
                    <p>Brisanjem školske godine brišu se i svi unosi učenika za odabranu godinu. </p>
                </div>
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_godine" value="<?php echo $detaljiskgod['id_godine']; ?>">
                    <input type="submit" name="obrisiskgod" class="button-red" value="Obriši godinu">  
                </div>
        </div>
        </form>
        <!--ADD NEW-->
        <?php } 
        else { ?>
        <form action="" method="post">
        <div class="content-right">
                <div class="form">
                <div class="bigfield">
                    <h2>Otvori školsku godinu</h2>
                </div>
                 <div class="bigfield">
                    <input type="text" id="skolska_godina" name="skolska_godina" required placeholder="Npr. 2024/2025">
                </div>
                <div class="bigfield">
                    <label for="cijena_po_km">Cijena po kilometru</label>
                    <input type="text" id="cijena_po_km" name="cijena_po_km" required placeholder="Npr. 2 (samo broj, bez KM)">
                </div>
                <div class="bigfield">
                    <select name="aktivno" class="lista">
                        <option value="" selected disabled>Status</option>
                        <option value="1">Aktivna</option>
                        <option value="0">Nije aktivna</option>
                    </select>
                </div>
                </div>
                <div class="form-wrap">
                    <input type="submit" name="dodajskgod" class="button" value="Kreiraj godinu">  
                </div>
        </div>
        </form>
        <?php } 
        ?>
    </div>

</div>
<?php } else {
    echo '<div class="greska">Nemate ovlaštenje za pristup ovom dijelu aplikacije</div>';
}
?>