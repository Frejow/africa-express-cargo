Pré-requis : 

- PHP : 
- Mysql : 
- Composer : 


Étapes de déploiement : 

- Installer les dépendances du projet via la commande : composer install.

- Créer une base de données.

- Importer le fichier de la base de données situé dans le dossier : database/africa-express-cargo.sql.

- Configurer la constante PROJECT dans le fichier index.php à la racine du projet en spécifiant le path de votre projet à partir du répertoire web. 
Exemple : C:\wamp64\www\africa-express-cargo. Ma constante PROJECT aura comme valeur : /africa-express-cargo/

- Configurer les constantes DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD dans un fichier .env structuré comme dans l'exemple (voir fichier .env.example) à la racine du projet en spécifiant les informations de la base de données.

- Configurer les constantes MAIL_ADDRESS, MAIL_PASSWORD dans le fichier .env à la racine du projet en spécifiant les informations de l'émetteur des mails dans l'application.

- Lancer le projet avec la commande : php -S localhost:8081

- Déployer votre projet en accédant a l'url suivant : http://localhost:8081