<?php


namespace App\Extensions\Markdown\Inline\Renderer;


use League\CommonMark\Inline\Renderer\LinkRenderer as Render;

class LinkRenderer extends Render
{

    /**
     * @param Center $block
     * @param ElementRendererInterface $htmlRenderer
     * @param bool $inTightList
     *
     * @return HtmlElement
     */
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, $inTightList = false)
    {

    }
}