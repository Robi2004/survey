<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <div style="text-align:center">
        <h1>Exportation des Sondages</h1>
    </div>
    @foreach($data as $survey)
        <div>
            @if ($title == true)
            <h3 style="text-align:center">Titre : {{$survey['title']}}</h3>
            @endif  
        </div>
    @endforeach
</body>
</html>