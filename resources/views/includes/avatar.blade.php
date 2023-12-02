@if(Auth::user()->imagen)
    <img src="{{route('user.imagen',['filename'=>Auth::user()->imagen])}}" alt="Imagen de usuario">
@else
    <img src="{{ asset('app/users/icono.jpg')}}" alt="">
@endif