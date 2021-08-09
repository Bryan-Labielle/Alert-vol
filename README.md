### Prerequisites

1. Check composer is installed
2. Check yarn & node are installed

### Install local

1. Clone this project
2. Run `symfony console doctrine:database:create`
   `symfony console d:m:m`
   `symfony console d:f:l`
3. Run `composer install`
4. Run `yarn install`
5. Run `yarn encore dev` to build assets

### Install with Docker

1. Install [Docker Desktop](https://www.docker.com/) on your machine
2. run `docker build -t alertvol .`
3. create and fill `.env.local` based on `.env` file  
4. run `docker-compose up -d`
5. app should be reachable with browser at http://localhost:8000

### Working

1. Run `yarn encore dev --watch` to launch your local server for assets
2. Run `symfony server:start` to launch your local php web server (only for local install)

### Windows Users

If you develop on Windows, you should edit you git configuration to change your end of line rules with this command :

`git config --global core.autocrlf true`

## Deployment

Three  *"Environmental Variables"* in *"App Configs"*  tab:

* `APP_ENV` with `prod`/`dev` value
* `DATABASE_URL` with the connection informations given by caprover when you create the related DB app.
* For FaceBook, create an Facebook account and a Facebook For Developper account. Don't forget to create credentials !
* `MAILLER_DSN` to send mail

### Api facebook

1. Commencer par vous créer un compte facebook, puis connecter vous à l'adresse :
   https://developers.facebook.com/

2. Dans l'onglet "Mes applications", créer une app .

3. Une fois celle-ci créer vous aurez besoin de récupérer les tokens de votre application :

- `APP_ID` et `APP_SECRET` :

Dans l'onglet "Paramètres -> Général" sous le "nom Identifiant de l'application" et "Clé secrètes"


- `DEFAULT_ACCESS_TOKEN` : Créer une page au préalable dans "Paramètres -> Avancé-> Page de l'application" Cette page devras être de catégorie  Page d'application ou jeux-vidéo et le nom devras contenir le nom de l'application ex : Alert'vol
  Puis à cette adresse :
  https://developers.facebook.com/tools/explorer/

Sous "App Facebook" : séléctionner votre application
Sous "Utilisateur ou Page" la page que vous venez de créer
Dans les autorisation ajouter pages_manage_posts

Puis "Generate Access Token" vous donneras un token courte durée pour le transformer en token qui n'expire pas selectionner le "i" a gauche du token créer, puis "ouvrir dans l'outil Access Token" et enfin "Etendre le token d'accés"

- PAGE_ID : Rendez vous sur la page que vous venez de créer  exemple : https://www.facebook.com/Wildtest-AlertVol-{100759468973506}

Votre token d'accés sera par exemple : 100759468973506

4. Renseignez les dans le .env

5. Pour pouvoir poster sur facebook vous devrez compléter les informations de votre application, notamment l'url de la politique de confidentialité, l'url des conditions de service et ajouter l'icone de l'app

### Api twitter

1. Commencer par vous créer un compte twitter puis connecter vous à l'adresse :
   https://developer.twitter.com/en/portal/projects-and-apps

2.Créer une application, puis dans l'overview selectionner "Keys and Tokens"

3. Générer vos "Consumer Keys" Api key and secret puis "Access Token and Secret"

4. Renseignez les dans le .env selon la syntaxe suivante :
`TWITTER_ACCESS_TOKEN`
`TWITTER_ACCESS_TOKEN_SECRET`
`TWITTER_CONSUMER_KEY`
`TWITTER_CONSUMER_SECRET`



### Compte administrateur environnement dev

Un compte administrateur est automatiquement créé lors de l'installation en environnement `DEV`.
Deux variables d'environnement doivent être renseignées avec les valeurs souhaitées
`ADMIN_USER_EMAIL` et `ADMIN_USER_PASS`.


### Créer des comptes utilisateurs (prod et dev)

Pour céer des comptes utilisateurs via la CLI, utiliser la commande
```bash
php bin/console user:create [--admin]
```
options: --admin pour créer un compte admin

### Modifier mot de passe d'un compte utilisateur (prod et dev)
```bash
php bin/console user:change-password <email>
```
