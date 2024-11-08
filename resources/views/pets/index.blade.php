@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">List of pets</h1>

<ul class="space-y-4">
    @foreach($pets as $pet)
        <li class="bg-white p-4 rounded-lg shadow-md flex items-center">
            @if(isset($pet['photoUrls'][0]))
                <img src="{{ $pet['photoUrls'][0] }}" alt="{{ $pet['name'] }}" class="w-12 h-12 rounded-full mr-4">
            @endif
            <div>
                <strong class="text-lg">{{ $pet['name'] ?? 'Unnamed Pet' }}</strong>
                <div class="text-blue-500">
                    <a href="{{ route('pets.show', $pet['id']) }}" class="hover:underline">Details</a>
                </div>
            </div>
        </li>
    @endforeach
</ul>
@endsection
