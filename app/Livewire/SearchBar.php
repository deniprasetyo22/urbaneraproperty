<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Models\Residence;

class SearchBar extends Component
{
    public string $activeFilter = 'location';

    // Property Input
    public $location = '';
    public $type = '';
    public $priceRange = ''; // Gunakan nama variabel yang konsisten

    public bool $showFilterMenu = false;

    // Data Dropdown
    public $locations = [];
    public $types = [];

    public function mount()
    {
        $this->locations = Residence::select('city')->distinct()->orderBy('city')->pluck('city');
        $this->types = Property::select('type')->distinct()->orderBy('type')->pluck('type');
    }

    public function selectFilter(string $filter)
    {
        // Reset input lain saat pindah tab (OPSIONAL - Jika ingin User hanya bisa pilih satu filter utama di Mobile)
        // Jika ingin User bisa mengkombinasikan filter di mobile, hapus bagian if-elseif ini.
        if ($filter === 'location') {
            $this->type = '';
            $this->priceRange = '';
        } elseif ($filter === 'type') {
            $this->location = '';
            $this->priceRange = '';
        } elseif ($filter === 'priceRange') {
            $this->location = '';
            $this->type = '';
        }

        $this->activeFilter = $filter;
        $this->showFilterMenu = false;
    }

    public function search()
    {
        $params = [];

        // 1. Cek Location
        if (!empty($this->location)) {
            $params['location'] = $this->location;
        }

        // 2. Cek Type
        if (!empty($this->type)) {
            $params['type'] = $this->type;
        }

        // 3. Cek Price Range (Gunakan $this->priceRange)
        if (!empty($this->priceRange)) {
            $params['priceRange'] = $this->priceRange;
        }

        // Redirect ke route property-list dengan semua parameter
        return redirect()->route('property-list', $params);
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}