<?php if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
<form action="" method="post">
<div class="content">
    
    <div class="form-wrap">
        <div class="form">
                 <div class="bigfield">
                    <h2>Dodaj unositelja/administratora</h2>
                </div>
                <div class="smallfield">
                    <input type="text" id="ime" name="ime" required placeholder="Ime">
                </div>
                <div class="smallfield">
                    <input type="text" id="prezime" name="prezime" required placeholder="Prezime">
                </div>
                <div class="smallfield">
                    <input type="text" id="email" name="email" required placeholder="E-mail">
                </div>
                <div class="smallfield">
                    <input type="text" id="telefon" name="telefon" required placeholder="Telefon">
                </div>
                <div class="smallfield">
                    
                    <select class="lista" name="ustanova" required>
                        <option value="" disabled selected>Obrazovna ustanova</option>
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
                    
                    <input type="password" id="password" name="password" required placeholder="Lozinka">
                </div>
                <div class="smallfield">
                    <select name="administrator" class="lista">
                        <option value="0">Unositelj</option>
                        <option value="1">Administrator</option>
                        <?php
                        if (isset($_SESSION['administrator']) && $_SESSION['administrator'] == 2) {
                            echo '<option value="2">Super administrator</option>';
                        }
                        ?>
                    </select>
                </div>
        </div>
    </div>
    <div class="form-wrap">
        <div class="xsfield btn-margin">
                 <input type="submit" name="dodajkorisnika" class="button" value="Dodaj korisnika">  
        </div>
    </div>
</div>
</form>
<?php } else {
    echo '<div class="greska">Nemate ovla分tenje za pristup ovom dijelu aplikacije</div>';
}
?>