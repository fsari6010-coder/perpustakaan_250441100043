<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">
            Pengaturan Profil
        </h2>
    </x-slot>

    <div class="profile-container">

        <div class="profile-card">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="profile-card">
            @include('profile.partials.update-password-form')
        </div>

        <div class="profile-card profile-delete-card">
            @include('profile.partials.delete-user-form')
        </div>

    </div>
</x-app-layout>