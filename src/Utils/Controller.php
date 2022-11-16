<?php
declare(strict_types = 1);

namespace App;

require_once("src/Exception/ConfigurationException.php");
require_once("src/View.php");
require_once("Database.php");

use App\Request;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;

class Controller
{
    private const DEFAULT_ACTION = 'list';
    
    private static array $configuration = [];

    private View $view;
    private Database $database;
    private Request $request;

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

    public function run(): void
    {
        switch($this->action())
        {
            case 'create':
                $page = 'create';
                
                if($this->request->hasPost())
                {
                    $noteData= [
                        'title' => $this->request->postParam('title'),
                        'description' => $this->request->postParam('description')
                    ];
                    $this->database->createNote($noteData);
                    header('Location: /?before=created');
                    exit;
                }
                break;

            case 'show':
                $page = 'show';

                $noteId = (int) $this->request->getParam('id');

                if(!$noteId)
                {
                    header('Location: /?error=missingNoteId');
                    exit; 
                }

                try
                {
                    $note = $this->database->getNote($noteId);
                }
                catch(NotFoundException $e)
                {
                    header('Location: /?error=noteNotFound');
                    exit('jesteśmy w kontrolerze');
                }
                $viewParams = [
                    'note' => $note
                ];
                break;
                
            default:
                $page = 'list';

                $viewParams = [
                    'notes' => $this->database->getNotes(),
                    'before' => $this->request->getParam('before'),
                    'error' => $this->request->getParam('error')
                ];
                break;
        }

        $this->view->render($page, $viewParams ?? []);
    }

    private function action(): string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }
}
?>