<?php

namespace App\Interfaces\View;

interface ViewInterface
{
    /**
     * Render the current view and return it.
     *
     * What this function does is that it evaluates the current view, and returns its value as a string. That value can
     * for example be echoed later.
     */
    public function render(): string;

    /**
     * Set the data that will be passed through to the view. For example, if the following key-value pair is passed,
     *
     * ```php
     * $key = "address";
     * $value = "Sweden";
     * ```
     *
     * it can be accessed in the template by
     * ```php
     * $address
     * ```
     * @param string $key
     * @param $value
     */
    public function setAttribute(string $key, $value): void;
}
