<?php

use App\Livewire\Home;
use Laravel\Fortify\Features;
use App\Livewire\DivisionPage;
use App\Livewire\MemberProfile;
use App\Livewire\AllGalleryPage;
use App\Livewire\AllMembersPage;
use App\Livewire\EditProfilePage;
use App\Livewire\UserProfilePage;
use App\Livewire\AllDivisionsPage;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\RegisterMemberPage;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('join', RegisterMemberPage::class)->name('register-member');
Route::get('user/{gamertag}', UserProfilePage::class)->name('user-profile');
Route::get('division/{slug}', DivisionPage::class)->name('division');
Route::get('division', AllDivisionsPage::class)->name('all-divisions');
Route::get('members', AllMembersPage::class)->name('all-members');
Route::get('gallery', AllGalleryPage::class)->name('all-gallery');

Route::middleware(['auth'])->group(function () {

    Route::get('dashboard', MemberProfile::class)->name('dashboard');
    Route::get('profile/edit', EditProfilePage::class)->name('edit-profile');
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
