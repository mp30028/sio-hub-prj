
`sio-hub-httpd2`

---

```
docker run -it -d `
-p 8081:80 `
-v G:\dev\php-projects\sio-hub-wksp\sio-hub-prj\src:/var/www/html/siohub `
-v G:\dev\php-projects\sio-hub-shared:/shared `
--name sio-hub-httpd2 `
--entrypoint bash `
mp30028/sio-hub-httpd
```

---

`docker exec sio-hub-httpd2 service apache2 start`

---

`docker exec sio-hub-httpd2 tail -f /var/log/apache2/error.log`

---
Application Debug Log

Grant read write permissions to the debug log file
`chmod ugo+rw /var/log/siohub-debug.log`

Tail the log
`docker exec sio-hub-httpd2 tail -f /var/log/siohub-debug.log`

---

http://localhost:8081/

http://localhost:8081/siohub/public/PhpInfo.php

---

**require** and **include** are used to pull in the contents of one PHP file into another.

There is one big difference between **include** and **require**. If an included file is not found, then the script will continue to execute but with require the execution will throw an error.

Use **require** when the file is required by the application.

Use **include** when the file is not required and the application should continue even when the file is not found.

---


[Enabling rewrite URLs using .htaccess on Ubuntu 22.04](https://www.digitalocean.com/community/tutorials/how-to-rewrite-urls-with-mod_rewrite-for-apache-on-ubuntu-22-04)

[Installing Composer on Ubuntu 22.04](https://www.digitalocean.com/community/tutorials/how-to-install-composer-on-ubuntu-22-04-quickstart)

[Installing Monolog, Logging framework for PHP](https://betterstack.com/community/guides/logging/how-to-start-logging-with-php/#getting-started-with-monolog)
