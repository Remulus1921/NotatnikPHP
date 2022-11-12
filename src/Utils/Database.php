<?php

declare(strict_types = 1);

namespace App;

require_once("src/Exception/StorageException.php");

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use PDO;
use PDOException;
use Throwable;

class Database
{
    public function __construct(array $config)
    {   
        try
        {
            $this->validateConfig($config);
            $dsn = "mysql:database={$config['database']};host={$config['host']}";

            $connection = new PDO(
                $dsn,
                $config['user'],
                $config['password']
            );
        //dump($connection);
        }
        catch(PDOException $e)
        {
            throw new StorageException('connection error');
        }
    }
    private function validateConfig(array $config): void
    {
        if(
            empty($config['database']) 
            || empty($config['host'])
            || empty($config['user'])
            || empty($config['password']))
        {
            throw new ConfigurationException('Stprage configuration error');
        }
    }
}

?>