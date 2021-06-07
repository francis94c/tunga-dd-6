<?php

namespace App\Interfaces;

interface DataAdapter {
    public function iterate(callable $callback);
}