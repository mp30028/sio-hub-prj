
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


---
### Testing baseline images for sio-hub

#### Step-1. Start up container with MySql
docker run -it -d --name test-mysql `
--rm `
-v G:\dev\docker-projects\tmp\sio-hub-prj\data:/var/lib/mysql `
-v G:\dev\docker-projects\tmp\sio-hub-prj\scripts:/var/scripts `
-p 3306:3306 `
-e MYSQL_ROOT_PASSWORD=R007Password*009 `
mp30028/sio-hub-mysql

#### Step-2. Create the database using the create_db.sql script
docker exec -i test-mysql sh -c 'exec mysql -uroot -pR007Password*009 < /var/scripts/create_db.sql'

#### Step-3. Start up the web-server container

docker run -it -d --name test-httpd `
--rm `
-v G:\dev\docker-projects\tmp\sio-hub-prj\src:/var/www/html/siohub `
-v G:\dev\docker-projects\tmp\shared:/shared `
-p 8081:80 `
--entrypoint bash `
mp30028/sio-hub-httpd2

docker exec test-httpd service apache2 start


#### SQL to check users have been created
SELECT Host, User, account_locked FROM mysql.user;



---
### Testing baseline images for sio-hub

#### Step-1 clone the repository
`git clone https://github.com/mp30028/sio-hub-prj`

#### Step-2. Start up container with MySql
```
docker run -it -d --name test-mysql `
--rm `
-v ./sio-hub-prj/data:/var/lib/mysql `
-v ./sio-hub-prj/scripts:/var/scripts `
-p 3306:3306 `
-e MYSQL_ROOT_PASSWORD=R007Password*009 `
mp30028/sio-hub-mysql
```

#### Step-3. Create the database using the create_db.sql script
`docker exec -i test-mysql sh -c 'exec mysql -uroot -pR007Password*009 < /var/scripts/create_db.sql'`

#### Step-4. Start up the web-server container
```
docker run -it -d --name test-httpd `
--rm `
-v /installed-apps/tmp/sio-hub-prj/src:/var/www/html/siohub `
-v /installed-apps/tmp/sio-hub-prj/shared:/shared `
-p 8081:80 `
--entrypoint bash `
mp30028/sio-hub-httpd2
```

#### Step-5. Start up the web-server service in the container
`docker exec sio-hub-httpd3 service apache2 start`


#### SQL to check users have been created
SELECT Host, User, account_locked FROM mysql.user;


#### Command used to create container sio-hub-httpd3 on 08-Mar-2023.
```
docker run -d -it `
--name sio-hub-httpd3 `
--volume=G:\dev\php-projects\sio-hub-wksp\sio-hub-prj\src:/var/www/html/siohub `
--volume=G:\dev\php-projects\sio-hub-shared:/shared `
-p 8081:80 `
-p 8082:81 `
--entrypoint bash `
mp30028/sio-hub-httpd2
```

#### Watching the web-server error logs
`docker exec sio-hub-httpd3 tail -f /var/log/apache2/error.log`

#### Watching the debug log
`Tail the log
`docker exec sio-hub-httpd3 tail -f /var/log/siohub-debug.log`


### Listening to events over WebSockets in Chrome

1. Open a blank page. Type `about:blank` in the address bar

2. Press `Ctrl-Shift-J` to open the console

3. Paste the following code to initiate a connection with the websockets server
```
var conn = new WebSocket('ws://localhost:8082');
conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
    console.log(e.data);
};
```
4. Open a second Chrome instance and repeat step 3

5. Type the following in one of the consoles `conn.send('Hello other console');`

6. You should see the message 'Hello other console' being echoed in the other console.

---

#### Headers from javascript making websocket connection
```   
GET ws://localhost:8082/ HTTP/1.1
Host: localhost:8082
Connection: Upgrade
Pragma: no-cache
Cache-Control: no-cache
User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36
Upgrade: websocket
Origin: null
Sec-WebSocket-Version: 13
Accept-Encoding: gzip, deflate, br
Accept-Language: en-GB,en-US;q=0.9,en;q=0.8
Sec-WebSocket-Key: 1lU/vQdcygKLKfDvcyVJIA==
Sec-WebSocket-Extensions: permessage-deflate; client_max_window_bits
```

---

#### CURL request based on javascript headers to make a websocket connection

```
curl \
    --include \
    --no-buffer \
    --header "Connection: Upgrade" \
    --header "Upgrade: websocket" \
    --header "Host: localhost:81" \
    --header "Origin: null" \
    --header "Sec-WebSocket-Version: 13" \
    --header "Pragma: no-cache" \
    --header "Cache-Control: no-cache" \
    --header "Sec-WebSocket-Key: 1lU/vQdcygKLKfDvcyVJIA==" \
    --header "Sec-WebSocket-Extensions: permessage-deflate; client_max_window_bits" \
    http://localhost:81/
```

---

#### Same thing done in postman. 

See ***sio-hub-websocket*** workspace for a working example

---
#### Playing around with javascript arrays

```
const numString = ["one", "two", "three", "four", "five", "six", "seven", "eight", "nine", "ten", "eleven", "twelve", "thirteen", "fourteen", "fifteen"];

const predicateFunction = (item) => {
	return (item.startsWith("s") || item.startsWith("t"));
}
```

`numString.find(predicateFunction);`

`numString.filter(predicateFunction);`


```
const numString = [
	{"id": 1, "value": "one"},
	{"id": 2, "value": "two"},
	{"id": 3, "value": "three"},
	{"id": 4, "value": "four"},
	{"id": 5, "value": "five"},
	{"id": 6, "value": "six"},
	{"id": 7, "value": "seven"},
	{"id": 8, "value": "eight"},
	{"id": 9, "value": "nine"},
	{"id": 10, "value": "ten"},
	{"id": 11, "value": "eleven"},
	{"id": 12, "value": "twelve"},
	{"id": 13, "value": "thirteen"},
	{"id": 14, "value": "fourteen"},
	{"id": 15, "value": "fifteen"}
];

const critera = [3, 11,14];

const filterNumstring = (source, toFind) => {
    return toFind.some(v => source.id.includes(v));
};


numString.includes( [{"id": 4, "value": "four"},{"id": 5, "value": "five"}]);

filterNumstring(numString, critera);

numString.map((o) => o.id}

```
