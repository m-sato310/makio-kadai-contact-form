@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
<div class="contact-form">
    <h2 class="contact-form__heading content__heading">Contact</h2>
    <div class="contact-form__inner">
        <form action="confirm" method="post">
            @csrf
            <div class="contact-form__group contact-form__name-group">
                <label class="contact-form__label" for="name">
                    お名前<span class="contact-form__required">※</span>
                </label>
                <div class="contact-form__name-inputs">
                    <input class="contact-form__input contact-form__name-input" type="text" name="first_name" id="name" value="{{ old('first_name) }}" placeholder="例：山田">
                    <input class="contact-form__input contact-form__name-input" type="text" name="last_name" id="name" value="{{ old(last_name) }}" placeholder="例：太郎">
                </div>
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label">
                    性別<span class="contact-form__required">※</span>
                </label>
                <div class="contact-form__gender-inputs">
                    <div class="contact-form__gender-option">
                        <label class="contact-form__gender-label">
                            <input class="contact-form__gender-input" name="gender" type="radio" id="male" value="1" {{ old('gender')==1 || old('gender')==null ? 'checked' : '' }}>
                            <span class="contact-form__gender-text">男性</span>
                        </label>
                    </div>
                    <div class="contact-form__gender-option">
                        <label class="contact-form__gender-label">
                            <input class="contact-form__gender-input" type="radio" name="gender" id="female" value="2" {{ old('gender')==2 ? 'checked' : ''}}>
                            <span class="contact-form__gender-text">女性</span>
                        </label>
                    </div>
                    <div class="contact-form__gender-option">
                        <label class="contact-form__gender-label" for="other">
                            <input class="contact-form__gender-input" type="radio" name="gender" id="other" value="3" {{ old('gender')==3 ? 'checked' : ''}}>
                            <span class="contact-form__gender-text">その他</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="email">
                    メールアドレス<span class="contact-form__required">※</span>
                </label>
                <input class="contact-form__input" type="email" name="email" id="email" value="{{ old('email) }}" placeholder="例：test@example.com">
            </div>


            <div class="contact-form__group">
                <label class="contact-form__label" for="tel">
                    電話番号<span class="contact-form__required">※</span>
                </label>
                <div class="contact-form__tel-inputs">
                    <input class="contact-form__input contact-form__tel-input" type="tel" name="tel_1" value="{{ old('tel_1') }}">
                    <span>-</span>
                    <input class="contact-form__input contact-form__tel-input" type="tel" name="tel_2" value="{{ old('tel_2') }}">
                    <span>-</span>
                    <input class="contact-form__input contact-form__tel-input" type="tel" name="tel_3" value="{{ old('tel_3') }}">
                </div>
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="address">
                    住所<span class="contact-form__required">※</span>
                </label>
                <input class="contact-form__input" type="text" name="address" id="address" value="{{ old('address') }}" placeholder="例：東京都渋谷区千駄ヶ谷１−２−３">
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="building">建物名</label>
                <input class="contact-form__input" type="text" name="building" id="building" value="{{ old('building') }}" placeholder="例：千駄ヶ谷マンション１０１">
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="">
                    お問い合わせの種類<span class="contact-form__required">※</span>
                </label>
                <div class="contact-form__select-inner">
                    <select class="contact-form__select" name="category_id" id="">
                        <option disabled selected>選択してください</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>{{ $category->content }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="contact-form__group">
                <label class="contact-form__label" for="detail">
                    お問い合わせ内容<span class="contact-form__required">※</span>
                </label>
                <textarea class="contact-form__textarea" name="detail" id="" cols="30" rows="10" placeholder="お問い合わせ内容をご記載ください">{{ old('detail') }}</textarea>
            </div>
        </form>
    </div>
</div>