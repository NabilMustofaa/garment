<nav id="navbar-main" class="navbar is-fixed-top" style="justify-content: flex-end">
      <div class="navbar-item dropdown has-divider has-user-avatar">
        <a class="navbar-link">
          <div class="user-avatar">
            <img src="https://avatars.dicebear.com/v2/initials/john-doe.svg" alt="John Doe" class="rounded-full">
          </div>
          <div class="is-user-name"><span>{{ Auth::user()->name }}</span></div>
          <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
        </a>
        <div class="navbar-dropdown">
          {{-- <a href="/profile/indexprofile" class="navbar-item">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>My Profile</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-settings"></i></span>
            <span>Settings</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-email"></i></span>
            <span>Messages</span>
          </a>
          <hr class="navbar-divider"> --}}
          <form action="/logout" method="get">
            @csrf
            <button type="submit" class="mdi mdi-logout" style="padding: 1.1rem">
                Logout
                <span data-feather="log-out"></span>
            </button>
          </form>
        </div>
      </div>
</nav>