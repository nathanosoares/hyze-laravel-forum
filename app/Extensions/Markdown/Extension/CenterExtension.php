<?php


namespace App\Extensions\Markdown\Extension;

use App\Extensions\Markdown\Inline\Element\Center;
use App\Extensions\Markdown\Inline\Parser\CenterParser;
use App\Extensions\Markdown\Inline\Renderer\CenterRenderer;
use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\ConfigurableEnvironmentInterface;

class CenterExtension implements ExtensionInterface
{

    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment
            ->addBlockParser(new CenterParser())
            ->addBlockRenderer(Center::class, new CenterRenderer(), 0);
    }
}
