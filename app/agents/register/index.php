<?php

$_SESSION['current_url'] = "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

include 'app/common/auth/1stpart.php';

$countries = [
    "<span>&#x1F1E6;&#x1F1EB;</span>&nbsp;&nbsp;&nbsp;Afghanistan",
    "<span>&#x1F1E6;&#x1F1F1;</span>&nbsp;&nbsp;&nbsp;Albanie",
    "<span>&#x1F1E9;&#x1F1FF;</span>&nbsp;&nbsp;&nbsp;Algérie",
    "<span>&#x1F1E9;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Allemagne",
    "<span>&#x1F1E6;&#x1F1E9;</span>&nbsp;&nbsp;&nbsp;Andorre",
    "<span>&#x1F1E6;&#x1F1F4;</span>&nbsp;&nbsp;&nbsp;Angola",
    "<span>&#x1F1E6;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;Antigua-et-Barbuda",
    "<span>&#x1F1E6;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;Arabie saoudite",
    "<span>&#x1F1E6;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Argentine",
    "<span>&#x1F1E6;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Arménie",
    "<span>&#x1F1E6;&#x1F1FA;</span>&nbsp;&nbsp;&nbsp;Australie",
    "<span>&#x1F1E6;&#x1F1F9;</span>&nbsp;&nbsp;&nbsp;Autriche",
    "<span>&#x1F1E6;&#x1F1FF;</span>&nbsp;&nbsp;&nbsp;Azerbaïdjan",
    "<span>&#x1F1E7;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;Bahamas",
    "<span>&#x1F1E7;&#x1F1ED;</span>&nbsp;&nbsp;&nbsp;Bahreïn",
    "<span>&#x1F1E7;&#x1F1E9;</span>&nbsp;&nbsp;&nbsp;Bangladesh",
    "<span>&#x1F1E7;&#x1F1E7;</span>&nbsp;&nbsp;&nbsp;Barbade",
    "<span>&#x1F1E7;&#x1F1FE;</span>&nbsp;&nbsp;&nbsp;Bélarus",
    "<span>&#x1F1E7;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Belgique",
    "<span>&#x1F1E7;&#x1F1FF;</span>&nbsp;&nbsp;&nbsp;Belize",
    "<span>&#x1F1E7;&#x1F1EF;</span>&nbsp;&nbsp;&nbsp;Bénin",
    "<span>&#x1F1E7;&#x1F1F9;</span>&nbsp;&nbsp;&nbsp;Bhoutan",
    "<span>&#x1F1E7;&#x1F1F4;</span>&nbsp;&nbsp;&nbsp;Bolivie",
    "<span>&#x1F1E7;&#x1F1E6;</span>&nbsp;&nbsp;&nbsp;Bosnie-Herzégovine",
    "<span>&#x1F1E7;&#x1F1FC;</span>&nbsp;&nbsp;&nbsp;Botswana",
    "<span>&#x1F1E7;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Brésil",
    "<span>&#x1F1E7;&#x1F1F3;</span>&nbsp;&nbsp;&nbsp;Brunei",
    "<span>&#x1F1E7;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;Bulgarie",
    "<span>&#x1F1E7;&#x1F1EB;</span>&nbsp;&nbsp;&nbsp;Burkina Faso",
    "<span>&#x1F1E7;&#x1F1EE;</span>&nbsp;&nbsp;&nbsp;Burundi",
    "<span>&#x1F1F0;&#x1F1ED;</span>&nbsp;&nbsp;&nbsp;Cambodge",
    "<span>&#x1F1E8;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Cameroun",
    "<span>&#x1F1E8;&#x1F1E6;</span>&nbsp;&nbsp;&nbsp;Canada",
    "<span>&#x1F1E8;&#x1F1FB;</span>&nbsp;&nbsp;&nbsp;Cap-Vert",
    "<span>&#x1F1E8;&#x1F1EB;</span>&nbsp;&nbsp;&nbsp;République centrafricaine",
    "<span>&#x1F1E8;&#x1F1F1;</span>&nbsp;&nbsp;&nbsp;Chili",
    "<span>&#x1F1E8;&#x1F1F3;</span>&nbsp;&nbsp;&nbsp;Chine",
    "<span>&#x1F1E8;&#x1F1FE;</span>&nbsp;&nbsp;&nbsp;Chypre",
    "<span>&#x1F1E8;&#x1F1F4;</span>&nbsp;&nbsp;&nbsp;Colombie",
    "<span>&#x1F1F0;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Comores",
    "<span>&#x1F1E8;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;République du Congo",
    "<span>&#x1F1E8;&#x1F1E9;</span>&nbsp;&nbsp;&nbsp;République démocratique du Congo",
    "<span>&#x1F1F0;&#x1F1F5;</span>&nbsp;&nbsp;&nbsp;Corée du Nord",
    "<span>&#x1F1F0;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Corée du Sud",
    "<span>&#x1F1E8;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Costa Rica",
    "<span>&#x1F1E8;&#x1F1EE;</span>&nbsp;&nbsp;&nbsp;Côte d'Ivoire",
    "<span>&#x1F1ED;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Croatie",
    "<span>&#x1F1E8;&#x1F1FA;</span>&nbsp;&nbsp;&nbsp;Cuba",
    "<span>&#x1F1E9;&#x1F1F0;</span>&nbsp;&nbsp;&nbsp;Danemark",
    "<span>&#x1F1E9;&#x1F1EF;</span>&nbsp;&nbsp;&nbsp;Djibouti",
    "<span>&#x1F1E9;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Dominique",
    "<span>&#x1F1E9;&#x1F1F4;</span>&nbsp;&nbsp;&nbsp;République dominicaine",
    "<span>&#x1F1EA;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;Égypte",
    "<span>&#x1F1F8;&#x1F1FB;</span>&nbsp;&nbsp;&nbsp;Salvador",
    "<span>&#x1F1E6;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Émirats arabes unis",
    "<span>&#x1F1EA;&#x1F1E8;</span>&nbsp;&nbsp;&nbsp;Équateur",
    "<span>&#x1F1EA;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Érythrée",
    "<span>&#x1F1EA;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;Espagne",
    "<span>&#x1F1EA;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Estonie",
    "<span>&#x1F1F8;&#x1F1FF;</span>&nbsp;&nbsp;&nbsp;Eswatini (Swaziland)",
    "<span>&#x1F1FA;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;États-Unis",
    "<span>&#x1F1EA;&#x1F1F9;</span>&nbsp;&nbsp;&nbsp;Éthiopie",
    "<span>&#x1F1EB;&#x1F1EF;</span>&nbsp;&nbsp;&nbsp;Fidji",
    "<span>&#x1F1EB;&#x1F1EE;</span>&nbsp;&nbsp;&nbsp;Finlande",
    "<span>&#x1F1EB;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;France",
    "<span>&#x1F1EC;&#x1F1E6;</span>&nbsp;&nbsp;&nbsp;Gabon",
    "<span>&#x1F1EC;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Gambie",
    "<span>&#x1F1EC;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Géorgie",
    "<span>&#x1F1EC;&#x1F1ED;</span>&nbsp;&nbsp;&nbsp;Ghana",
    "<span>&#x1F1EC;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Grèce",
    "<span>&#x1F1EC;&#x1F1E9;</span>&nbsp;&nbsp;&nbsp;Grenade",
    "<span>&#x1F1EC;&#x1F1F9;</span>&nbsp;&nbsp;&nbsp;Guatemala",
    "<span>&#x1F1EC;&#x1F1F3;</span>&nbsp;&nbsp;&nbsp;Guinée",
    "<span>&#x1F1EC;&#x1F1FC;</span>&nbsp;&nbsp;&nbsp;Guinée-Bissau",
    "<span>&#x1F1EC;&#x1F1FE;</span>&nbsp;&nbsp;&nbsp;Guyana",
    "<span>&#x1F1ED;&#x1F1F0;</span>&nbsp;&nbsp;&nbsp;Haïti",
    "<span>&#x1F1ED;&#x1F1F3;</span>&nbsp;&nbsp;&nbsp;Honduras",
    "<span>&#x1F1ED;&#x1F1FA;</span>&nbsp;&nbsp;&nbsp;Hongrie",
    "<span>&#x1F1E8;&#x1F1F0;</span>&nbsp;&nbsp;&nbsp;Îles Cook",
    "<span>&#x1F1F2;&#x1F1ED;</span>&nbsp;&nbsp;&nbsp;Îles Marshall",
    "<span>&#x1F1FB;&#x1F1E6;</span>&nbsp;&nbsp;&nbsp;Îles Salomon",
    "<span>&#x1F1EE;&#x1F1F3;</span>&nbsp;&nbsp;&nbsp;Inde",
    "<span>&#x1F1EE;&#x1F1E9;</span>&nbsp;&nbsp;&nbsp;Indonésie",
    "<span>&#x1F1EE;&#x1F1F6;</span>&nbsp;&nbsp;&nbsp;Irak",
    "<span>&#x1F1EE;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Iran",
    "<span>&#x1F1EE;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Irlande",
    "<span>&#x1F1EE;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;Islande",
    "<span>&#x1F1EE;&#x1F1F1;</span>&nbsp;&nbsp;&nbsp;Israël",
    "<span>&#x1F1EE;&#x1F1F9;</span>&nbsp;&nbsp;&nbsp;Italie",
    "<span>&#x1F1EF;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Jamaïque",
    "<span>&#x1F1EF;&#x1F1F5;</span>&nbsp;&nbsp;&nbsp;Japon",
    "<span>&#x1F1EF;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Jordanie",
    "<span>&#x1F1F0;&#x1F1FF;</span>&nbsp;&nbsp;&nbsp;Kazakhstan",
    "<span>&#x1F1F0;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Kenya",
    "<span>&#x1F1F0;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;Kirghizistan",
    "<span>&#x1F1F0;&#x1F1EE;</span>&nbsp;&nbsp;&nbsp;Kiribati",
    "<span>&#x1F1F0;&#x1F1FC;</span>&nbsp;&nbsp;&nbsp;Koweït",
    "<span>&#x1F1E6;&#x1F1F4;</span>&nbsp;&nbsp;&nbsp;Laos",
    "<span>&#x1F1F1;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;Lesotho",
    "<span>&#x1F1F1;&#x1F1FB;</span>&nbsp;&nbsp;&nbsp;Lettonie",
    "<span>&#x1F1F1;&#x1F1E7;</span>&nbsp;&nbsp;&nbsp;Liban",
    "<span>&#x1F1F1;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Libéria",
    "<span>&#x1F1F1;&#x1F1FE;</span>&nbsp;&nbsp;&nbsp;Libye",
    "<span>&#x1F1F1;&#x1F1EE;</span>&nbsp;&nbsp;&nbsp;Liechtenstein",
    "<span>&#x1F1F1;&#x1F1F9;</span>&nbsp;&nbsp;&nbsp;Lituanie",
    "<span>&#x1F1F1;&#x1F1FA;</span>&nbsp;&nbsp;&nbsp;Luxembourg",
    "<span>&#x1F1F2;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;Madagascar",
    "<span>&#x1F1F2;&#x1F1FE;</span>&nbsp;&nbsp;&nbsp;Malaisie",
    "<span>&#x1F1F2;&#x1F1FC;</span>&nbsp;&nbsp;&nbsp;Malawi",
    "<span>&#x1F1F2;&#x1F1FB;</span>&nbsp;&nbsp;&nbsp;Maldives",
    "<span>&#x1F1F2;&#x1F1F1;</span>&nbsp;&nbsp;&nbsp;Mali",
    "<span>&#x1F1F2;&#x1F1F9;</span>&nbsp;&nbsp;&nbsp;Malte",
    "<span>&#x1F1F2;&#x1F1E6;</span>&nbsp;&nbsp;&nbsp;Maroc",
    "<span>&#x1F1F2;&#x1F1FA;</span>&nbsp;&nbsp;&nbsp;Maurice",
    "<span>&#x1F1F2;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Mauritanie",
    "<span>&#x1F1F2;&#x1F1FD;</span>&nbsp;&nbsp;&nbsp;Mexique",
    "<span>&#x1F1EB;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Micronésie",
    "<span>&#x1F1F2;&#x1F1E9;</span>&nbsp;&nbsp;&nbsp;Moldavie",
    "<span>&#x1F1F2;&#x1F1E8;</span>&nbsp;&nbsp;&nbsp;Monaco",
    "<span>&#x1F1F2;&#x1F1F3;</span>&nbsp;&nbsp;&nbsp;Mongolie",
    "<span>&#x1F1EE;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Monténégro",
    "<span>&#x1F1F8;&#x1F1FF;</span>&nbsp;&nbsp;&nbsp;Mozambique",
    "<span>&#x1F1E6;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Namibie",
    "<span>&#x1F1F3;&#x1F1F5;</span>&nbsp;&nbsp;&nbsp;Nauru",
    "<span>&#x1F1F3;&#x1F1F5;</span>&nbsp;&nbsp;&nbsp;Népal",
    "<span>&#x1F1F3;&#x1F1EE;</span>&nbsp;&nbsp;&nbsp;Nicaragua",
    "<span>&#x1F1F3;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Niger",
    "<span>&#x1F1F3;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;Nigeria",
    "<span>&#x1F1F3;&#x1F1FA;</span>&nbsp;&nbsp;&nbsp;Niue",
    "<span>&#x1F1F3;&#x1F1F4;</span>&nbsp;&nbsp;&nbsp;Norvège",
    "<span>&#x1F1F3;&#x1F1FF;</span>&nbsp;&nbsp;&nbsp;Nouvelle-Zélande",
    "<span>&#x1F1F4;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Oman",
    "<span>&#x1F1FA;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;Ouganda",
    "<span>&#x1F1FA;&#x1F1FF;</span>&nbsp;&nbsp;&nbsp;Ouzbékistan",
    "<span>&#x1F1F5;&#x1F1F0;</span>&nbsp;&nbsp;&nbsp;Pakistan",
    "<span>&#x1F1F5;&#x1F1FC;</span>&nbsp;&nbsp;&nbsp;Palaos",
    "<span>&#x1F1F5;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;Palestine",
    "<span>&#x1F1F5;&#x1F1E6;</span>&nbsp;&nbsp;&nbsp;Panama",
    "<span>&#x1F1F5;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;Papouasie-Nouvelle-Guinée",
    "<span>&#x1F1F5;&#x1F1FE;</span>&nbsp;&nbsp;&nbsp;Paraguay",
    "<span>&#x1F1F3;&#x1F1F1;</span>&nbsp;&nbsp;&nbsp;Pays-Bas",
    "<span>&#x1F1F5;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Pérou",
    "<span>&#x1F1F5;&#x1F1ED;</span>&nbsp;&nbsp;&nbsp;Philippines",
    "<span>&#x1F1F5;&#x1F1F1;</span>&nbsp;&nbsp;&nbsp;Pologne",
    "<span>&#x1F1F5;&#x1F1F9;</span>&nbsp;&nbsp;&nbsp;Portugal",
    "<span>&#x1F1F6;&#x1F1E6;</span>&nbsp;&nbsp;&nbsp;Qatar",
    "<span>&#x1F1E8;&#x1F1EB;</span>&nbsp;&nbsp;&nbsp;République centrafricaine",
    "<span>&#x1F1E8;&#x1F1E9;</span>&nbsp;&nbsp;&nbsp;République démocratique du Congo",
    "<span>&#x1F1E9;&#x1F1F4;</span>&nbsp;&nbsp;&nbsp;République dominicaine",
    '<span>&#x1F1E8;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;République tchèque',
    '<span>&#x1F1F7;&#x1F1F4;</span>&nbsp;&nbsp;&nbsp;Roumanie',
    '<span>&#x1F1EC;&#x1F1E7;</span>&nbsp;&nbsp;&nbsp;Royaume-Uni',
    '<span>&#x1F1F7;&#x1F1FA;</span>&nbsp;&nbsp;&nbsp;Russie',
    '<span>&#x1F1F7;&#x1F1FC;</span>&nbsp;&nbsp;&nbsp;Rwanda',
    '<span>&#x1F1E8;&#x1F1F0;</span>&nbsp;&nbsp;&nbsp;Saint-Christophe-et-Niévès',
    '<span>&#x1F1F8;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Saint-Marin',
    '<span>&#x1F1FB;&#x1F1E8;</span>&nbsp;&nbsp;&nbsp;Saint-Vincent-et-les-Grenadines',
    '<span>&#x1F1F1;&#x1F1E8;</span>&nbsp;&nbsp;&nbsp;Sainte-Lucie',
    '<span>&#x1F1F8;&#x1F1FB;</span>&nbsp;&nbsp;&nbsp;Salvador',
    '<span>&#x1F1FC;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;Samoa',
    '<span>&#x1F1F8;&#x1F1F9;</span>&nbsp;&nbsp;&nbsp;Sao Tomé-et-Principe',
    '<span>&#x1F1F8;&#x1F1F3;</span>&nbsp;&nbsp;&nbsp;Sénégal',
    '<span>&#x1F1F7;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;Serbie',
    '<span>&#x1F1FA;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;Seychelles',
    '<span>&#x1F1F8;&#x1F1F1;</span>&nbsp;&nbsp;&nbsp;Sierra Leone',
    '<span>&#x1F1F8;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;Singapour',
    '<span>&#x1F1F8;&#x1F1F0;</span>&nbsp;&nbsp;&nbsp;Slovaquie',
    '<span>&#x1F1F8;&#x1F1EE;</span>&nbsp;&nbsp;&nbsp;Slovénie',
    '<span>&#x1F1F8;&#x1F1F4;</span>&nbsp;&nbsp;&nbsp;Somalie',
    '<span>&#x1F1F8;&#x1F1E9;</span>&nbsp;&nbsp;&nbsp;Soudan',
    '<span>&#x1F1F8;&#x1F1F8;</span>&nbsp;&nbsp;&nbsp;Soudan du Sud',
    '<span>&#x1F1F1;&#x1F1F0;</span>&nbsp;&nbsp;&nbsp;Sri Lanka',
    '<span>&#x1F1F0;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Suède',
    "<span>&#x1F1E8;&#x1F1ED;</span>&nbsp;&nbsp;&nbsp;Suisse",
    "<span>&#x1F1F8;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Suriname",
    "<span>&#x1F1F8;&#x1F1FE;</span>&nbsp;&nbsp;&nbsp;Syrie",
    "<span>&#x1F1F9;&#x1F1EF;</span>&nbsp;&nbsp;&nbsp;Tadjikistan",
    "<span>&#x1F1F9;&#x1F1FF;</span>&nbsp;&nbsp;&nbsp;Tanzanie",
    "<span>&#x1F1F9;&#x1F1E9;</span>&nbsp;&nbsp;&nbsp;Tchad",
    "<span>&#x1F1F9;&#x1F1ED;</span>&nbsp;&nbsp;&nbsp;Thaïlande",
    "<span>&#x1F1F9;&#x1F1F1;</span>&nbsp;&nbsp;&nbsp;Timor oriental",
    "<span>&#x1F1F9;&#x1F1EC;</span>&nbsp;&nbsp;&nbsp;Togo",
    "<span>&#x1F1F9;&#x1F1F4;</span>&nbsp;&nbsp;&nbsp;Tonga",
    "<span>&#x1F1F9;&#x1F1F9;</span>&nbsp;&nbsp;&nbsp;Trinité-et-Tobago",
    "<span>&#x1F1F9;&#x1F1F3;</span>&nbsp;&nbsp;&nbsp;Tunisie",
    "<span>&#x1F1F9;&#x1F1F0;</span>&nbsp;&nbsp;&nbsp;Turkménistan",
    "<span>&#x1F1F9;&#x1F1F7;</span>&nbsp;&nbsp;&nbsp;Turquie",
    "<span>&#x1F1F9;&#x1F1FB;</span>&nbsp;&nbsp;&nbsp;Tuvalu",
    "<span>&#x1F1FA;&#x1F1E6;</span>&nbsp;&nbsp;&nbsp;Ukraine",
    "<span>&#x1F1EA;&#x1F1FA;</span>&nbsp;&nbsp;&nbsp;Union européenne",
    "<span>&#x1F1FA;&#x1F1FE;</span>&nbsp;&nbsp;&nbsp;Uruguay",
    "<span>&#x1F1FB;&#x1F1FA;</span>&nbsp;&nbsp;&nbsp;Vanuatu",
    "<span>&#x1F1FB;&#x1F1E6;</span>&nbsp;&nbsp;&nbsp;Vatican",
    "<span>&#x1F1FB;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Venezuela",
    "<span>&#x1F1FB;&#x1F1F3;</span>&nbsp;&nbsp;&nbsp;Vietnam",
    "<span>&#x1F1FE;&#x1F1EA;</span>&nbsp;&nbsp;&nbsp;Yémen",
    "<span>&#x1F1FF;&#x1F1F2;</span>&nbsp;&nbsp;&nbsp;Zambie",
    "<span>&#x1F1FF;&#x1F1FC;</span>&nbsp;&nbsp;&nbsp;Zimbabwé",
];

?>

<body>

    <div class="limiter">
           
        <div class="container-login100">
            <div class="wrap-register100">
                
                <div>
                    <form id="register" class="login100-form validate-form" style="width: 100%;">
                        <span class="login100-form-title">
                            <i class="fa fa-user-plus"></i>
                            Agents
                        </span>

                        <div class="row">

                            <div class="col-lg-6">
                                <label for="nom" class="ml-3">Nom<span class="text-danger">*</span></label>
                                <div class="wrap-input100 validate-input" data-validate="Champs requis">
                                    <input class="input100" type="text" name="nom" id="nom" placeholder="Nom">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>



                            <div class="col-lg-6">
                                <label for="prenom" class="ml-3">Prénoms<span class="text-danger">*</span></label>
                                <div class="wrap-input100 validate-input" data-validate="Champs requis">
                                    <input class="input100" type="text" id="prenom" name="prenom" placeholder="Prénoms">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>                              
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <label for="mail" class="ml-3">Adresse Email<span class="text-danger">*</span></label> 
                                <div class="wrap-input100 validate-input" data-validate="Champs requis">
                                    <input class="input100" type="" id="mail" name="mail" placeholder="Email">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                    </span>
                                </div>  
                            </div>

                            <div class="col-lg-6">
                                <label for="pseudo" class="ml-3">Nom d'Utilisateur<span class="text-danger">*</span></label>
                                <div class="wrap-input100 validate-input" data-validate="Champs requis">
                                    <input class="input100" type="text" id="pseudo" name="pseudo" placeholder="Nom d'utilisateur">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>                           
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <label for="tel" class="ml-3">Numéro de téléphone<span class="text-danger">*</span></label>
                                <div class="wrap-input100 validate-input" data-validate="Champs requis">
                                    <input class="input100" type="tel" id="tel" name="tel" placeholder="Numéro de téléphone">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                    </span>
                                </div>                              
                            </div>

                            <div class="col-lg-6">
                                <label for="country" class="ml-3">Pays<span class="text-danger">*</span></label>
                                <div class="wrap-input100" data-validate="Champs requis">
                                    <input type="hidden" class="input100">
                                    <select class="input100" id="country" name="country">
                                        <option selected><span>&#x1F1E7;&#x1F1EF;</span>&nbsp;&nbsp;&nbsp;Bénin</option>
                                        <?php
                                        foreach ($countries as $key => $value) {
                                        ?>
                                            <option><?= $countries[$key]; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-lg-6">
                                <label for="pass" class="ml-3">Mot de passe<span class="text-danger">*</span></label>
                                <div class="wrap-input100 validate-input" data-validate="Champs requis">
                                    <input class="input100" type="password" id="pass" name="pass" placeholder="Mot de passe">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label for="repass" class="ml-3">Confirmez mot de passe<span class="text-danger">*</span></label>
                                <div class="wrap-input100 validate-input" data-validate="Champs requis">
                                    <input class="input100" type="password" id="repass" name="repass" placeholder="Confirmez mot de passe">
                                    <span class="focus-input100"></span>
                                    <span class="symbol-input100">
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                    </span>
                                </div> 
                            </div>

                        </div>
                        <p class="text-center mt-3">En vous inscrivant sur notre plateforme, vous acceptez nos <a href="#"> <strong>termes et conditions</strong></a>.</p>

                        <div class="container-login100-form-btn">
                            <button type="submit" id="submitButton" class="login100-form-btn" style="width : 50%;">
                                <span>Je m'inscris</span>
                                <span class="loader"></span>
                            </button>
                        </div>

                    </form>

                    <div class="text-center p-t-12">
                        <a class="txt2" href="<?= PROJECT ?>agents/login">
                            Déjà inscrit ? Connectez-vous
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
    unset($_SESSION["register_errors"]); 
    ?>

</body>

<?php include 'app/common/auth/2ndpart.php'; ?>

</html>