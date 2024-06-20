<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('dashboard') }}">
            {{ config('app.name', 'Laravel') }}
        </a>

        <!-- Toggle button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <!-- Dashboard Link -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <!-- Laptop Manager Link -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('laptop') ? 'active' : '' }}" href="{{ route('laptop') }}">Laptop Manager</a>
                </li>

                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="teamsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->currentTeam->name }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="teamsDropdown">
                            <!-- Team Settings -->
                            <li><a class="dropdown-item" href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">Team Settings</a></li>
                            <!-- Create New Team -->
                            @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                <li><a class="dropdown-item" href="{{ route('teams.create') }}">Create New Team</a></li>
                            @endcan
                            <!-- Switch Teams -->
                            @if (Auth::user()->allTeams()->count() > 1)
                                <li><hr class="dropdown-divider"></li>
                                <li><span class="dropdown-item-text">Switch Teams:</span></li>
                                @foreach (Auth::user()->allTeams() as $team)
                                    <li><a class="dropdown-item" href="{{ route('team.switch', $team->id) }}">{{ $team->name }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                @endif
            </ul>

            <!-- Search Form -->
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <!-- Right side of Navbar -->
            <ul class="navbar-nav">
                <!-- Profile Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <!-- Profile Link -->
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                        <!-- API Tokens Link -->
                        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                            <li><a class="dropdown-item" href="{{ route('api-tokens.index') }}">API Tokens</a></li>
                        @endif
                        <!-- Logout -->
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
