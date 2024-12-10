<div>
    <div class="flex justify-between">
        <h2 class="text-2xl font-semibold">Create Product</h2>
{{--        <a href="{{ route('products.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Back</a>--}}
    </div>
    <form wire:submit.prevent="store" class="mt-4">
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" wire:model="name" id="name" name="name" value="{{$name}}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="text" wire:model="price" id="price" name="price" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @error('price') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="cost" class="block text-sm font-medium text-gray-700">Cost</label>
                <input type="text" wire:model="cost" id="cost" name="price" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @error('cost') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                <input type="text" wire:model="quantity" id="quantity" name="quantity" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @error('quantity') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                <input type="text" wire:model="quantity" id="code" name="code" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @error('code') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <select wire:model="type" id="type" name="type" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @foreach($types as $type)
                        <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>
                @error('type') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <div>
                <select wire:model="category_id" id="category_id" name="category_id" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-4">
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" wire:model="image" id="image" name="image" class="mt-1 mb-4 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                @error('image') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea wire:model="description" id="description" name="description" rows="3" class="mt-1 mb-4 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                </textarea>
                @error('description') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Save</button>
        </div>
    </form>
</div>
