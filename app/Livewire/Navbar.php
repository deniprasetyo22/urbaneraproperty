<?php

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component
{
    public bool $mobileOpen = false;
    public bool $companyOpen = false;
    public bool $mobileCompanyOpen = false;

    public function toggleMobile()
    {
        $this->mobileOpen = ! $this->mobileOpen;
    }

    public function toggleCompany()
    {
        $this->companyOpen = ! $this->companyOpen;
    }

    public function toggleMobileCompany()
    {
        $this->mobileCompanyOpen = ! $this->mobileCompanyOpen;
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}