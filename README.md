# passproject
basic admin control panel

(Last tested with Symfony 4.3.1 and PHP 7.1.3)
This project consists of several features described below
It is made with symfony framework and will not work without it
This Project does not use jQuery and there are no plans to implement it

the features:
  - An admin login panel
    - Utilizes MySQL Database users
    - Only admin users with mathing credentials can log in
    - CAPTCHA protection
  - An admin control panel:
    - Logs to a local file all successful log ins and log outs
    - Displays last 10 logs from the local file
    - Allows user to do the following operations:
      - Open command line for windows
      - Open Notepad for Windows
      - Log out back to the login panel
  - Not fully implemented
    - In the control panel:
      - display logged in users
      - allow for instant communication (chat) between users (integrated with AJAX)
      - display old conversations with the selected user
    
This app has been created for practice in the offline environment and is not suitable for use outside of it.
