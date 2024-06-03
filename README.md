# SocialShuffle
SocialShuffle est une application Web réalisée avec le Framework Laravel permettant la créations automatique de groupes hétérogènes afin de favoriser les interractions sociales.
## Prérequis
* PHP 8.2 minimum
* Composer
* Node.js
* Serveur de base de données local

## Installation du projet en local

Ouvrez un terminal de commandes dans le répertoir `SocialShuffle` et mettez à jour les dépendances avec 
`composer update`.
Installez le dossier node_modules avec `npm -i` afin de pouvoir utiliser Tailwind.

## Configuration du projet
### Fichier `.env`

1. Copiez le fichier d'exemple `.env.example` et renommez-le en `.env`.

2. Dans le fichier `.env`, modifiez les valeurs de connexion à la base de données selon votre serveur local. Le champ `DB_DATABASE` doit cependant être configuré ainsi afin que la base de données aie le nom correcte :
   ```
    DB_DATABASE=SocialShuffle
   ```


4. Générez la clé de l'application :
   ```
   php artisan key:generate
   ```

### Migration de la base de données

Faites une migration de la base de données afin de créer les tables :
```
php artisan migrate
```

Si vous n'avez pas encore créé la base de données, il vous sera demandé si vous souhaitez qu'elle soit créée automatiquement avant le lancement de la migration.

Dans le cas où vous voudriez populer votre base de données avec des données fictives de test, lancez la commande suivante :
```
php artisan migrate:fresh --seed
```

### Mise en place du front-end

Afin que Tailwind soit fonctionnel, lancez la commande suivante :
```
npm run dev
```

## Lancer l'application

 Pour lancer le serveur de développement de Laravel, lancez la commande suivante :
 ```
 php artisan serve
 ```

L'application est désormais disponnible à l'adresse `http://127.0.0.1:8000`

