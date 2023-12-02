@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.mensaje')
           <div class="card mb-5">
            <div class="card-header">Editar</div>
            <div class="card-body">
                <form action="{{route('categorias.update')}}" method="post" enctype="multipart/form-data" autocomplete="off">
                @csrf
                    <input name="id" type="hidden" value="{{$categorias->id}}">
                <div class="form-group row mb-3">
                    <label class="col-md-4 text-md-end col-form-label" for="tipo">Nombre</label>
                    <div class="col-md-6">
                        <input id="tipo" name="tipo" value="{{$categorias->tipo}}" class="form-control @error('tipo') is-invalid @enderror" type="text" required/>

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

@endsection