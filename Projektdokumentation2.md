# Projekt-Dokumentation

☝️ Alle Text-Stellen, welche mit einem ✍️ beginnen, können Sie löschen, sobald Sie die entsprechende Stellen ausgefüllt haben.

✍️ Ihr Gruppenname und Ihre Nachnamen

| Datum | Version | Zusammenfassung                                              |
| ----- | ------- | ------------------------------------------------------------ |
|       | 0.0.1   |  |
|       | ...     |                                                              |
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
|3.2| Muss| Funktional| Als Privatnutzer möchte ich mich in meinen Privataccount einloggen können
|4.1|	Muss|	Funktional|	Als Unternehmen möchte ich Produkte veröffentlichen können, damit ich sie zum Verkauf anbieten kann.|
|4.2|	Muss|	Funktional|	Als Privatnutzer möchte ich eigene Produkte zum Verkauf anbieten können, damit ich sie anderen Nutzern zur Verfügung stellen kann.|
|5.1|	Kann|	Qualität|	Als User möchte ich eine Vorschau meiner Bestellung vor der Bezahlung sehen, damit ich sicher sein kann, dass alles korrekt ist.|
|5.2| Muss| Funktional | Als User möchte ich einen Funktionierenden Checkout sehen|
|5.3| Kann|	Funktional|	Als User möchte ich eine Bestätigungsmail nach Abschluss des Checkouts erhalten, damit ich einen Nachweis über meine Bestellung habe.|


✍️ Jede User Story hat eine ganzzahlige Nummer (1, 2, 3 etc.), eine Verbindlichkeit (Muss oder Kann?), und einen Typ (Funktional, Qualität, Rand). Die User Story selber hat folgende Form: *Als ein 🤷‍♂️ möchte ich 🤷‍♂️, damit 🤷‍♂️*.

### 1.3 Testfälle

|TC-№|	Ausgangslage|	Eingabe|	Erwartete Ausgabe|
|---|----------------|-|-|
|1.1.1|	Der Nutzer hat die Produktseite geöffnet.|	Der Nutzer klickt auf „In den Warenkorb“.|	Das Produkt wird erfolgreich in den Warenkorb gelegt.|
|1.2.1|	Der Warenkorb enthält Produkte.|	Der Nutzer öffnet den Warenkorb.|	Eine Liste der im Warenkorb enthaltenen Produkte wird angezeigt.|
|1.3.1|	Der Warenkorb enthält Produkte.|	Der Nutzer klickt auf „Entfernen“.|	Das ausgewählte Produkt wird aus dem Warenkorb entfernt.|
|2.1.1|	Der Nutzer ist als Unternehmen angemeldet.|	Der Nutzer erstellt ein neues Produkt und klickt auf „Veröffentlichen“.|	Das Produkt wird im Katalog veröffentlicht.|
|2.2.1|	Der Nutzer ist als Privatnutzer angemeldet.|	Der Nutzer erstellt ein neues Produkt und klickt auf „Veröffentlichen“.|	Das Produkt wird im Katalog veröffentlicht.|
|3.1.1|	Der Warenkorb ist vollständig befüllt.|	Der Nutzer klickt auf „Zur Kasse gehen“.|	Eine Übersicht mit den Bestelldetails wird angezeigt.|
|3.2.1|	Der Checkout wurde erfolgreich abgeschlossen.|	Der Nutzer schließt die Zahlung ab.|	Eine Bestätigungsmail wird an die hinterlegte E-Mail-Adresse gesendet.|

✍️ Die Nummer hat das Format `N.m`, wobei `N` die Nummer der User Story ist, die der Testfall abdeckt, und `m` von `1` an nach oben gezählt. Beispiel: Der dritte Testfall, der die zweite User Story abdeckt, hat also die Nummer `2.3`.

### 1.4 Diagramme

✍️ Hier können Sie PAPs, Use Case- und Gantt-Diagramme oder Ähnliches einfügen.

## 2 Planen

| AP-№ | Frist | Zuständig | Beschreibung | geplante Zeit |
| ---- | ----- | --------- | ------------ | ------------- |
| 1.A  |       |           |              |               |
| ...  |       |           |              |               |

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
