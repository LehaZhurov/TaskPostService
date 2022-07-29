<?php
namespace App\Http\ApiV1\Support\Search;
use Illuminate\Support\Collection;

class PostDetail
{
    public function __construct(public $post,public $voices){
    }
}