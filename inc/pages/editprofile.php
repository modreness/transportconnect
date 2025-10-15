<form action="" method="post" enctype="multipart/form-data">
<div class="content">
    
    <div class="form-wrap">
        <div class="form">
                 <div class="bigfield">
                    <h2>Uredi profil</h2>
                    <p>Ime i prezime nije moguće promjeniti, moguće je promjeniti e-mail, korisničko ime i kontakt telefon. Nakon što izmjenite email adresu za prijavu je potrebno koristiti nove podatke koje ste postavili.</p>
                </div>
                <div class="smallfield">
                    <input type="text" id="ime" name="ime" required placeholder="Ime" value="<?php echo $korisnik['ime'];?>" readonly>
                </div>
                <div class="smallfield">
                    <input type="text" id="prezime" name="prezime" required placeholder="Prezime" value="<?php echo $korisnik['prezime'];?>" readonly>
                </div>
                <div class="smallfield">
                    <input type="text" id="email" name="email" required placeholder="E-mail" value="<?php echo $korisnik['email'];?>">
                </div>
                <div class="smallfield">
                    <input type="text" id="telefon" name="telefon" required placeholder="Telefon" value="<?php echo $korisnik['telefon'];?>">
                </div>
                
        </div>
    </div>
    <div class="form-wrap">
        <div class="xsfield btn-margin">
             <input type="hidden" name="id_korisnika" value="<?php echo $korisnik['user_id']; ?>">
                 <input type="submit" name="urediprofil" class="button" value="Spremi izmjene">  
        </div>
    </div>
</div>
</form>