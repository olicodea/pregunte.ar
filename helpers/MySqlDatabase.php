<?php

class MySqlDatabase {
    private $connection;

    public function __construct($serverName, $userName, $password, $databaseName) {
        $this->connection = mysqli_connect(
            $serverName,
            $userName,
            $password,
            $databaseName);

        if (!$this->connection) {
            die('Connection failed: ' . mysqli_connect_error());
        }
    }

    public function __destruct() {
        mysqli_close($this->connection);
    }

    public function query($sql) {
        $result = mysqli_query($this->connection, $sql);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function queryWthParameters($query, $value) {
        $stmt = mysqli_prepare($this->connection, $query);

        // Vincular el parámetro
        mysqli_stmt_bind_param($stmt, "s", $value);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }



    public function save($types, $values, $sql) {
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param($types, ...$values);
        $stmt->execute();
        $stmt->close();
        return true;
    }
}