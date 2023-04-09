@extends('layouts.admin')

@section('section_data')
    
            <div class="addbatan">
                <h2>countries</h2>
                    @can('country_create')
                        <button><a href="{{ route('country.create') }}">+ Add New Country</a></button>
                    @endcan
            </div>
            <hr>
            <table border="1">
                <tr>
                    <th>Id</th>
                    <th>Country Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @php $i=1; @endphp
                @foreach($countries as $country)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{ $country->name }}</td>
                    <td>{{ $country->status==="1"?'Enable':'Disable'}}</td>
                    <td>
                        @can('country_edit')
                        <a href="{{ route('country.edit', $country->id) }}">Edit</a>
                         |
                        @endcan
                        @can('country_delete')
                        <form action="{{ route('country.destroy', $country->id) }}" method="post">
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
                {{ $countries->links();}}
            </div>  
@endsection