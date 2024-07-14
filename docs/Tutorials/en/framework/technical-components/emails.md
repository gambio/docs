# Emails

The new framework of the shop doesn't provide a new service to manage or send emails.


## Adding new email templates

The integration of new email templates or replacing them is straightforward. All you need to do is use the folder
`GXModules/<Vendor>/<Module>/Admin/MailTemplates`. The `MailTemplates` folder must contain subfolders for the
individual languages.

If you want to create an email template for the German language, you have to put your HTML and TXT file in the
folder `GXModules/<Vendor>/<Module>/Admin/MailTemplates/german/`.

__Example:__ Assuming you want to overwrite the existing email template
`lang/english/original_mail_templates/admin_create_account_mail.html`, you have to place your HTML file in the
directory `GXModules/<Vendor>/<Module>/Admin/MailTemplates/german/admin_create_account_mail.html`.
