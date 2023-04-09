@extends('layouts.admin')

@section('section_data')
    
            <div class="addbatan">
                <h2>Users</h2>
                <button><a href="{{ route('user.create') }}">+ Add New User</a></button>
            </div>
            <hr>
            <table border="1">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Images</th>
                    <th>Banner Image</th>
                    <th>Roles</th>
                    <th>Action</th>
                </tr>
                @php $i = ($_GET['page']??1)*5-4; @endphp
                @foreach($users as $user)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><img src="{{ $user->getFirstMediaUrl('profile_image') }}" height="50"></td>
                    <td><img src="{{ $user->getFirstMediaUrl('banner_image') }}" height="50"></td>
                    <td>
                        @foreach($user->roles as $role)
                            {{$role->name}} | 
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}">Edit</a> |
                        <form action="{{ route('user.destroy', $user->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
            <div class="pages">
                {{ $users->links(); }}
            </div> 
@endsection