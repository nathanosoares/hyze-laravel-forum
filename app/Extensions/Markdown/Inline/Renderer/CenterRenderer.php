<?php


namespace App\Extensions\Markdown\Inline\Renderer;


use App\Extensions\Markdown\Inline\Element\Center;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

class CenterRenderer implements BlockRendererInterface
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
        if (!($block instanceof Center)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        $attrs = $block->getData('attributes', []);
        $filling = $htmlRenderer->renderBlocks($block->children());

        if ($filling === '') {
            return new HtmlElement('center', $attrs, $htmlRenderer->getOption('inner_separator', "\n"));
        }

        return new HtmlElement(
            'center',
            $attrs,
            $htmlRenderer->getOption('inner_separator', "\n") . $filling . $htmlRenderer->getOption('inner_separator', "\n")
        );
    }
}