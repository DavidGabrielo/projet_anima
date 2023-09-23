<?php
class Database
{
    public $host = "mysql:dbname=projet_ecole_anima";
    public $user = "root";
    public $pswd = "";

    public function getconnexion()
    {
        try {
            return new PDO($this->host, $this->user, $this->pswd);
        } catch (PDOException $e) {
            die('Erreur' . $e->getMessage());
        }
    }
}
