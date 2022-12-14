@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>REGIONAIS</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.regional.create')}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>

        <a class="btn btn-primary btn-danger" href="{{route('admin.regional.relpdfregional')}}" role="button" style="margin-bottom: 10px" target="_blank">
            <i class="far fa-file-pdf"></i> pdf
        </a>

        @if(session('sucesso'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>OK!</strong> {{session('sucesso')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


    <!-- DataTales Example -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Nº Municípios</th>
                            {{-- <th>Nº Bairros</th> --}}
                            <th>Nº Restaurantes</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($regionais as $regional)
                            <tr>
                                <td>{{$regional->id}}</td>
                                <td>{{$regional->nome}}</td>
                                <td>{{$regional->qtdmunicipiosvinc($regional->id)}}</td>
                                {{-- <td>{{$regional->bairros->count()}} / {{$regional->countmunicipios()}}</td>   Obtendo a quantidade de bairros pelo hasManyThrough--}}
                                <td>{{$regional->restaurantes->count()}}</td>
                                <td>@if($regional->ativo == 1) <b>SIM</b> @else NÃO @endif</td>
                                <td>
                                    {{--<a href="{{route('admin.regional.relpdfmunicipiosregional', $regional->id)}}" title="pdf municípios desta regional" target="_blank"><i class="fas fa-file-pdf text-danger mr-2"></i></a>--}}
                                    <a href="{{route('admin.regional.listarmunicipios', $regional->id)}}" title="municípios desta regional"><i class="fas fa-list text-success mr-2"></i></i></a>
                                    <a href="{{route('admin.regional.show', $regional->id)}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                                    <a href="{{route('admin.regional.edit', $regional->id)}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                                    {{-- Se o id da regional atual estiver dentro do array de regsvinculados, impede a deleção acidental. --}}
                                    {{-- @if(in_array($regional->id,$regsvinculados)) --}}
                                    @if($regional->qtdmunicipiosvinc($regional->id) == 0)
                                        <a href="" data-toggle="modal" data-target="#formDelete{{$regional->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>
                                    @else
                                        <a href="" title="há municípios vinculados!"><i class="fas fa-trash text-secondary mr-2"></i></a>
                                    @endif


                                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                                    <div class="modal fade" id="formDelete{{$regional->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar Regional</strong></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="alert alert-danger">ATENÇÃO! Esta operação não tem retorno!</p>
                                                    <h5>{{$regional->nome}}</h5>
                                                    <span class="mensagem" style="color: #f00;"></span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{route('admin.regional.destroy', $regional->id)}}" method="POST" style="display: inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" role="button"> Confirmar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
   </div>
</div>
@endsection

@section('scripts')

    {{-- <script>
        $(document).ready(function(){
            $('#dataTable').on('click', '.deletarregional', function(){

                var idMunicipio = $(this).data('idregional');

                $.ajax({
                    url:"{{route('admin.getamountbairros')}}",
                    type: "POST",
                    data: {
                        regional_id: idMunicipio,
                        _token: '{{csrf_token()}}'
                    },
                    dataType : 'json',
                    success: function(result){
                        if(result.qtd_bairros >= 1){
                            $(".mensagem").text("Este Município não pode ser deletado, pois possui: "+ result.qtd_bairros + " registro(s) associado(s) a ele!");
                            $("button[type=submit]").hide();
                        }else{
                            $("button[type=submit]").show();
                            $(".mensagem").text("");
                        }
                    }
                });
            });

            //$('button[type=button]').click(function(){
            //    location.reload(true);
            //});

        });
    </script> --}}

@endsection
