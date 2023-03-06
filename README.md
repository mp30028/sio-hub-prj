# sio-hub
Explore and try an API first approach


## Instructions to set up and try the first cut of the API running in Docker Containers


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
-v <adjust_this_path>/sio-hub-prj/src:/var/www/html/siohub `
-v <adjust_this_path>/sio-hub-prj/shared:/shared `
-p 8081:80 `
--entrypoint bash `
mp30028/sio-hub-httpd2
```

#### Step-5. Start up the web-server service in the container
`docker exec test-httpd service apache2 start`

#### Step-6. Load the postman collection in Postman-App. 
NB: Adjust the domain to point to where the docker containers are hosted.

