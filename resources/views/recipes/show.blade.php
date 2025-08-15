<x-app-layout>
    <div class="w-10/12 p-4 mx-auto bg-white rounded">
        {{ Breadcrumbs::render('show', $recipe) }}
        {{-- レシピ --}}
        <div class="grid grid-cols-2 rounded border border-gray-500 mt-4">
            <div class="col-span-1">
                <img src="{{ $recipe['image'] }}" alt="{{ $recipe['title'] }}" class="w-full object-cover aspect-square">
            </div>
            <div class="col-span-1 p-4">
                <p class="mb-4">{{ $recipe['description'] }}</p>
                <p class="mb-4 text-gray-500">{{ $recipe['user']['name'] }}</p>
                <h4 class="text-2xl font-bold mb-2">材料</h4>
                <ul class="text-gray-500 ml-6">
                    @foreach ($recipe['ingredients'] as $i)
                        <li>{{ $i['name'] }}: {{ $i['quantity'] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <br>
        {{-- 作り方 --}}
        <div class="">
            <h4 class="text-2xl font-bold mb-6">作り方</h4>
            <div class="grid grid-cols-4 gap-4">
                @foreach ($recipe['steps'] as $s)
                    <div class="mb-2 p-2 background-color">
                        <div class="flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full mr-4 mb-2">
                            {{ $s['step_number'] }}
                        </div>
                        <p>{{ $s['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <br>
        {{-- レビュー --}}
        <div class="w-10/12 p-4 bg-white rounded">
            <h4 class="text-2xl font-bold mb-2">レビュー</h4>
            @foreach ($recipe['reviews'] as $r)
                <div class="background-color rounded mb-4 p-4">
                    <div class="flex mb-4">
                        @for ($i = 0; $i < $r['rating']; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                class="w-6 h-6 text-yellow-400">
                                <path
                                    d="M12 17.27L18.18 21 16.54 13.97 22 9.24 14.81 8.63 12 2 9.19 8.63 2 9.24 7.46 13.97 5.82 21 12 17.27z" />
                            </svg>
                        @endfor
                        <p class="ml-4">{{ $r['comment'] }}</p>
                    </div>
                    <p class="text-gray-600 font-bold">{{ $r['user']['name'] }}</p>
                </div>
            @endforeach
            @if (count($recipe['reviews']) === 0)
                <p>レビューがありません。</p>
            @endif
        </div>
    </div>
</x-app-layout>
