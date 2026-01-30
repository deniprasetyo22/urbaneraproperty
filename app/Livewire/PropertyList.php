<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Property;
use App\Models\Residence;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

#[Title('Properties')]
class PropertyList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $perPage = 9;

    // protected $queryString = [
    //     'sort' => ['except' => 'latest'],
    //     'page' => ['except' => 1],
    //     'perPage' => ['except' => 6],
    // ];

    #[Url(except: '')]
    public $search = '';

    #[Url(except: 'Latest')]
    public $sort = 'Latest';

    #[Url(except: '')]
    public $priceRange = '';

    #[Url(except: '')]
    public $location = '';

    #[Url(except: '')]
    public $type = '';

    #[Url(except: '')]
    public $residence = '';

    #[Url(except: '')]
    public $status = '';

    public function updatedPerPage() { $this->resetPage(); }
    public function updatedSearch() { $this->resetPage(); }
    public function updatedSort() { $this->resetPage(); }
    public function updatedPriceRange($value)
    {
        if ($value) {
            $this->status = 'Available';
        }
        if(!$value) {
            $this->status = '';
        }
        $this->resetPage();
    }
    public function updatedLocation() { $this->resetPage(); }
    public function updatedType() { $this->resetPage(); }
    public function updatedResidence() { $this->resetPage(); }
    public function updatedStatus() { $this->resetPage(); }

    public function setSort(string $value)
    {
        $this->sort = $value;
        $this->resetPage();
    }

    public function setPriceRange(string $value)
    {
        $this->priceRange = $value;
        if ($value) {
            $this->status = 'Available';
        }
        if(!$value) {
            $this->status = '';
        }
        $this->resetPage();
    }

    public function getPriceLabelProperty()
    {
        return match($this->priceRange) {
            'under_500' => '< 500 M',
            '500_1b'    => '500 M - 1 B',
            'above_1b'  => '> 1 B',
            default     => 'All Price',
        };
    }

    public function setLocation(string $value)
    {
        $this->location = $value;
        $this->resetPage();
    }

    public function getLocationsProperty()
    {
        return Residence::select('city')->distinct()->orderBy('city')->pluck('city');
    }

    public function setType(string $value)
    {
        $this->type = $value;
        $this->resetPage();
    }

    public function getTypesProperty()
    {
        return Property::select('type')->distinct()->orderBy('type')->pluck('type');
    }

    public function setResidence(string $value)
    {
        $this->residence = $value;
        $this->resetPage();
    }

    public function getResidencesProperty()
    {
        return Residence::select('name')->distinct()->orderBy('name')->pluck('name');
    }

    public function setStatus(string $value)
    {
        $this->status = $value;
        $this->resetPage();
    }

    public function getStatusesProperty()
    {
        return Property::select('status')->distinct()->orderBy('status')->pluck('status');
    }

    // Method untuk Reset Filter
    public function resetFilters()
    {
        $this->reset(['location', 'type', 'priceRange', 'sort', 'residence', 'search', 'status']);
        $this->resetPage();
    }

    public function mount()
    {
        // Mengisi filter dari URL parameter (fallback manual jika #[Url] tidak langsung trigger di UI tertentu)
        // $this->location = request()->query('location', $this->location);
        // $this->type = request()->query('type', $this->type);
        // $this->priceRange = request()->query('priceRange', $this->priceRange);
        // $this->residence = request()->query('residence', $this->residence);
    }

    public function render()
    {
        $query = Property::query()->with('residence');

        // 1. Search
        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhereHas('residence', function ($r) use ($search) {
                      $r->where('city', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Filters
        if ($this->location) {
            $query->whereHas('residence', fn($q) => $q->where('city', $this->location));
        }

        if ($this->type) {
            $query->where('type', $this->type);
        }

        if ($this->residence) {
            $query->whereHas('residence', fn($q) => $q->where('name', $this->residence));
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->priceRange) {
            match ($this->priceRange) {
                'under_500' => $query->where('price', '<', 500000000),
                '500_1b'    => $query->whereBetween('price', [500000000, 1000000000]),
                'above_1b'  => $query->where('price', '>', 1000000000),
                default     => null,
            };
        }

        // 3. Sort
        match ($this->sort) {
            'Latest'  => $query->latest(),
            'Oldest'  => $query->oldest(),
            'Highest' => $query->orderByDesc('price'),
            'Lowest'  => $query->orderBy('price'),
            default   => $query->latest(),
        };

        return view('livewire.property-list', [
            'properties' => $query->paginate($this->perPage)
        ]);
    }
}