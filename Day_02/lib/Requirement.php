<?php

declare(strict_types = 1);

interface Requirement
{
    public function checkGame(Game $game): bool;
}
