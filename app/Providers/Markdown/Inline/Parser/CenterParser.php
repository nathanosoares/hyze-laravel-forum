<?php


namespace App\Providers\Markdown\Inline\Parser;


use App\Providers\Markdown\Inline\Element\Center;
use League\CommonMark\Block\Parser\AbstractBlockParser;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

class CenterParser extends AbstractBlockParser
{

    public function parse(ContextInterface $context, Cursor $cursor)
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