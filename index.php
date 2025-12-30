<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page === "souscrire") {
        include "souscrire.php"; // Load souscrire.php
    } else if ($page === "conditions") {
        include "conditions.php"; // Load conditions.php
    }else if ($page === "identification") {
        include "identification.php"; // Load identification.php
    } else if ($page === "apropos") {
        include "apropos.php"; // Load apropos.php
    } else  if ($page === "type-parcelle") {
        include "type-parcelle.php"; // Load type-parcelle.php
    }else if ($page === "paiement") {
        include "paiement.php"; // Load paiement.php
        
    }
    
    
} else {
   include "home.php";
}
?>


