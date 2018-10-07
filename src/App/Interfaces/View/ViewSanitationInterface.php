<?php

namespace App\Interfaces\View;

interface ViewSanitationInterface
{
    /**
     * Escape the provided data.
     *
     * @param string $input
     * @return string
     */
    public function escape(string $input): string;
}
