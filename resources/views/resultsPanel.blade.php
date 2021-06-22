@extends('layouts.default', ['title' => 'Results Panel'])

@section('content')
    <div class="w-full flex justify-center mt-40">
        <div class="max-w-md sm:max-w-sm w-full">
            <h1 class="mb-2 text-2xl font-bold text-gray-800">Results Panel</h1>
            <table style="border-spacing: 20px 20px" class="border-separate w-full">
                <tr>
                    <th class="w-20 text-center">Engine</th>
                    <th class="w-20 text-center">Value</th>
                </tr>

                @foreach ($engines as $engine)
                    <tr class="text-center">
                        <td class="bg-white py-4 rounded-l-lg shadow-md">{{ $engine->name }}</td>
                        <td class="bg-white py-4 rounded-r-lg shadow-md">{{ $engine->value }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
