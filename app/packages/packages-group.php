<?php
//die (var_dump($_POST));
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $rowschecked = [];
    foreach ($_POST as $index => $checked){
        if ($checked){
            $rowsvalues = [
                'N° de suivi' => $_POST['N° de suivi'][$index],
                'Type de produits' => $_POST['Type de produits'][$index],
                'Statut' => $_POST['Statut'][$index],
            ];
            $rowschecked [] = $rowsvalues;
        }
    }
    var_dump($rowschecked);
}