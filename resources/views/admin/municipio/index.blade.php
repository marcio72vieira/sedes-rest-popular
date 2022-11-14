@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>MUNICÍPIOS</strong></h5>

        <a class="btn btn-primary" href="{{route('admin.municipio.create')}}" role="button" style="margin-bottom: 10px">
            <i class="fas fa-plus-circle"></i>
            Adicionar
        </a>

        <a class="btn btn-primary btn-danger" href="{{route('admin.municipio.relpdfmunicipio')}}" role="button" style="margin-bottom: 10px" target="_blank">
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
                            <th>Regional</th>
                            <th>Nº Bairros</th>
                            <th>Nº Restaurantes</th>
                            <th>Ativo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($municipios as $municipio)
                            <tr>
                                <td>{{$municipio->id}}</td>
                                <td>{{$municipio->nome}}</td>
                                <td>{{$municipio->regional->nome}}</td>
                                <td>{{$municipio->qtdbairrosvinc($municipio->id)}}</td>
                                <td>{{$municipio->qtdrestaurantesvinc($municipio->id)}}</td>
                                <td>@if($municipio->ativo == 1) <b>SIM</b> @else NÃO @endif</td>
                                <td>
                                    <a href="{{route('admin.municipio.listarbairros', $municipio->id)}}" title="bairros e restaurantes deste município"><i class="fas fa-list text-success mr-2"></i></i></a>
                                    <a href="{{route('admin.municipio.show', $municipio->id)}}" title="exibir"><i class="fas fa-eye text-warning mr-2"></i></a>
                                    <a href="{{route('admin.municipio.edit', $municipio->id)}}" title="editar"><i class="fas fa-edit text-info mr-2"></i></a>
                                    @if($municipio->qtdbairrosvinc($municipio->id) == 0 && $municipio->qtdrestaurantesvinc($municipio->id) == 0)
                                        <a href="" data-toggle="modal" data-target="#formDelete{{$municipio->id}}" title="excluir"><i class="fas fa-trash text-danger mr-2"></i></a>
                                    @else
                                        <a href="" title="há bairros/restaurantes vinculados!"><i class="fas fa-trash text-secondary mr-2"></i></a>
                                    @endif

                                    <!-- MODAL FormDelete OBS: O id da modal para cada registro tem que ser diferente, senão ele pega apenas o primeiro registro-->
                                    <div class="modal fade" id="formDelete{{$municipio->id}}" tabindex="-1" aria-labelledby="formDeleteLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="formDeleteLabel"><strong>Deletar municipio</strong></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>{{$municipio->nome}}</h5>
                                                    <span class="mensagem" style="color: #f00;"></span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{route('admin.municipio.destroy', $municipio->id)}}" method="POST" style="display: inline">
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
    <script>
        $(document).ready(function(){
            $('#dataTable').on('click', '.deletarmunicipio', function(){

                var idMunicipio = $(this).data('idmunicipio');

                $.ajax({
                    url:"{{route('admin.getamountbairros')}}",
                    type: "POST",
                    data: {
                        municipio_id: idMunicipio,
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
    </script>
@endsection
