<?php

namespace App\Livewire;

use Livewire\Component;

class Index extends Component
{
    public $features = [];

    public function mount()
    {
        $this->features = [
            [
                'title_key' => 'landing.features.track.title',
                'description_key' => 'landing.features.track.description',
                'icon' => 'briefcase',
                'color' => '#F59E0B',
                'colorFrom' => '#FBBF24',
                'colorTo' => '#F59E0B'
            ],
            [
                'title_key' => 'landing.features.documents.title',
                'description_key' => 'landing.features.documents.description',
                'icon' => 'document',
                'color' => '#06B6D4',
                'colorFrom' => '#22D3EE',
                'colorTo' => '#06B6D4'
            ],
            [
                'title_key' => 'landing.features.visualizations.title',
                'description_key' => 'landing.features.visualizations.description',
                'icon' => 'chart',
                'color' => '#84CC16',
                'colorFrom' => '#A3E635',
                'colorTo' => '#84CC16'
            ],
            [
                'title_key' => 'landing.features.history.title',
                'description_key' => 'landing.features.history.description',
                'icon' => 'clock',
                'color' => '#F43F5E',
                'colorFrom' => '#FB7185',
                'colorTo' => '#F43F5E'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.index')->layout('components.layouts.guest');
    }
}
