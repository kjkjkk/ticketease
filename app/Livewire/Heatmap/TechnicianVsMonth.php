<?php

namespace App\Livewire\Heatmap;

use Livewire\Component;
use App\Models\Ticket;

class TechnicianVsMonth extends Component
{
    public $selectedPalette = 'default';
    public $palette_one = ['#e0f7fa', '#b2ebf2', '#80deea', '#4dd0e1', '#26c6da', '#00bcd4', '#00acc1', '#0097a7'];
    public $palette_two = ['#e8f5e9', '#c8e6c9', '#a5d6a7', '#81c784', '#66bb6a', '#4caf50', '#43a047', '#388e3c'];
    public $palette_three = ['#f3e5f5', '#e1bee7', '#ce93d8', '#ba68c8', '#ab47bc', '#9c27b0', '#8e24aa', '#7b1fa2'];
    public $palette_four = ['#fde4e1', '#fbb8b3', '#f98b85', '#f75e57', '#f5312a', '#d42018', '#b31d16', '#911713'];
    public $palette_five = ['#e8eaf6', '#c5cae9', '#9fa8da', '#7986cb', '#5c6bc0', '#3f51b5', '#3949ab', '#303f9f'];
    public $default_palette = ['#CBFFBB', '#A5FF93', '#FFEE8E', '#FFDA62', '#FFCB21', '#FF8000', '#FF4D00', '#FF0000'];
    public $showVolume = true;
    public $data;
    public $years;
    public $selectedYear;


    public function mount($data, $selectedYear)
    {
        $this->data = $data;
        $this->years =  Ticket::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->pluck('year');
        $this->selectedYear = $selectedYear;
    }

    public function getHeatmapColor($value, $minValue, $maxValue)
    {
        $paletteColors = $this->default_palette; // Default to the heatmap palette

        switch ($this->selectedPalette) {
            case 'palette_one':
                $paletteColors = $this->palette_one;
                break;
            case 'palette_two':
                $paletteColors = $this->palette_two;
                break;
            case 'palette_three':
                $paletteColors = $this->palette_three;
                break;
            case 'palette_four':
                $paletteColors = $this->palette_four;
                break;
            case 'palette_five':
                $paletteColors = $this->palette_five;
                break;
        }
        $range = ($maxValue - $minValue) / (count($paletteColors) - 1);
        $index = floor(($value - $minValue) / $range);
        $index = min(max($index, 0), count($paletteColors) - 1);

        return $paletteColors[$index];
    }

    public function selectPalette($palette)
    {
        $this->selectedPalette = $palette;
    }

    public function getColumns($data)
    {
        if (!empty($data)) {
            $keys = array_keys($data[0]);
            return array_slice($keys, 1);
        }
        return [];
    }

    public function render()
    {
        $allVolumes = $this->data;
        $columns = $this->getColumns($allVolumes);
        $values = [];

        foreach ($allVolumes as $row) {
            // Loop through each month's value and collect them into $values
            foreach (array_slice($row, 1) as $value) {
                $values[] = intval($value);
            }
        }

        // $filteredValues = array_filter($values, function ($value) {
        //     return $value != 0;
        // });

        $minValue = min($values);
        $maxValue = max($values);
        $key = "lastname";
        return view(
            'livewire.heatmap.technician-vs-month',
            [
                'data' => $allVolumes,
                'columns' => $columns,
                'minValue' => $minValue,
                'maxValue' => $maxValue,
                'key' => $key,
                'years' => $this->years,
            ]
        );
    }
}
