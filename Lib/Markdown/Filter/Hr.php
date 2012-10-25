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
 * Translates horizontal rules.
 *
 * Definitions:
 * <ul>
 *   <li>horizontal rule produced by placing three or more
 *      hyphens, asterisks, or underscores on a line by themselves</li>
 *   <li>spaces can be used between the hyphens or asterisks</li>
 * </ul>
 *
 * @package Markdown
 * @subpackage Filter
 * @author Igor Gaponov <jiminy96@gmail.com>
 * @version 1.0
 */
class Markdown_Filter_Hr extends Markdown_Filter
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
        return preg_replace(
            '/^ {0,3}([*-_])(?> {0,2}\1){2,} *$/m',
            "\n<hr />\n",
            $text
        );
    }
}
