@php use App\Utils\Utils; @endphp
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
              <a class="btn btn-primary" href="{{ route('admin.index') }}">
                Admin
              </a>
            @endif
          </div>
          <div class="card-body">
            <div class="row">
              <span class="col">Nom : <b>{{ $user->username }}</b></span>
              <span class="col">Email : <b>{{ $user->email }}</b></span>
              <span class="col">Code d'invitation : <b>{{ $user->invitation_code }}</b></span>
              <span class="col">Points accumulés : <b>{{ $user->points }}</b></span>
            </div>
            <div class="row m-3">
              <h3>Les parrainés : </h3>
              @foreach($user->parraines() as $parraine)
                <div class="col">Niveau {{ $parraine['niveau'] }} : {{ $parraine['number'] }}</div>
              @endforeach
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>Niveau</th>
                  <th>Nom</th>
                  <th>Création de compte</th>
                </tr>
                </thead>
                <tbody>
                @foreach($user->parrainesList() as $descendant)
                  <tr>
                    <td>{{ $descendant['niveau'] }}</td>
                    <td>{{ $descendant['username'] }}</td>
                    <td>{{ Utils::formatDate($descendant['created_at'], 'd/m/Y') }}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
            <div class="row m-3">
              <h3>Historique des points : </h3>
              <table class="table table-striped">
                <thead>
                <tr>
                  <th>Id</th>
                  <th>Utilisateur</th>
                  <th>Points</th>
                  <th>Date et heure</th>
                </tr>
                </thead>
                <tbody>
                @foreach($histories as $history)
                  <tr>
                    <td>{{ $history->id }}</td>
                    <td>{{ $history->user?->username }}</td>
                    <td>{{ $history->points }}</td>
                    <td>{{ Utils::formatDate($history->created_at, 'd/m/Y H:i') }}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
              {{ $histories->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
