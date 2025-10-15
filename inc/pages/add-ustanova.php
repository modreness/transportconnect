<?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
<form action="" method="post">
<div class="content">
    
    <div class="form-wrap">
        <div class="form">
                 <div class="bigfield">
                    <h2>Dodaj novu obrazovnu ustanovu</h2>
                </div>
                <div class="smallfield">
                    <select name="vrsta" class="lista">
                        <option value="" disabled selected>Izaberi vrstu</option>
                        <option value="Osnovna škola">Osnovna škola</option>
                        <option value="Srednja škola">Srednja škola</option>
                    </select>
                </div>
                <div class="smallfield">
                    <select name="tip" class="lista">
                        <option value="" disabled selected>Izaberi NPP</option>
                        <option value="Bosanski jezik">Hrvatski jezik</option>
                        <option value="Hrvatski jezik">Bosanski jezik</option>
                    </select>
                </div>
                <div class="bigfield">
                    <input type="text" id="naziv_ustanove" name="naziv_ustanove" required placeholder="Naziv ustanove">
                </div>
                <div class="smallfield">
                    <select class="lista" name="mjesto" required>
                        <option value="" disabled selected>Odaberite mjesto</option>
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
                    <input type="text" id="telefon" name="telefon" required placeholder="Telefon">
                </div>
                <div class="smallfield">
                    <input type="text" id="fax" name="fax" required placeholder="Fax">
                </div>
                 <div class="smallfield">
                    <input type="text" id="email" name="email" required placeholder="E-mail">
                </div>
                <div class="smallfield">
                    
                    <input type="text" id="ravnatelj" name="ravnatelj" required placeholder="Ravnatelj/Direktor">    
                </div>
                <div class="smallfield">
                    
                    <input type="text" id="mobitel_ravnatelja" name="mobitel_ravnatelja" required placeholder="Broj mobitela od ravnatelja/direktora">
                </div>
                
        </div>
    </div>
    <div class="form-wrap">
        <div class="xsfield btn-margin">
                 <input type="submit" name="dodajustanovu" class="button" value="Dodaj ustanovu">  
        </div>
    </div>
</div>
</form>
<?php } else {
    echo '<div class="greska">Nemate ovla分tenje za pristup ovom dijelu aplikacije</div>';
}
?>