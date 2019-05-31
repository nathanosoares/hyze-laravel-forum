<?php


namespace App\Extensions\Markdown\Inline\Parser;


use App\Extensions\Markdown\Inline\Element\BlankLink;
use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\InlineParserContext;

class TwitterHandleParser extends AbstractInlineParser
{
    public function getCharacters()
    {
        return ['@'];
    }

    public function parse(InlineParserContext $inlineContext)
    {
        $cursor = $inlineContext->getCursor();

        // The @ symbol must not have any other characters immediately prior
        $previousChar = $cursor->peek(-1);

        if ($previousChar !== null && $previousChar !== ' ') {
            // peek() doesn't modify the cursor, so no need to restore state first
            return false;
        }

        // Save the cursor state in case we need to rewind and bail
        $previousState = $cursor->saveState();

        // Advance past the @ symbol to keep parsing simpler
        $cursor->advance();

        // Parse the handle
        $handle = $cursor->match('/^[A-Za-z0-9_]{1,15}(?!\w)/');

        if (empty($handle)) {
            // Regex failed to match; this isn't a valid Twitter handle
            $cursor->restoreState($previousState);
            return false;
        }

        $profileUrl = 'https://twitter.com/' . $handle;
        $inlineContext->getContainer()->appendChild(new BlankLink($profileUrl, '@' . $handle));

        return true;
    }
}