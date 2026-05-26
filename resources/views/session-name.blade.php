<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Session demo</title>
</head>
<body>
    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif

    <form method="post" action="/session/name">
        @csrf
        <label>
            Name
            <input name="name" value="{{ old('name', session('demo_name')) }}" required maxlength="80">
        </label>
        @error('name')
            <p>{{ $message }}</p>
        @enderror
        <button type="submit">Save</button>
    </form>
</body>
</html>
