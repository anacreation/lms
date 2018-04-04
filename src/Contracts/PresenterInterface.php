<?php
/**
 * Author: Xavier Au
 * Date: 27/3/2018
 * Time: 5:09 PM
 */

namespace Anacreation\Lms\Contracts;


interface PresenterInterface
{
    public function render(string $content, ...$options): string;
}