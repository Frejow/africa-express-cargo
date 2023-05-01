<?php

// Récupération des données envoyées par l'utilisateur
$search_terms = $_POST['search_terms'];

// Connexion à la base de données
$pdo = new PDO ('mysql:host=nom_du_serveur;dbname=nom_de_la_base_de_donnees', 'nom_utilisateur', 'mot_de_passe');

// Préparation de la requête SQL avec une clause LIKE pour chaque caractère entré par l'utilisateur
$sql = "SELECT nom, prenom FROM employes WHERE ";
$search_terms_array = str_split($search_terms);
$search_terms_count = count($search_terms_array);
for ($i = 0; $i < $search_terms_count; $i++) {
    $sql .= "prenom LIKE '%" . $search_terms_array[$i] . "%'";
    if ($i != $search_terms_count - 1) {
        $sql .= " AND ";
    }
}

// Exécution de la requête préparée
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Récupération des résultats
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

function packages_list($page = 1, $packages_nb_per_page = 10, $status = 'undefined', $search = 'undefined')
{

    $packages_list = [];

    $database = _database_login();

    if ($status === 'undefined' && $search === 'undefined') {

        $request = "SELECT * FROM package ORDER BY id DESC LIMIT " . ($page - 1) * $packages_nb_per_page . ", " . $packages_nb_per_page * $page;

        $request_prepare = $database->prepare($request);
    
        $request_execution = $request_prepare->execute();

    } elseif ($status !== 'undefined' && $search === 'undefined') {

        $request = "SELECT * FROM package WHERE status = :status ORDER BY id DESC LIMIT " . ($page - 1) * $packages_nb_per_page . ", " . $packages_nb_per_page * $page;

        $request_prepare = $database->prepare($request);
    
        $request_execution = $request_prepare->execute([
            'status' => $status,
        ]);

    } elseif ($status === 'undefined' && $search !== 'undefined') {

        $request = "SELECT * FROM package WHERE ";

        $search_terms_array = str_split($search);

        $search_terms_count = count($search_terms_array);

        for ($i = 0; $i < $search_terms_count; $i++) {
            $request .= "tracking_number LIKE '%" . $search_terms_array[$i] . "%'";
            if ($i != $search_terms_count - 1) {
                $request .= " AND ";
            }
        }
        $request .= " ORDER BY id DESC LIMIT " . ($page - 1) * $packages_nb_per_page . ", " . $packages_nb_per_page * $page;

        $request_prepare = $database->prepare($request);
    
        $request_execution = $request_prepare->execute();

    } elseif ($status !== 'undefined' && $search !== 'undefined') {

        $request = "SELECT * FROM package WHERE ";

        $search_terms_array = str_split($search);

        $search_terms_count = count($search_terms_array);

        for ($i = 0; $i < $search_terms_count; $i++) {
            $request .= "tracking_number LIKE '%" . $search_terms_array[$i] . "%'";
            if ($i != $search_terms_count - 1) {
                $request .= " AND ";
            }
        }
        $request .= " AND status = :status ORDER BY id DESC LIMIT " . ($page - 1) * $packages_nb_per_page . ", " . $packages_nb_per_page * $page;

        $request_prepare = $database->prepare($request);
    
        $request_execution = $request_prepare->execute([
            'status' => $status,
        ]);
    }

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $packages_list = $data;
        }
    }

    return $packages_list;
}


function _packages_list($page = 1, $packages_nb_per_page = 10, $status = 'undefined')
{

    $packages_list = [];

    $database = _database_login();

    if ($status === 'undefined') {
        $request = "SELECT * FROM package ORDER BY id DESC LIMIT " . ($page - 1) * $packages_nb_per_page . ", " . $packages_nb_per_page * $page;

        $request_prepare = $database->prepare($request);
    
        $request_execution = $request_prepare->execute();
    } else {
        $request = "SELECT * FROM package WHERE status = :status ORDER BY id DESC LIMIT " . ($page - 1) * $packages_nb_per_page . ", " . $packages_nb_per_page * $page;

        $request_prepare = $database->prepare($request);
    
        $request_execution = $request_prepare->execute([
            'status' => $status,
        ]);
    }

    if ($request_execution) {

        $data = $request_prepare->fetchAll(PDO::FETCH_ASSOC);

        if (isset($data) && !empty($data) && is_array($data)) {

            $packages_list = $data;
        }
    }

    return $packages_list;
}