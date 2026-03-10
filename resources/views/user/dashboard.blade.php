<h1>Dashboard User</h1>

<p>Selamat datang, {{ Auth::user()->name }}</p>

<form method="POST" action="/logout">
@csrf
<button type="submit">Logout</button>
</form>