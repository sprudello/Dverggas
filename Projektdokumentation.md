# Projekt-Dokumentation

Dverggas: Julius Burlet und Timo Goedertier

| Datum    | Version | Zusammenfassung                                                                                                      |
|----------|---------|-----------------------------------------------------------------------------------------------------------------------|
| 23.08.24 | 0.0.1   | Entwicklungsumgebung eingerichtet und Technologien für das Projekt ausgewählt.                                        |
| 30.08.24 | 0.1.0   | Grundstruktur der Anwendung erstellt und Registrierung sowie Anmelde-Funktionalitäten im Frontend und Backend umgesetzt. |
| 06.09.24 | 0.2.0   | Dunkelmodus-Toggle und grundlegende Profilverwaltung entwickelt.                                                     |
| 13.09.24 | 0.3.0   | Produkt-Datenbankstruktur aufgebaut und API für Produkte und Kategorien erstellt.                                   |
| 20.09.24 | 0.4.0   | Kategoriefilter und Produktsuche im Frontend und Backend implementiert.                                             |
| 27.09.24 | 0.5.0   | Sicherheitsmaßnahmen für die Anmeldung getestet und Unit-Tests für alle Module durchgeführt.                        |
| 27.09.24 | 1.0.0   | Kontrolle und Tests abgeschlossen und Anwendung für den produktiven Einsatz freigegeben.                               |
                                                                                                                                             |

## 1 Informieren

### 1.1 Ihr Projekt

Unser Projekt ist eine benutzerfreundliche Webanwendung, die es Nutzern ermöglicht, sich sicher zu registrieren, Produkte zu durchsuchen und Einkäufe unkompliziert abzuschliessen.

### 1.2 User Stories

| US-№ | Verbindlichkeit | Typ        | Beschreibung|
| ---- | --------------- | ---------- | ----------------------------------------------------------------------------------------------------------------------------------- |
| 1    | Muss            | Funktional | Als ein Nutzer möchte ich mich registrieren und anmelden können.|
| 2    | Kann            | Qualität | Als ein Nutzer möchte ich zwischen Hell- und Dunkelmodus wechseln können.|
| 3    | Muss            | Funktional | Als ein Nutzer möchte ich Produkte und Kategorien durchstöbern können.|
| 4    | Kann            | Funktional | Als ein Nutzer möchte ich sehen können, welche Sub-Kategorien in einer Kategorie existieren.|
| 5    | Kann            | Funktional | Als ein Nutzer möchte ich einen Checkout-Prozess durchführen können, damit ich meinen Kauf abschliessen kann.|
| 6    | Muss            | Rand       | Als ein Entwickler möchte ich eine sichere Nutzeranmeldung implementieren, damit die Nutzerdaten geschützt sind.|
| 7    | Muss            | Funktional   | Als ein Nutzer möchte ich eine Suchfunktion haben für Produkte.|
| 8    | Kann            | Funktional | Als ein Entwickler möchte ich Kategorien und Produkte in die Datenbank hinzufügen können und sie werden dargestellt, ohne dass ich sie persöhnlich in die Webseite einfügen muss.|

### 1.3 Testfälle

| TC-№ | Ausgangslage                               | Eingabe                                                | Erwartete Ausgabe                                     |
|-------|--------------------------------------------|--------------------------------------------------------|------------------------------------------------------|
| 1.1   | System ist gestartet, Registrierungsseite ist geöffnet | Gültige E-Mail, gültiges Passwort (mind. 8 Zeichen, Sonderzeichen) | Erfolgreiche Registrierung, Bestätigungsnachricht     |
| 1.2   | System ist gestartet, Registrierungsseite ist geöffnet | Bereits registrierte E-Mail-Adresse                     | Fehlermeldung: "E-Mail bereits registriert"           |
| 1.3   | System ist gestartet, Login-Seite ist geöffnet | Korrekte E-Mail und Passwort                            | Erfolgreicher Login, Weiterleitung zum Dashboard      |
| 2.1   | System im Hellmodus                         | Klick auf Dunkelmodus-Toggle                            | UI wechselt zu dunklem Farbschema                     |
| 2.2   | System im Dunkelmodus                       | Klick auf Hellmodus-Toggle                              | UI wechselt zu hellem Farbschema                      |
| 2.3   | Browser neu geöffnet                        | -                                                      | Zuletzt gewählter Modus wird beibehalten              |
| 3.1   | Startseite geöffnet                         | Navigation zur Produktübersicht                         | Liste aller verfügbaren Produkte                      |
| 3.2   | Startseite geöffnet                         | Navigation zur Kategorieübersicht                       | Liste aller Hauptkategorien                           |
| 3.3   | Produktübersicht geöffnet                   | Auswahl einer Kategorie                                 | Gefilterte Produktliste der gewählten Kategorie       |
| 4.1   | Kategorieübersicht geöffnet                 | Klick auf Hauptkategorie                                | Anzeige aller zugehörigen Sub-Kategorien              |
| 4.2   | Kategorie ohne Sub-Kategorien geöffnet      | Klick auf Kategorie                                     | Direkte Anzeige der Produkte                          |
| 4.3   | Sub-Kategorie geöffnet                      | Navigation zurück                                       | Rückkehr zur Hauptkategorie                           |
| 5.1   | Warenkorb mit Produkten                     | Start Checkout-Prozess                                  | Anzeige Lieferadress-Formular                         |
| 5.2   | Lieferadress-Formular                       | Eingabe gültiger Adressdaten                            | Weiterleitung zur Zahlungsmethode                     |
| 5.3   | Bestellübersicht                            | Bestätigung der Bestellung                              | Bestellbestätigung, Bestellnummer                     |
| 6.1   | Login-Versuch                               | 3 falsche Login-Versuche                                | Temporäre Sperrung des Accounts                       |
| 6.2   | Passwort-Reset angefordert                  | Klick auf Reset-Link                                    | Sichere Passwort-Reset-Seite                          |
| 6.3   | Aktive Session                              | 30 Minuten Inaktivität                                  | Automatische Abmeldung                                |
| 7.1   | Suchfeld geöffnet                           | Exakter Produktname                                     | Direkter Treffer wird angezeigt                       |
| 7.2   | Suchfeld geöffnet                           | Teilbegriff eines Produkts                              | Liste aller relevanten Treffer                        |
| 7.3   | Suchfeld geöffnet                           | Nicht existierendes Produkt                             | "Keine Treffer gefunden" Meldung                      |
| 8.1   | Admin-Bereich, Datenbankzugriff             | Neue Kategorie in DB erstellen                          | Automatische Anzeige auf Website                      |
| 8.2   | Admin-Bereich, Datenbankzugriff             | Neues Produkt in DB erstellen                           | Automatische Anzeige in entsprechender Kategorie      |
| 8.3   | Admin-Bereich, Datenbankzugriff             | Produkt in DB aktualisieren                             | Aktualisierte Anzeige auf Website                     |


### 1.4 Diagramme

✍️ Hier können Sie PAPs, Use Case- und Gantt-Diagramme oder Ähnliches einfügen.

## 2 Planen

| AP-№ | Frist    | Zuständig | Beschreibung                                                       | geplante Zeit |
| ---- | -------- | --------- | ------------------------------------------------------------------ | ------------- |
| 1.A  | 23.08.24 | Beide     | Testfall für Registrierung und Anmeldung vorbereiten (US 1)        | 60'           |
| 1.B  | 23.08.24 | Timo      | Implementierung der Registrierung (Backend) (US 1)                 | 90'           |
| 1.C  | 23.08.24 | Julius    | Implementierung der Anmeldung (Frontend und Backend) (US 1)        | 90'           |
| 1.D  | 30.08.24 | Timo      | Hell-/Dunkelmodus Toggle implementieren (Frontend) (US 2)          | 45'           |
| 2.A  | 06.09.24 | Julius    | Testfälle für Produkt- und Kategoriendurchstöberung entwickeln (US 3) | 60'           |
| 2.B  | 06.09.24 | Timo      | Implementierung der Kategoriedurchstöberung (Backend und Frontend) (US 3) | 120'      |
| 3.A  | 13.09.24 | Timo      | Implementierung der Sub-Kategorienansicht (Frontend) (US 4)        | 60'           |
| 3.B  | 13.09.24 | Julius    | Checkout-Prozess entwickeln (Backend) (US 5)                       | 90'           |
| 3.C  | 13.09.24 | Timo      | Frontend-Implementierung des Checkout-Prozesses (US 5)             | 60'           |
| 4.A  | 20.09.24 | Julius    | Sicherheitsmassnahmen für Nutzeranmeldung implementieren (US 6)     | 75'           |
| 4.B  | 20.09.24 | Timo      | Testfälle für Sicherheit der Anmeldung und Zugriff (US 6)          | 60'           |
| 5.A  | 20.09.24 | Beide     | Implementierung und Test der Produktsuche (Frontend und Backend) (US 7) | 120'   |
| 6.A  | 27.09.24 | Julius    | Datenbankzugriff für Kategorien und Produkte implementieren (US 8) | 90'           |
| 6.B  | 27.09.24 | Timo      | Automatische Anzeige von DB-Einträgen auf der Webseite (US 8)      | 60'           |
| 7.A  | 27.09.24 | Beide     | Durchführung und Dokumentation von End-to-End-Tests für alle Module| 120'         |
| 7.B  | 27.09.24 | Beide     | Fehlerbehebung und Optimierung basierend auf End-to-End-Tests      | 90'           |


## 3 Entscheiden

Bei der Umsetzung der User Stories haben wir uns für eine einfache, benutzerfreundliche Implementierung in HTML, Css und JavaScript im Frontend sowie PHP im Backend entschieden. Diese Technologien ermöglichen eine reibungslose Registrierung, Anmeldung und Verwaltung von Benutzerprofilen sowie die dynamische Anzeige von Produkten und Kategorien. Zusätzliche Sicherheitsmassnahmen wurden beim Login integriert, um den Schutz der Nutzerdaten zu gewährleisten.

## 4 Realisieren

| AP-№ | Datum    | Zuständig | geplante Zeit | tatsächliche Zeit |
| ---- | -------- | --------- | ------------- | ----------------- |
| 1.A  | 23.08.24 | Beide     | 60'           | 70'               |
| 1.B  | 23.08.24 | Timo      | 90'           | 80'               |
| 1.C  | 23.08.24 | Julius    | 90'           | 105'              |
| 1.D  | 30.08.24 | Timo      | 45'           | 50'               |
| 2.A  | 06.09.24 | Julius    | 60'           | 65'               |
| 2.B  | 06.09.24 | Timo      | 120'          | 110'              |
| 3.A  | 13.09.24 | Timo      | 60'           | 55'               |
| 3.B  | 13.09.24 | Julius    | 90'           | 100'              |
| 3.C  | 13.09.24 | Timo      | 60'           | 45'               |
| 4.A  | 20.09.24 | Julius    | 75'           | 90'               |
| 4.B  | 20.09.24 | Timo      | 60'           | 70'               |
| 5.A  | 20.09.24 | Beide     | 120'          | 130'              |
| 6.A  | 27.09.24 | Julius    | 90'           | 85'               |
| 6.B  | 27.09.24 | Timo      | 60'           | 50'               |
| 7.A  | 27.09.24 | Beide     | 120'          | 135'              |
| 7.B  | 27.09.24 | Beide     | 90'           | 95'               |

## 5 Kontrollieren

### 5.1 Testprotokoll

| TC-№ | Datum    | Resultat | Tester   |
| ---- | -------- | -------- | -------- |
| 1.1  | 01.11.24 | OK       | Timo     |
| 1.2  | 01.11.24 | OK       | Julius   |
| 1.3  | 01.11.24 | OK       | Beide    |
| 2.1  | 01.11.24 | OK       | Timo     |
| 2.2  | 01.11.24 | OK       | Julius   |
| 2.3  | 01.11.24 | OK       | Beide    |
| 3.1  | 01.11.24 | OK       | Timo     |
| 3.2  | 01.11.24 | OK       | Julius   |
| 3.3  | 01.11.24 | OK       | Beide    |
| 4.1  | 01.11.24 | OK       | Timo     |
| 4.2  | 01.11.24 | OK       | Julius   |
| 4.3  | 01.11.24 | OK       | Beide    |
| 5.1  | 01.11.24 | OK       | Timo     |
| 5.2  | 01.11.24 | OK       | Julius   |
| 5.3  | 01.11.24 | OK       | Beide    |
| 6.1  | 01.11.24 | OK       | Timo     |
| 6.2  | 01.11.24 | OK       | Julius   |
| 6.3  | 01.11.24 | OK       | Beide    |
| 7.1  | 01.11.24 | OK       | Timo     |
| 7.2  | 01.11.24 | OK       | Julius   |
| 7.3  | 01.11.24 | OK       | Beide    |
| 8.1  | 01.11.24 | OK       | Timo     |
| 8.2  | 01.11.24 | OK       | Julius   |
| 8.3  | 01.11.24 | OK       | Beide    |


## 6 Auswerten

Lernbericht J. Burlet: https://portfolio.bbbaden.ch/view/view.php?t=b797748762c91ea576d3

Lernbericht T. Goedertier: https://portfolio.bbbaden.ch/view/view.php?t=bc66c3f58d01ad0a4053

