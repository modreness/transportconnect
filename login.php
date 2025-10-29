<?php 
session_start();

// Provjeri je li korisnik već prijavljen
if (isset($_SESSION["email"])) {
    // Ako je korisnik već prijavljen, provjeri da li je administrator
    if (isset($_SESSION["administrator"]) && $_SESSION["administrator"] == 1 || $_SESSION['administrator'] == 2) {
        header("Location: dashboard.php");
    } else {
        header("Location: dashboard.php?action=lista");
    }
    exit;
}
ob_start();
require_once "inc/functions.php";


?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Prijava u sistem - Aplikacija za prevoz učenika" />
    <title>MOZKS KSB - Aplikacija za prevoz učenika</title>
    <link rel="stylesheet" href="css/login.css">
   <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <div class="forma forma-login">
            <div class="logo">
                <a href="/"><img src="img/logo.png" alt="Logo"></a>
            </div>
            
            <div class="login-form">
                <?php if (isset($_GET['status']) && $_GET['status'] === 'odjavljen') {
                    echo '<div class="info">
                    <center>Uspješno ste odjavljeni iz aplikacije. Molimo prijavite se ponovo</center>
                </div>';
                } 
                ?>
                <?php if (isset($_GET['prijava']) && $_GET['prijava'] === 'greska') {
                    echo '<div class="greska">
                    <center>Neispravni pristupni podaci.</center>
                </div>';
                } 
                ?>
                <?php if (isset($_GET['status']) && $_GET['status'] === 'lozinka-izmjenjena') {
                    echo '<div class="uspjesno">
                    <center>Uspješno ste izmjenili lozinku. Prijavite se ponovo sa lozinkom koju ste postavili.</center>
                </div>';
                } 
                ?>
                
                <?php if (isset($_GET['profil']) && $_GET['profil'] === 'uredi' && isset($_GET['status']) && $_GET['status'] === 'azurirano') {
                    echo '<div class="uspjesno">
                    <center>Uspješno ste izmjenili podatke. Prijavite se ponovo.</center>
                </div>';
                } 
                ?>
                <h2>Prevoz učenika SBK/KSB</h2>
                <p>Prijava u sistem</p>
               
                
                <form action="inc/login" method="POST">
                <div class="login-container">
                    
                    <div class="username">
                      <input type="text" name="email" placeholder="E-mail adresa" required>
                    </div>
                    <div class="password">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="loginbtn">
                        
                    <input type="submit" value="Prijava" class="submit-btn">
                    
                    </div>
                      
                </div>
                </form>
                
            </div>
            
        </div>
        <?php include('inc/footer.php');?>
    </div>
</body>
</html>
