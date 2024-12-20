# Projekt-Dokumentation

Goedertier Timo, Manser Alberto, Lutziger Cyril, Atputharasa Agachan

| Datum | Version | Zusammenfassung |
|-------|---------|----------------|
| 15.11.24 | 0.0.1 | Login hinzugefügt, Warenkorb speichert ab |
| 22.11.24 | 0.0.2 | Warenkorb fertig, Checkout begonnen |
| 29.11.24 | 0.0.3 | Warenkorb-Entfernung implementiert, Login-System vervollständigt |
| 06.12.24 | 0.0.4 | Wunschlisten und Bestellvorschau implementiert |
| 13.12.24 | 0.0.5 | Checkout-Prozess fertiggestellt, Einkaufsverlauf hinzugefügt |
| 20.12.24 | 1.0.0 | Finales Testing und Projektabschluss |

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
|7.1|	Kann|	Qualität|	Als User möchte ich eine Vorschau meiner Bestellung vor der Bezahlung sehen, damit ich sicher sein kann, dass alles korrekt ist.|
|7.2| Muss| Funktional | Als User möchte ich einen Funktionierenden Checkout sehen|
|7.3| Kann|	Funktional|	Als User möchte ich eine Bestätigungsmail nach Abschluss des Checkouts erhalten, damit ich einen Nachweis über meine Bestellung habe.|


### 1.3 Testfälle

|TC-№	|Ausgangslage|	Eingabe|	Erwartete Ausgabe|
|-------|------------|---------|---------------------|
|1.1.1	|Der Nutzer hat die Produktseite geöffnet.	|Der Nutzer klickt auf „In den Warenkorb“.	|Das Produkt wird erfolgreich in den Warenkorb gelegt.|
|1.2.1	|Der Warenkorb enthält Produkte.	|Der Nutzer öffnet den Warenkorb.	|Eine Liste der im Warenkorb enthaltenen Produkte wird angezeigt.|
|1.3.1	|Der Warenkorb enthält Produkte.	|Der Nutzer klickt auf „Entfernen“.	|Das ausgewählte Produkt wird aus dem Warenkorb entfernt.|
|2.1.1	|Der Nutzer ist nicht eingeloggt.	|Der Nutzer füllt die Registrierungsmaske aus und klickt auf „Registrieren“.	|Ein Unternehmenskonto wird erstellt, und der Nutzer wird eingeloggt.|
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
|7.1.1	|Der Warenkorb ist vollständig befüllt.	|Der Nutzer klickt auf „Zur Kasse gehen“.	|Eine Vorschau der Bestellung wird angezeigt.|
|7.2.1	|Der Nutzer hat die Bestellung überprüft.	|Der Nutzer klickt auf „Zahlen“.	|Die Zahlung wird erfolgreich abgeschlossen, und die Bestellung ist abgeschlossen.|
|7.3.1	|Der Checkout wurde erfolgreich abgeschlossen.	|Der Nutzer schliesst die Zahlung ab.	|Eine Bestätigungsmail wird an die hinterlegte E-Mail-Adresse gesendet.|


### 1.4 Diagramme
![image](https://github.com/user-attachments/assets/a6e3d4e5-b69c-437c-bc45-9cc738eb3ff5)


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
| 7.A  | 13.12.24| Cyril Lutziger |Entwicklung der Bestellvorschau. |1 Stunde|
| 7.B  | 13.12.24| Cyril Lutziger |Implementierung des Checkout-Prozesses. |3 Stunden|
| 7.C  | 13.12.24| Cyril Lutziger |Entwicklung der Bestätigungsmail-Funktion. |3 Stunden|
| 8.A  | 20.12.24| Alle | Durchführung Testen und Bugfixes | 5 Stunden |


## 3 Entscheiden

Wegen Zeitdruckes haben wir uns entschieden das Arbeitspaket 7.C nicht zu implementieren.
Die Arbeitspakete von 2 wurden ausserdem leicht verändert da wir keine separaten Loginfenster oder funktionen hinzugefügt haben.

## 4 Realisieren

|AP-№|	Datum|	Zuständig|	geplante Zeit|	tatsächliche Zeit|
|----|-------|-----------|---------------|-------------------|
|1.A|	15.11.24|	Alberto Manser|	1 Stunde| 1.5 Stunden |
|1.B|	22.11.24|	Alberto Manser|	2 Stunden| 4 Stunden |	
|1.C|	29.11.24|	Alberto Manser|	2 Stunden| 1 Stunde |
|2.A|	29.11.24|	Alberto Manser|	2 Stunden| 2 Stunden | 
|2.B|	15.11.24|	Agachan Atputharasa|	2 Stunden| 3 Stunden |	
|3.A|	22.11.24|	Agachan Atputharasa|	2 Stunden| 2 Stunden |
|3.B|	22.11.24|	Agachan Atputharasa|	2 Stunden| mit Login kombiniert |	
|4.A|	22.12.24|	Timo Goedertier|	2 Stunden| 5 Stunden |	
|4.B|	22.12.24|	Timo Goedertier| 2 Stunden|	2 Stunden |
|5.A|	29.12.24|	Timo Goedertier|	1.5 Stunden| 2 Stunden |
|5.B|	13.12.24|	Timo Goedertier|	2 Stunden| 2 Stunden |	
|6.A|	6.12.24|	Agachan Atputharasa|	2 Stunden| 1.5 Stunden |	
|6.B|	6.12.24|	Timo Goedertier|	1 Stunde| 2 Stunden|
|7.A|	6.12.24|	Cyril Lutziger|	1 Stunde| 1.5 Stunden	|
|7.B|	13.12.24|	Cyril Lutziger|	3 Stunden| 4 Stunden |	
|7.C|	13.12.24|	Cyril Lutziger|	3 Stunden| Nicht Implementiert |
|8.A|	20.12.24|	Alle|	5 Stunden|  |

## 5 Kontrollieren

### 5.1 Testprotokoll

| TC-№  | Datum    | Tester              | Resultat    | Fehlerbeschreibung |
|-------|----------|---------------------|-------------|-------------------|
| 1.1.1 | 08.11.24 | Alberto Manser      | Erfolgreich | |
| 1.2.1 | 08.11.24 | Alberto Manser      | Erfolgreich | |
| 1.2.1 | 15.11.24 | Alberto Manser      | Erfolgreich | |
| 1.3.1 | 15.11.24 | Alberto Manser      | Erfolgreich | |
| 2.1.1 | 15.11.24 | Agachan Atputharasa | Erfolgreich | |
| 2.2.1 | 22.11.24 | Agachan Atputharasa | Erfolgreich | |
| 3.1.1 | 22.11.24 | Agachan Atputharasa | Erfolgreich | |
| 3.2.1 | 29.11.24 | Agachan Atputharasa | Erfolgreich | |
| 4.1.1 | 29.11.24 | Timo Goedertier     | Erfolgreich | |
| 4.2.1 | 06.12.24 | Timo Goedertier     | Erfolgreich | |
| 4.3.1 | 06.12.24 | Timo Goedertier     | Erfolgreich | |
| 5.1.1 | 06.12.24 | Timo Goedertier     | Erfolgreich | |
| 5.2.1 | 06.12.24 | Timo Goedertier     | Erfolgreich | |
| 6.1.1 | 13.12.24 | Agachan Atputharasa | Erfolgreich | |
| 6.2.1 | 13.12.24 | Timo Goedertier     | Erfolgreich | |
| 7.1.1 | 13.12.24 | Cyril Lutziger      | Erfolgreich | |
| 7.2.1 | 20.12.24 | Cyril Lutziger      | Erfolgreich | |
| 7.3.1 | 20.12.24 | Cyril Lutziger      | Erfolgreich | |

