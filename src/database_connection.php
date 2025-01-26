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

