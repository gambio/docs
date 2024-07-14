# Entwicklung und Git-Workflow

An dieser Stelle setzen wir vorraus, dass du das Shop Projekt erfolgreich aufgesetzt hast.
Ansonsten rufe bitte den Abschnitt [Aufsetzen des Shop Projektes](setup_project.md) auf und gehe diesen durch.

Wie du nun im Detail eigene Module entwickeln kannst, wird dir in den Abschnitten unter
[Entwicklung eigener Module]()
ausführlich erklärt, grundsätzlich kann jedoch bei der Entwicklung auch die Nutzung unseres Gitlab Servers von
Bedeutung sein. Weswegen wir nachfolgend kurz erklären wollen, wie du deine Anpassungen in Form von Merge-Requests bei
uns einreichen kannst, damit diese in unser Repository aufgenommen werden.


**Inhalt:**

* <a href="#Gambio-Remote-Verbindung hinzufügen">Gambio-Remote-Verbindung hinzufügen</a>
* <a href="#Codebasis bestimmen und auschecken">Codebasis bestimmen und auschecken</a>
    * <a href="#Ein Tag als Codebasis">Ein Tag als Codebasis</a>
    * <a href="#Ein Entwicklungszweig als Codebasis">Ein Entwicklungszweig als Codebasis</a>
* <a href="#Das eigene Modul integrieren">Das eigene Modul integrieren</a>
* <a href="#Codebasis akutalisieren">Codebasis akutalisieren</a>
    * <a href="#Einen neuen Entwicklungszweig als Codebasis lokal erstellen">Einen neuen Entwicklungszweig als Codebasis lokal erstellen</a>
    * <a href="#Einen bestehenden Entwicklungszweig aktualisieren"> Einen bestehenden Entwicklungszweig aktualisieren</a>
        * <a href="#Codebasis aktualisieren">Codebasis aktualisieren</a>
        * <a href="#Integrationsbranch aktualisieren">Integrationsbranch aktualisieren</a>
* <a href="#Die eigene Modul Integrierung aktualisieren">Die eigene Modul Integrierung aktualisieren</a>
    * <a href="#Merge Requests">Merge Requests</a>
* <a href="#Shopversionen">Shopversionen</a>
* <a href="#Links">Links</a>



## <a name="Gambio-Remote-Verbindung hinzufügen"></a>Gambio-Remote-Verbindung hinzufügen

Zunächst muss die Remote-Verbindung des Gambio Repositories zum lokal geklonten Fork hinzugefügt werden. 
Hier wird als Referenz für das Gambio-Repository **gambio** genutzt.

```sh
> cd path/to/your/local/repository
> git remote add gambio https://sources.gambio-server.net/gambio/gxdev.git
```


## <a name="Codebasis bestimmen und auschecken"></a>Codebasis bestimmen und auschecken


### <a name="Ein Tag als Codebasis"></a>Ein Tag als Codebasis

Wenn eine bestimmte Release-Version als Codebasis genutzt werden soll, können alle Tags aus dem Gambio-Repository
aufgelistet und ausgecheckt werden.

```sh
> git ls-remote --tags gambio

# Ausgabe:
...  
c3b80e8c385fe87312f4abdcde0314f3e42dd580	refs/tags/v2.7.1.0  
e237c150fbf2bb866b0f42373f799bb3bc581a3d	refs/tags/v2.7.1.0_beta1  
df8584c2d9783812dcf50dfe7eab9588149c20cd	refs/tags/v2.7.1.0_beta2  
ab2d9f9601a86dde722e8488ed0b132eedf9948b	refs/tags/v2.7.1.0_beta3  
a2824ef82f2ceb6f8e83f1a20af7d8bf4c65222f	refs/tags/v2.7.1.0_beta4  
8fad6840c90163e4ae85a2077cf1e4bf0d1a6a1a	refs/tags/v2.7.1.1  
7485a28184d964135293a1a8b280c3866deddc94	refs/tags/v2.7.1.2  
...
```

Die Ausgabe listet den SHA1-Hash des getaggten Commits und den Speicherort der jeweiligen Referenz (hier: Tag) auf. 

Um einen Branch mit dem Namen `3.15_feature_my_module_v1.0` basierend auf der Release-Version *3.15.1.0* zu erstellen,
wird folgender Befehl genutzt:

```sh
> git fetch gambio v3.15.1.0
> git checkout -b 3.15_feature_my_module_v1.0 FETCH_HEAD
```


### <a name="Ein Entwicklungszweig als Codebasis"></a>Ein Entwicklungszweig als Codebasis

Wenn der aktuelle Stand eins Entwicklungszweiges als Codebasis genutzt werden soll, können alle *develop-Branches* aus
dem Gambio-Repository aufgelistet werden.

```sh
> git ls-remote --heads gambio *_develop

# Ausgabe:
2df174cb19f3c8da044dde57245221ce1299e85e	refs/heads/1.0_develop
feb047d6e15a6378e67ce92ad31981ca02608d0f	refs/heads/2.0_develop
f4a8319d515fb75283a08556459a617b05b08e92	refs/heads/2.1_develop
ee4f67bc1938ae18e5034269cd0cf027292df187	refs/heads/2.2_develop
499500e433f7617363b44f4baa1679243655d305	refs/heads/2.3_develop
983956ac62771dc6ec5063b99247535ecb0e2e66	refs/heads/2.4_develop
cbb6ac53a4c23f0f200b23303458b12f8f0fa012	refs/heads/2.5_develop
4975da0b0dc5dd1e897633df52cda593e734283c	refs/heads/2.6_develop
f89c01e7185eeb7b0e796ef170143de58400115e	refs/heads/2.7_develop
```

Die Ausgabe listet den SHA1-Hash des jeweiligen HEADS und den Speicherort der Referenz (hier: Branch) auf.

Um einen Branch mit dem Namen `3.15_feature_my_module_v1.0` basierend auf dem Entwicklungszweig der Versionsreihe
*3.15* zu erstellen, wird folgender Befehl genutzt:

```sh
> git fetch gambio 3.15_develop
> git checkout -b 3.15_feature_my_module_v1.0 FETCH_HEAD
```


## <a name="Das eigene Modul integrieren"></a>Das eigene Modul integrieren

Nun können die Programmdateien des eigenen Moduls in das Projektverzeichnis kopiert und das Modul anschließend
installiert werden, um dessen Kompatibilität mit der Versionsreihe 3.15.x zu testen oder Anpassungen vorzunehmen.

Sofern Anpassungen notwendig sind, können diese wie gewohnt [commitet](https://www.atlassian.com/git/tutorials/saving-changes)
werden. Sobald das Modul mit der Shopversion kompatibel ist, sollte der aktuelle Branch in den eigenen Fork gepusht
werden.

```sh
git push origin 3.15_feature_my_module_v1.0
```


## <a name="Codebasis akutalisieren"></a>Codebasis akutalisieren


### <a name="Einen neuen Entwicklungszweig als Codebasis lokal erstellen"></a>Einen neuen Entwicklungszweig als Codebasis lokal erstellen

Um alle *develop-Branches* aus dem Gambio-Repository aufzulisten, wird folgender Befehl verwendet.

```sh
> git ls-remote --heads gambio *_develop

# Ausgabe:
2df174cb19f3c8da044dde57245221ce1299e85e	refs/heads/1.0_develop
feb047d6e15a6378e67ce92ad31981ca02608d0f	refs/heads/2.0_develop
f4a8319d515fb75283a08556459a617b05b08e92	refs/heads/2.1_develop
ee4f67bc1938ae18e5034269cd0cf027292df187	refs/heads/2.2_develop
499500e433f7617363b44f4baa1679243655d305	refs/heads/2.3_develop
983956ac62771dc6ec5063b99247535ecb0e2e66	refs/heads/2.4_develop
cbb6ac53a4c23f0f200b23303458b12f8f0fa012	refs/heads/2.5_develop
4975da0b0dc5dd1e897633df52cda593e734283c	refs/heads/2.6_develop
f89c01e7185eeb7b0e796ef170143de58400115e	refs/heads/2.7_develop
```

Um einen lokalen Branch, der auf den aktuellen *3.15_develop*-Branch des Gambio-Repositories basiert, zu erstellen,
müssen zunächst die neuesten Änderungen aus dem Gambio-Repository geladen werden. Anschließend wird ein lokaler Branch
mit dem Namen *3.15_develop* erstellt.

```sh
> git fetch gambio 3.15_develop
> git checkout -b 3.15_develop FETCH_HEAD
```

Um den Entwicklungsweig (*3.15_develop*) im Remote Repository (*origin*) des eigenen Forks zu veröffentlichen, ist
folgender Befehl notwendig:

```sh
> git push origin 3.15_develop
```

Der soeben erstellte Branch *3.15_develop* dient **nur als Basis für den Integrationsbranch**, in dem die eigentliche
Integration vorgenommen wird.  Die eigenen Commits sollten immer in eigenen Integrationsbranches vorgenommen werden.
Dies hat den Vorteil, dass die Codebasis (*hier: 3.15_develop*) immer sauber mit dem öffentlichen Gambio-Repository
synchronisiert werden kann (siehe: [Einen bestehenden Entwicklungszweig aktualisieren](#UpdateCodeBase)) und der
develop-Branch bei Ablehnung des Merge Requests nicht zurückgesetzt werden muss.


### <a name="Einen bestehenden Entwicklungszweig aktualisieren"></a>Einen bestehenden Entwicklungszweig aktualisieren

Falls ein Integrationsbranch bereits erstellt wurde und eine Aktualisierung eines Moduls mit der gleichen Codebasis
(*3.15_develop*) vorgenommen werden muss, sollte vorher die zugrundeliegende Codebasis aktualisiert und in den
bestehenden Integrationsbranch gemergt werden. Dafür sind zwei Schritte notwendig:

* Aktualisierung der Codebasis (*hier: 3.15_develop*)
* Aktualisierung des Integrationsbranches


#### <a name="Codebasis aktualisieren"></a>Codebasis aktualisieren

Um die neuen Commits aus dem öffentlichen Gambio-Repository zu laden, werden die Änderungen gefetcht. Der aktualisierte
Remote-Tracking-Branch wird dann in den lokalen Branch gemergt und die Änderung in das Remote Repository des eigenen
Forks veröffentlicht.

```sh
> git fetch gambio
> git checkout 3.15_develop
> git merge --ff gambio/3.15_develop
> git push origin 3.15_develop
```


#### <a name="Integrationsbranch aktualisieren"></a>Integrationsbranch aktualisieren

Nachdem die neuen Commits aus dem öffentlichem Gambio-Repository in den Entwicklungszweig gemergt wurden, muss nun der
Integrationsbranch, in dem die eigentliche Integration stattfindet, gemergt werden. Dafür muss zuerst in den
Integrationsbranch `3.15_feature_my_module_v1.0` gewechselt und der vorher aktualisierte Entwicklungszweig
`3.15_develop` gemergt werden.

```sh
> git checkout 3.15_feature_my_module_v1.0
> git merge --no-ff 3.15_develop
```


## <a name="Die eigene Modul Integrierung aktualisieren"></a>Die eigene Modul Integrierung aktualisieren

Nun kann das Modul aktualisiert oder für die entsprechende Versionsreihe angepasst werden. Sobald die Integration
abgeschlossen ist, müssen die noch nicht veröffentlichen Commits in das Remote Repository des eigenen Forks gepusht
werden.

```sh
> git push origin 3.15_feature_my_module_v1.0
```


### <a name="Merge Requests"></a>Merge Requests

Da nur Mitarbeiter der Gambio GmbH über Schreibrechte im öffentlichen Gambio-Repository verfügen, muss die Integration
von externen Modulen über sogenannte Merge Requests erfolgen. Ein Merge Request ist eine Anfrage, einen Branch eines
Repositories (*der eigene Fork*) in einen Branch eines anderen Repositories (*das öffentliche Gambio-Repository*) zu
mergen.

Merge Requests beziehen sich nicht auf einen bestimmten Codestand zum Zeitpunkt X, sondern auf einen Branch. Das
bedeutet, dass weitere Commits, also Änderungen, in dem Quellbranch eines eingereichten Merge Requests automatisch in
den Merge Request aufgenommen werden. So können Korrekturen vorgenommen werden, ohne ständig neue Merge Requests
erstellen zu müssen. 

Integrationen oder Aktualisierungen von Modulen sollten immer mit der aktuellen Codebasis vorgenommen werden. Vor
Beginn der eigenen Integration und ggf. vor dem Einreichen des Merge Requests sollten immer die aktuellen Änderungen
des öffentlichen Gambio-Repositories in den eigenen Fork geladen werden (siehe: [Einen bestehenden Entwicklungszweig aktualisieren](#UpdateCodeBase))


## <a name="Shopversionen"></a>Shopversionen

Die Gambio GmbH entwickelt parallel zwei Shopversionen.  

* Stable Releases: Die Stable Releases haben immer eine **gerade** Zahl an der zweiten Stelle der Version
  (Beispiel: 2.**6**.1.0). Diese Version befindet sich im *Wartungsmodus*. Änderungen innerhalb dieser Versionsreihe
  beinhalten nur Bugfixes und kleinere Modulkorrekturen.
* Feature Releases: Die Feature Releases haben immer eine **ungerade** Zahl an der zweiten Stelle der Version
  (Beispiel: 2.**7**.1.0). Die erste Version dieser Versionsreihe beinhaltet immer neue Funktionen und Module, die dann
  in den nachfolgenden Service Packs stätig korrigiert werden. Nach drei Service Packs sollten die neuen Funktionen
  stabil genug sein, sodass eine Versionsreihe für Stable Releases veröffentlicht wird (Beispiel: 2.**8**.0.0) und die
  Entwicklung der vorherigen Versionreihe, also 2.**7**.x eingestellt wird.

[Weitere Informationen zu der Versionisierung der Gambio GmbH](http://www.gambio.de/blog/gambio-fuehrt-neue-versionierung-ein/)


## <a name="Links"></a>Links

* [Gambio Gitlab](https://sources.gambio-server.net/gambio/gxdev)
* [Git Dokumentation](https://git-scm.com/doc)
* [Git Essentials (external link)](https://www.atlassian.com/git/tutorials/)
* [Kostenloser Git GUI Client (Atlassian Sourcetree)](https://de.atlassian.com/software/sourcetree/overview)