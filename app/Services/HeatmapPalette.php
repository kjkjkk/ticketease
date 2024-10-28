<?php

namespace App\Services;

class HeatmapPalette
{
    public $palettes = [
        'palette_one' => ['#e0f7fa', '#b2ebf2', '#80deea', '#4dd0e1', '#26c6da', '#00bcd4', '#00acc1', '#0097a7'],
        'palette_two' => ['#e8f5e9', '#c8e6c9', '#a5d6a7', '#81c784', '#66bb6a', '#4caf50', '#43a047', '#388e3c'],
        'palette_three' => ['#f3e5f5', '#e1bee7', '#ce93d8', '#ba68c8', '#ab47bc', '#9c27b0', '#8e24aa', '#7b1fa2'],
        'palette_four' => ['#fde4e1', '#fbb8b3', '#f98b85', '#f75e57', '#f5312a', '#d42018', '#b31d16', '#911713'],
        'palette_five' => ['#e8eaf6', '#c5cae9', '#9fa8da', '#7986cb', '#5c6bc0', '#3f51b5', '#3949ab', '#303f9f'],
        'default_palette' => ['#CBFFBB', '#A5FF93', '#FFEE8E', '#FFDA62', '#FFCB21', '#FF8000', '#FF4D00', '#FF0000'],
    ];

    public function getPalette($paletteName)
    {
        return $this->palettes[$paletteName] ?? $this->palettes['default_palette'];
    }
}
