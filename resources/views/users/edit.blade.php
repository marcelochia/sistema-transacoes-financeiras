<x-layout>

    <h2>{{ $title }}</h2>

    @isset($created)
        <div class="alert alert-success">
            {{ $created }}
        </div>
    @endisset

    <x-users.form :action="route('users.update', $user)"
                  :name="$user->name" 
                  :email="$user->email"
                  :update="true"
                  :invalidEmail="$invalidEmail" />

</x-layout>