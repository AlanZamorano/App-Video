@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.mensaje')
           <div class="card mb-5">
            <div class="card-header">Crear categoria</div>
            <div class="card-body">
                <form action="{{route('categorias.save')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="form-group row mb-3">
                    <label class="col-md-4 text-md-end col-form-label" for="tipo">Nombre</label>
                    <div class="col-md-6">
                        <input id="tipo" name="tipo" class="form-control @error('tipo') is-invalid @enderror" type="text" required/>

                        @error('tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </div>
                </div>
               
                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <input type="submit" class="btn btn-primary" value="Guardar">
                    </div>
                </div>

                </form>
            </div>
           </div>

           <h3>Categorías</h3>
           @foreach ($categorias as $categoria)
           <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between align-items-center">
              {{$categoria->tipo}}
              <span class="badge bg-primary rounded-pill">{{count($categoria->videos)}}</span>
            </li>
            <li class="list-group-item d-flex align-items-center">
                <a href="{{route('categorias.edit', ['id' => $categoria->id])}}">
                <button style="margin-right: 10px" class="btn btn-warning text-black" data-bs-toggle="modal" data-bs-target="#editarCategoria" data-bs-id="{{$categoria->id}}">Editar</button>
            </a>
            </li>
                
          </ul>
           @endforeach
           
        </div>
    </div>
</div>



@endsection