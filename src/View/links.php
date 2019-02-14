<?php $welcome_text = "Bienvenue";
    $goodbye_text = "Aurevoir";
    $test_tab = array("Un", "Deux", "Trois", "Quatre", "Cinq");
    $records = array(); ?>
<a href="/PiePHP/log">Go to Login</a>
<a href="/PiePHP/reg">Go to Register</a>
{{$welcome_text}}
{{$goodbye_text}}
@if ($welcome_text === "Bienvenue")
    Afficher if
@elseif ($welcome_text === "Aurevoir")
    Afficher elseif
@else
    Afficher else
@endif
@foreach ($test_tab as $key => $value)
    <p>This is index {{$key}} and it is worth {{$value}}<p>
@endforeach
@isset ($records)
    <p>Records is not null!</p>
@endisset
@empty ($records)
    <p>Records is empty!</p>
@endempty