<div class="main-content-traka">
                <div class="welcome">
                <?php
            $ime = $korisnik['ime'] .' '. $korisnik['prezime'];
            $email = $korisnik['email'];
            echo "Prijavljen: " . $ime ." (".$email.")";
            ?>
                </div>

                <div class="loged-user">
                    <a class="user-account" href="dashboard.php?profil=edit">
                        <i class="fas fa-user-cog"></i>Postavke profila
                    </a>
                    <a class="user-account" href="dashboard.php?profil=password">
                        <i class="fas fa-key"></i>Izmjena lozinke
                    </a>
                </div>

                <div class="logout">
                    <a href="inc/login.php?action=odjava" class="user-logout">
                        <i class="fas fa-sign-out-alt"></i>Odjava
                    </a>
                </div>
            </div>