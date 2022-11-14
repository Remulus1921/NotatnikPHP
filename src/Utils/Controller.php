<?php
declare(strict_types = 1);

namespace App;

require_once("src/Exception/ConfigurationException.php");
require_once("src/View.php");
require_once("Database.php");

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

class Controller
{
    private const DEFAULT_ACTION = 'list';
    
    private static array $configuration = [];

    private View $view;
    private Database $database;
    private array $request;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(array $request)
    {
        if(empty(self::$configuration['db']))
        {
            throw new ConfigurationException('Cofniguration error');
        }
        $this->database = new Database(self::$configuration['db']);

        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        switch($this->action())
        {
            case 'create':
                $page = 'create';
                
                $data = $this->getRequestPost();
                if(!empty($data))
                {
                    $noteData= [
                        'title' => $data['title'],
                        'description' => $data['description']
                    ];
                    $this->database->createNote($noteData);
                    header('Location: /?before=created');
                }
                break;

            case 'show':
                $page = 'show';

                $data = $this->getRequestGet();
                $noteId = (int)$data['id'];

                try
                {
                    $this->database->getNote($noteId);
                }
                catch(NotFoundException $e)
                {
                    exit('jesteśmy w kontrolerze');
                }
                $viewParams = [
                    'title' => 'Moja notatka',
                    'description' => 'Opis'
                ];
                break;
                
            default:
                $page = 'list';

                $data = $this->getRequestGet();

                $viewParams = [
                    'notes' => $this->database->getNotes(),
                    'before' => $data['before'] ?? null
                ];
                break;
        }

        $this->view->render($page, $viewParams ?? []);
    }

    private function action(): string
    {
        $data = $this->getRequestGet();
        return $data['action'] ?? self::DEFAULT_ACTION;
    }

    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }

    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }
}
?>