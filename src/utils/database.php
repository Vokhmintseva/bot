<?php

function database(): PDO
{
    static $connection = null;
    if ($connection === null)
    {
        //echo "Create new batabase connection \n";
        $connection = new PDO(BD_DSN, BD_USER, DB_PASSWORD);
    }
    return $connection;
}

function saveFeedback(array $userDataArray): void
{
    $connection = database();
    $statement = $connection->prepare('INSERT INTO `user_data` (`name`, `email`, `country`, `gender`, `message`)
    VALUES (:name, :email, :country, :gender, :message)');
    foreach($userDataArray as $key => $value)
    {
        $statement->bindValue(':' . $key, $value);
    }
    echo ($statement->execute()) ? "" : "Unable to create record";
}

function getFeedback(string $email): ? array
{
    $connection = database();
    $email = $connection->quote("$email");
    $stmt = $connection->query(
        "SELECT `name`, `email`, `country`, `gender`, `message`
                   FROM `user_data`
                   WHERE email = {$email}");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$data)
    {
        return null;
    }
    else
    {
        return $data;
    }
}
