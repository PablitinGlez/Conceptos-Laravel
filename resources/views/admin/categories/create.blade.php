
<x-layouts.admin>

   

<div class="mb-4">
 <flux:breadcrumbs>
    <flux:breadcrumbs.item href="{{route('admin.dashboard')}}">Dashboard</flux:breadcrumbs.item>
         <flux:breadcrumbs.item href="{{route('admin.categories.index')}}">Categorias</flux:breadcrumbs.item>
    
        <flux:breadcrumbs.item>Nuevo</flux:breadcrumbs.item>
</flux:breadcrumbs>  

</div>

<form action="{{route('admin.categories.store')}}" method="POST" class="bg-white px-6 py-8 rounded-lg shadow-lg space-y-4">
    @csrf
    
    <flux:input label="Nombre" name="name" value="{{old('name')}}" />
    
    <div class="flex justify-end">
        <flux:button type="submit" variant="primary">Guardar</flux:button>
   
</div>

</form>





</x-layouts.admin>