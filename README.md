# Guitar-Chords
Annuaire d'accords de guitare, tablatures, tutoriels

### ENVIRONNEMENT
* Symfony 7.2
* PHP 8.2+
* Composer 2
* AssetMapper
* Font Awesome

### ADMIN/BackOffice
* Url : /admin

**Comptes Admin**
* Login : citizenz7@protonmail.com
* Password : 72P3EH2XfVq2ij3w

### BUNDLES
* easycorp/easyadmin-bundle
* symfony/asset-mapper
* knplabs/knp-paginator-bundle
* twig/extra-bundle
* victor-prdh/recaptcha-bundle

### Fonts
* Montserrat

### COMMANDES
* commande Symfony pour la création d'un admin :
`php bin/console app:create-admin EMAIL PASSWORD FIRSTNAME LASTNAME`

### Listener (EventSubscriber is deprecated)
`symfony console make:listener EasyAdminSubscriberOfficeCreatedAt`

### Translations
`php bin/console translation:extract --force fr`

### Créer un mot de passe hashé en console
`symfony console security:hash-password`

### Google reCapctha
* clé du site : 6LdvCNYqAAAAACRNREmQcTdGZ1bsKQ-ASVCv8jXL
* clé secrète : 6LdvCNYqAAAAAMFTikaSrxqbkCUQdhViTPsVyCMp

### Google Analytics
* G-XXXXXXXXXX

### AssetMapper
* Installer un package JS (exemple avec SplideJS) : `php bin/console importmap:require @splidejs/splide`
* Vérifier les mises à jour éventuelles de tous les packages JS installés : `php bin/console importmap:outdated`
* Vérifier les mises à jour pour un package JS en particulier : `php bin/console importmap:outdated @splidejs/splide`

### A FAIRE / VERIFIER AVANT LA MISE EN PROD
* page login CSS
* Erreurs personnalisées
* reCaptcha Google
* test formulaire de contact
* flash messages
* BO css
* Sitemap
* robots.txt
* Favicon
* Meta + données structurées schema.org
* Tarteaucitron
* permissions BO : utilisateurs, commentaires, articles, images, fichiers
* div dans les crudcontroller ADMIN
* Responsive
* SEO :
    * titre H1 de chaque page
    * vérifier les balise HTML de titre sur chaque page : h1 (une seule par page) puis h2, h3, ...
    * vérifier les img alt=""
* CGU
* Confidentialite
* constraints dans crud controller sur images et fichiers
* Mentions légales
* Un utlisateur qui n'aura pas validé son adresse e-mail ne pourra pas proposer d'article

### Mise en PROD
**Installer/compiler les assets**
1. `php bin/console importmap:install` : re-installer les fichiers JS sur un autre serveur
2. `php bin/console asset-map:compile` : compiler les assets dans public à chaque fois qu'il y a un changement de fichier CSS

**robots.txt**
* Ajouter sitemap dans robots.txt : `Sitemap: https://www.monsite.fr/sitemap.xml`

**Analytics (prod)**
* Google Analytics 4
* Google Search Console + soumission sitemap