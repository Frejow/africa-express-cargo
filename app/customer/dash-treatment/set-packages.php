<?php

//die (var_dump($_FILES["filesToUpload"]));

$newdata = [];
$error = [];
$updata = [];
$_SESSION['images_errors'] = [];
$_SESSION['success_msg'] = [];


if (isset($_POST['pack_trackN']) && !empty($_POST['pack_trackN'])) {
    $newdata['pack_trackN'] = secure(strtoupper($_POST['pack_trackN']));
    $updata['pack_trackN'] = secure($_POST['pack_trackN']);
} else {
    $newdata['pack_trackN'] = "NULL";
}

if (isset($_POST['pack_count']) && !empty($_POST['pack_count'])) {
    $newdata['pack_count'] = secure($_POST['pack_count']);
    $updata['pack_count'] = secure($_POST['pack_count']);
} else {
    $newdata['pack_count'] = 0;
}

if (isset($_POST['pack_cost']) && !empty($_POST['pack_cost'])) {
    $newdata['pack_cost'] = secure($_POST['pack_cost']);
    $updata['pack_cost'] = secure($_POST['pack_cost']);
} else {
    $newdata['pack_cost'] = 0;
}

if (isset($_POST['pack_descp']) && !empty($_POST['pack_descp'])) {
    $newdata['pack_descp'] = secure($_POST['pack_descp']);
    $updata['pack_descp'] = secure($_POST['pack_descp']);
} else {
    $newdata['pack_descp'] = "NULL";
}

if (isset($_POST['pack_type']) && !empty($_POST['pack_type'])) {
    $newdata['pack_type'] = secure($_POST['pack_type']);
    $updata['pack_type'] = secure($_POST['pack_type']);
} else {
    $newdata['pack_type'] = "NULL";
}

if (isset($_POST['pack_netW']) && !empty($_POST['pack_netW'])) {
    $newdata['pack_netW'] = secure($_POST['pack_netW']);
    $updata['pack_netW'] = secure($_POST['pack_netW']);
} else {
    $newdata['pack_netW'] = 0;
}

if (isset($_POST['pack_metricW']) && !empty($_POST['pack_metricW'])) {
    $newdata['pack_metricW'] = secure($_POST['pack_metricW']);
    $updata['pack_metricW'] = secure($_POST['pack_metricW']);
} else {
    $newdata['pack_metricW'] = 0;
}

if (isset($_FILES["filesToUpload"])) {

    $newdata['images'] = []; 

    foreach ($_FILES["filesToUpload"]['error'] as $key => $value) {

        if ($_FILES["filesToUpload"]['error'][$key] == 0) {

            if ($_FILES["filesToUpload"]["size"][$key] <= 3000000) {

                $file_name = $_FILES["filesToUpload"]["name"][$key];

                $file_info = pathinfo($file_name);

                $file_ext = $file_info["extension"];

                $allowed_ext = ["png", "jpg", "jpeg", "gif"];

                if (in_array($file_ext, $allowed_ext)) {

                    $rootpath = $_SERVER['DOCUMENT_ROOT'] . '/africa-express-cargo/public/images/uploads';

                    $newfolder = $rootpath . '/' . $data[0]['id'] . '/packages/' . $newdata['pack_trackN'] ;

                    if (!file_exists($newfolder)) {

                        mkdir($newfolder, 0700, true);
                    }

                    move_uploaded_file($_FILES['filesToUpload']['tmp_name'][$key], $newfolder . '/' . basename($_FILES['filesToUpload']['name'][$key]));

                    $newdata["images"][$key] = PROJECT . 'public/images/uploads/' . $data[0]['id'] . '/packages/' . $newdata['pack_trackN'] . '/' . basename($_FILES['filesToUpload']['name'][$key]);
                
                } else {

                    $error["images"][$key] = "L'extension du fichier ".$file_name." n'est pas pris en compte. <br> Extensions autorisées [ PNG/JPG/JPEG/GIF ]";

                    $updata['images'] = $file_name;

                }
            } else {

                $file_name = $_FILES["filesToUpload"]["name"][$key]; 

                $error["images"][$key] = "Le fichier ".$file_name." est trop lourd. Poids maximum autorisé : 3mo";

                $updata['images'] = $file_name;

            }
        }
    } //die (var_dump($_FILES["filesToUpload"]["name"]));
} else {
    $newdata['images'] = "NO IMAGES";
}
if (!empty($newdata['images']) && $newdata['images'] != "NULL") {
    $newdata['images'] = implode(' && ', $newdata['images']);
}

if (empty($error)) {

    if (add_package($newdata['pack_trackN'], $newdata['pack_count'], $newdata['pack_cost'], $newdata['pack_descp'], 
    $newdata['pack_netW'], $newdata['pack_metricW'], $newdata['images'], $newdata['pack_type'], $data[0]['id'])) {

        $_SESSION['success_msg'] = 'Votre colis a été ajouté avec succès';

        if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=dark");
        } else {
            header("location:" . PROJECT . "customer/dash/packages-listings?theme=light");
        }
    }
    
    //die (var_dump($newdata['images']));

} elseif (!empty($error)) {

    //die ('erreur');

    $_SESSION['data'] = json_encode($updata);

    $_SESSION['images_errors'] = $error;

    if (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=light") {
        header("location:" . PROJECT . "customer/dash/set-packages?theme=light");
    } elseif (isset(explode('?', $_SERVER['REQUEST_URI'])[1]) && explode('?', $_SERVER['REQUEST_URI'])[1] == "theme=dark") {
        header("location:" . PROJECT . "customer/dash/set-packages?theme=dark");
    } else {
        header("location:" . PROJECT . "customer/dash/set-packages?theme=light");
    }

}




