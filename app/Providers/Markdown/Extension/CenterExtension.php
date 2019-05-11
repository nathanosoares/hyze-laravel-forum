<?php


namespace App\Providers\Markdown\Extension;

use App\Providers\Markdown\Inline\Element\Center;
use App\Providers\Markdown\Inline\Parser\CenterParser;
use App\Providers\Markdown\Inline\Renderer\CenterRenderer;
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