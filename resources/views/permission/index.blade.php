
@extends('layouts.admin')

@section('section_data')
    
            <div class="addbatan">
                <h2>Prmissions</h2>
                <button><a href="{{ route('permissions.create') }}">+ Add New Permission</a></button>
            </div>
            <hr>
            <table border="1">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <!-- <th>guard_name</th> -->
                    <th>Action</th>
                </tr>
                @foreach($permissions as $permission)
                <tr>
                    <td>{{ $permission->id}}</td>
                    <td>{{ $permission->name }}</td>
                    <!-- <td>{{ $permission->guard_name }}</td> -->
                    <td>
                        <a href="{{ route('permissions.edit', $permission->id) }}">Edit</a> |
                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>    
            <div class="pages">
                {{ $permissions->links() }}
            </div> 
@endsection