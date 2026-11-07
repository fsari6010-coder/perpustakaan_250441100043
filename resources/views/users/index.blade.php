@extends('layouts.app')

@section('title', 'Pengelolaan Pengguna')

@section('content')
<div class="container">
    <h2>Pengelolaan Pengguna</h2>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role Saat Ini</th>
                <th>Ubah Role</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>
                        @foreach($user->roles as $role)
                            {{ ucfirst($role->name) }}
                        @endforeach
                    </td>

                    <td>
                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <select name="role" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}"
                                        @selected($user->hasRole($role->name))>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit">Simpan</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection