<?php

return [
  'allowedHosters' => [
    'img.w0bm.com' => [
     '/^img\.w0bm\.com$/'
    ],
    'imgur.com' => [
      '/^i\.imgur\.com$/'
    ],
    'giphy.com' => [
      '/^media[0-6]?\.giphy\.com$/'
    ],
    'f0ck.me' => [
      '/^f0ck\.me$/'
    ],
    'tumblr.com' => [
      '/^(?:68|78)\.media\.tumblr\.com$/'
    ],
    'catbox.moe' => [
      '/^files\.catbox\.moe$/'
    ],
    'pr0gramm.com' => [
      '/^img\.pr0gramm\.com$/'
    ],
    '' => [
      '/^files\.nogf\.club$/',
      '/^f0ck\.space$/'
    ]
  ],
  'allowedImageFileExtensions' => [
    'jpg',
    'png',
    'gif',
  ]
];

