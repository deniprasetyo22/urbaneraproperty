<?php

use App\Livewire\Home;
use App\Livewire\About;
use App\Livewire\Contact;
use App\Livewire\ArticleList;
use App\Livewire\Testimonial;
use App\Livewire\PropertyList;
use App\Livewire\ArticleDetail;
use App\Livewire\ResidenceList;
use App\Livewire\PropertyDetail;
use App\Livewire\CustomerFeedback;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/residence-list', ResidenceList::class)->name('residence-list');

Route::get('/property-list', PropertyList::class)->name('property-list');
Route::get('/property/{property:slug}', PropertyDetail::class)->name('property-detail');

Route::get('/article-list', ArticleList::class)->name('article-list');
Route::get('/article/{article:slug}', ArticleDetail::class)->name('article-detail');

Route::get('/testimonials', Testimonial::class)->name('testimonials');

Route::get('/customer-feedback', CustomerFeedback::class)->middleware('throttle:5,1')->name('customer-feedback');

Route::get('/about', About::class)->name('about');

Route::get('/contact', Contact::class)->name('contact');