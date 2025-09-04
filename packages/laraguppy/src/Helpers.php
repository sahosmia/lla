<?php

use Amentotech\LaraGuppy\Services\MessagesService;

if (!function_exists('sendMessage')) {
    function sendMessage($to, $from, $message) {
        return (new MessagesService)->sendMessage($to, $from, $message);
    }
}