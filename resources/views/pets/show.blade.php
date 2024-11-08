@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Pet details</h1>

<div class="bg-white p-6 rounded-lg shadow-md space-y-4">
    @if(isset($pet['photoUrls'][0]))
        <img src="{{ $pet['photoUrls'][0] }}" alt="{{ $pet['name'] }}" class="w-32 h-32 rounded-full mx-auto">
    @endif

    <p><strong>Name:</strong> {{ $pet['name'] ?? 'Unnamed Pet' }}</p>
    <p><strong>Category:</strong> {{ $pet['category']['name'] ?? 'Category not specified' }}</p>
    <p><strong>Status:</strong> {{ ucfirst($pet['status'] ?? 'Status not defined') }}</p>

    <div class="flex space-x-4">
        <a href="{{ route('pets.edit', $pet['id']) }}" class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600">Edit</a>
        
        <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" onsubmit="return confirm('Are you sure?')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white font-semibold py-2 px-4 rounded hover:bg-red-700">Delete</button>
        </form>

        <a href="{{ route('pets.index') }}" class="bg-gray-500 text-white font-semibold py-2 px-4 rounded hover:bg-gray-600">Back</a>
    </div>
</div>
@endsection
