**To Dockerize A PHP Application**
To Dockerize a php-based application successufully, we neet the following resources
- **PHP IMAGE**
- **DATABASE**
- **DATABASE ADMINISTRATION SOFTWARE**
First, create a new directory for the application: In the folder add a docker-compose.yml file. In the docker-compose file, we add two services- the web(php) and db(database).

The web service will use the php-apache image. This image gives us an apache server that's already setup with php. We can find this image in a dockerhub where all images are stored. On the php page, we can see many tags for php. One of them is php-apache. This image combines php runtime with apache server. With this combined we can easily build our docker-compose file for the web container.

The **version: '3'** at the top of the file indicates the version of the docker-compose file format that we are using. Each version of docker-compose's file format adds, removes, or changes it functionality compared to previous versions. Therefore, it's important to spacify the version you are using, so docker-compose knows which features it can expect of the file. 

Services: The "web" service is our webserver. We are using the php-apache image which gives us the php environment running on apache server. This image is pulled from dockerhub, a cloud-based registry service that allows us to distribute docker images.

The volumes' directives under the webserver **./:/var/www/html/**. Here the **./** represents the current directory on our Host machine and **/var/www/html/** is the default directory where apache looks for files to serve on the container. This configuration means our application's code based on the current directory is made available to the webserver in the docker container.

The ports directive is set to **80:80**. This means that port 80 on the localhost is mapped to port 80 on the container., which is where apache listens by default. However, You have the flexibibily to change the ports. For example if you want your webserver to listen to 8080, you can change the port directive to 8080:8080.

We also need a database(mysql) service. For this, we use the latest mysql image from the dockerhub.
The volumes's directive for the db service is **./db_data:/docker-entrypoint-initdb.d**. This creats a name volume **db_data** which is stored in the docker managed portion of the host's file system. All database's data will be stored here ensuring that they persist even if the container is stopped or deleted.

Environment directive is used to set environment variables in the db service. Here we're setting the *root password for mysql, the database name, the database user, and user password*. That's **(MYSQL_ROOT_PASSWORD, MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD)**. These environment variables are used to configure the MYSQL server inside the docker container.


PhpMyAdmin: We need to set up a phpmyadmin on our docker-compose file. This let us manage our database more easily.


Finally we'll define a volume section (as a service) of our docker-compose file. We'll sepacify the volume name "db". in docker, volumes are used for data persistence and sharing among containers. There are easy to backup or migrated and be managed with docker commands. By stating db, we will creating a volume named db. This volume will be linked to our db service ensuring that our database data will be stored on our local machine and lost if our database container is removed. Once our docker-conpose.yml file is ready, we will run our containers

```bash
*docker-compose up -d --build*
```

If you are using a MacOS or Windows system, it is necessary to launch the docker desktop application to get docker up and running. As for Linux as a service on the machine.

Our **index.php** file will contain supper html and php commands that echo **Hello Docker**

```bash
<!DOCTYPE html>
<html>

<head>
    <title>Wisdom</title>
</head>

<body>
    <h1>Welcome To Wisdom PHP Application Deployment Using Docker</h1>
    <p>
        <?php
            echo 'Hello Docker!!!';
        ?>
    </p>
</body>

</html>
```

When we run our docker containers and visit our localserver on the browser, we'll see, we'll see the "*Welcome To Wisdom PHP Application Deployment Using Docker*" message.

To test our database service, we can login to **MYSQL** service inside the container. To do this we execute the command

```bash
docker exec -t <container_name> /bin/bash
```

While in the container, we can login to mysql by using the following cmds
```bash
mysql -u <MYSQL_USER> -p<MYSQL_PASSWORD>
```
After loging into mysql database, we can run the following cmds
```bash
SHOW DATABASES
```

**CONNECT TO DATABASE**
Next we'll test our connection to the MYSQL DATABASE. For this, we'll create a nwe file called database_connection.php. In this file, we'll add codes specificly designed to test the connection to our MYSQL database.

```bash
<!DOCTYPE html>
<html>

<head>
    <title>Wisdom</title>
</head>

<body>
    <h1>Welcome To Database Connection</h1>
    <p>
        <?php
            $servername='mysql';
            $username= 'your_name';
            $password= 'your_pw';
            $dbname= 'your_db';
            $connection = new mysqli($servername, $username, $password,
$dbname);

            if ($connection->connect_error) {
                die('Connection failed: '. $connection->connect_error);
            }
            echo 'Connected Successfully!';
        ?>
    </p>
</body>

</html>
```

Once the file is ready we'll run it.
If you encounter an error message that points that **Class "mysqli"** in **/var/www/html/database_connection**, it means the **php-apache** image which is currently being in use by our webserver(php containers) doesn't include mysqli extention as part of it default configuration. To solve this error, we set the installation of mysqli extention in our Dockerfile. If set properply, then we can run the *database_connection* without any error.

**Scaling the PHP Service**
If you need to scale the PHP service to handle more traffic, you can scale the number of containers running the PHP service. For example:

```bash
docker-compose up -d --scale php=3
```
Pass the environment variable file to docker-compose.yml file

```bash
docker-compose --env-file <name_of_env_file> up -d
```
