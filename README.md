# SOPRJ_Agile
## Groepsleden

| Usernames      | Naam               | Studentnummer |
| :------------- | :----------------- | :------------ |
| @JasperMooren | Jasper Mooren | 2126574 |
| @Vincent2162102 | Vincent Jamont | 2162102 |
| @GXZheng312 | Jacky Zheng | 2164239 | 
| @tommydr     | Tommy den Reijer    | 2167744       |
| @jasontonk    | Jason Tonk | 2163027       |
| @raintje       | Wessel van Dorsten | 2153442       |

---

### Git guidelines

* We werken vanaf de `develop` branch waar feature branches op gecommit worden. De `develop` branch wordt niet direct gebruikt.
* Op de `master` branch kunnen alleen hotfixes direct worden gecommit.
* Voor feature branches wordt de volgende naamgeving gebruikt: `feature/JouwFeatureHier`.
* Link nieuwe features aan bestaande issues.
* Maak geen dubbele features aan.
* Hou de status van jouw `feature`, `bugfix` of `hotfix` bij in github issues met comments.
* Als je klaar bent met je `feature` maak dan een PR aan en koppel het aan de issue.
* PR's worden door minimaal 2 mensen gecheckt en getest lokaal op hun machine.

---

### Code guidelines

* Geen duplicate code.
* Pascal en CamelCase.
* Tabs zijn 4 spaties lang.
* Houd standaard coding conventions voor PHP aan.
* Leesbaarheid en netheid over grootte in de code.
* Maak tests aan voor classes en methods.
* Gebruik logische benaming van variabelen.
* Probeer niet het wiel opnieuw uit te vinden maar maak gebruik van libaries bij complete taken (let er op dat je niet te veel dependencies gebruikt).
* Voeg comments toe als dat de leesbaarheid bevordert. 

[![CodeFactor](https://www.codefactor.io/repository/github/raintje/soprj_agile/badge?s=23e3518ad7c30badf60b9bbac37884e5f13021c5)](https://www.codefactor.io/repository/github/raintje/soprj_agile)

---

### Project inner workings

* Voor IOC gebruiken we de constructor injection.
* Voor elk Model die benodigd is in de presentatie van de applicatie, wordt er een ViewModel gemaakt. In deze ViewModels worden Modellen als paramter opgenomen. In een ViewModel wordt de meegegeven Model omgezet naar het ViewModel.
* Naamgeving van Viewmodels is 'Model naam'+VM
