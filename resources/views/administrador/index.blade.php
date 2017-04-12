@extends('layouts.app')

@section('content')
    <div class="container">
        <h3> Panel de control</h3>
        <div class="row">
            <div class="col-lg-12">

                <h4> Usuarios </h4>
                    <a class="btn btn-primary btn-xs"
                       href="{{ route('administrador.form_crear_usuario')}}">
                        Crear usuario
                    </a>
                <table class="table table-responsive table-condensed ">
                    <thead>
                        <th>ID de usuario</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Rol</th>
                    </thead>
                    @foreach($users as $u)
                        <tr @if($u->oculto ==1) class="danger" @endif>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->name . ' ' . $u->apellidos}}</td>
                            <td>{{ $u->email }} </td>
                            <td>{{ $u->direccion_fisica}} </td>
                            <td>{{ $u->telefono }} </td>
                            <td>{{ $u->getTitle() }}</td>
                            <td>
                                <a class="btn btn-default btn-xs"
                                    href="{{ route('administrador.form_editar_usuario', $u->id) }}">
                                    Editar
                                </a>
                            </td>
                            <td>
                                <div class="form-inline">
                                @if($u->oculto == 0)
                                    <form action="{{ route('administrador.deshabilitar_usuario') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$u->id}}">
                                        <input type="submit" class="btn btn-primary btn-xs" value="Deshabilitar">
                                    </form>
                                @elseif($u->oculto ==1)
                                    <!-- TODO: Seguir con esto -->

                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal">
                                        Habilitar
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Habilitar Usuario</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('administrador.habilitar_usuario') }}" method="post">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="id" value="{{$u->id}}">
                                                        <label for="password" class="control-label">Nueva contraseña  </label>
                                                        <input type="password" name="password">
                                                        <input type="submit" class="btn btn-success btn-xs" value="Habilitar">
                                                    </form>
                                                </div>
                                                <div class="modal-footer">Para habilitar de nuevo a {{ $u->name .' '. $u->apellidos}} es necesario establecer una nueva contraseña.</div>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <h4> Productos </h4>
                    <a class="btn btn-primary btn-xs"
                       href="{{ route('administrador.form_crear_producto')}}">
                        Crear producto
                    </a>
                <table class="table table-responsive table-condensed">
                    <thead>
                    <th>ID de producto</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Restricciones</th>
                    <th>Coste</th>
                    <th>Imagen</th>
                    </thead>
                    @foreach($productos as $p)
                        <tr @if($p->oculto ==1) class="danger" @endif>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->nombre }}</td>
                            <td>{{ $p->descripcion }} </td>
                            <td>{{ $p->restricciones}} </td>
                            <td>{{ $p->coste . " €"}} </td>
                            <td>{{ $p->imagen }}</td>
                            <td>
                                <a class="btn btn-default btn-xs"
                                   href="{{ route('administrador.form_editar_producto', $p->id) }}">
                                    Editar
                                </a>
                            </td>
                            <td>
                                <div class="form-inline">
                                @if($p->oculto == 0)
                                    <form action="{{ route('administrador.deshabilitar_producto') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$p->id}}">
                                        <input type="submit" class="btn btn-primary btn-xs" value="Deshabilitar">
                                    </form>
                                @elseif($p->oculto ==1)
                                    <form action="{{ route('administrador.habilitar_producto') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$p->id}}">
                                        <input type="submit" class="btn btn-success btn-xs" value="Habilitar">
                                    </form>
                                @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <h4> Planos </h4>
                    <a class="btn btn-primary btn-xs"
                       href="{{ route('administrador.form_crear_plano')}}">
                        Crear plano
                    </a>
                <table class="table table-responsive table-condensed ">
                    <thead>
                    <th>ID de plano</th>
                    <th>Nombre</th>
                    <th>Imagen</th>
                    </thead>
                    @foreach($planos as $p)
                        <tr @if($p->oculto ==1) class="danger" @endif>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->nombre }}</td>
                            <td>{{ $p->imagen }}</td>
                            <td>
                                <a class="btn btn-default btn-xs"
                                   href="{{ route('administrador.form_editar_plano', $p->id) }}">
                                    Editar
                                </a>
                            </td>
                            <td>
                                <div class="form-inline">
                                @if($p->oculto == 0)
                                    <form action="{{ route('administrador.deshabilitar_plano') }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="id" value="{{$p->id}}">
                                        <input type="submit" class="btn btn-primary btn-xs" value="Deshabilitar">
                                    </form>
                                @elseif($p->oculto ==1)



                                            <form action="{{ route('administrador.habilitar_plano') }}" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{$p->id}}">
                                                <input type="submit" class="btn btn-success btn-xs" value="Habilitar">
                                            </form>


                                @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection