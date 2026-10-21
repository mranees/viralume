<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)->in('Feature');


function get($uri)
{
    return test()->get($uri);
}
function post($uri, $data)
{
    return test()->post($uri, $data);
}
