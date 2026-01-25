<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Testimonial as Testimonials;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Testimonials')]
class Testimonial extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public int $perPage = 9;

    // protected $queryString = [
    //     'sort' => ['except' => 'latest'],
    //     'page' => ['except' => 1],
    //     'perPage' => ['except' => 6],
    // ];

    public string $sort = 'Latest';

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function setSort(string $value)
    {
        $this->sort = $value;
        $this->resetPage();
    }

    public function render()
    {
        $query = Testimonials::query()->with('residence');

        match ($this->sort) {
            'Latest'  => $query->latest(),
            'Oldest'  => $query->oldest(),
            'Highest' => $query->orderByDesc('rating'),
            'Lowest'  => $query->orderBy('rating'),
            default   => $query->latest(),
        };

        return view('livewire.testimonial', [
            'testimonials' => $query->paginate($this->perPage),
        ]);
    }
}