<?php
namespace app\Search\controller;

class Index
{
    public function index($q)
    {
        return 'index hello'.$q;
    }
}
