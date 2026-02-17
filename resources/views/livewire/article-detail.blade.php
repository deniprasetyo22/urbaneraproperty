<div class="mt-16 bg-white">
    <div class="mx-auto max-w-7xl px-6 pt-8">

        <p class="text-md mb-3 text-gray-500"><a
                href="{{ route('article-list') }}"class="hover:text-brand">Articles</a>/<span
                class="text-gray-900">Article Detail</span></p>

        <p class="mb-3 text-xs text-gray-600">
            <i class="fa-regular fa-calendar"></i> {{ $article->created_at->translatedFormat('l, j F Y H:i') }} WIB
        </p>

        <img class="mb-4 h-auto max-w-full rounded-md" src="{{ asset('storage/' . $article->image) }}" alt="Article Image">

        <h1 class="mb-4 text-3xl font-bold text-gray-900">
            {{ $article->title }}
        </h1>

        <div
            class="space-y-4 text-justify leading-relaxed text-gray-800 [&_li]:my-1 [&_li]:ml-0 [&_ol]:my-3 [&_ol]:list-inside [&_ol]:list-decimal [&_ol]:pl-0 [&_p]:mb-3 [&_ul]:my-3 [&_ul]:list-inside [&_ul]:list-disc [&_ul]:pl-0">
            {!! $article->content !!}
        </div>

    </div>
</div>
