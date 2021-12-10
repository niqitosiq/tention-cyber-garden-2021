<?php

namespace dvegasa\cg2021\storage\localstorage;

class LocalStorage {
    const PATH = __DIR__ . '\\..\\..\\storage\\';

    function saveImageFromBase64(string $base64, string $name): void {
        file_put_contents(LocalStorage::PATH . 'images\\' . $name, base64_decode($base64));
    }
}
