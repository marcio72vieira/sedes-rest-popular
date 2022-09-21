@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Gerenciar Perfil</h1>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Aviso! Caso altere seus dados, novo login deverá ser realizado! </strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="row">

        <div class="col-lg-12 order-lg-1">

            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{$user->fullname}}<br>
                        <span class="small text-secondary">Campo marcado com * é de preenchimento obrigatório!</span>
                    </h6>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{route('admin.user.updateprofile', $user->id)}}" autocomplete="off">
                        @csrf
                        @method('PUT')

                        {{-- preservando a antiga senha e perfil do usuario --}}
                        <input type="hidden" name="old_perfil_hidden" value="{{$user->perfil}}">
                        <input type="hidden" name="old_password_hidden" value="{{$user->password}}">

                        <div class="pl-lg-4">
                            <div class="row">
                                {{-- nomecompleto --}}
                                <div class="col-lg-4">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="nomecompleto">Nome Completo<span class="small text-danger">*</span></label>
                                        <input type="text" id="nomecompleto" class="form-control" name="nomecompleto" value="{{old('nomecompleto', $user->nomecompleto)}}" required>
                                        @error('nomecompleto')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- cpf --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="cpf">CPF<span class="small text-danger">*</span></label>
                                        <input type="text" id="cpf" class="form-control" name="cpf" value="{{old('cpf', $user->cpf)}}" required>
                                        @error('cpf')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- crn --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="crn">CRN<span class="small text-danger">*</span></label>
                                        <input type="text" id="crn" class="form-control" name="crn" value="{{old('crn', $user->crn)}}">
                                        @error('crn')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>


                                {{-- telefone --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="telefone">Telefone<span class="small text-danger">*</span></label>
                                        <input type="text" id="telefone" class="form-control" name="telefone" value="{{old('telefone', $user->telefone)}}" required>
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
                                        <input type="text" id="name" class="form-control" name="name" value="{{old('name', $user->name)}}" required>
                                        @error('name')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- email --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="email">E-mail<span class="small text-danger">*</span></label>
                                        <input type="email" id="email" class="form-control" name="email" value="{{old('email', $user->email)}}" required>
                                        @error('email')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                {{-- password --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="password">Senha<span class="small text-danger">*</span></label>
                                        <input type="password" id="password" class="form-control" name="password" value="{{old('password')}}">
                                        @error('password')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                                {{-- password_confirmation --}}
                                <div class="col-lg-2">
                                    <div class="form-group focused">
                                        <label class="form-control-label" for="password_confirmation">Confirmar Senha<span class="small text-danger">*</span></label>
                                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" value="{{old('password_confirmation')}}">
                                        @error('password_confirmation')
                                            <small style="color: red">{{$message}}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col text-center">
                                    <a class="btn btn-primary" href="{{route('admin.user.index')}}" role="button">Cancelar</a>
                                    <button type="submit" class="btn btn-primary" style="width: 95px;"> Salvar </button>
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
