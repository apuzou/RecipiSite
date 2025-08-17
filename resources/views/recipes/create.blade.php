<x-app-layout>
    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.13.0/Sortable.min.js"></script>
        <script src="/js/recipe/create.js"></script>
    </x-slot>

    <form class="w-10/12 p-4 mx-auto bg-white rounded" action="{{ route('recipe.store') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        {{ Breadcrumbs::render('create') }}
        <div class="grid grid-cols-2 rounded border border-gray-500 mt-4">
            <div class="col-span-1">
                <img id="preview" src="/images/recipe-dummy.png" alt="recipe-image"
                    class="w-full object-cover aspect-video mb-4">
                <input type="file" id="image" name="image"
                    class="w-full p-2 mb-4 border border-gray-300 rounded-md">
            </div>
            <div class="col-span-1 p-4">
                <input type="text" name="title" class="w-full p-2 mb-2 border border-gray-300 rounded-md"
                    placeholder="レシピ名">
                <textarea name="description" class="w-full p-2 mb-4 border border-gray-300 rounded-md" placeholder="レシピの説明"></textarea>
                <select name="category" class="w-full p-2 mb-4 border border-gray-300 rounded-md">
                    <option value="">カテゴリを選択</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                    @endforeach
                </select>
                {{-- 材料 --}}
                <h4 class="font-bold text-xl mb-4">材料</h4>
                <div id="ingredients">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="ingredient flex items-center mb-4">
                            @include('components.bars-3')
                            <input type="text" name="ingredients[{{ $i }}][name]" placeholder="材料名"
                                class="ingredient-name border border-gray-300 p-2 ml-4 w-full rounded">
                            <p class="mx-2">:</p>
                            <input type="text" name="ingredients[{{ $i }}][quantity]" placeholder="分量"
                                class="ingredient-quantity border border-gray-300 p-2 w-full rounded">
                            @include('components.trash-icon')
                        </div>
                    @endfor
                </div>
                <button type="button" id="ingredient-add"
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ">材料を追加する</button>
            </div>
        </div>
        <div class="flex justify-center mt-4">
            <button type="submit"class="py-2 px-4 bg-green-700 hover:bg-green-800 text-white font-bold rounded-md">レシピを投稿</button>
        </div>
        {{-- line --}}
        <hr class="my-4">
        {{-- 手順 --}}
        <h4 class="text-xl font-bold mb-4">手順を入力</h4>
        <div id="steps">
            @for ($i = 1; $i < 4; $i++)
                <div class="step flex justify-between items-center mb-4">
                    @include('components.bars-3')
                    <p class="step-number w-16">手順{{ $i }}</p>
                    <input type="text" name="steps[]" placeholder="手順を入力"
                        class="border border-gray-300 p-2 w-full rounded">
                    @include('components.trash-icon')
                </div>
            @endfor
        </div>
        <button type="button" id="step-add"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ">手順を追加する</button>
    </form>
</x-app-layout>
