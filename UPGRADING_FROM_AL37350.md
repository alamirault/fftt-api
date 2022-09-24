# Migrer de al37350/fftt-api à alamirault/fftt-api


L'ensemble du code à changé de namespace.

```php
$api = new \FFTTApi\FFTTApi("identifiant", "password"); // Avant
$api = new \Alamirault\FFTTApi\Service\FFTTApi("identifiant", "password"); // Maintenant
```

Les modèles sont toujours les mêmes mais ont aussi changé de namespace

```php
use FFTTApi\Model\Rencontre; // Avant
use Alamirault\FFTTApi\Model\Rencontre; // Maintenant
```

Changement des exceptions

```txt
ClubNotFoundException -> ClubNotFoundException
InvalidCredidentials -> InvalidRequestException
InvalidLienRencontre -> InvalidLienRencontreException
InvalidURIParametersException -> InvalidRequestException
JoueurNotFound -> JoueurNotFoundException
NoFFTTResponseException -> InvalidResponseException
UnauthorizedCredentials -> InvalidRequestException
URIPartNotValidException -> InvalidRequestException
```

Modification du nom des méthodes de `FFTTApi`

```txt
initialize -> SUPPRIMÉE
getOrganismes -> listOrganismes
getClubsByDepartement -> listClubsByDepartement
getClubsByName -> listClubsByVille
getClubDetails -> retrieveClubDetails
getJoueursByClub -> listJoueursByClub
getJoueursByNom -> listJoueursByNom
getJoueurDetailsByLicence -> retrieveJoueurDetails
getClassementJoueurByLicence -> retrieveClassement
getHistoriqueJoueurByLicence -> listHistorique
getPartiesJoueurByLicence -> listPartiesJoueurByLicence
isInCurrentSaison -> SUPPRIMÉE
isInCurrentVirtualMonth -> SUPPRIMÉE
getUnvalidatedPartiesJoueurByLicence -> listUnvalidatedPartiesJoueurByLicence
getJoueurVirtualPoints -> retrieveVirtualPoints
getVirtualPoints -> SUPPRIMÉE
getEquipesByClub -> listEquipesByClub
getClassementPouleByLienDivision -> listEquipePouleByLienDivision
getRencontrePouleByLienDivision -> listRencontrePouleByLienDivision
getProchainesRencontresEquipe -> listProchainesRencontresEquipe
getClubEquipe -> retrieveClubDetailsByEquipe
getDetailsRencontreByLien -> retrieveRencontreDetailsByLien
getActualites -> listActualites
```