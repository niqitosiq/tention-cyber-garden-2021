<?php

namespace dvegasa\cg2021\models;

class ImageURL {
    public function __construct(
            public string $url,
    ) {}
}

class ImageBase64 {
    public function __construct (
            public string $base64,
    ) {}
}
