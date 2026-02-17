<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Property;
use Illuminate\Console\Command;
use Spatie\Sitemap\Tags\Url;
use Spatie\Sitemap\Sitemap;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menghasilkan file sitemap.xml otomatis';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create();

        // 1. Tambahkan Rute Statis
        $sitemap->add(Url::create('/')->setPriority(1.0))
            ->add(Url::create('/residence-list'))
            ->add(Url::create('/property-list'))
            ->add(Url::create('/article-list'))
            ->add(Url::create('/testimonials'))
            ->add(Url::create('/about'))
            ->add(Url::create('/contact'));

        // // 2. Tambahkan Rute Properti Dinamis
        // Property::all()->each(function (Property $property) use ($sitemap) {
        //     $sitemap->add(Url::create("/property/{$property->slug}"));
        // });

        // // 3. Tambahkan Rute Artikel Dinamis
        // Article::all()->each(function (Article $article) use ($sitemap) {
        //     $sitemap->add(Url::create("/article/{$article->slug}"));
        // });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap.xml berhasil diperbarui dengan data properti dan artikel!');
    }
}