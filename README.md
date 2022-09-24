# FFTTApi, API PHP pour la FFTT

FFTTApi permet de consommer facilement l'API officielle de la Fédération Française de Tennis de table.

### Installation avec Composer

Il est recommandé d'installer FFTTApi grâce à composer
[Composer](http://getcomposer.org).

```bash
composer require alamirault/fftt-api
```

### Exemple d'utilisation

```php
<?php

use Alamirault\FFTTApi\Service\FFTTApi;

require __DIR__ . '/vendor/autoload.php';

$ffttApi = new FFTTApi('SW014', '54gsX6jbz3');

$joueurs = $ffttApi->getJoueursByNom('Lamirault');

```

### Features

- Liste des organismes
- Liste des clubs par département
- Liste des clubs par nom
- Détail d'un club
- Lists des joueurs d'un club
- Liste des joueurs par nom, prénom
- Détail d'un joueur
- Classement d'un joueur
- Historique d'un joueur
- Liste des parties d'un joueur
- Liste des parties non validées d'un joueur
- Points virtuels d'un joueur
- Liste des équipes d'un club
- Classement d'une poule
- Liste des rencontres d'une poule
- Liste des prochaines rencontres d'une équipe
- Détail d'une rencontre
- Liste des actualitées

### Contribution

Pour contribuer à ce package, il faut en réalité contribuer au projet [alamirault/fftt-api-src](https://github.com/alamirault/fftt-api-src).  
En effet ce repository est le resultat d'un build pour être compatible avec le plus de versions de PHP possibles.

### Migration depuis al37350/fftt-api

Si vous utilisés, `al37350/fftt-api`, vous pouvez migrer sur ce package sans trop de changements majeur. (Les deux packages sont fait par les mêmes contributeurs)
Vous trouverez la liste des [changements majeurs ici](UPGRADING_FROM_AL37350.md).  
