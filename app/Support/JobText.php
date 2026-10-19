<?php

namespace App\Support;

/**
 * Turns plain-text job copy (headings on their own line, "* " bullets)
 * into clean HTML. Text that already contains HTML tags is passed through.
 *
 * Usage in Blade:  {!! \App\Support\JobText::format($vacancy->description) !!}
 */
class JobText
{
    public static function format(?string $text): string
    {
        $text = trim((string) $text);
        if ($text === '') {
            return '';
        }

        // Already HTML (e.g. from a rich-text editor): leave it alone.
        if ($text !== strip_tags($text)) {
            return $text;
        }

        $text  = str_replace(["\r\n", "\r", "\u{00A0}"], ["\n", "\n", ' '], $text);
        $lines = array_map('trim', explode("\n", $text));

        $html = '';
        $para = [];
        $list = [];

        $flushPara = function () use (&$html, &$para) {
            if ($para) {
                $html .= '<p>' . e(implode(' ', $para)) . '</p>';
                $para = [];
            }
        };
        $flushList = function () use (&$html, &$list) {
            if ($list) {
                $html .= '<ul>' . implode('', array_map(fn ($i) => '<li>' . e($i) . '</li>', $list)) . '</ul>';
                $list = [];
            }
        };

        foreach ($lines as $line) {
            if ($line === '') {
                $flushPara();
                continue; // blank lines don't end a list; the next non-bullet does
            }

            if (preg_match('/^([*\-•])\s+(.+)$/u', $line, $m)) {
                $flushPara();
                $list[] = $m[2];
                continue;
            }

            $flushList();

            // Short standalone line with no closing punctuation = sub-heading
            if (mb_strlen($line) <= 45 && !preg_match('/[.,;:!?]$/u', $line)) {
                $flushPara();
                $html .= '<h3>' . e($line) . '</h3>';
                continue;
            }

            $para[] = $line;
        }

        $flushPara();
        $flushList();

        return $html;
    }
}