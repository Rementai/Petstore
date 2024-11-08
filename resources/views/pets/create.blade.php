@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Add new pet</h1>

<form action="{{ route('pets.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-4">
    @csrf
    <div>
        <label for="name" class="block font-semibold">Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded p-2">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="status" class="block font-semibold">Status:</label>
        <select id="status" name="status" required class="w-full border border-gray-300 rounded p-2">
            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
        </select>
        @error('status')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700">Add</button>
</form>
@endsection
