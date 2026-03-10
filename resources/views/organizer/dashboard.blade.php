<h1>Dashboard Organizer</h1>

<p>Selamat datang, {{ Auth::user()->name }}</p>

<form method="POST" action="/logout">
@csrf
<button type="submit">Logout</button>
</form>