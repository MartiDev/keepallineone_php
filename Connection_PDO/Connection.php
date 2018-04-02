<?php

/**
 * Created by PhpStorm.
 * User: m14020696
 * Date: 18/11/15
 * Time: 10:33
 */
class SPDO {

    private $PDOInstance = null;
    private static $instance = null;

    const DEFAULT_SQL_USER = 'keepalliinbobo';
    const DEFAULT_SQL_HOST = 'keepalliinbobo.mysql.db';
    const DEFAULT_SQL_PASS = 'Hawk10081994';
    const DEFAULT_SQL_DTB = 'keepalliinbobo';

    private function __construct() {
        try {
            // Connexion à la base de données.
            $this->PDOInstance = new PDO('mysql:host=' . self::DEFAULT_SQL_HOST . ';dbname=' . self::DEFAULT_SQL_DTB, self::DEFAULT_SQL_USER, self::DEFAULT_SQL_PASS);
            $this->PDOInstance->exec('SET CHARACTER SET utf8');
            $this->PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Connexion impossible aux données. veuillez réessayer ultérieurement: ');
        }
    }

    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new SPDO();
        }
        return self::$instance;
    }

    public function exec($query) {
        return $this->PDOInstance->exec($query);
    }

    public function query($query) {
        $stock = $this->PDOInstance->query($query);
        if (!$stock){
            throw new Exception ('Erreur avec les données. Veuillez réessayer ultérieurement.');
        }
        return $stock;
    }

    public function quote($string) {
        $stock = $this->PDOInstance->quote($string);
        if (!$stock){
            throw new Exception('Le pilote du server ne supporte pas ce type de projections');
        }
        else {
            return $stock;
        }
    }

    public function prepare($query) {
        $stock = $this->PDOInstance->prepare($query);
        if (!$stock){
            throw new Exception('Probléme durant la préparation de la requête.');
        }
        else {
            return $stock;
        }
    }
    
    public function bindValue ($parameter, $value, int $data_type = Null){
        $stock = $this->PDOStatement->bindValue($parameter, $value, $data_type);
        if (!$stock){
            throw new Exception ('Probléme lors de l\'affectation d\'une valeur à un paramétre de la requête.');
        }
        else {
            return $stock;
        }
    }
    
    public function execute () {
        $stock = $this->PDOStatement->execute();
        if (!stock){
            throw new Exception ('Probléme lors de l\'éxécution de la requête');
        }
        else {
            return true;
        }
    }
}

?>