<?php

namespace App\Extensions\Markdown\Inline\Parser;

use App\Extensions\Markdown\Inline\Element\Center;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;
use League\CommonMark\Block\Parser\BlockParserInterface;

class CenterParser implements BlockParserInterface
{

    public function parse(ContextInterface $context, Cursor $cursor): bool
    {

        $tmpCursor = clone $cursor;
        $tmpCursor->advanceToNextNonSpaceOrTab();
        $rest = $tmpCursor->getRemainder();

        if (preg_match('/^->/', $rest) !== 1) {
            return false;
        }

        $context->addBlock(new Center());

        $cursor->advanceToNextNonSpaceOrTab();
        $cursor->advance();
        $cursor->advanceBySpaceOrTab();

        return true;
    }
}
