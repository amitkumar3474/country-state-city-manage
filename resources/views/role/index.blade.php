@extends('layouts.admin')

@section('section_data')
    
            <div class="addbatan">
                <h2>Roles</h2>
                <button><a href="{{ route('roles.create') }}">+ Add New Roles</a></button>
            </div>
            <hr>
            <table border="1">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Permission</th>
                    <th>Action</th>
                </tr>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id}}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @foreach($role->permissions as $_permission)
                            {{$_permission->name}} | 
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id) }}">Edit</a> |
                        <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>    
            <div class="pages">
                {{ $roles->links() }}
            </div> 
@endsection