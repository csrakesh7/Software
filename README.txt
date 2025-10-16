PrimeIT Website with PHPMailer (Ready-to-Configure)

Files included:
- index.html           -> Frontend (AJAX forms)
- send_mail.php        -> PHP mail handler using PHPMailer + Gmail SMTP
- README.txt           -> This file
- phpmailer/           -> (NOT included) you must download PHPMailer and place here

Important: PHPMailer library NOT included in this ZIP due to distribution. Follow steps below.

1) Download PHPMailer (stable):
   - Visit: https://github.com/PHPMailer/PHPMailer
   - Download ZIP and extract. Copy the files:
     PHPMailer.php
     SMTP.php
     Exception.php
   - Place them into the 'phpmailer' folder in the same directory as send_mail.php
   Example structure:
     /your-site/
       index.html
       send_mail.php
       phpmailer/PHPMailer.php
       phpmailer/SMTP.php
       phpmailer/Exception.php

2) Configure Gmail SMTP in send_mail.php:
   - Open send_mail.php and set:
       $mail->Username = 'yourname@gmail.com';
       $mail->Password = 'your-app-password';
     Also update recipient:
       $mail->addAddress('yourname@example.com', 'Website Recipient');

3) Create a Gmail App Password (recommended):
   - Use a Google account with 2-Step Verification enabled.
   - Go to https://myaccount.google.com/security -> App passwords
   - Create an App Password for 'Mail' (select device 'Other' and name it e.g., 'PrimeIT Website').
   - Copy the 16-character app password and paste into send_mail.php as $mail->Password.

4) Deploy:
   - Upload all files to your PHP-enabled hosting (Apache, Nginx + PHP-FPM).
   - Ensure outbound connections to smtp.gmail.com:587 are allowed by your host.

5) Testing:
   - Open index.html in a browser on your server and submit the forms.
   - The frontend uses AJAX and will show a small toast on success/error.

Security notes:
- Do not commit real passwords to public repos.
- For production, store credentials in environment variables or a secure config file.
- Consider using transactional email services (SendGrid/Mailgun/Amazon SES) for higher deliverability.
