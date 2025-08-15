<x-app-layout>
    <form class="w-10/12 p-4 mx-auto bg-white rounded" action="{{ route('recipe.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        {{ Breadcrumbs::render('create') }}
        <div class="grid grid-cols-2 rounded border border-gray-500 mt-4">
            <div class="col-span-1">
                <img src="/images/recipe-dummy.png" alt="recipe-image" class="w-full object-cover aspect-video mb-4">
                <input type="file" name="image" class="w-full p-2 mb-4 border border-gray-300 rounded-md">
            </div>
            <div class="col-span-1 p-4">
                <input type="text" name="title" class="w-full p-2 mb-2 border border-gray-300 rounded-md" placeholder="レシピ名">
                <textarea name="description" class="w-full p-2 mb-4 border border-gray-300 rounded-md" placeholder="レシピの説明"></textarea>
                <select name="category" class="w-full p-2 mb-4 border border-gray-300 rounded-md">
                    <option value="">カテゴリを選択</option>
                  @foreach ($categories as $c)
                        <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                    @endforeach
                </select>
                <div class="flex justify-end">
                    <button type="submit" class="py-2 px-4 bg-green-700 hover:bg-green-800 text-white font-bold rounded-md">レシピを投稿</button>
                </div>
            </div>
        </input>
    </form>
</x-app-layout>
