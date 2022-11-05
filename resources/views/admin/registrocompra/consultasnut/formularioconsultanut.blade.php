@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

    <h5><strong>Consultar compras</h5>


    <form action="{{route('admin.consulta.compramensalrestaurante')}}"  method="GET" class="form-inline"  style="margin-left: -15px">
        <div class="form-group mx-sm-3 mb-2">

            {{-- id do restaurante do restaurante do usuário nutricionista logado --}}
            <input type="hidden" name="restaurante_id" value="{{ $restaurante->id }}">

            <select name="mes_id" id="mes_id" class="form-control" required>
                <option value="" selected disabled>Mês...</option>
                @foreach($mesespesquisa as $key => $value)
                    <option value="{{ $key }}"> {{ $value }} </option>
                @endforeach
            </select>

            &nbsp;&nbsp;&nbsp;

            <select name="ano_id" id="ano_id" class="form-control" required>
                <option value="" selected disabled>Ano...</option>
                @foreach($anospesquisa as $value)
                    <option value="{{ $value}}"> {{ $value }} </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary mb-2 btn-sm">pesquisar</button>
    </form>

    <div class="card shadow mb-4">
        <div class="card-body">

            @if(session('error_compramensalrestaurante'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Atenção! </strong> {{session('error_compramensalrestaurante')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table class="table table-sm table-bordered  table-hover">
                <thead  class="bg-gray-100">
                    <tr>
                        {{-- Forma de acessar uma propriedade antes de um "FOREACH": $records[0]->coluna --}}
                        <th colspan="4">Região: - Município: </th>
                        <th colspan="4"></th>
                        <th colspan="4" style="text-align: right"></th>
                    </tr>
                    <tr>
                        <th colspan="4">Nutricionista Empresa: </th>
                        <th colspan="4">De: a </th>
                        <th colspan="4"></th>
                    </tr>
                    <tr>
                        <th colspan="4">Nutricionista SEDES: </th>
                        <th colspan="4"></th>
                        <th colspan="4"></th>
                    </tr>
                    <tr>
                        <th scope="col" style="width: 40px; text-align: center">Id</th>
                        <th scope="col" style="width: 100px; text-align: center">semana</th>
                        <th scope="col" style="width: 200px; text-align: center">Produto</th>
                        <th scope="col" style="text-align: center">Detalhe</th>
                        <th scope="col" style="width: 40px; text-align: center">AF</th>
                        <th scope="col" style="width: 100px; text-align: center">Quant.</th>
                        <th scope="col" style="width: 100px; text-align: center">Unidade</th>
                        <th scope="col" style="width: 120px; text-align: center">Preço</th>
                        <th scope="col" style="width: 120px; text-align: center">Total</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <th scope="row">&nbsp;</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: right"></td>
                            <td style="text-align: center"></td>
                            <td style="text-align: right"></td>
                            <td style="text-align: right"></td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td colspan="8" style="text-align: right"><strong>Valor R$</strong> </td>
                            <td style="text-align: right" ></td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td colspan="8" style="text-align: right">
                                <strong>Valor AF (%) R$ </strong>
                            </td>
                            <td style="text-align: right" ></td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td colspan="8" style="text-align: right"><strong>Valor Total R$</strong> </td>
                            <td style="text-align: right" ></td>
                        </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection
