<?php

use App\Models\App;
use App\Models\Command;
use App\Models\Flow;
use App\Models\Schema;
use App\Models\Simple;
use App\X\Detect;

function _act($code, $x = null)
{
    $cmd = Command::has($code);
    Detect::add("Act::$code", route('x.command.edit', [$cmd, 'view' => 'ref']));
    return $cmd->embed('source')->run($x);
}


function _ui($code, $data = [])
{
    $cmd = Command::has($code, 'ui');
    Detect::add("Ui::$code", route('x.command.edit', [$cmd, 'view' => 'ref']));
    return $cmd->embed('source')->run($data);
}


function _web($code,$data = [])
{
    $flow = Flow::has($code, 'web');
    Detect::add("Web::$code", route('x.flow.edit',[$flow, 'view' => 'ref']));
    return route($flow->route_name,$data);
}

function _api($code,$data = [])
{
    $flow = Flow::has($code, 'api');
    Detect::add("Api::$code", route('x.flow.edit', [$flow, 'view' => 'ref']));
    return route($flow->route_name,$data);
}


function _label($code)
{
    $simp = Simple::has($code, 'label');
    Detect::add("Label::$code", route('x.simple.edit', [$simp, 'view' => 'ref']));
    return $simp->value;
}

function _media($code)
{
    $simp = Simple::has($code, 'media');
    Detect::add("media::$code", route('x.simple.edit',   [$simp, 'view' => 'ref']));
    return $simp->val;
}


function _content($code)
{
    $simp = Simple::has($code, 'content');
    Detect::add("Content::$code", route('x.simple.edit',  [$simp, 'view' => 'ref']));
    return $simp->val->html;
}

//
function _schema($code)
{
    $schema = Schema::has($code);
    Detect::add("Schema::$code", route('x.simple.edit',  [$schema, 'view' => 'ref']));
    return  $schema->mix();
}


function _app($code)
{
    $app = App::has($code);
    Detect::add("App::$code", route('x.app.edit', [$app, 'view' => 'ref']));
    return $app;
}
