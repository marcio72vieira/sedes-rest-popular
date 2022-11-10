
<div class="table table-sm table-bordered  table-hover">
    <div  class="bg-gray-100">
        <div>
            <div colspan="4">Região: <span class="regiao"></span> - Município: <span class="municipio"></span></div>
            <div colspan="4">{{ $records[0]->identificacao }}</div>
            <div colspan="4" style="text-align: right"><a class="btn btn-primary btn-danger btn-sm" href="{{ route('admin.registroconsultacompra.comprasmes.relpdfcomprasmes', [$records[0]->restaurante_id, $mes_id, $ano_id]) }}" role="button" target="_blank"><i class="far fa-file-pdf"  style="font-size: 15px;"></i> pdf</a></div>
        </div>
        <div>
            <div colspan="4">Nudivicionista Empresa: <span class="nudivicionistaempresa"></span></div>
            <div colspan="4">De:<span class="datainicial"></span>  a <span class="datafinal"></span>  </div>
            <div colspan="4"></div>
        </div>
        <div>
            <div colspan="4">Nudivicionista SEDES: <span class="nudivicionistasedes"></span></div>
            <div colspan="4"></div>
            <div colspan="4"></div>
        </div>
        <div>
            <div scope="col" style="width: 40px; text-align: center">Id</div>
            <div scope="col" style="width: 100px; text-align: center">semana</div>
            <div scope="col" style="width: 200px; text-align: center">Produto</div>
            <div scope="col" style="text-align: center">Detalhe</div>
            <div scope="col" style="width: 40px; text-align: center">AF</div>
            <div scope="col" style="width: 100px; text-align: center">Quant.</div>
            <div scope="col" style="width: 100px; text-align: center">Unidade</div>
            <div scope="col" style="width: 120px; text-align: center">Preço</div>
            <div scope="col" style="width: 120px; text-align: center">Total</div>
        </div>
    </div>
    <div>
            
                <div>
                    <div scope="row"></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div style="text-align: center"></div>
                    <div style="text-align: right"></div>
                    <div style="text-align: center"></div>
                    <div style="text-align: right"></div>
                    <div style="text-align: right"></div>
                </div>
            

            
            
                <div><div colspan="9"><strong>COMPRAS AF</strong></div></div>
                
                    <div>
                        <div scope="row"></div>
                        <div></div>
                        <div></div>
                        <div></div>
                        <div style="text-align: center"></div>
                        <div style="text-align: right"></div>
                        <div style="text-align: center"></div>
                        <div style="text-align: right"></div>
                        <div style="text-align: right"></div>
                    </div>
                
            
            <div class="bg-gray-100">
                <div colspan="8" style="text-align: right"><strong>Valor R$</strong> </div>
                <div style="text-align: right" > </div>
            </div>
            <div class="bg-gray-100">
                <div colspan="8" style="text-align: right">
                    <strong>Valor AF (%) R$ </strong>
                </div>
                <div style="text-align: right" ></div>
            </div>
            <div class="bg-gray-100">
                <div colspan="8" style="text-align: right"><strong>Valor Total R$</strong> </div>
                <div style="text-align: right" ></div>
            </div>
    </div>
</div>