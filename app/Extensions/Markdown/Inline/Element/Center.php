<?php


namespace App\Extensions\Markdown\Inline\Element;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Cursor;
use League\CommonMark\Inline\Element\AbstractInlineContainer;
use League\CommonMark\Inline\Element\Text;

class Center extends AbstractBlock
{

    /**
     * Returns true if this block can contain the given block as a child node
     *
     * @param AbstractBlock $block
     *
     * @return bool
     */
    public function canContain(AbstractBlock $block)
    {
        return true;
    }

    /**
     * Returns true if block type can accept lines of text
     *
     * @return bool
     */
    public function acceptsLines()
    {
        return false;
    }

    /**
     * Whether this is a code block
     *
     * @return bool
     */
    public function isCode()
    {
        return false;
    }

    /**
     * @param Cursor $cursor
     *
     * @return bool
     */
    public function matchesNextLine(Cursor $cursor)
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