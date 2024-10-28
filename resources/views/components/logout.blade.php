<form id="logout-form" action="{{ route('logout') }}" method="POST">
    @csrf
</form>
<a href="#" class="dropdown-item"
    onclick="event.preventDefault(); resetModalFlag(); document.getElementById('logout-form').submit();">Logout</a>

