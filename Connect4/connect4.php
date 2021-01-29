<?php

require_once "lib/dbconnect.php";
require_once "lib/players.php";
require_once "lib/board.php";
require_once "lib/game_status.php";
require_once "lib/check_winner.php";

//analush tou ajax request
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);
if (isset($_SERVER['HTTP_X_TOKEN'])) {
    $input['token'] = $_SERVER['HTTP_X_TOKEN'];
}

//symfwna me thn parapanw analush epilogh ths katalhlhs methodou apo thn library
switch ($r = array_shift($request)) {
    case 'players':
        switch ($r = array_shift($request)) {
            case '':
                manage_player($method, $input);
                break;
        }
        break;
    case 'board':
        switch ($r = array_shift($request)) {
            case 'reset':
                reset_board();
                break;
            case 'move':
                manage_board($method, $input);
                break;
            case '':
                manage_board($method, $input);
                break;
        }
        break;
    case 'status':
        show_status();
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        print json_encode(['errormsg' => "Switch problem."]);
        exit;
}

function manage_player($method, $input)
{
    handle_player($method, $input);
}

function manage_board($method, $input)
{
    if ($method == 'PUT') {
        do_move($input);
    }
    if ($method == 'GET') {
        show_board();
    }
}
