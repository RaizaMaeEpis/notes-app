<x-app-layout>
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        body { background: #F4F2FF; }

        .profile-page { max-width: 600px; margin: 0 auto; padding: 24px 16px 100px; }

        /* Profile hero card */
        .profile-hero {
            background: linear-gradient(135deg, #6C3FE8 0%, #9B6DFF 100%);
            border-radius: 24px;
            padding: 32px 24px;
            text-align: center;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }
        .profile-hero::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 160px; height: 160px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
        }
        .profile-hero::after {
            content: '';
            position: absolute;
            bottom: -30px; left: -30px;
            width: 120px; height: 120px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
        }

        /* Avatar upload */
        .avatar-wrap {
            position: relative;
            display: inline-block;
            margin-bottom: 16px;
        }
        .avatar-img {
            width: 96px; height: 96px;
            border-radius: 50%;
            border: 4px solid rgba(255,255,255,0.4);
            object-fit: cover;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 36px; font-weight: 700; color: white;
            font-family: 'Sora', sans-serif;
            overflow: hidden;
        }
        .avatar-edit-btn {
            position: absolute;
            bottom: 2px; right: 2px;
            width: 28px; height: 28px;
            background: #FFD60A;
            border-radius: 50%;
            border: 2px solid white;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-size: 13px;
            transition: transform 0.15s;
        }
        .avatar-edit-btn:hover { transform: scale(1.1); }
        #avatarInput { display: none; }

        .profile-name { font-size: 22px; font-weight: 700; color: white; font-family: 'Sora', sans-serif; margin-bottom: 4px; }
        .profile-email { font-size: 13px; color: rgba(255,255,255,0.75); }

        /* Cards */
        .card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            margin-bottom: 16px;
            border: 1.5px solid #EDE9FE;
            box-shadow: 0 2px 8px rgba(108,63,232,0.06);
        }
        .card-title {
            font-size: 15px; font-weight: 700; color: #1F2937;
            font-family: 'Sora', sans-serif;
            margin-bottom: 4px;
        }
        .card-subtitle { font-size: 13px; color: #9CA3AF; margin-bottom: 20px; }

        /* Form fields */
        .field-label { font-size: 12px; font-weight: 600; color: #6B7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.05em; }
        .field-input {
            width: 100%; padding: 12px 14px;
            border: 1.5px solid #EDE9FE; border-radius: 12px;
            font-size: 15px; color: #1F2937; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #FAFAFE;
            font-family: 'DM Sans', sans-serif;
            box-sizing: border-box;
        }
        .field-input:focus { border-color: #6C3FE8; box-shadow: 0 0 0 3px rgba(108,63,232,0.1); background: white; }

        /* Buttons */
        .btn-save {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #6C3FE8, #9B6DFF);
            color: white; font-weight: 700; font-size: 15px;
            border: none; border-radius: 14px; cursor: pointer;
            transition: transform 0.15s, box-shadow 0.15s;
            box-shadow: 0 4px 16px rgba(108,63,232,0.3);
            font-family: 'Sora', sans-serif;
            margin-top: 8px;
        }
        .btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(108,63,232,0.4); }

        .btn-danger {
            width: 100%; padding: 14px;
            background: white; color: #EF4444;
            font-weight: 700; font-size: 15px;
            border: 1.5px solid #FEE2E2; border-radius: 14px; cursor: pointer;
            transition: background 0.15s;
            font-family: 'Sora', sans-serif;
            margin-top: 8px;
        }
        .btn-danger:hover { background: #FEF2F2; }

        .saved-msg { font-size: 13px; color: #10B981; font-weight: 500; text-align: center; margin-top: 8px; }

        /* Stats row */
        .stats-row { display: flex; gap: 12px; margin-bottom: 20px; }
        .stat-card {
            flex: 1; background: white; border-radius: 16px;
            padding: 16px; text-align: center;
            border: 1.5px solid #EDE9FE;
            box-shadow: 0 2px 8px rgba(108,63,232,0.06);
        }
        .stat-num { font-size: 24px; font-weight: 800; color: #6C3FE8; font-family: 'Sora', sans-serif; }
        .stat-label { font-size: 11px; color: #9CA3AF; font-weight: 500; margin-top: 2px; }
    </style>

    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">

    <div class="profile-page">

        <!-- Hero card -->
        <div class="profile-hero">
            <div class="avatar-wrap">
                <div class="avatar-img" id="avatarDisplay">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Profile" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </div>
                <label for="avatarInput" class="avatar-edit-btn" title="Change photo">✏️</label>
                <input type="file" id="avatarInput" accept="image/*" onchange="previewAvatar(this)">
            </div>
            <div class="profile-name">{{ auth()->user()->name }}</div>
            <div class="profile-email">{{ auth()->user()->email }}</div>
        </div>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-num">{{ auth()->user()->notes()->count() }}</div>
                <div class="stat-label">Total Notes</div>
            </div>
            <div class="stat-card">
                <div class="stat-num">{{ auth()->user()->created_at->format('M Y') }}</div>
                <div class="stat-label">Member Since</div>
            </div>
        </div>

        <!-- Profile info form -->
        <div class="card">
            <div class="card-title">Profile Information</div>
            <div class="card-subtitle">Update your name and email address</div>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <!-- Hidden avatar input that submits with form -->
                <input type="file" name="avatar" id="avatarFormInput" style="display:none;" accept="image/*">

                <div style="margin-bottom: 16px;">
                    <div class="field-label">Full Name</div>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                        class="field-input" required>
                    @error('name')<p style="color:#EF4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <div class="field-label">Email Address</div>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                        class="field-input" required>
                    @error('email')<p style="color:#EF4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="btn-save">Save Changes</button>

                @if(session('status') === 'profile-updated')
                    <p class="saved-msg">✓ Profile updated successfully!</p>
                @endif
            </form>
        </div>

        <!-- Password form -->
        <div class="card">
            <div class="card-title">Change Password</div>
            <div class="card-subtitle">Use a strong password to keep your account safe</div>

            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                <div style="margin-bottom: 16px;">
                    <div class="field-label">Current Password</div>
                    <input type="password" name="current_password" class="field-input" autocomplete="current-password">
                    @error('current_password', 'updatePassword')<p style="color:#EF4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <div class="field-label">New Password</div>
                    <input type="password" name="password" class="field-input" autocomplete="new-password">
                    @error('password', 'updatePassword')<p style="color:#EF4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <div class="field-label">Confirm New Password</div>
                    <input type="password" name="password_confirmation" class="field-input" autocomplete="new-password">
                </div>

                <button type="submit" class="btn-save">Update Password</button>

                @if(session('status') === 'password-updated')
                    <p class="saved-msg">✓ Password updated!</p>
                @endif
            </form>
        </div>

        <!-- Delete account -->
        <div class="card">
            <div class="card-title" style="color:#EF4444;">Delete Account</div>
            <div class="card-subtitle">Permanently delete your account and all your notes</div>

            <form method="post" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure? This cannot be undone!')">
                @csrf
                @method('delete')
                <div style="margin-bottom: 16px;">
                    <div class="field-label">Confirm your password</div>
                    <input type="password" name="password" class="field-input" placeholder="Enter your password">
                    @error('password', 'userDeletion')<p style="color:#EF4444;font-size:12px;margin-top:4px;">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-danger">Delete My Account</button>
            </form>
        </div>

    </div>

    <script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarDisplay').innerHTML =
                    `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">`;
                // Copy file to the form input
                const dt = new DataTransfer();
                dt.items.add(input.files[0]);
                document.getElementById('avatarFormInput').files = dt.files;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
</x-app-layout>