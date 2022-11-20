<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Request;
use App\Database;
use App\View;
use App\Exception\ConfigurationException;

abstract class AbstractController 
{
    protected const DEFAULT_ACTION = 'list';
    
    private static array $configuration = [];

    protected View $view;
    protected Database $database;
    protected Request $request;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
    {
        if(empty(self::$configuration['db']))
        {
            throw new ConfigurationException('Cofniguration error');
        }
        $this->database = new Database(self::$configuration['db']);

        $this->request = $request;
        $this->view = new View();
    }

    final public function run(): void
    {
        $action = $this->action() . 'Action';
        if (!method_exists($this, $action))
        {
            $action = self::DEFAULT_ACTION . 'Action';
        }
            $this->$action();
    }  

    private function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }

    final protected function redirect(string $to, array $params): void
    {
        $location = $to;

        if(count($params))
        {
            $querryParams = [];
            foreach ($params as $key => $value)
            {
                $querryParams[] = urlencode($key) . '=' . urlencode($value);
            }
    
            $querryParams = implode('&', $querryParams);

            $location .= '?' . $querryParams;
        }
        header("Location: $location");
        exit;
    }
}