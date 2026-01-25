<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\CompanyProfile;
use Livewire\Component;
use App\Models\Property;
use App\Models\Residence;
use App\Models\Testimonial;
use Livewire\Attributes\Title;

#[Title('Home')]
class Home extends Component
{
    public $showVideo = false;

    public function toggleModalVideo()
    {
        $this->showVideo = !$this->showVideo;
    }

    public function render()
    {
        return view('livewire.home', [
            'residences' => Residence::latest()->paginate(3),
            'properties' => Property::latest()->paginate(3),
            'articles' => Article::latest()->paginate(3),
            'testimonials' => Testimonial::has('residence')->latest()->paginate(3),
            'company_profile' => CompanyProfile::first(),
        ]);
    }
}