<?php declare(strict_types=1);

function __url(string $url) : string
{
    return $url;
}

function __dd($variable) : void
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    die();
}

function has_flash_message() : bool
{
    return isset($_SESSION['___FLASH_MESSAGE']);
}

function get_flash_messages() : array
{
    if(!has_flash_message()) return [];

    return  $_SESSION['___FLASH_MESSAGE'];
}

function clear_flash_messages() : void
{
    unset($_SESSION['___FLASH_MESSAGE']);
}

function add_flash_message($message, string $type) : void
{
    if(!array_key_exists('___FLASH_MESSAGE', $_SESSION))
    {
        $_SESSION['___FLASH_MESSAGE'] = [];
    }

    $data = compact('message', 'type');
    $data['is_list'] = is_array($message);

    $_SESSION['___FLASH_MESSAGE'][] = $data;
}

function flash_message_success($message) : void
{
    add_flash_message($message, 'success');
}

function flash_message_error($message) : void
{
    add_flash_message($message, 'danger');
}

