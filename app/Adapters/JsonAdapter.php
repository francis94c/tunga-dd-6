<?php

namespace App\Adapters;

use App\Interfaces\DataAdapter;
use JsonMachine\JsonMachine;

class JsonAdapter implements DataAdapter
{
    /**
     * Json file location
     *
     * @var string
     */
    private $fileLocation;
    
    /**
     * Class constructor
     *
     * @param string $fileLocation
     */
    public function __construct(string $fileLocation)
    {
        $this->fileLocation = $fileLocation;
    }

    /**
     * Iterate through the data source.
     *
     * @param callable $callback
     * @return void
     */
    public function iterate(callable $callback)
    {
        $jsonArray = JsonMachine::fromFile($this->fileLocation);

        foreach ($jsonArray as $index => $data) {
            $callback($index, $data);
        }
    }
}
