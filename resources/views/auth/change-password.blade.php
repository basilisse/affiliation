@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ __('Edit') }}</div>

          <div class="card-body">
            <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
              @csrf
              @method('put')
              <div class="row mb-3">
                <label for="ol-password" class="col-md-4 col-form-label text-md-end">{{ __('Ancien Password') }}</label>

                <div class="col-md-6">
                  <input id="old-password"
                         type="text"
                         class="form-control @error('name') is-invalid @enderror"
                         name="old-password"
                         required autocomplete="username" autofocus>

                  @error('username')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                <div class="col-md-6">
                  <input id="email"
                         type="email"
                         class="form-control @error('email') is-invalid @enderror"
                         name="email"
                         value="{{ $user->email }}"
                         required autocomplete="email">

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>

              <div class="row mb-3">
                <label for="enabled" class="col-md-4 col-form-label text-md-end">{{ __('Active') }}</label>

                <div class="col-md-6">
                  <input id="password"
                         type="checkbox"
                         class="mt-2 @error('password') is-invalid @enderror"
                         @checked($user->enabled)
                         name="enabled">

                  @error('enabled')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label for="banned" class="col-md-4 col-form-label text-md-end">{{ __('Banni') }}</label>

                <div class="col-md-6">
                  <input id="banned"
                         type="checkbox"
                         class="mt-2 @error('banned') is-invalid @enderror"
                         @checked($user->banned)
                         name="banned">

                  @error('baned')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
                </div>
              </div>
              <div class="row mb-0 justify-content-center gap-3">
                <button type="submit" class="col-3 btn btn-primary">
                  {{ __('Register') }}
                </button>
                <a href="{{ route('admin.index') }}" type="reset" class="col-3 btn btn-danger">
                  {{ __('Annuler') }}
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
