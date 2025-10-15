<?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 0) { ?>
<form action="" method="post" enctype="multipart/form-data">
<div class="content">
    <div class="form-wrap">
        <div class="form">
                <div class="smallfield">
                    <label for="skolska_godina">Školska godina</label>
                     <select name="skolska_godina" class="lista" id="skolska_godina" onchange="calculateIznos()">
                        <option value="" selected disabled>Izaberi školsku godinu</option>
                        <?php foreach ($skolskegodine as $skg) { ?>
                        <option value="<?php echo $skg['id_godine']; ?>" data-cijena="<?php echo $skg['cijena_po_km']; ?>"><?php echo $skg['skolska_godina']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="bigfield">
                    <h2>Osnovni podaci o učeniku</h2>
                </div>
                <div class="smallfield">
                    <input type="text" id="ime" name="ime_ucenika" required placeholder="Ime">
                </div>
                <div class="smallfield">
                    <input type="text" id="prezime" name="prezime_ucenika" required placeholder="Prezime">
                </div>
                <div class="smallfield">
                    <input type="text" id="ime_oca" name="ime_oca" required placeholder="Ime oca">
                </div>
                <div class="smallfield">
                    <input type="text" id="ime_majke" name="ime_majke" required placeholder="Ime majke">
                </div>
                <div class="smallfield">
                    <input type="text" id="prezime_majke" name="prezime_majke" required placeholder="Prezime majke">
                </div>
                <div class="smallfield">
                    <input type="text" id="jmbg" name="jmbg" required placeholder="JMBG učenika">
                </div>
                <div class="smallfield">
                    <label for="datum_rodjenja">Datum rođenja</label>
                    <input type="date" id="datum_rodjenja" name="datum_rodjenja" required placeholder="Datum rođenja">
                </div>
                <div class="smallfield">
                    <label for="spol">Izaberi spol</label>
                     <select name="spol" class="lista">
                        <option value="" selected disabled>Spol</option>
                        <option value="Muški">Muški</option>
                        <option value="Ženski">Ženski</option>
                    </select>
                </div>
                <div class="bigfield">
                    <input type="text" id="adresa_stanovanja" name="adresa_stanovanja" required placeholder="Adresa stanovanja">
                </div>
                <div class="smallfield">
                    <input type="text" id="mjesto_stanovanja" name="mjesto_stanovanja" required placeholder="Mjesto stanovanja">
                </div>
                <div class="bigfield">
                    <div class="smallfield">
                         <div class="smallfield">
                            <input type="text" id="razred" name="razred" required placeholder="Razred">
                        </div>
                    </div>
                </div>
                <div class="bigfield">
                    <div class="smallfield">
                         <div class="smallfield">
                            <input type="number" id="udaljenost" name="udaljenost" required placeholder="Udaljenost do škole" oninput="calculateIznos()">
                        </div>
                    </div>
                </div>
                <div class="bigfield">
                    <div class="smallfield">
                         <div class="smallfield">
                            <input type="text" id="iznos" name="iznos" required placeholder="Iznos" >
                        </div>
                    </div>
                </div>
                <div class="bigfield">
                    <h2>Bankovni račun</h2>
                </div>
                <div class="smallfield">
                     <input type="text" id="banka" name="banka" required placeholder="Naziv banke">
                </div>
                <div class="smallfield">
                    <input type="text" id="ziro_racun" name="ziro_racun" required placeholder="Broj tekućeg računa">
                </div>
                
                
        </div>
            

       
   
</div><input type="hidden" name="ustanova" value="<?php echo $korisnik['ustanova_id'];?>">
<input type="hidden" name="status_uplate" value="0">
<input type="hidden" name="status" value="0">
<input type="hidden" name="napomena" value="">

            <div class="smallfield btn-margin"><div class="smallfield"><input type="submit" name="dodajucenika" class="button" value="Spremi"></div></div>
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
    echo '<div class="greska">Unos učenika mogu vršiti isključivo ovlaštene osobe u obrazovnim ustanovama.</div>';
}
?>