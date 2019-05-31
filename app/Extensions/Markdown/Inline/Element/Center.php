<?php


namespace App\Extensions\Markdown\Inline\Element;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Cursor;

class Center extends AbstractBlock
{

    /**
     * Returns true if this block can contain the given block as a child node
     *
     * @param AbstractBlock $block
     *
     * @return bool
     */
    public function canContain(AbstractBlock $block): bool
    {
        return true;
    }

    /**
     * Returns true if block type can accept lines of text
     *
     * @return bool
     */
    public function acceptsLines(): bool
    {
        return false;
    }

    /**
     * Whether this is a code block
     *
     * @return bool
     */
    public function isCode(): bool
    {
        return false;
    }

    /**
     * @param Cursor $cursor
     *
     * @return bool
     */
    public function matchesNextLine(Cursor $cursor): bool
    {
        $tmpCursor = clone $cursor;
        $tmpCursor->advanceToNextNonSpaceOrTab();
        $rest = $tmpCursor->getRemainder();

        if (preg_match('/^->/', $rest) !== 1) {
            return false;
        }

        $cursor->advanceToNextNonSpaceOrTab();
        $cursor->advance();
        $cursor->advanceBySpaceOrTab();

        return true;
    }
}