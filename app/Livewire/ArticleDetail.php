<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Articles')]
class ArticleDetail extends Component
{
    public $article;

    public function mount(Article $article)
    {
        $this->article = $article;
    }
    public function render()
    {
        return view('livewire.article-detail');
    }
}