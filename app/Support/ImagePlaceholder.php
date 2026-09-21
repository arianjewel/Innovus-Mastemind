<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class ImagePlaceholder
{
    public static function make(
        string $path,
        string $label,
        string $sub = '',
        array $palette = ['#0e7490', '#155e75'],
    ): void {
        [$c1, $c2] = $palette;
        $w = 800;
        $h = 600;
        $safeLabel = htmlspecialchars($label, ENT_QUOTES);
        $safeSub = htmlspecialchars($sub, ENT_QUOTES);

        $initial = mb_strtoupper(mb_substr(trim($label) !== '' ? trim($label) : 'I', 0, 1));

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$w}" height="{$h}" viewBox="0 0 {$w} {$h}">
  <defs>
    <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="{$c1}"/>
      <stop offset="100%" stop-color="{$c2}"/>
    </linearGradient>
    <pattern id="p" width="60" height="60" patternUnits="userSpaceOnUse" patternTransform="rotate(35)">
      <rect width="60" height="60" fill="none"/>
      <line x1="0" y1="0" x2="0" y2="60" stroke="#ffffff" stroke-opacity="0.06" stroke-width="14"/>
    </pattern>
  </defs>
  <rect width="{$w}" height="{$h}" fill="url(#g)"/>
  <rect width="{$w}" height="{$h}" fill="url(#p)"/>
  <circle cx="{$w}" cy="0" r="180" fill="#ffffff" fill-opacity="0.07"/>
  <circle cx="0" cy="{$h}" r="220" fill="#000000" fill-opacity="0.10"/>
  <text x="50%" y="44%" font-family="Arial, Helvetica, sans-serif" font-size="150" font-weight="bold"
        fill="#ffffff" fill-opacity="0.25" text-anchor="middle" dominant-baseline="middle">{$initial}</text>
  <text x="50%" y="66%" font-family="Arial, Helvetica, sans-serif" font-size="30" font-weight="bold"
        fill="#ffffff" text-anchor="middle">{$safeLabel}</text>
  <text x="50%" y="74%" font-family="Arial, Helvetica, sans-serif" font-size="19"
        fill="#ffffff" fill-opacity="0.75" text-anchor="middle">{$safeSub}</text>
</svg>
SVG;

        Storage::disk('public')->put($path, $svg);
    }

    public static function url(string $label, int $w = 800, int $h = 600): string
    {
        $safeLabel = htmlspecialchars($label, ENT_QUOTES);
        $initial = mb_strtoupper(mb_substr(trim($label) !== '' ? trim($label) : 'I', 0, 1));

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$w}" height="{$h}" viewBox="0 0 {$w} {$h}">
  <defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
    <stop offset="0%" stop-color="#155e75"/><stop offset="100%" stop-color="#0e7490"/>
  </linearGradient></defs>
  <rect width="{$w}" height="{$h}" fill="url(#g)"/>
  <text x="50%" y="50%" font-family="Arial, Helvetica, sans-serif" font-size="120" font-weight="bold"
        fill="#ffffff" fill-opacity="0.3" text-anchor="middle" dominant-baseline="middle">{$initial}</text>
  <text x="50%" y="78%" font-family="Arial, Helvetica, sans-serif" font-size="22" font-weight="bold"
        fill="#ffffff" text-anchor="middle">{$safeLabel}</text>
</svg>
SVG;

        return 'data:image/svg+xml;charset=utf-8,' . rawurlencode($svg);
    }
}
