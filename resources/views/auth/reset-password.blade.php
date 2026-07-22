<x-guest-layout>
    <h2>{{ l('تغییر رمز عبور') }}</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <label>{{ l('ایمیل:') }}</label>
        <input type="email" name="email" required />
        <label>{{ l('رمز عبور جدید:') }}</label>
        <input type="password" name="password" required />
        <label>{{ l('تکرار رمز عبور:') }}</label>
        <input type="password" name="password_confirmation" required />
        <button type="submit">{{ l('تغییر رمز عبور') }}</button>
    </form>
</x-guest-layout>
