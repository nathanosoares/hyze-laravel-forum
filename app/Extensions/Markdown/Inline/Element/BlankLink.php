<?php


namespace App\Extensions\Markdown\Inline\Element;


use League\CommonMark\Inline\Element\Link;

class BlankLink extends Link
{
    /**
     * @param string $url
     * @param string|null $label
     * @param string $title
     */
    public function __construct($url, $label = null, $title = '')
    {
        parent::__construct($url, $label, $title);

        $this->data['attributes'] = ['target' => '_blank'];
    }
}