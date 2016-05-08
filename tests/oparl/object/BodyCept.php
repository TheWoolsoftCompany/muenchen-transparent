<?php
$I = new OparlTester($scenario);
$I->wantTo('validate oparl:body objects (the Stadtrat and one BA)');
$I->sendGET('/body/0');
$I->seeOparl('
{
  "id": "http://localhost:8080/oparl/v1.0/body/0",
  "type": "https://oparl.org/schema/1.0/Body",
  "system": "http://localhost:8080/oparl/v1.0",
  "contactEmail": "info@muenchen-transparent.de",
  "contactName": "München Transparent",
  "name": "Stadrat der Landeshauptstadt München",
  "shortName": "Stadtrat",
  "website": "http://www.muenchen.de/",
  "organization": "http://localhost:8080/oparl/v1.0/body/0/list/organization",
  "person": "http://localhost:8080/oparl/v1.0/body/0/list/person",
  "meeting": "http://localhost:8080/oparl/v1.0/body/0/list/meeting",
  "paper": "http://localhost:8080/oparl/v1.0/body/0/list/paper",
  "legislativeTerm": [
    {
      "type": "https://oparl.org/schema/1.0/LegislativeTerm",
      "name": "Unbekannt",
      "startDate": "0000-00-00",
      "endDate": "0000-00-00",
      "id": "http://localhost:8080/oparl/v1.0/legislativeterm/0"
    },
    {
      "type": "https://oparl.org/schema/1.0/LegislativeTerm",
      "name": "1996-2002",
      "startDate": "1996-12-03",
      "endDate": "2002-12-03",
      "id": "http://localhost:8080/oparl/v1.0/legislativeterm/1"
    },
    {
      "type": "https://oparl.org/schema/1.0/LegislativeTerm",
      "name": "2002-2008",
      "startDate": "2002-12-03",
      "endDate": "2008-12-03",
      "id": "http://localhost:8080/oparl/v1.0/legislativeterm/2"
    },
    {
      "type": "https://oparl.org/schema/1.0/LegislativeTerm",
      "name": "2008-2014",
      "startDate": "2008-12-03",
      "endDate": "2014-12-03",
      "id": "http://localhost:8080/oparl/v1.0/legislativeterm/3"
    },
    {
      "type": "https://oparl.org/schema/1.0/LegislativeTerm",
      "name": "2014-2020",
      "startDate": "2014-12-03",
      "endDate": "2020-12-03",
      "id": "http://localhost:8080/oparl/v1.0/legislativeterm/4"
    }
  ]
}
');
$I->sendGET('/body/1');
$I->seeOparl('
{
  "id": "http://localhost:8080/oparl/v1.0/body/1",
  "type": "https://oparl.org/schema/1.0/Body",
  "system": "http://localhost:8080/oparl/v1.0",
  "contactEmail": "info@muenchen-transparent.de",
  "contactName": "München Transparent",
  "name": "Bezirksausschuss 1: BA mit Ausschuss mit Termin",
  "shortName": "BA 1",
  "website": "http://localhost:8080/bezirksausschuss/1_BA+mit+Ausschuss+mit+Termin",
  "organization": "http://localhost:8080/oparl/v1.0/body/1/list/organization",
  "person": "http://localhost:8080/oparl/v1.0/body/1/list/person",
  "meeting": "http://localhost:8080/oparl/v1.0/body/1/list/meeting",
  "paper": "http://localhost:8080/oparl/v1.0/body/1/list/paper",
  "legislativeTerm": [
    {
      "type": "https://oparl.org/schema/1.0/LegislativeTerm",
      "name": "Unbekannt",
      "startDate": "0000-00-00",
      "endDate": "0000-00-00",
      "id": "http://localhost:8080/oparl/v1.0/legislativeterm/0"
    },
    {
      "type": "https://oparl.org/schema/1.0/LegislativeTerm",
      "name": "1996-2002",
      "startDate": "1996-12-03",
      "endDate": "2002-12-03",
      "id": "http://localhost:8080/oparl/v1.0/legislativeterm/1"
    },
    {
      "type": "https://oparl.org/schema/1.0/LegislativeTerm",
      "name": "2002-2008",
      "startDate": "2002-12-03",
      "endDate": "2008-12-03",
      "id": "http://localhost:8080/oparl/v1.0/legislativeterm/2"
    },
    {
      "type": "https://oparl.org/schema/1.0/LegislativeTerm",
      "name": "2008-2014",
      "startDate": "2008-12-03",
      "endDate": "2014-12-03",
      "id": "http://localhost:8080/oparl/v1.0/legislativeterm/3"
    },
    {
      "type": "https://oparl.org/schema/1.0/LegislativeTerm",
      "name": "2014-2020",
      "startDate": "2014-12-03",
      "endDate": "2020-12-03",
      "id": "http://localhost:8080/oparl/v1.0/legislativeterm/4"
    }
  ]
}
');
