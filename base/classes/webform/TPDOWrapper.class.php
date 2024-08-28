<?php

class TPDOWrapper
{
    public PDO $pdo;
    public string $poolId;

    public function __construct(PDO $pdo, string $poolId)
    {
        $this->pdo = $pdo;
        $this->poolId = $poolId;
    }
}
?>