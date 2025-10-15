<?php 
ob_start();
session_start();
require_once "inc/functions.php";
checklogin();
include('inc/actions.php');
include('inc/header.php');
$userid = $_SESSION['user_id'];
$currentPage = basename($_SERVER['PHP_SELF']);
$korisnik = korisnikpodaci();
$detaljikorisnika = detaljiKorisnika();
$users = userlist();
$skolskegodine = listaSkGod();
$detaljiskgod = detaljiSkGod();
$ustanove = listaUstanova();
$detaljiustanove = detaljiUstanove();
$ustanovalistaucenika = listaUcenikaUstanove();
$korisniklistaucenika = listaUcenikaKorisnika();
$detaljiucenika = detaljiUcenika();
$obavjestenja = listaObavjestenja();
$obavjestenjauser = listaObavjestenjaUnositelj();
$detaljiobavjestenja = detaljiObavjestenja();

$skoleosbh = skoleOSBH();
$skoleoshr = skoleOSHR();
$skolesrhr = skoleSRHR();
$skolesrbh = skoleSRBH();

$rownum = 1;
?>

<body>
    <div class="main-wrapper">
         <?php include('inc/sidebar.php');?>
        <div class="main-content">
            <?php include('inc/topbar.php');?> 
            
            <?php include('inc/notifications.php');?>
            
            <?php include('inc/obavijesti.php');?>
            
            <?php 
            if (isset($_GET['action']) && $_GET['action'] == 'dodaj') {
                include ('inc/pages/add.php');
            }
            elseif (isset($_GET['action']) && $_GET['action'] == 'list') {
                include ('inc/pages/list.php');
            }
            elseif (isset($_GET['action']) && $_GET['action'] == 'ucenik') {
                include ('inc/pages/ucenik.php');
            }
            elseif (isset($_GET['action']) && $_GET['action'] == 'pretraga') {
                include ('inc/pages/pretraga.php');
            }
            elseif (isset($_GET['action']) && $_GET['action'] == 'users') {
                include ('inc/pages/users.php');
            }
            elseif (isset($_GET['action']) && $_GET['action'] == 'ustanove') {
                include ('inc/pages/ustanove.php');
            }
            elseif (isset($_GET['action']) && $_GET['action'] == 'skolska-godina') {
                include ('inc/pages/skg.php');
            }
            elseif (isset($_GET['action']) && $_GET['action'] == 'obavjestenja') {
                include ('inc/pages/obavjestenja.php');
            }
            elseif (isset($_GET['profil']) && $_GET['profil'] == 'password') {
                include ('inc/pages/izmjenapw.php');
            }
            elseif (isset($_GET['profil']) && $_GET['profil'] == 'edit') {
                include ('inc/pages/editprofile.php');
            }
            elseif (isset($_GET['profil']) && $_GET['profil'] == 'new') {
                include ('inc/pages/add-user.php');
            }
            elseif (isset($_GET['ustanova']) && $_GET['ustanova'] == 'new') {
                include ('inc/pages/add-ustanova.php');
            }
            else {
                include ('inc/pages/list.php');
            }
            ?>
        </div>
    </div>
<script>
    $(document).ready(function() {
    $('.lista').select2();
});


<?php include('js/tables.js');?>
</script>
</body>
</html>