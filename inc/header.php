<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="js/script.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!--FONTAWESOME-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <!--DATATABLES-->
    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.js"></script>

    <!--SELECT2-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <?php 
    $title = "MOZMKS KSB - Aplikacija za prevoz učenika";
    if (isset($_GET['action']) && $_GET['action'] == 'lista' && isset($_GET['filter']) && $_GET['filter'] == 'skg' && isset($_GET['ustanova']) && isset($_GET['skg'])) {
        $ustanova = $_GET['ustanova'];
        $skg = $_GET['skg'];
            $nazivUstanove = getNazivUstanove($ustanova);
            $nazivSkolskeGodine = getNazivSkolskeGodine($skg);
            $title = "MOZMKS KSB - " . $nazivUstanove . " - Školska godina " . $nazivSkolskeGodine;
        
    }
    ?>  
    <title><?php echo htmlspecialchars($title); ?></title>
</head>