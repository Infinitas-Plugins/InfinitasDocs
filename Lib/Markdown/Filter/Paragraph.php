<?php
/**
 * Copyright (C) 2011, Maxim S. Tsepkov
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

require_once __DIR__ . '/../Filter.php';

/**
 * Translates paragraphs.
 *
 * Definitions:
 * <ul>
 *   <li>paragraph is simply one or more consecutive lines of text,
 *      separated by one or more blank lines</li>
 *   <li>normal paragraphs should not be indented</li>
 *   <li>block level inline html must be separated with blank lines
 *      and start and end tags should not be indented</li>
 * </ul>
 *
 * @package Markdown
 * @subpackage Filter
 * @author Max Tsepkov <max@garygolden.me>
 * @version 1.0
 */
class Markdown_Filter_Paragraph extends Markdown_Filter
{
    /**
     * Pass given text through the filter and return result.
     *
     * @see Markdown_Filter::filter()
     * @param string $text
     * @return string $text
     */
    public function filter($text)
    {
        $result = '';

        // split by empty lines to match paragraphs
        foreach(preg_split('/\n\s*\n/', $text) as $snippet) {
            $snippet = trim($snippet, "\n");
            if (self::isParagraph($snippet)) {
                $result .= '<p>' . $snippet . '</p>';
            }
            else {
                $result .= $snippet;
            }
            $result .= "\n\n";
        }

        return rtrim($result, "\n") . "\n";
    }

    /**
     * Return true if given text is:
     * <ul>
     *   <li>not intended</li>
     *   <li>not started by a block-level tag</li>
     * </ul>
     *
     * False otherwise.
     *
     * @param string $text
     * @return bool
     */
    protected static function isParagraph($text)
    {
        if (strlen($text) > 0) {
            // should not be indented
            if (!preg_match('/^\s/', $text)) {
                // should not be a block-level tag
                $regex = sprintf('/^<(%s)/i', implode('|', self::$_blockTags));
                if (!preg_match($regex, $text)) {
                    return true;
                }
            }
        }

        return false;
    }
}
