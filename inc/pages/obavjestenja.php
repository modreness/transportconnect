<?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
<div class="content">
    
    <div class="content-wrap">
        <div class="content-left">
        <div class="bigfield"><h2>Obavještenja</h2></div>
        <div class="tabela tabela-obavjestenja">
        <table id="tabelamoduli" class="hover row-border no-wrap responsive" style="width:100%;">
            <thead>
            <tr>
                <th>Datum</th>
                <th>Obavještenje</th>
                <th>Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($obavjestenja as $obv) {?>
                  <tr>
                    <td><?php echo date('d.m.Y \u H:i', strtotime($obv['datum'])); ?></td>
                    <td><h3><?php echo $obv['naslov'];?></h3>
                    <p><?php echo $obv['poruka'];?></p></td>
                    </td>
                    <td><?php if (!empty($obv['status']) && $obv['status'] == 1) {
                        echo 'Aktivno';
                        } else { 
                            echo 'Nije aktivno';
                        }
                        ?></td>
                    <td><a href="dashboard.php?action=obavjestenja&obv=edit&id=<?php echo $obv['id_obavjestenja'];?>"><i class="fas fa-pen"></i></a> <a href="dashboard.php?action=obavjestenja&obv=del&id=<?php echo $obv['id_obavjestenja'];?>"><i class="fas fa-trash"></i></a></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
        </div>
        </div>
        
        <!--EDIT-->
        <?php  
        if (isset($_GET['action']) && $_GET['action'] == 'obavjestenja' && isset($_GET['obv']) && $_GET['obv'] == 'edit') {?>
        <form action="" method="post">
        <div class="content-right">
                <div class="form">
                <div class="bigfield">
                    <h2>Uredi obavještenje: <?php echo $detaljiobavjestenja['id_obavjestenja'];?></h2>
                </div>
                 
                <div class="bigfield">
                    <input type="text" id="naslov" name="naslov" required placeholder="Naslov obavijesti" value="<?php echo $detaljiobavjestenja['naslov'];?>">
                </div>
                <div class="bigfield">
                    <label for="poruka">Poruka:</label>
                        <textarea name="poruka" rows="6"><?php echo $detaljiobavjestenja['poruka'];?></textarea>
                </div>
                <div class="bigfield">
                    <select name="aktivno" class="lista">
                            <option value="1" <?php if ($detaljiobavjestenja['status'] == 1) echo 'selected'; ?>>Aktivno</option>
                            <option value="0" <?php if ($detaljiobavjestenja['status'] == 0) echo 'selected'; ?>>Nije aktivno</option>
                        </select>
                </div>
                
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_obavjestenja" value="<?php echo $detaljiobavjestenja['id_obavjestenja']; ?>">
                    <input type="submit" name="urediobavjestenje" class="button" value="Spremi izmjene">  
                </div>
        </div>
        </form>
        <!--DELETE-->
        <?php }
        elseif (isset($_GET['action']) && $_GET['action'] == 'obavjestenja' && isset($_GET['obv']) && $_GET['obv'] == 'del') {?>
        <form action="" method="post">
        <div class="content-right">
                <div class="form">
                <div class="bigfield">
                    <h2>Brisanje obavještenja: <br><?php echo $detaljiobavjestenja['naslov'];?></h2>
                    <p>Jeste li sigurni da želite obrisati obavještenje? </p>
                </div>
                </div>
                <div class="form-wrap">
                    <input type="hidden" name="id_obavjestenja" value="<?php echo $detaljiobavjestenja['id_obavjestenja']; ?>">
                    <input type="submit" name="obrisiobavjestenje" class="button-red" value="Obriši obavijest">  
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
                    <h2>Dodaj novu obavijest</h2>
                </div>
                 
                <div class="bigfield">
                    <input type="text" id="naslov" name="naslov" required placeholder="Naslov obavijesti">
                </div>
                <div class="bigfield">
                    <label for="poruka">Poruka:</label>
                        <textarea name="poruka" rows="6"></textarea>
                </div>
                
                <div class="bigfield">
                    <select name="aktivno" class="lista">
                        <option value="" selected disabled>Status</option>
                        <option value="1">Aktivno</option>
                        <option value="0">Nije aktivno</option>
                    </select>
                </div>
                </div>
                <div class="form-wrap">
                    <input type="submit" name="dodajobavjestenje" class="button" value="Kreiraj obavijest">  
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