@if($canal->imagen)
    <img src="{{route('canal.imagen',['filename'=>$canal->imagen])}}" alt="Imagen de canal">
@else
    <img src="{{ asset('app/users/icono.jpg')}}" alt="">
@endif