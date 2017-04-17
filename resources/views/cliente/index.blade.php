@extends('layouts.app')

<!--- TODO: CAMBIAR TODO --->

@section('content')

    <div class="container container-page">
        <div class="row">
            <div class="col-lg-12">
                <h3>Proyectos de {{ $user->name }}</h3>

                <a href="{{ route('cliente.create') }}" class="btn btn-primary">
                    Nuevo proyecto
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                @if(count($proyectos) == 0)
                    <div class="alert alert-warning">
                        <b>Ups!</b> Parece que no tienes proyectos creados
                    </div>
                @else

                    <table class="table table-responsive table-striped">

                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Proyecto</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                        </thead>
                        <input type="hidden" value="{{ $cont = 0 }}">
                        @foreach($proyectos as $p)
                            <tr>
                                <td>{{ ++$cont }}</td>
                                <td>{{ $p->nombre }}</td>
                                <td>
                                    @if($p->getEstado() != "no_pendiente")
                                        <p class="labelValidado-{{$p->id}}">{{ $p->getTituloEstado() }}</p>
                                    @else
                                        <a href="{{ route('cliente.cambiar_estado', $p->id) }}" data-id="{{$p->id}}" class="cambiar_estado btn btn-sm btn-primary">Pedir validación</a>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-default btn-xs"
                                       href="{{ route('cliente.show', $p->id) }}">
                                        Ver
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif

            </div>
        </div>
    </div>
@endsection