<div class="container">
    <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="{{ route('display') }}" class="nav-link active" aria-current="page">Display</a></li>
            @if(Auth::user()->is_admin == \App\Models\User::IS_ADMIN)
            <li class="nav-item"><a href="{{ route('users') }}" class="nav-link" aria-current="page">Utilisateurs</a></li>
            @endif
            <li class="nav-item"><a href="{{ route('logout') }}" class="nav-link">Logout</a></li>
        </ul>
    </header>
</div>
