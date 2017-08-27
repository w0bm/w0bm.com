<?php

namespace App\Services;
use App\Models\User;

class Markdown extends \Parsedown {

    function __construct() {
        $this->setMarkupEscaped(true);
        $this->setBreaksEnabled(true);
        $this->setUrlsLinked(true);
        $this->InlineTypes['@'][] = 'UserMention';
        $this->InlineTypes['%'][] = 'ColoredText';
        $this->inlineMarkerList .= '@%';
    }

    protected function inlineUserMention($Excerpt) {
        
        if (preg_match('/\B@([a-zA-Z][\w-]+)/i', $Excerpt['context'], $matches)) {
            if(User::whereUsername($matches[1])->count() > 0) {
                return [
                    'extent' => strlen($matches[0]),
                    'element' => [
                        'name' => 'a',
                        'text' => $matches[0],
                        'attributes' => [
                            'href' => '/user/' . $matches[1], //link to username profile
                            'class' => 'user-mention', //style class of url
                        ],
                    ],
                ];
            } else {
                return [
                    'markup' => $matches[0],
                    'extent' => strlen($matches[0]),
                ];
            }
        }
    }

    // Matches %text%
    protected function inlineColoredText($Excerpt) {
        if (preg_match('/%(.+)%/', $Excerpt['text'], $matches)) {
            return [
                'extent' => strlen($matches[0]),
                'element' => [
                    'name' => 'span',
                    'text' => $matches[1],
                    'attributes' => [
                        'class' => 'anim'
                    ],
                ]
            ];
        }
    }

    //Greentext
    protected function blockQuote($Excerpt) {
        if (preg_match('/^>[ ]?(.*)/', $Excerpt['text'], $matches)) {
            $Block = [
                'element' => [
                    'name' => 'blockquote',
                    'handler' => 'lines',
                    'text' => (array) ('&gt;' . $matches[1]),
                ],
            ];
            return $Block;
        }

    }

    protected function blockQuoteContinue($Excerpt, array $Block) {
        if ($Excerpt['text'][0] === '>' && preg_match('/^>[ ]?(.*)/', $Excerpt['text'], $matches)) {
            if (isset($Block['interrupted'])) {
                $Block['element']['text'][] = '';
                unset($Block['interrupted']);
            }
            $Block['element']['text'][] = '&gt;' . $matches[1];
            return $Block;
        }
        if (!isset($Block['interrupted'])) {
            $Block['element']['text'][] = '&gt;' . $Excerpt['text'];
            return $Block;
        }
    }

    // Disable Lists
    protected function blockList($Excerpt) {
        return;
    }

    protected function blockListContinue($Excerpt, array $block) {
        return;
    }

    // Disable headers
    protected function blockHeader($Excerpt) {
        return;
    }

    protected function blockSetextHeader($Excerpt, array $block = null) {
        return;
    }

    protected function blockTable($Excerpt, array $block = null) {
        return;
    }

    // Disable markdown links
    protected function inlineLink($Excerpt) {
        return;
    }

    // Disable markdown images
    protected function inlineImage($Excerpt) {
        return;
    }

    // Differentiate between internal and external urls and images
    protected function inlineUrl($Excerpt) {
        $e = parent::inlineUrl($Excerpt);
        if (is_null($e)) return;
        if (static::isImage($e['element']['attributes']['href'])) {
            $e['element']['name'] = 'img';
            $e['element']['attributes']['src'] = $e['element']['attributes']['href'];
            $e['element']['attributes']['alt'] = 'Image';
            $e['element']['attributes']['class'] = 'comment_image';
            unset($e['element']['attributes']['href']);
            unset($e['element']['text']);
            return $e;
        }
        if (!static::isInternal($e['element']['attributes']['href'])) {
            $e['element']['attributes']['target'] = '_blank';
            $e['element']['attributes']['rel'] = 'extern';
        } else {
            $url = parse_url($e['element']['text']);
            $text = $url['path'];
            if (isset($url['query'])) {
                $text .= '?' . $url['query'];
            }
            if (isset($url['fragment'])) {
                $text .= '#' . $url['fragment'];
            }
            $e['element']['text'] = $text;
        }
        return $e;
    }

    private static function isInternal($url) {
        $host = parse_url($url, PHP_URL_HOST);
        $currhost = $_SERVER['SERVER_NAME'];
        if (0 === strpos($host, 'www')) {
            $host = substr($host, 4);
        }
        if (0 === strpos($currhost, 'www')) {
            $currhost = substr($currhost, 4);
        }
        return $host === $currhost;
    }

    private static function isImage($url) {
        $cfg = config('comments');
        $allowedHosters = $cfg['allowedHosters'];
        $allowedExtensions = $cfg['allowedImageFileExtensions'];
        $url = parse_url($url);
        if (isset($url['path'])) {
            $ext = pathinfo($url['path'], PATHINFO_EXTENSION);
            if (in_array($ext, $allowedExtensions)) {
                if (isset($url['scheme']) && $url['scheme'] === 'https') {
                    return in_array($url['host'], $allowedHosters);
                }
            }
        }
        return false;
    }


}
