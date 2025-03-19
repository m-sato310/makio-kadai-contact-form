@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-form">
    <h2 class="profile-form__heading content__heading">Profile</h2>
    <div class="profile-form__inner">
        <form action="/admin/register" class="profile-form__form" method="post">
            @csrf
            <div class="profile-form__group">
                <label class="profile-form__label" for="gender">性別</label>
                <div class="profile-form__gender-inputs">
                    <div class="profile-form__gender-option">
                        <label class="profile-form__gender-label">
                            <input class="profile-form__gender-input" name="gender" type="radio" id="male" value="1">
                            <span class="profile-form__gender-text">男性</span>
                        </label>
                    </div>
                    <div class="profile-form__gender-option">
                        <label class="profile-form__gender-label">
                            <input class="profile-form__gender-input" name="gender" type="radio" id="female" value="2">
                            <span class="profile-form__gender-text">女性</span>
                        </label>
                    </div>
                    <div class="profile-form__gender-option">
                        <label class="profile-form__gender-label">
                            <input class="profile-form__gender-input" name="gender" type="radio" id="other" value="3">
                            <span class="profile-form__gender-text">その他</span>
                        </label>
                    </div>
                </div>
                <p class="profile-form__error-message">
                    @error('gender')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label" for="position">役職</label>
                <input class="profile-form__input" type="text" name="position" id="position" placeholder="例：部長">
                <p class="profile-form__error-message">
                    @error('position')
                    {{ $message }}
                    @enderror
                </p>
            </div>
            <input class="profile-form__btn btn" type="submit" value="登録">
        </form>
    </div>
</div>

@endsection('content')