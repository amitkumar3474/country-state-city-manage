@extends('layouts.admin')

@section('section_data')
    
            <div class="addbatan">
                <h2>States</h2>
                @can('state_create')
                    <button><a href="{{ route('state.create') }}">+ Add New State</a></button>
                @endcan
            </div>
            <hr>
            <table border="1">
                <tr>
                    <th>Id</th>
                    <th>Country Name</th>
                    <th>State Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @foreach($states as $key=>$state)
                <tr>
                    <td>{{ $key+1}}</td>
                    <td>{{ $state->country['name'] }}</td>
                    <td>{{ $state->name }}</td>
                    <td>{{ $state->status ==="1"?'Enable':'Disable' }}</td>
                    <td>
                        @can('state_edit')
                        <a href="{{ route('state.edit', $state->id) }}">Edit</a> |
                        @endcan
                        @can('state_delete')
                        <form action="{{ route('state.destroy', $state->id) }}" method="post">
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
                {{ $states->links() }}
            </div>    
@endsection