<?php

namespace App\Livewire;

use Livewire\Component;

class Hero extends Component
{
    public string $hero_quote = '';
    public string $hero_title = '';
    public string $hero_subTitle = '';
    public string $background = 'images/banner.webp';

    public function mount(
        string $hero_quote = '',
        string $hero_title = '',
        string $hero_subTitle = '',
        string $background = 'images/banner.webp'
    ) {
        $this->hero_quote = $hero_quote;
        $this->hero_title = $hero_title;
        $this->hero_subTitle = $hero_subTitle;
        $this->background = $background;
    }

    public function render()
    {
        return view('livewire.hero');
    }
}