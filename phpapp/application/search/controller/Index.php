<?php
namespace app\Search\controller;

class Index
{
    public function index($search)
    {
        return 'index hello'.$search;
    }
}
