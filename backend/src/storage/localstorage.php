<?php

namespace dvegasa\cg2021\storage\localstorage;

class LocalStorage {
    const PATH = __DIR__ . '\\..\\..\\storage\\';

    function saveImageFromBase64(string $base64, string $name): void {
        file_put_contents(LocalStorage::PATH . 'images\\' . $name, base64_decode($base64));
    }

    // return string[] - file names
    function getLastNImages(int $n): array {
        $scan = scandir(LocalStorage::PATH . 'images', SCANDIR_SORT_DESCENDING);
        if (($key = array_search('.', $scan)) !== false) unset($scan[$key]);
        if (($key = array_search('..', $scan)) !== false) unset($scan[$key]);
        if (($key = array_search('test.png', $scan)) !== false) unset($scan[$key]);
        $scan = array_slice($scan, 0, $n);
        return $scan;
    }
}
