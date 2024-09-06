# Projekt-Dokumentation

☝️ Alle Text-Stellen, welche mit einem ✍️ beginnen, können Sie löschen, sobald Sie die entsprechende Stellen ausgefüllt haben.

✍️ Ihr Gruppenname und Ihre Nachnamen

| Datum | Version | Zusammenfassung                                                                                                                             |
| ----- | ------- | ------------------------------------------------------------------------------------------------------------------------------------------- |
|       | 0.0.1   | ✍️ Jedes Mal, wenn Sie an dem Projekt arbeiten, fügen Sie hier eine neue Zeile ein und beschreiben in *einem* Satz, was Sie erreicht haben. |
|       | ...     |                                                                                                                                             |
|       | 1.0.0   |                                                                                                                                             |

## 1 Informieren

### 1.1 Ihr Projekt

✍️ Beschreiben Sie Ihr Projekt in einem griffigen Satz.

### 1.2 User Stories

| US-№ | Verbindlichkeit | Typ        | Beschreibung                                                                                                                        |
| ---- | --------------- | ---------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| 1    | Muss            | Funktional | Als ein Nutzer möchte ich mich registrieren und anmelden können, damit ich auf mein Profil und den Produktkatalog zugreifen kann.   |
| 2    | Muss            | Funktional | Als ein Nutzer möchte ich mein Profil bearbeiten können, damit meine Informationen aktuell und korrekt sind.                        |
| 3    | Muss            | Funktional | Als ein Nutzer möchte ich Produkte im Katalog nach Kategorien durchsuchen können, damit ich die gewünschten Produkte leicht finde.  |
| 4    | Kann            | Funktional | Als ein angemeldeter Nutzer möchte ich Produkte zu einem Warenkorb hinzufügen können, damit ich später einen Kauf abschließen kann. |
| 5    | Kann            | Funktional | Als ein angemeldeter Nutzer möchte ich einen Checkout-Prozess durchführen können, damit ich meinen Kauf abschließen kann.           |
| 6    | Muss            | Rand       | Als ein Entwickler möchte ich eine sichere Nutzeranmeldung implementieren, damit die Nutzerdaten geschützt sind.                    |
| 7    | Kann            | Qualität   | Als ein Entwickler möchte ich eine Testabdeckung von mindestens 80% erreichen, damit die Codequalität sichergestellt wird.          |

### 1.3 Testfälle

| TC-№ | Ausgangslage                                    | Eingabe                                                                    | Erwartete Ausgabe                                                                          |
| ---- | ----------------------------------------------- | -------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------ |
| 1.1  | Die Registrierungsseite ist aufgerufen.         | Nutzer gibt gültige Registrierungsdaten ein und klickt auf "Registrieren". | Der Nutzer wird registriert und erhält eine Bestätigungsmeldung                            |
| 1.2  | Die Anmeldeseite ist aufgerufen.                | Nutzer gibt gültige Anmeldedaten ein und klickt auf "Anmelden".            | Der Nutzer wird angemeldet und auf die Startseite weitergeleitet.                          |
| 2.1  | Nutzer ist angemeldet und auf der Profilseite.  | Nutzer bearbeitet seine Profildaten und klickt auf "Speichern".            | Die Profildaten werden aktualisiert und eine Bestätigungsmeldung wird angezeigt.           |
| 3.1  | Nutzer ist auf der Produktkatalogseite.         | Nutzer wählt eine Kategorie aus dem Dropdown-Menü.                         | Die Produkte der gewählten Kategorie werden angezeigt.                                     |
| 3.2  | Nutzer ist auf der Produktkatalogseite.         | Nutzer gibt einen Suchbegriff in die Suchleiste ein.                       | Die passenden Produkte werden basierend auf dem Suchbegriff angezeigt.                     |
| 4.1  | Nutzer ist angemeldet und auf der Produktseite. | Nutzer klickt auf "Zum Warenkorb hinzufügen".                              | Das Produkt wird dem Warenkorb hinzugefügt und der Nutzer erhält eine Bestätigungsmeldung. |
| 5.1  | Nutzer hat Produkte im Warenkorb.               | Nutzer klickt auf "Checkout".                                              | Der Checkout-Prozess wird gestartet, und der Nutzer wird zur Zahlungsseite weitergeleitet. |
| 6.1  | Die Anmeldeseite ist aufgerufen.                | Nutzer gibt ungültige Anmeldedaten ein (z.B. falsches Passwort).           | Eine Fehlermeldung wird angezeigt, dass die Anmeldedaten ungültig sind.                    |
| 7.1  | Testumgebung ist bereitgestellt.                | bereitgestellt.    Tests werden ausgeführt.                                | Mindestens 80% der Testfälle werden erfolgreich bestanden.                                 |

### 1.4 Diagramme

✍️ Hier können Sie PAPs, Use Case- und Gantt-Diagramme oder Ähnliches einfügen.

## 2 Planen

| AP-№ | Frist    | Zuständig | Beschreibung                                       | geplante Zeit |
| ---- | -------- | --------- | -------------------------------------------------- | ------------- |
| 1.A  | 23.08.24 | Beide     | Einrichtung der Entwicklungsumgebung               | 45'           |
| 1.B  | 23.08.24 | Timo      | Auswahl der Technologien                           | 45'           |
| 1.C  | 23.08.24 | Julius    | Grundstruktur der Anwendung aufsetzen              | 45'           |
| 1.D  | 30.08.24 | Timo      | Implementierung der Nutzerregistrierung (Backend)  | 45'           |
| 1.E  | 30.08.24 | Julius    | Implementierung der Nutzerregistrierung (Frontend) | 45'           |
| 1.F  | 30.08.24 | Timo      | Implementierung der Nutzeranmeldung (Backend)      | 45'           |
| 1.G  | 30.08.24 | Julius    | Implementierung der Nutzeranmeldung (Frontend)     | 45'           |
| 2.A  | 06.09.24 | Julius    | Entwicklung der Profildatenverwaltung (Backend)    | 45'           |
| 2.B  | 06.09.24 | Timo      | Entwicklung der Profildatenverwaltung (Frontend)   | 45'           |
| 3.A  | 13.09.24 | Timo      | Aufbau der Produkt-Datenbankstruktur               | 45'           |
| 3.B  | 13.09.24 | Julius    | Entwicklung der API für Produkte und Kategorien    | 45'           |
| 3.C  | 13.09.24 | Timo      | Implementierung der Kategoriefilterung (Backend)   | 45'           |
| 3.D  | 20.09.24 | Julius    | Implementierung der Kategoriefilterung (Frontend)  | 45'           |
| 3.E  | 20.09.24 | Timo      | Implementierung der Produktsuche (Backend)         | 45'           |
| 3.F  | 20.09.24 | Julius    | Implementierung der Produktsuche (Frontend)        | 45'           |
| 6.A  | 27.09.24 | Julius    | Implementierung der Sicherheitsmaßnahmen für Login | 45'           |
| 6.B  | 27.09.24 | Timo      | Überprüfung der Sicherheitsmaßnahmen durch Tests   | 45'           |
| 7.A  | 27.09.24 | Julius    | Durchführung von Unit-Tests für alle Module        | 45'           |
| 7.B  | 27.09.24 | Timo      | Erreichen der Testabdeckung von 80%                | 45'           |
| 7.C  | 27.09.24 | Beide     | End-to-End-Tests und Fehlerbehebung                | 45'           |

Total: 

✍️ Die Nummer hat das Format `N.m`, wobei `N` die Nummer der User Story ist, auf die sich das Arbeitspaket bezieht, und `m` von `A` an nach oben buchstabiert. Beispiel: Das dritte Arbeitspaket, das die zweite User Story betrifft, hat also die Nummer `2.C`.

✍️ Ein Arbeitspaket sollte etwa 45' für eine Person in Anspruch nehmen. Die totale Anzahl Arbeitspakete sollte etwa Folgendem entsprechen: `Anzahl R-Sitzungen` ╳ `Anzahl Gruppenmitglieder` ╳ `4`. Wenn Sie also zu dritt an einem Projekt arbeiten, für welches zwei R-Sitzungen geplant sind, sollten Sie auf `2` ╳ `3` ╳`4` = `24` Arbeitspakete kommen. Sollten Sie merken, dass Sie hier nicht genügend Arbeitspakte haben, denken Sie sich weitere "Kann"-User Stories für Kapitel 1.2 aus.

## 3 Entscheiden

✍️ Dokumentieren Sie hier Ihre Entscheidungen und Annahmen, die Sie im Bezug auf Ihre User Stories und die Implementierung getroffen haben.

## 4 Realisieren

| AP-№ | Datum | Zuständig | geplante Zeit | tatsächliche Zeit |
| ---- | ----- | --------- | ------------- | ----------------- |
| 1.A  |       |           |               |                   |
| ...  |       |           |               |                   |

✍️ Tragen Sie jedes Mal, wenn Sie ein Arbeitspaket abschließen, hier ein, wie lang Sie effektiv dafür hatten.

## 5 Kontrollieren

### 5.1 Testprotokoll

| TC-№ | Datum | Resultat | Tester |
| ---- | ----- | -------- | ------ |
| 1.1  |       |          |        |
| ...  |       |          |        |

✍️ Vergessen Sie nicht, ein Fazit hinzuzufügen, welches das Test-Ergebnis einordnet.

### 5.2 Exploratives Testen

| BR-№ | Ausgangslage | Eingabe | Erwartete Ausgabe | Tatsächliche Ausgabe |
| ---- | ------------ | ------- | ----------------- | -------------------- |
| I    |              |         |                   |                      |
| ...  |              |         |                   |                      |

✍️ Verwenden Sie römische Ziffern für Ihre Bug Reports, also I, II, III, IV etc.

## 6 Auswerten

✍️ Fügen Sie hier eine Verknüpfung zu Ihrem Lern-Bericht ein.
