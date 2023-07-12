Pré-requis : 

- PHP : 
- Mysql : 
- Composer : 


Étapes de déploiement : 

- Installer les dépendances du projet via la commande : composer install.

- Créer une base de données.

- Importer le fichier de la base de données situé dans le dossier : database/africa-express-cargo.sql.

- Configurer la variable d'environnement PROJECT dans un fichier .env créé à la racine du projet et structuré comme dans l'exemple (voir fichier .env.example) en spécifiant le path de votre projet à partir du répertoire web. 

Exemple : C:\wamp64\www\africa-express-cargo. Ma constante PROJECT aura comme valeur : /africa-express-cargo/

- Configurer les variables d'environnements DATABASE_NAME, DATABASE_USERNAME, DATABASE_PASSWORD dans le fichier .env à la racine du projet en spécifiant les informations de la base de données.

- Configurer les variables d'environnements MAIL_ADDRESS, MAIL_PASSWORD dans le fichier .env à la racine du projet en spécifiant les informations de l'émetteur des mails dans l'application.

- Configurer la variable d'environnement ANONYMOUS_ID dans le fichier .env à la racine du projet en spécifiant l'ID d'un compte utilisateur à définir comme utilisateur anonyme. A cet utilisateur sera associé tous les colis ou groupes de colis sans destinataire connu.

- Lancer le projet avec la commande : php -S localhost:8081

- Déployer votre projet en accédant a l'url suivant : http://localhost:8081