# Projekt-Dokumentation

Goedertier Timo, Manser Alberto, Lutziger Cyril, Atputharasa Agachan

| Datum | Version | Zusammenfassung                                              |
| ----- | ------- | ------------------------------------------------------------ |
| 15.11.24 | 0.0.1   |Login hinzugefügt, Warenkorb speichert ab  |
| 22.11.24       | 0.0.2| Warenkorb fertig, Checkout begonnen                                                              |
|       | 1.0.0   |                                                              |

## 1 Informieren

### 1.1 Ihr Projekt

Die Weiterführung des Projektes DVERGGAS 

### 1.2 User Stories

|US-№	|Verbindlichkeit |	Typ|	Beschreibung|
|---|----------------|-|-|
|1.1|	Muss|	Funktional|	Als User möchte ich Waren in einen Warenkorb hinzufügen können, damit ich meine gewünschten Produkte speichern kann.|
|1.2|	Muss|	Funktional|	Als User möchte ich meinen Warenkorb anschauen können, damit ich die hinzugefügten Produkte überprüfen kann.|
|1.3|	Muss|	Funktional|	Als User möchte ich Produkte aus meinem Warenkorb entfernen können, damit ich ihn anpassen kann.|
|2.1| Muss| Funktional| Als Unternehmen möchte ich einen Unternehmungsaccount erstellen können |
|2.2| Muss| Funktional| Als Unternehmen möchte ich mich in meinen Unternehmungsaccount einloggen können|
|3.1| Muss| Funktional| Als Privatnutzer möchte ich einen Privataccount erstellen können|
|3.2| Muss| Funktional| Als Privatnutzer möchte ich mich in meinen Privataccount einloggen können|
|4.1| Muss| Funktional| Als Nutzer möchte ich mein Profil verwalten können |
|4.2| Muss| Funktional| Als Nutzer möchte ich mein passwort ändern können|
|4.3| Muss| Funktional| Als Nutzer möchte ich meine Profilinformationen ändern können |
|5.1| Kann | Qualität | Als Nutzer möchte ich meine Notifications sehen können |
|5.2| Kann | Qualität | Als Nutzer möchte ich mein Einkaufsverlauf sehen können|
|6.1| Kann | Funktional| als Nutzer möchte ich Produkte zu einer Wunschliste hinzufügen können |
|6.2| Kann | Qualität | Als Nutzer möchte ich meine Wunschliste abrufen können |
|7.1|	Muss|	Funktional|	Als Unternehmen möchte ich Produkte veröffentlichen können, damit ich sie zum Verkauf anbieten kann.|
|7.2|	Muss|	Funktional|	Als Privatnutzer möchte ich eigene Produkte zum Verkauf anbieten können, damit ich sie anderen Nutzern zur Verfügung stellen kann.|
|8.1|	Kann|	Qualität|	Als User möchte ich eine Vorschau meiner Bestellung vor der Bezahlung sehen, damit ich sicher sein kann, dass alles korrekt ist.|
|8.2| Muss| Funktional | Als User möchte ich einen Funktionierenden Checkout sehen|
|8.3| Kann|	Funktional|	Als User möchte ich eine Bestätigungsmail nach Abschluss des Checkouts erhalten, damit ich einen Nachweis über meine Bestellung habe.|


### 1.3 Testfälle

|TC-№	|Ausgangslage|	Eingabe|	Erwartete Ausgabe|
|-------|------------|---------|---------------------|
|1.1.1	|Der Nutzer hat die Produktseite geöffnet.	|Der Nutzer klickt auf „In den Warenkorb“.	|Das Produkt wird erfolgreich in den Warenkorb gelegt.|
|1.2.1	|Der Warenkorb enthält Produkte.	|Der Nutzer öffnet den Warenkorb.	|Eine Liste der im Warenkorb enthaltenen Produkte wird angezeigt.|
|1.3.1	|Der Warenkorb enthält Produkte.	|Der Nutzer klickt auf „Entfernen“.	|Das ausgewählte Produkt wird aus dem Warenkorb entfernt.|
|2.1.1	Der Nutzer ist nicht eingeloggt.	|Der Nutzer füllt die Registrierungsmaske aus und klickt auf „Registrieren“.	|Ein Unternehmenskonto wird erstellt, und der Nutzer wird eingeloggt.|
|2.2.1	|Der Unternehmenskonto-Benutzer existiert.	|Der Nutzer gibt seine Login-Daten ein und klickt auf „Einloggen“.	|Der Nutzer wird erfolgreich eingeloggt.
|3.1.1	|Der Nutzer ist nicht eingeloggt.	|Der Nutzer füllt die Registrierungsmaske aus und klickt auf „Registrieren“.	|Ein Privatkonto wird erstellt, und der Nutzer wird eingeloggt.|
|3.2.1	|Der Privatkonto-Benutzer existiert.	 |Der Nutzer gibt seine Login-Daten ein und klickt auf „Einloggen“.	|Der Nutzer wird erfolgreich eingeloggt.|
|4.1.1	|Der Nutzer ist eingeloggt.	|Der Nutzer öffnet die Profilseite und ändert Einstellungen.	|Die Änderungen werden gespeichert und aktualisiert.|
|4.2.1	|Der Nutzer ist eingeloggt.	|Der Nutzer gibt das aktuelle und ein neues Passwort ein und klickt auf „Speichern“.	|Das Passwort wird erfolgreich geändert.|
|4.3.1|	Der Nutzer ist eingeloggt.	|Der Nutzer aktualisiert Profilinformationen und klickt auf „Speichern“.	|Die aktualisierten Informationen werden gespeichert.|
|5.1.1	|Der Nutzer hat Benachrichtigungen.	|Der Nutzer öffnet die Notifications-Seite.|	Eine Liste der Benachrichtigungen wird angezeigt.|
|5.2.1	|Der Nutzer hat einen Einkaufsverlauf.	|Der Nutzer öffnet die Seite „Einkaufsverlauf“.	|Der Einkaufsverlauf wird angezeigt.|
|6.1.1	|Der Nutzer hat die Produktseite geöffnet.	|Der Nutzer klickt auf „Zur Wunschliste hinzufügen“.	|Das Produkt wird erfolgreich zur Wunschliste hinzugefügt.|
|6.2.1	|Der Nutzer hat Produkte in seiner Wunschliste.	|Der Nutzer öffnet die Wunschliste.	|Eine Liste der Produkte in der Wunschliste wird angezeigt.|
|7.1.1|	Der Nutzer ist als Unternehmen eingeloggt.	|Der Nutzer erstellt ein neues Produkt und klickt auf „Veröffentlichen“.	|Das Produkt wird erfolgreich veröffentlicht.|
|7.2.1	|Der Nutzer ist als Privatnutzer eingeloggt.	|Der Nutzer erstellt ein neues Produkt und klickt auf „Veröffentlichen“.	|Das Produkt wird erfolgreich veröffentlicht.|
|8.1.1	|Der Warenkorb ist vollständig befüllt.	|Der Nutzer klickt auf „Zur Kasse gehen“.	|Eine Vorschau der Bestellung wird angezeigt.|
|8.2.1	|Der Nutzer hat die Bestellung überprüft.	|Der Nutzer klickt auf „Zahlen“.	|Die Zahlung wird erfolgreich abgeschlossen, und die Bestellung ist abgeschlossen.|
|8.3.1	|Der Checkout wurde erfolgreich abgeschlossen.	|Der Nutzer schließt die Zahlung ab.	|Eine Bestätigungsmail wird an die hinterlegte E-Mail-Adresse gesendet.|


### 1.4 Diagramme

✍️ Hier können Sie PAPs, Use Case- und Gantt-Diagramme oder Ähnliches einfügen.

## 2 Planen

| AP-№ | Frist | Zuständig | Beschreibung | geplante Zeit |
| ---- | ----- | --------- | ------------ | ------------- |
| 1.A  | 13.12.24| Alberto Manser |Implementierung der Funktion, Produkte in den Warenkorb hinzuzufügen.|1 Stunde|
| 1.B  | 13.12.24| Alberto Manser |Entwicklung der Anzeige der Warenkorb-Inhalte.| 2 Stunden|
| 1.C  | 13.12.24| Alberto Manser |Implementierung der Funktion, Produkte aus dem Warenkorb zu entfernen. |2 Stunden |
| 2.A  | 13.12.24| Alberto Manser |Erstellung der Unternehmenskonto-Registrierungsfunktion. |2 Stunden  |
| 2.B  | 13.12.24| Agachan Atputharasa |Implementierung der Login-Funktion für Unternehmenskonten. |2 Stunden|
| 3.A  | 13.12.24| Agachan Atputharasa |Erstellung der Privatkonto-Registrierungsfunktion. |2 Stunden|
| 3.B  | 13.12.24| Agachan Atputharasa |Implementierung der Login-Funktion für Privatkonten. |2 Stunden|
| 4.A  | 13.12.24| Timo Goedertier |Entwicklung der Profilverwaltung für Nutzer. |2 Stunden|
| 4.B  | 13.12.24| Timo Goedertier |Implementierung der Passwortänderungsfunktion. |2 Stunden|
| 5.A  | 13.12.24| Timo Goedertier |Implementierung der Benachrichtigungsanzeige. |1.5 Stunden|
| 5.B  | 13.12.24| Timo Goedertier |Entwicklung der Einkaufsverlaufsanzeige. |2 Stunden|
| 6.A  | 13.12.24| Agachan Atputharasa |Implementierung der Wunschlisten-Funktion (Hinzufügen). |2 Stunden|
| 6.B  | 13.12.24| Timo Goedertier |Entwicklung der Wunschlistenanzeige. |1 Stunde|
| 7.A  | 13.12.24| Alberto Manser |Implementierung der Produktveröffentlichung für Unternehmen. |2 Stunden|
| 7.B  | 13.12.24| Timo Goedertier |Implementierung der Produktveröffentlichung für Privatnutzer. |2 Stunden|
| 8.A  | 13.12.24| Cyril Lutziger |Entwicklung der Bestellvorschau. |1 Stunde|
| 8.B  | 13.12.24| Cyril Lutziger |Implementierung des Checkout-Prozesses. |3 Stunden|
| 8.C  | 13.12.24| Cyril Lutziger |Entwicklung der Bestätigungsmail-Funktion. |3 Stunden|
| 9.A  | 20.12.24| Alle | Durchführung Testen und Bugfixes | 5 Stunden |


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
