<?php

namespace App\Http\ApiV1\Requests;


interface SearchVoiceParams
{
    public function getFilter(): array;
    public function getSort(): array;
    public function isInclude(string $include): bool;
}
