<?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 0) { ?>
<form action="" method="post" enctype="multipart/form-data">
<div class="content">
<<<<<<< HEAD
  <div class="form-wrap">
    <div class="form">

      <div class="smallfield">
        <label for="skolska_godina">Školska godina</label>
        <select name="skolska_godina" class="lista" id="skolska_godina" required>
          <option value="" selected disabled>Izaberi školsku godinu</option>
          <?php foreach ($skolskegodine as $skg) { ?>
          <option
            value="<?php echo (int)$skg['id_godine']; ?>"
            data-cijena="<?php echo htmlspecialchars($skg['cijena_po_km'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($skg['skolska_godina'], ENT_QUOTES, 'UTF-8'); ?>
          </option>
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
        <input type="text" id="jmbg" name="jmbg" maxlength="13" inputmode="numeric" required placeholder="JMBG učenika">
      </div>

      <div class="smallfield">
        <label for="datum_rodjenja">Datum rođenja</label>
        <input type="date" id="datum_rodjenja" name="datum_rodjenja" required>
      </div>

      <div class="smallfield">
        <label for="spol">Izaberi spol</label>
        <select name="spol" id="spol" class="lista" required>
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
      <div class="smallfield">
        <input type="text" id="razred" name="razred" required placeholder="Razred">
      </div>

      <div class="smallfield">
        <input type="number" id="udaljenost" name="udaljenost" required placeholder="Udaljenost do škole (km)" min="0" step="0.1">
      </div>

      <div class="smallfield">
        <input type="text" id="iznos" name="iznos" required placeholder="Iznos" readonly>
      </div>

      <!-- Podaci za isplatu -->
      <div class="bigfield"><h2>Podaci za isplatu</h2></div>

      <div class="smallfield">
        <input type="text" id="nosilac_racuna" name="nosilac_racuna" placeholder="Nositelj računa" required>
      </div>

      <div class="smallfield">
        <input type="text" id="jmbg_roditelja" name="jmbg_roditelja" maxlength="13" inputmode="numeric" placeholder="JMBG roditelja ili staratelja">
      </div>

      <div class="bigfield"><h2>Bankovni račun</h2></div>
      <div class="smallfield">
        <input type="text" id="banka" name="banka" required placeholder="Naziv banke">
      </div>
      <div class="smallfield">
        <input type="text" id="ziro_racun" name="ziro_racun" maxlength="16" inputmode="numeric" required placeholder="Broj tekućeg računa (16 cifara)">
      </div>

    </div>
  </div>
</div>

<input type="hidden" name="ustanova" value="<?php echo htmlspecialchars((string)$korisnik['ustanova_id'], ENT_QUOTES, 'UTF-8'); ?>">
=======
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
>>>>>>> 4a063e1060e990edc73df0da7d84c2426ab06961
<input type="hidden" name="status_uplate" value="0">
<input type="hidden" name="status" value="0">
<input type="hidden" name="napomena" value="">

<<<<<<< HEAD
<div class="smallfield btn-margin">
  <input type="submit" name="dodajucenika" class="button" value="Spremi">
</div>
</form>

<script>
function toNumber(v){
  v = (v ?? '').toString().trim().replace(',', '.').replace(/[^\d.]/g,'');
  const n = parseFloat(v);
  return Number.isFinite(n) ? n : NaN;
}

function calculateIznos() {
  const sk = document.getElementById('skolska_godina');
  const udal = document.getElementById('udaljenost');
  const iznosEl = document.getElementById('iznos');
  if (!sk || !udal || !iznosEl) return;

  const opt = sk.options[sk.selectedIndex];
  const cijena = opt ? toNumber(opt.getAttribute('data-cijena')) : NaN;
  const km = toNumber(udal.value);

  iznosEl.value = (Number.isFinite(cijena) && Number.isFinite(km)) ? (cijena * km).toFixed(2) : '';
}

// reaguj i na promjenu školske godine i na unos udaljenosti
['change','input'].forEach(evt=>{
  document.getElementById('skolska_godina')?.addEventListener(evt, calculateIznos);
  document.getElementById('udaljenost')?.addEventListener(evt, calculateIznos);
});

// samo cifre za JMBG-e i račun
function onlyDigits(s){ return (s||'').replace(/\D+/g,''); }

document.getElementById('jmbg')?.addEventListener('input', e=>{
  e.target.value = onlyDigits(e.target.value).slice(0,13);
});
document.getElementById('jmbg_roditelja')?.addEventListener('input', e=>{
  e.target.value = onlyDigits(e.target.value).slice(0,13);
});
document.getElementById('ziro_racun')?.addEventListener('input', e=>{
  e.target.value = onlyDigits(e.target.value).slice(0,16);
});
</script>

<?php } else {
  echo '<div class="greska">Unos učenika mogu vršiti isključivo ovlaštene osobe u obrazovnim ustanovama.</div>';
} ?>
=======
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
>>>>>>> 4a063e1060e990edc73df0da7d84c2426ab06961
