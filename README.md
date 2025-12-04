# REST API Kursverwaltung

## OpenAPI Spezifikation

Die vollständige API-Dokumentation ist in der `openapi.yaml` Datei verfügbar und folgt dem OpenAPI 3.0 Standard.

## Endpoints

### Lernende
- `GET /api/lernende` - Alle Lernende abrufen
- `GET /api/lernende?id={id}` - Einzelnen Lernenden abrufen
- `POST /api/lernende` - Lernenden erstellen
- `PUT /api/lernende` - Lernenden aktualisieren
- `DELETE /api/lernende` - Lernenden löschen

### Lehrbetriebe
- `GET /api/lehrbetriebe` - Alle Lehrbetriebe abrufen
- `GET /api/lehrbetriebe?id={id}` - Einzelnen Lehrbetrieb abrufen
- `POST /api/lehrbetriebe` - Lehrbetrieb erstellen
- `PUT /api/lehrbetriebe` - Lehrbetrieb aktualisieren
- `DELETE /api/lehrbetriebe` - Lehrbetrieb löschen

### Laender
- `GET /api/laender` - Alle Länder abrufen
- `GET /api/laender?id={id}` - Einzelnes Land abrufen
- `POST /api/laender` - Land erstellen
- `PUT /api/laender` - Land aktualisieren
- `DELETE /api/laender` - Land löschen

### Dozenten
- `GET /api/dozenten` - Alle Dozenten abrufen
- `GET /api/dozenten?id={id}` - Einzelnen Dozenten abrufen
- `POST /api/dozenten` - Dozenten erstellen
- `PUT /api/dozenten` - Dozenten aktualisieren
- `DELETE /api/dozenten` - Dozenten löschen

### Kurse
- `GET /api/kurse` - Alle Kurse abrufen
- `GET /api/kurse?id={id}` - Einzelnen Kurs abrufen
- `POST /api/kurse` - Kurs erstellen
- `PUT /api/kurse` - Kurs aktualisieren
- `DELETE /api/kurse` - Kurs löschen

### Kurse_Lernende
- `GET /api/kurse_lernende` - Alle Zuordnungen abrufen
- `GET /api/kurse_lernende?id={id}` - Einzelne Zuordnung abrufen
- `POST /api/kurse_lernende` - Zuordnung erstellen
- `PUT /api/kurse_lernende` - Zuordnung aktualisieren
- `DELETE /api/kurse_lernende` - Zuordnung löschen

### Lehrbetrieb_Lernende
- `GET /api/lehrbetrieb_lernende` - Alle Zuordnungen abrufen
- `GET /api/lehrbetrieb_lernende?id={id}` - Einzelne Zuordnung abrufen
- `POST /api/lehrbetrieb_lernende` - Zuordnung erstellen
- `PUT /api/lehrbetrieb_lernende` - Zuordnung aktualisieren
- `DELETE /api/lehrbetrieb_lernende` - Zuordnung löschen

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

