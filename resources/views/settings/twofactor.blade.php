@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Two factor settings</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('twofactor.settings.index') }}">
                        @csrf
                        @method('put')

                        <div class="form-group row">
                            <label for="two_factor_type" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>

                            <div class="col-md-6">
                                <select name="two_factor_type" id="two_factor_type" class="form-control @error('two_factor_type') is-invalid @enderror">
                                    @foreach(config('twofactor.types') as $key => $name)
                                        <option value="{{ $key }}"
                                        {{ old('two_factor_type') === $key || Auth::user()->hasTwoFactorType($key) ? 'selected' : ''}}
                                        >
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('two_factor_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number_dialling_code" class="col-md-4 col-form-label text-md-right">{{ __('Dialling code') }}</label>

                            <div class="col-md-6">
                                <select name="phone_number_dialling_code" id="phone_number_dialling_code" class="form-control @error('phone_number_dialling_code') is-invalid @enderror">
                                    <option value="">Select a dialling code</option>
                                    @foreach($diallingCodes as $code)
                                        <option value="{{ $code->id }}"
                                            {{ old('phone_number_dialling_code') == $code->id || Auth::user()->hasDiallingCode($code->id) ? 'selected' : '' }}
                                        >
                                            {{ $code->name }} (+{{ $code->dialling_code }})
                                        </option>
                                    @endforeach
                                </select>

                                @error('phone_number_dialling_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-right">{{ __('Phone number') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') ? old('phone_number') : Auth::user()->getPhoneNumber() }}" autofocus>

                                @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

