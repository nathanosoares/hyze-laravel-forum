<?php

if (!function_exists('markconverter')) {
    function markconverter($text)
    {
        $converter = app('markconverter');
        return $converter->convertToHtml($text);
    }
}

if (!function_exists('user_url')) {
    function user_url($user)
    {
        return "https://twitter.com/" . $user->username;
    }
}

if (!function_exists('thread_url')) {
    function thread_url($thread)
    {
        return route('forums.thread', [$thread->slug, $thread->id]);
    }
}


if (!function_exists('forum_url')) {
    function forum_url($forum)
    {
        return route('forums.forum', [$forum->slug, $forum->id]);
    }
}

if (!function_exists('html_cut')) {
    function html_cut($text, $max_length)
    {
        $tags = array();
        $result = "";

        $is_open = false;
        $grab_open = false;
        $is_close = false;
        $in_double_quotes = false;
        $in_single_quotes = false;
        $tag = "";

        $i = 0;
        $stripped = 0;

        $stripped_text = strip_tags($text);

        while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length) {
            $symbol = $text{
                $i};
            $result .= $symbol;

            switch ($symbol) {
                case '<':
                    $is_open = true;
                    $grab_open = true;
                    break;
                case '"':
                    if ($in_double_quotes) {
                        $in_double_quotes = false;
                    } else {
                        $in_double_quotes = true;
                    }
                    break;
                case "'":
                    if ($in_single_quotes) {
                        $in_single_quotes = false;
                    } else {
                        $in_single_quotes = true;
                    }
                    break;
                case '/':
                    if ($is_open && !$in_double_quotes && !$in_single_quotes) {
                        $is_close = true;
                        $is_open = false;
                        $grab_open = false;
                    }
                    break;
                case ' ':
                    if ($is_open) {
                        $grab_open = false;
                    } else {
                        $stripped++;
                    }
                    break;
                case '>':
                    if ($is_open) {
                        $is_open = false;
                        $grab_open = false;
                        array_push($tags, $tag);
                        $tag = "";
                    } elseif ($is_close) {
                        $is_close = false;
                        array_pop($tags);
                        $tag = "";
                    }
                    break;
                default:
                    if ($grab_open || $is_close) {
                        $tag .= $symbol;
                    }

                    if (!$is_open && !$is_close) {
                        $stripped++;
                    }
            }

            $i++;
        }

        while ($tags) {
            $result .= "</" . array_pop($tags) . ">";
        }

        return $result;
    }
}


if (!function_exists('plural')) {
    function plural(string $singular, string $plural, int $amount, string $zero = null): string
    {
        return $amount == 1 ? "${amount} ${singular}" : ($amount == 0 && $zero ? "${zero}" : "${amount} ${plural}");
    }
}


if (!function_exists('url_to_domain')) {
    function url_to_domain($url)
    {
        $host = @parse_url($url, PHP_URL_HOST);
        // If the URL can't be parsed, use the original URL
        // Change to "return false" if you don't want that
        if (!$host)
            $host = $url;
        // The "www." prefix isn't really needed if you're just using
        // this to display the domain to the user
        if (substr($host, 0, 4) == "www.")
            $host = substr($host, 4);
        // You might also want to limit the length if screen space is limited
        if (strlen($host) > 50)
            $host = substr($host, 0, 47) . '...';
        return $host;
    }
}
