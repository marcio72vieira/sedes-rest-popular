@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h5 class="h5 mb-4 text-gray-800">Usuarios / Exibir</h5>

    <div class="row">

        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Usuário: {{$user->nomecompleto}} -  Restaurante: {{$user->restaurante->identificacao}}
                    </h6>
                </div>

                <div class="card-body">

                    <form method="" action="">
                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- nomecompleto --}}
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="nomecompleto">Nome Completo<span class="small text-danger">*</span></label>
                                        <input type="text" id="nomecompleto" class="form-control" name="nomecompleto" value="{{$user->nomecompleto}}" readonly>
                                        @error('nomecompleto')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cpf --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cpf">CPF<span class="small text-danger">*</span></label>
                                        <input type="text" id="cpf" class="form-control" name="cpf" value="{{$user->cpf}}" readonly>
                                        @error('cpf')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- crn --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="crn">crn<span class="small text-danger">*</span></label>
                                        <input type="text" id="crn" class="form-control" name="crn" value="{{$user->crn}}" readonly>
                                        @error('crn')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>


                                {{-- telefone --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="telefone">Telefone<span class="small text-danger">*</span></label>
                                        <input type="text" id="telefone" class="form-control" name="telefone" value="{{$user->telefone}}" readonly>
                                        @error('telefone')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                {{-- name --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="name">Usuário<span class="small text-danger">*</span></label>
                                        <input type="text" id="name" class="form-control" name="name" value="{{$user->name}}" readonly>
                                        @error('name')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- email --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="email">E-mail<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" value="{{$user->email}}" readonly>
                                        @error('email')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- municipio_id --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="municipio_id">Município<span class="small text-danger">*</span></label>
                                        <select name="municipio_id" id="municipio_id" class="form-control" disabled>
                                            <option>{{$user->municipio->nome}}</option>
                                        </select>
                                        @error('municipio_id')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- perfil --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="perfil">Perfil<span class="small text-danger">*</span></label>
                                        <select name="perfil" id="perfil" class="form-control" disabled>
                                            <option value="" selected disabled>Escolha ...</option>
                                            <option value="adm" {{old('perfil', $user->perfil) == 'adm' ? 'selected' : ''}}>Administrador</option>
                                            <option value="nut" {{old('perfil', $user->perfil) == 'nut' ? 'selected' : ''}}>Nutricionista</option>
                                            <option value="ina" {{old('perfil', $user->perfil) == 'ina' ? 'selected' : ''}}>Inativo</option>
                                        </select>
                                        @error('perfil')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                {{-- password --}}
                                {{-- 
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="password">Senha<span class="small text-danger">*</span></label>
                                        <input type="password" id="password" class="form-control" name="password" value="******" readonly>
                                        @error('password')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                --}}
                            </div>
                        </div>


                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <a class="btn btn-primary" href="{{route('admin.user.index')}}" role="button">
                                        <i class="fas fa-undo-alt"></i>
                                        Retornar</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
