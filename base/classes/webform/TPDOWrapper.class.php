<?php

class TPDOWrapper {
    private $dbType;
    private $username;
    private $password;
    private $database;
    private $host;
    private $port;
    private $schema;
    private $boolUtf8;
    public  $isPDO;

    public PDO $pdo;
    public string $poolId;

    private static $supportedDbTypes = [DBMS_POSTGRES, DBMS_MYSQL, DBMS_SQLITE, DBMS_ORACLE, DBMS_SQLSERVER];

    public function __construct(string $dbType
                               ,string $host = null
                               ,string $username = null
                               ,string $password = null
                               ,string $database = null
                               ,string $port = null 
                               ,string $schema = null
                               ,string $boolUtf8 = null) {
        $this->setDbType($dbType);
        $this->setHost($host);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setDatabase($database);
        $this->setPort($port);
        $this->setSchema($schema);
        $this->setBoolUtf8($boolUtf8);
        $this->isPDO = true;

        // Calcular o poolId
        $this->poolId = self::calculateIdConnect($this->dbType, $this->host, $this->username, $this->password, $this->database, $this->port, $this->schema, $this->boolUtf8);

        //Inicializar a conexão PDO
        //$this->initializePDO();
    }

    // Getters e Setters
    public function getDbType() {
        return $this->dbType;
    }

    public function setDbType($dbType) {
        self::isValidDbType($dbType);
        $this->dbType = StringHelper::strtoupper($dbType);
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getDatabase() {
        return $this->database;
    }

    public function setDatabase($database) {
        $this->database = $database;
    }

    public function getHost() {
        return $this->host;
    }

    public function setHost($host) {
        $this->host = $host;
    }

    public function getPort() {
        return $this->port;
    }

    public function setPort($port) {
        $this->port = $port;
    }

    public function getSchema() {
        return $this->schema;
    }

    public function setSchema($schema) {
        $this->schema = $schema;
    }

    public function getBoolUtf8() {
        return $this->boolUtf8;
    }

    public function setBoolUtf8($boolUtf8) {
        $this->boolUtf8 = $boolUtf8;
    }

    public function getPoolId() {
        return $this->poolId;
    }

    public function getPdo() {
        return $this->pdo;
    }

    public function setPdo(PDO $pdo) {
        $this->pdo = $pdo;
    }    

    // Métodos auxiliares
    private function initializePDO() {
        $dsn = $this->createDsn();
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        if ($this->boolUtf8) {
            $options[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'utf8'";
        }

        $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
    }

    private function createDsn() {
        $dsn = null;
        $DBMS= $this->getDbType();
        $host= $this->getHost();
        $port= $this->getPort();
        $database= $this->getDatabase();
        $username= $this->getUsername();
        $password= $this->getPassword();
        $dsn = TPDOConnection::getDsnPDO($DBMS,$host,$port,$database,$username,$password);
        if( empty($dsn) ){
            throw new Exception("Tipo de banco de dados não suportado: {$this->dbType}");
        }
        return $dsn;
    }

    public static function isValidDbType(string $dbType){
        $inArray = in_array( StringHelper::strtoupper($dbType), self::$supportedDbTypes);
        if ($inArray == false) {
            throw new Exception("Tipo de banco de dados não suportado: $dbType");
        }
    }

    public static function calculateIdConnect(string $dbType
                                             ,string $host = null
                                             ,string $username = null
                                             ,string $password = null
                                             ,string $database = null
                                             ,string $port = null 
                                             ,string $schema = null
                                             ,string $boolUtf8 = null) {
        self::isValidDbType($dbType);
        $string = strtolower($dbType.$host.$username.$password.$database.$port.$schema.$boolUtf8);
        $idConnect = md5($string);
        return $idConnect;
    }
}