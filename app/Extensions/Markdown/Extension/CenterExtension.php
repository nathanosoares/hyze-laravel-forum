<?php


namespace App\Extensions\Markdown\Extension;

use App\Extensions\Markdown\Inline\Element\Center;
use App\Extensions\Markdown\Inline\Parser\CenterParser;
use App\Extensions\Markdown\Inline\Renderer\CenterRenderer;
use League\CommonMark\Extension\Extension;

class CenterExtension extends Extension
{

    /**
     * {@inheritdoc}
     */
    public function getBlockParsers()
    {
        return [
            new CenterParser(),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function getBlockRenderers()
    {
        return [
            Center::class => new CenterRenderer(),
        ];
    }

}