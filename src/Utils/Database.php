<?php

declare(strict_types = 1);

namespace App;

use Exception;
use PDO;

class Database
{
    public function __construct(array $config)
    {   
        $dsn = "mysql:database={$config['database']};host={$config['host']}";
        try{
            $connection = new PDO(
                $dsn,
                $config['user'],
                $config['password']
            );
            
        } catch (Exception $e) {
            dump($e);
            exit;
        }
        dump($connection);

    }
}

?>