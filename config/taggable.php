<?php

return [
    'delimiters' => ',;',

    'glue' => ',',

    'normalizer' => function($str) {
        return str_slug($str, '');
    },
];
