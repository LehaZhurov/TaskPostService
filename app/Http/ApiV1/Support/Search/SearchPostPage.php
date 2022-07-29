<?php
namespace App\Http\ApiV1\Support\Search;
use Illuminate\Support\Collection;

class SearchPostPage 
{
    public function __construct(public array|Collection $posts,public $pagination){
        
    }
}