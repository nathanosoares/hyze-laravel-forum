<?php

namespace App\Extensions\Markdown\Inline\Renderer;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Util\RegexHelper;
use League\CommonMark\Inline\Renderer\LinkRenderer as Render;

class LinkRenderer extends Render
{

    /**
     * @param Link                     $inline
     * @param ElementRendererInterface $htmlRenderer
     *
     * @return HtmlElement
     */
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (!($inline instanceof Link)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . \get_class($inline));
        }

        $attrs = $inline->getData('attributes', []);

        $forbidUnsafeLinks = $this->config->getConfig('safe') || !$this->config->getConfig('allow_unsafe_links');
        if (!($forbidUnsafeLinks && RegexHelper::isLinkPotentiallyUnsafe($inline->getUrl()))) {
            $attrs['href'] = $inline->getUrl();
        }

        if (isset($inline->data['title'])) {
            $attrs['title'] = $inline->data['title'];
        }

        if (isset($attrs['target']) && $attrs['target'] === '_blank' && !isset($attrs['rel'])) {
            $attrs['rel'] = 'noopener noreferrer nofollow';
        }

        if (url_to_domain($inline->getUrl()) != url_to_domain(env('APP_URL'))) {
            $attrs['rel'] = 'noopener noreferrer nofollow';
        }

        return new HtmlElement('a', $attrs, $htmlRenderer->renderInlines($inline->children()));
    }
}
