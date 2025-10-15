<div class="sidebar">
            
            <a href="/"><img class="logo" src="img/logowhite.png"></a>

            <div class="izbornik-wrapper">
                <h2>Izbornik</h2>

                <div class="izbornik-content">
                    <ul class="izbornik-stavke">
                         
                        <li <?php echo (isset($_GET['action']) && $_GET['action'] === 'pretraga') ? 'class="active"' : ''; ?>><a href="dashboard.php?action=pretraga">
                            <i class="fas fa-search"></i>
                            Pretraga</a></li>
                        
                         <?php if ($_SESSION['administrator'] == 0) { ?>
                        <li <?php echo (isset($_GET['action']) && $_GET['action'] === 'dodaj') ? 'class="active"' : ''; ?>><a href="dashboard.php?action=dodaj"><i class="fas fa-user-plus"></i>
                            Dodaj učenika</a></li>
                        <?php }?> 
                        <li <?php echo (isset($_GET['action']) && $_GET['action'] === 'lista') ? 'class="active"' : ''; ?>><a href="dashboard.php?action=lista"><i class="fas fa-address-book"></i>
                            Spiskovi učenika</a></li>
                           
                         <?php if ($_SESSION['administrator'] == 1 || $_SESSION['administrator'] == 2) { ?>
                        <li <?php echo (isset($_GET['action']) && $_GET['action'] === 'skolska-godina') ? 'class="active"' : ''; ?>><a href="dashboard.php?action=skolska-godina"><i class="fas fa-calendar"></i>
                        Školske godine</a></li>
                        <li <?php echo (isset($_GET['action']) && $_GET['action'] === 'ustanove') ? 'class="active"' : ''; ?>><a href="dashboard.php?action=ustanove"><i class="fas fa-graduation-cap"></i>
                        Obrazovne ustanove</a></li>
                        <li <?php echo (isset($_GET['action']) && $_GET['action'] === 'users') ? 'class="active"' : ''; ?>><a href="dashboard.php?action=users"><i class="fas fa-user-lock"></i>
                        Administratori</a></li>
                        <li <?php echo (isset($_GET['action']) && $_GET['action'] === 'obavjestenja') ? 'class="active"' : ''; ?>><a href="dashboard.php?action=obavjestenja"><i class="fas fa-bell"></i>
                        Obavještenja</a></li>
                        <li><a href="inc/backup.php"><i class="fas fa-database"></i>
                        Backup</a></li>
                        <li><a href="https://ticket.galopdigital.com/mozksksb"><i class="fas fa-question"></i>
                        Podrška</a></li>
                        <?php }?>
                        
                        
                    </ul>
                   
                </div>
            </div>
        </div>