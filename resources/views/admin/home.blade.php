@extends('layouts.app')

@php
  $user = Auth::user();
@endphp

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header col-12 d-flex justify-content-between">
            <h3 class="m-1">{{ __('Dashboard') }}</h3>
            @if ($user->role == 'admin')
              <a class="btn btn-primary" href="{{ route('home') }}">
                Revenir a l'accueil
              </a>
            @endif
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-5">
                <div class="row m-4">
                  <h4>Généralités : </h4>
                  <ul>
                    <li>Nombre d'inscription : <b>{{ $totalUser }}</b></li>
                    <li>Points distribués : <b>{{ $totalPoint }}</b></li>
                  </ul>
                </div>
                <div class="row m-4">
                  <h4>Les nombres par niveau : </h4>
                  <ul>
                    @foreach($userPerLevel as $level)
                      <li>Niveau {{ $level['niveau'] }} : {{ $level['number'] }}</li>
                    @endforeach
                  </ul>
                </div>
              </div>
              <div class="col-7">
                <h4>Liste des utilisateurs : </h4>
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Points</th>
                    <th>Role</th>
                    <th>Active</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($users as $user)
                    <tr>
                      <td>{{ $user->id }}</td>
                      <td>{{ $user->username }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->points }}</td>
                      <td>{{ $user->role }}</td>
                      <td>
                        @if($user->enabled)
                          <span class="badge bg-success">Active</span>
                        @else
                          <span class="badge bg-danger">Inactif</span>
                        @endif
                      </td>
                      <td>
                        <div class="d-flex gap-2">
                          <a class="btn btn-primary" href="{{ route('admin.user.edit', $user->id) }}">
                            <i class="fas fa-pencil"></i>
                          </a>
                          <form action="{{ route('admin.user.update', $user->id) }}" method="post">
                            @csrf
                            @method('put')
                            <input type="checkbox" hidden="hidden" name="banned" @checked(true) />
                            <button type="submit" class="btn btn-danger">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
