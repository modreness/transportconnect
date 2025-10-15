<?php
session_start();
require_once "functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $enkriptovan = sha1($password);

    // Povezivanje s bazom podataka
    $conn = dbConnect();

    // Provera korisničkih podataka u bazi
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$enkriptovan'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Korisnik je uspešno prijavljen, redirektujte ga na index.php
        $row = $result->fetch_assoc();
        $_SESSION["email"] = $email;
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION['administrator'] = $row["nivo"];
        $_SESSION['ustanova_id'] = $row['ustanova_id'];
        
        // Ažuriranje poslednjeg logiranja u bazi
        $lastLoginTime = date("Y-m-d H:i:s");
        $user_id = $row["user_id"];
        $updateLastLoginSql = "UPDATE users SET lastlogin = '$lastLoginTime' WHERE user_id = '$user_id'";
        $conn->query($updateLastLoginSql);
        
        if ($row["administrator"] == 1 || $row["administrator"] ==2) {
            // Ako je korisnik administrator, redirektujte ga na su-admin.php
            header('Location: ../dashboard.php');
        } else {
            // Ako nije administrator, redirektujte ga na dashboard.php
            header('Location: ../dashboard.php');
        }
        exit;
    } else {
        // Pogrešni podaci za prijavu
        header('Location: ../login.php?prijava=greska');
    }

    $conn->close();
}

if($_GET['action'] == 'odjava') {
    session_unset();
    session_destroy();
    header('Location:../login.php?status=odjavljen');
    }
?>
