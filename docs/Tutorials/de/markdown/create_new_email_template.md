# Anlegen und Bearbeiten von Email-Templates

Die Einbindung von Email-Templates gestaltet sich ganz einfach. Notwendig ist hierfür lediglich die Verwendung eines
Ordners  `GXModules/{Modulherstellername}/{Modulname}/Admin/MailTemplates`. Wichtig ist dabei, dass der
`MailTemplates`-Ordner Unterordner für die einzelnen Sprachen enthalten muss.

Möchtest du nun also ein Email-Template für die deutsche Sprache erstellt, dann muss deine HTML- und TXT-Datei im
Verzeichnis `GXModules/{Modulherstellername}/{Modulname}/Admin/MailTemplates/german/` ablegen.

**Beispiel:** Angenommen du möchtest das bestehende Email-Template
`lang/english/original_mail_templates/admin_create_account_mail.html` überschreiben, dann musst deine eigene HTML-Datei
unter `GXModules/{Modulherstellername}/{Modulname}/Admin/MailTemplates/german/admin_create_account_mail.html` ablegen.