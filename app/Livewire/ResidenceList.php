<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Residence;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Residences')]
class ResidenceList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $perPage = 9;

    #[Url]
    public $search = '';

    #[Url]
    public $sort = 'Latest';

    #[Url]
    public $location = '';

    public function mount()
    {
        // Tangkap parameter location dari URL (misal dari Home Page)
        $this->location = request()->query('location', $this->location);
        $this->search = request()->query('search', $this->search);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSort()
    {
        $this->resetPage();
    }

    public function updatedLocation()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    // Ambil daftar kota yang ada di database residence
    public function getLocationsProperty()
    {
        return Residence::select('city')->distinct()->orderBy('city')->pluck('city');
    }

    // Reset semua filter
    public function resetFilters()
    {
        $this->reset(['search', 'location', 'sort']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Residence::query();

        // 1. Logic Search Text (Nama atau Kota)
        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // 2. Logic Filter Location (Dropdown Sidebar)
        if ($this->location) {
            $query->where('city', $this->location);
        }

        // 3. Logic Sorting
        match ($this->sort) {
            'Latest'  => $query->latest(),
            'Oldest'  => $query->oldest(),
            default   => $query->latest(),
        };

        return view('livewire.residence-list', [
            'residences' => $query->paginate($this->perPage)
        ]);
    }
}