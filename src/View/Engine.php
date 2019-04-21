<?php declare(strict_types=1);

namespace App\View;

use App\Contracts\View\EngineInterface;
use App\Contracts\View\ViewException;
use eftec\bladeone\BladeOne;
use Exception;

class Engine implements EngineInterface
{

    private $engine = null;

    public function __construct(BladeOne $engine)
    {
        $this->engine = $engine;
    }

    public function get(string $path, array $data = []) : string
    {
        try
        {
            return $this->engine->run($path, $data);
        }
        catch (Exception $ex)
        {
            throw new ViewException($ex->getMessage());
        }
    }
}