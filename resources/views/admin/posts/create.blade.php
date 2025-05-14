<x-layouts.admin>



    <div class="mb-4">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Dashboard</flux:breadcrumbs.item>
            <flux:breadcrumbs.item href="{{ route('admin.posts.index') }}">Posts</flux:breadcrumbs.item>

            <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
        </flux:breadcrumbs>

    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST"
        class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4">
        @csrf

        <flux:input label="Titulo" name="title" value="{{ old('title') }}"
            oninput="string_to_slug(this.value, '#slug')" />

        <flux:input id="slug" label="Slug" name="slug" value="{{ old('slug') }}" />


        <flux:select label="Categorias" name="category_id" wire:model="industry" placeholder="Choose industry...">
            @foreach ($categories as $category)
                <flux:select.option value="{{ $category->id }}"  :selected="$category->id == old('category_id')">{{ $category->name }}</flux:select.option>
            @endforeach

        </flux:select>



        <div class="flex justify-end">
            <flux:button type="submit" variant="primary">Guardar</flux:button>

        </div>

    </form>





</x-layouts.admin>
