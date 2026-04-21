<?php

namespace App\Helpers;

class ContentRenderer
{
    /**
     * Convert our simple markdown+shortcode format to safe HTML.
     *
     * Supported syntax:
     *   ## Heading 2          -> <h2>
     *   ### Heading 3         -> <h3>
     *   #### Heading 4        -> <h4>
     *   **text**              -> <strong>
     *   *text*                -> <em>
     *   `inline code`         -> <code>
     *   [text](url)           -> <a>
     *   > blockquote          -> <blockquote>
     *   - list item           -> <ul><li>
     *   1. list item          -> <ol><li>
     *   ---                   -> <hr>
     *   ```lang\ncode\n```    -> code block with copy button
     *   [img: URL | caption]  -> <figure><img><figcaption>
     *   [iklan]               -> ad slot placeholder
     *   [iklan: leaderboard]  -> ad slot with type label
     */
    public static function render(string $raw): string
    {
        if (trim($raw) === '') {
            return '<p style="color:var(--text3);">Konten belum tersedia.</p>';
        }

        // 1. Normalize line endings
        $text = str_replace("\r\n", "\n", $raw);
        $text = str_replace("\r", "\n", $text);

        // 2. Extract & protect code blocks (``` ... ```)
        $codeBlocks = [];
        $text = preg_replace_callback(
            '/```(\w*)\n([\s\S]*?)```/m',
            function ($m) use (&$codeBlocks) {
                $lang    = trim($m[1]) ?: 'text';
                $code    = htmlspecialchars($m[2], ENT_QUOTES, 'UTF-8');
                $id      = '%%CODE_' . count($codeBlocks) . '%%';
                $codeBlocks[$id] = self::codeBlock($lang, $code);
                return $id;
            },
            $text
        );

        // 3. Extract & protect image shortcodes [img: url | caption]
        $imgBlocks = [];
        $text = preg_replace_callback(
            '/\[img:\s*([^\]|]+?)(?:\s*\|\s*([^\]]*))?\]/i',
            function ($m) use (&$imgBlocks) {
                $url     = htmlspecialchars(trim($m[1]), ENT_QUOTES, 'UTF-8');
                $caption = isset($m[2]) ? htmlspecialchars(trim($m[2]), ENT_QUOTES, 'UTF-8') : '';
                $id      = '%%IMG_' . count($imgBlocks) . '%%';
                $imgBlocks[$id] = self::imageBlock($url, $caption);
                return $id;
            },
            $text
        );

        // 4. Extract & protect ad slots [iklan] or [iklan: type]
        $adBlocks = [];
        $text = preg_replace_callback(
            '/\[iklan(?::\s*([^\]]*))?\]/i',
            function ($m) use (&$adBlocks) {
                $type = isset($m[1]) ? trim($m[1]) : 'banner';
                $id   = '%%AD_' . count($adBlocks) . '%%';
                $adBlocks[$id] = self::adSlot($type);
                return $id;
            },
            $text
        );

        // 5. Split into blocks by double newline
        $paragraphs = preg_split('/\n{2,}/', trim($text));
        $html = '';

        foreach ($paragraphs as $para) {
            $para = trim($para);
            if ($para === '') continue;

            // Already replaced placeholders - pass through
            if (preg_match('/^%%(CODE|IMG|AD)_\d+%%$/', $para)) {
                $html .= $para . "\n";
                continue;
            }

            // HR
            if (preg_match('/^-{3,}$/', $para)) {
                $html .= '<hr style="border:none;border-top:1px solid var(--border);margin:2em 0;">' . "\n";
                continue;
            }

            // Headings
            if (preg_match('/^(#{1,4})\s+(.+)$/', $para, $hm)) {
                $level = strlen($hm[1]);
                $level = max(2, min(4, $level)); // clamp h2-h4
                $id    = 'heading-' . substr(md5($hm[2]), 0, 6);
                $inner = self::inlineMarkdown($hm[2]);
                $html .= "<h{$level} id=\"{$id}\">{$inner}</h{$level}>\n";
                continue;
            }

            // Blockquote (lines starting with >)
            if (str_starts_with($para, '>')) {
                $lines = array_map(fn($l) => ltrim(ltrim($l, '>'), ' '), explode("\n", $para));
                $inner = self::inlineMarkdown(implode(' ', $lines));
                $html .= "<blockquote><p>{$inner}</p></blockquote>\n";
                continue;
            }

            // Unordered list (lines starting with - or *)
            if (preg_match('/^[-*]\s+/', $para)) {
                $items = [];
                foreach (explode("\n", $para) as $line) {
                    if (preg_match('/^[-*]\s+(.+)$/', $line, $lm)) {
                        $items[] = '<li>' . self::inlineMarkdown($lm[1]) . '</li>';
                    }
                }
                $html .= '<ul>' . implode('', $items) . "</ul>\n";
                continue;
            }

            // Ordered list (lines starting with 1.)
            if (preg_match('/^\d+\.\s+/', $para)) {
                $items = [];
                foreach (explode("\n", $para) as $line) {
                    if (preg_match('/^\d+\.\s+(.+)$/', $line, $lm)) {
                        $items[] = '<li>' . self::inlineMarkdown($lm[1]) . '</li>';
                    }
                }
                $html .= '<ol>' . implode('', $items) . "</ol>\n";
                continue;
            }

            // Regular paragraph - join single newlines with <br> only when >1 line
            $lines  = explode("\n", $para);
            $joined = implode("\n", array_map('trim', $lines));
            $inner  = self::inlineMarkdown($joined);
            // Replace single remaining newlines with <br>
            $inner  = str_replace("\n", "<br>\n", $inner);
            $html  .= "<p>{$inner}</p>\n";
        }

        // 6. Restore placeholders
        $html = strtr($html, $codeBlocks);
        $html = strtr($html, $imgBlocks);
        $html = strtr($html, $adBlocks);

        return $html;
    }

    // â”€â”€ Inline markdown â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    private static function inlineMarkdown(string $text): string
    {
        // escape HTML first (but not & which might already be escaped)
        $text = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8', false);

        // inline code (protect first)
        $inlines = [];
        $text = preg_replace_callback('/`([^`]+)`/', function ($m) use (&$inlines) {
            $id = '%%IC_' . count($inlines) . '%%';
            $inlines[$id] = '<code>' . $m[1] . '</code>';
            return $id;
        }, $text);

        // bold+italic ***text***
        $text = preg_replace('/\*\*\*(.+?)\*\*\*/', '<strong><em>$1</em></strong>', $text);
        // bold **text**
        $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
        // italic *text* (not inside words)
        $text = preg_replace('/(?<!\w)\*([^*\n]+?)\*(?!\w)/', '<em>$1</em>', $text);
        // ~~strikethrough~~
        $text = preg_replace('/~~(.+?)~~/', '<del>$1</del>', $text);
        // links [text](url)
        $text = preg_replace_callback(
            '/\[([^\]]+)\]\((https?:\/\/[^\)]+)\)/',
            fn($m) => '<a href="' . $m[2] . '" target="_blank" rel="noreferrer noopener">' . $m[1] . '</a>',
            $text
        );

        // restore inline codes
        $text = strtr($text, $inlines);

        return $text;
    }

    // â”€â”€ Code block HTML â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    private static function codeBlock(string $lang, string $escapedCode): string
    {
        $label = strtoupper($lang);
        return <<<HTML
<div class="code-block-wrap">
  <div class="code-block-header">
    <span class="code-lang">{$label}</span>
    <button class="code-copy-btn" type="button">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><rect x="9" y="9" width="13" height="13" rx="2" ry="2" stroke="currentColor" stroke-width="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
      Salin
    </button>
  </div>
  <pre><code class="language-{$lang}">{$escapedCode}</code></pre>
</div>
HTML;
    }

    // â”€â”€ Image block HTML â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    private static function imageBlock(string $url, string $caption): string
    {
        $cap = $caption
            ? "<figcaption>{$caption}</figcaption>"
            : '';
        return "<figure class=\"content-image\"><img src=\"{$url}\" alt=\"{$caption}\" loading=\"lazy\">{$cap}</figure>";
    }

    // â”€â”€ Ad slot HTML â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
    private static function adSlot(string $type): string
    {
        $sizes = [
            'leaderboard' => '728x90',
            'rectangle'   => '300x250',
            'banner'      => '468x60',
        ];
        $size  = $sizes[$type] ?? '468x60';
        $label = ucfirst($type);
        return <<<HTML
<div class="ad-slot">
  <strong>Iklan - {$label}</strong>
  Slot {$size} - Hubungi kami untuk pasang iklan di sini.
</div>
HTML;
    }
}
