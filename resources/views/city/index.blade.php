@extends('layouts.admin')

@section('section_data')
    
            <div class="addbatan">
                <h2>Cities</h2>
                @can('city_create')
                    <button><a href="{{ route('city.create') }}">+ Add New City</a></button>
                @endcan()
            </div>
            <hr>
            <table border="1">
                <tr>
                    <th>Id</th>
                    <th>Country Name</th>
                    <th>State Name</th>
                    <th>City Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @php $i=1; @endphp
                @foreach($cities as $city)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $city->country['name'] }}</td>
                    <td>{{ $city->state['name'] }}</td>
                    <td>{{ $city->name }}</td>
                    <td>{{ $city->status ==="1"?'Enable':'Disable' }}</td>
                    <td>
                        @can('city_edit')
                        <a href="{{ route('city.edit', $city->id) }}">Edit</a> |
                        @endcan
                        @can('city_delete')
                        <form action="{{ route('city.destroy', $city->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" name="delete" value="Delete">
                        </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="pages">
                {{ $cities->links(); }}
            </div> 
            
@endsection