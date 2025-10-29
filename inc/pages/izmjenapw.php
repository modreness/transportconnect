<form action="" method="POST">
<div class="content">

<div class="form-wrap">
    <div class="form">
        <div class="bigfield">
            <h2>Izmjena lozinke</h2>
        </div>
         <div class="xsfield">
            <input type="password" name="stari_password" required placeholder="Trenutna lozinka">
        </div>
        <div class="xsfield">
            <input type="password" name="password" required placeholder="Unesi novu lozinku">
        </div>
        <div class="xsfield">
            <input type="password" name="potvrdi_password" required placeholder="Potvrdi novu lozinku">
        </div>
        <input type="hidden" name="id_korisnika" value="<?php echo $korisnik['user_id']; ?>">
         
    </div>
    
</div>
<div class="form-wrap">
    <div class="xsfield btn-margin">
             <input type="submit" name="izmjenalozinke" class="button" value="Spremi izmjene">  
    </div>
</div>
</div> 
</form>