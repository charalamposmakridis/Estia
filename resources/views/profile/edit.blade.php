<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <title>Profile Update</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
<div class="profile-container">
    <h2>Profile Update</h2>

    @if (session('status') === 'profile-updated')
        <div class="alert-success">
            <p>Profile updated successfully</p>
        </div>
    @endif


    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name">Username</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-actions">
            <button type="submit">Save</button>
        </div>
    </form>

    <hr>

    <!-- Φόρμα Αλλαγής Κωδικού -->
    <h3>Change Password</h3>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
            @error('current_password', 'updatePassword')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" required>
            @error('password', 'updatePassword')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="form-actions">
            <button type="submit">Change Password</button>
        </div>
    </form>

    <div class="nav-back">
        <p><a href="{{ route('listings.index') }}">Explore Listings</a></p>
    </div>
</div>
</body>
</html>
