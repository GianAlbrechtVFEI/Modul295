# REST API Kursverwaltung

## OpenAPI Spezifikation

Die vollständige API-Dokumentation ist in der `openapi.yaml` Datei verfügbar und folgt dem OpenAPI 3.0 Standard.

## Endpoints

### Lernende
- `GET /api/lernende.php` - Alle Lernende abrufen
- `GET /api/lernende.php?id={id}` - Einzelnen Lernenden abrufen
- `POST /api/lernende.php` - Lernenden erstellen
- `PUT /api/lernende.php` - Lernenden aktualisieren
- `DELETE /api/lernende.php` - Lernenden löschen

### Lehrbetriebe
- `GET /api/lehrbetriebe.php` - Alle Lehrbetriebe abrufen
- `GET /api/lehrbetriebe.php?id={id}` - Einzelnen Lehrbetrieb abrufen
- `POST /api/lehrbetriebe.php` - Lehrbetrieb erstellen
- `PUT /api/lehrbetriebe.php` - Lehrbetrieb aktualisieren
- `DELETE /api/lehrbetriebe.php` - Lehrbetrieb löschen

### Laender
- `GET /api/laender.php` - Alle Länder abrufen
- `GET /api/laender.php?id={id}` - Einzelnes Land abrufen
- `POST /api/laender.php` - Land erstellen
- `PUT /api/laender.php` - Land aktualisieren
- `DELETE /api/laender.php` - Land löschen

### Dozenten
- `GET /api/dozenten.php` - Alle Dozenten abrufen
- `GET /api/dozenten.php?id={id}` - Einzelnen Dozenten abrufen
- `POST /api/dozenten.php` - Dozenten erstellen
- `PUT /api/dozenten.php` - Dozenten aktualisieren
- `DELETE /api/dozenten.php` - Dozenten löschen

### Kurse
- `GET /api/kurse.php` - Alle Kurse abrufen
- `GET /api/kurse.php?id={id}` - Einzelnen Kurs abrufen
- `POST /api/kurse.php` - Kurs erstellen
- `PUT /api/kurse.php` - Kurs aktualisieren
- `DELETE /api/kurse.php` - Kurs löschen

### Kurse_Lernende
- `GET /api/kurse_lernende.php` - Alle Zuordnungen abrufen
- `GET /api/kurse_lernende.php?id={id}` - Einzelne Zuordnung abrufen
- `POST /api/kurse_lernende.php` - Zuordnung erstellen
- `PUT /api/kurse_lernende.php` - Zuordnung aktualisieren
- `DELETE /api/kurse_lernende.php` - Zuordnung löschen

### Lehrbetrieb_Lernende
- `GET /api/lehrbetrieb_lernende.php` - Alle Zuordnungen abrufen
- `GET /api/lehrbetrieb_lernende.php?id={id}` - Einzelne Zuordnung abrufen
- `POST /api/lehrbetrieb_lernende.php` - Zuordnung erstellen
- `PUT /api/lehrbetrieb_lernende.php` - Zuordnung aktualisieren
- `DELETE /api/lehrbetrieb_lernende.php` - Zuordnung löschen

## Datenformat
- Content-Type: `application/json`
- Alle Anfragen und Antworten im JSON-Format

## HTTP Status Codes
- `200` - Erfolg
- `400` - Ungültige Anfrage
- `404` - Nicht gefunden
- `405` - Methode nicht erlaubt
- `409` - Duplicate Entry (z.B. Email bereits vorhanden)
- `500` - Serverfehler

