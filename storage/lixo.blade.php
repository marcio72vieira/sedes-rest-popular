Todas as entidades (tabelas) contidas no painel de visualização rápida, são entidades com número de registro limitado, não se justificando a necessidade da criação de um filtro para fazer uma pesquisa mais elaborada. Como o proórpio nome diz, o painel se chama visualização rápida, como propósito do usuário administrador obter uma informação o mais rápido possível. As informações fornecidas por qualquer registro selecionado, traz informações corriqueiras, sem a necessidade de um aprofundamento. Isso poupa o usuário administrador de de ter que entrar em um módulo específico para obter uma informação sem grandes relevânica.


Obs: Quando um usuário de um restaurante tenta "burlar" a segurança do sistema digitando diretamente na URL:
admin/restaurante/4/compra e seus derivados (.../compra/create, .../compra/update, .../compra/delete, .../compra/etc...)  para acessar o restaurante de terceiro, ou seja, que não seja a suapropriedade, o mesmo consegue inserir dados na compra, mas o mesmo não irá vê a compra
feita de maneira irregular em seu index, visto que este registro será gravado como se fosse o proprietario do restaurante invadido que tivesse inputado a compra, sendo assim, o mesmo não poderá desta forma anexar, visualizar, alterar ou deletar a compra realizada de forma irregular, pois sendo esta vincuada ao restaurante invadido, só o proprietário do restaurante invadido poderá operar em cima desta compra. Mas como sabemos isso é um error. O mesmo acontece se o usuário invasor tentar acessar os comprovantes de um outro restaurante que não seja
o seu. como prova o a URI anexada abaixo.





mariajoaquina@email.com -  	1 - Liberdade
joaquimjose@email.com -  	2 - Coroadinho
kleber@email.com - 		4 - São José de Ribamar





admin/restaurante/4/compra/create

admin/compra/93/comprovante

admin/restaurante/4/compra/93

admin/restaurante/4/compra/93/edit	Um usuário consegue alterar os dados de uma compra mesmo que esta não tenha sido realizada
					por ele, alterando apenas o número da conta desejada, podendo esta ser de outro restaurante.



admin/restaurante/4/compra/93/pdf/relpdfcompra


Passos para Corrigir
1 - Estando no index (visualizando a lista de compras do Restaurante 1 - Liberdade), clicando em uma compra específica (por exemplo: compra 94) para Visualizar ou Editar, dentro desta
	view cuja URL é: http://127.0.0.1:8000/admin/restaurante/1/compra/94/edit modificando o parâmetro 94 para 93, eu consigo acessar esses dados para modificação, mesmo sendo esta
	compra pertencente a outro restaurnante. Terminando a edição (com alteração dos dados propriamente dito) e sanlvando o registro, este irá pertencer agora ao Restaurante
	1 - Liberdade e sumindo do restaurante de 4 - São José de Ribamar.

	Tabela Compra
	Antes do Edit
	Compra	Restaurante
	94	1 - Liberdade
	93	4 - São Jose de Ribamar


	Tabela BigTable
	Antes do Edit
	id	Compra	Restaurante	Bairro		Nome User	ID User

	146	94	1-liberdade	Liberdade	Maria Joaquina	2
	145	93	4-sao jose	Maruinho	Kleber Barbosa	4
	144	93	4-são jose	Maruinho	Kleber Barbosa	4




2 - Digitando: http://127.0.0.1:8000/admin/restaurante/14compra (ou seja uma rota que não existe) na url do nutricionista o mesmo é redirecionado para página de exceção: 403 - Ação não autorizada

3 - Alterando a URL http://127.0.0.1:8000/admin/restaurante/1/compra/94/edit (que e um restaurante a Liberdade com  uma compra da liberdade) para http://127.0.0.1:8000/admin/restaurante/4/compra/94/edit (Um restaurante de São JOse de Ribamar com uma compra da lIBERDADE) o mesmo permanece inalterado, ou seja, o usuário é redirecionado para a URL
Original: http://127.0.0.1:8000/admin/restaurante/1/compra/94/edit


4 - Alterando o mês na URL http://127.0.0.1:8000/admin/registroconsultacompra/comprasemanalmensalrestaurante?restaurante_id=1&semana=&mes_id=6&ano_id=2023 para ... &mes_id=15&ano_id=2023 ou seja, para um mês que não exista (de 1 a 12)  a aplicação é quebrada TRATAR O MÊS DIGITADO NA URL CASO O USUÁRIO FAÇA ISSO. para usuário nutricionista

5 - Alterando a semana na URL http://127.0.0.1:8000/admin/registroconsultacompra/comprasemanalmensalrestaurante?restaurante_id=1&semana=1&mes_id=6&ano_id=2023 para ...&semana=10&mes_id=6&ano_id=2023 ou seja para uma semana inexistente (de 1 a 5) a aplicação pe quebrada TRATAR A SEMANA DIGITADO NA URL CASO O USUÁRIO FAÇA ISSO. para usuário nutricionista


SELECT
            regional_id,
            regional_nome,

            IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
            IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf,

            IF(MONTH(data_ini) = 02 AND af = "nao", SUM(precototal), 0.00) AS fevnormal,
            IF(MONTH(data_ini) = 02 AND af = "sim", SUM(precototal), 0.00) AS fevaf,

            IF(MONTH(data_ini) = 03 AND af = "nao", SUM(precototal), 0.00) AS marnormal,
            IF(MONTH(data_ini) = 03 AND af = "sim", SUM(precototal), 0.00) AS maraf,

            IF(MONTH(data_ini) = 04 AND af = "nao", SUM(precototal), 0.00) AS abrnormal,
            IF(MONTH(data_ini) = 04 AND af = "sim", SUM(precototal), 0.00) AS abraf,

            IF(MONTH(data_ini) = 05 AND af = "nao", SUM(precototal), 0.00) AS mainormal,
            IF(MONTH(data_ini) = 05 AND af = "sim", SUM(precototal), 0.00) AS maiaf,

            IF(MONTH(data_ini) = 06 AND af = "nao", SUM(precototal), 0.00) AS junnormal,
            IF(MONTH(data_ini) = 06 AND af = "sim", SUM(precototal), 0.00) AS junaf,

            IF(MONTH(data_ini) = 07 AND af = "nao", SUM(precototal), 0.00) AS julnormal,
            IF(MONTH(data_ini) = 07 AND af = "sim", SUM(precototal), 0.00) AS julaf,

            IF(MONTH(data_ini) = 08 AND af = "nao", SUM(precototal), 0.00) AS agsnormal,
            IF(MONTH(data_ini) = 08 AND af = "sim", SUM(precototal), 0.00) AS agsaf,

            IF(MONTH(data_ini) = 09 AND af = "nao", SUM(precototal), 0.00) AS setnormal,
            IF(MONTH(data_ini) = 09 AND af = "sim", SUM(precototal), 0.00) AS setaf,

            IF(MONTH(data_ini) = 10 AND af = "nao", SUM(precototal), 0.00) AS outnormal,
            IF(MONTH(data_ini) = 10 AND af = "sim", SUM(precototal), 0.00) AS outaf,

            IF(MONTH(data_ini) = 11 AND af = "nao", SUM(precototal), 0.00) AS novnormal,
            IF(MONTH(data_ini) = 11 AND af = "sim", SUM(precototal), 0.00) AS novaf,

            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS deznormal,
            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS dezaf

        FROM `bigtable_data`
        WHERE YEAR(data_ini) = 2023
        GROUP BY regional_id, MONTH(data_ini)
        ORDER BY regional_nome;



SELECT
        MONTH(data_ini),
        regional_id,
        regional_nome,
        IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
        IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf,

        IF(MONTH(data_ini) = 02 AND af = "nao", SUM(precototal), 0.00) AS fevnormal,
        IF(MONTH(data_ini) = 02 AND af = "sim", SUM(precototal), 0.00) AS fevaf,

        IF(MONTH(data_ini) = 03 AND af = "nao", SUM(precototal), 0.00) AS marnormal,
        IF(MONTH(data_ini) = 03 AND af = "sim", SUM(precototal), 0.00) AS maraf,

        IF(MONTH(data_ini) = 04 AND af = "nao", SUM(precototal), 0.00) AS abrnormal,
        IF(MONTH(data_ini) = 04 AND af = "sim", SUM(precototal), 0.00) AS abraf,

        IF(MONTH(data_ini) = 05 AND af = "nao", SUM(precototal), 0.00) AS mainormal,
        IF(MONTH(data_ini) = 05 AND af = "sim", SUM(precototal), 0.00) AS maiaf,

        IF(MONTH(data_ini) = 06 AND af = "nao", SUM(precototal), 0.00) AS junnormal,
        IF(MONTH(data_ini) = 06 AND af = "sim", SUM(precototal), 0.00) AS junaf,

        IF(MONTH(data_ini) = 07 AND af = "nao", SUM(precototal), 0.00) AS julnormal,
        IF(MONTH(data_ini) = 07 AND af = "sim", SUM(precototal), 0.00) AS julaf,

        IF(MONTH(data_ini) = 08 AND af = "nao", SUM(precototal), 0.00) AS agsnormal,
        IF(MONTH(data_ini) = 08 AND af = "sim", SUM(precototal), 0.00) AS agsaf,

        IF(MONTH(data_ini) = 09 AND af = "nao", SUM(precototal), 0.00) AS setnormal,
        IF(MONTH(data_ini) = 09 AND af = "sim", SUM(precototal), 0.00) AS setaf,

        IF(MONTH(data_ini) = 10 AND af = "nao", SUM(precototal), 0.00) AS outnormal,
        IF(MONTH(data_ini) = 10 AND af = "sim", SUM(precototal), 0.00) AS outaf,

        IF(MONTH(data_ini) = 11 AND af = "nao", SUM(precototal), 0.00) AS novnormal,
        IF(MONTH(data_ini) = 11 AND af = "sim", SUM(precototal), 0.00) AS novaf,

        IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS deznormal,
        IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS dezaf

    FROM `bigtable_data`
    WHERE YEAR(data_ini) = 2023
    GROUP BY regional_id, MONTH(data_ini)
    ORDER BY regional_nome;


    $regionais = DB::table('bigtable_data')
        ->selectRaw('
            data_ini,
            regional_id AS id,
            regional_nome AS regional,

            IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
            IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf,

            IF(MONTH(data_ini) = 02 AND af = "nao", SUM(precototal), 0.00) AS fevnormal,
            IF(MONTH(data_ini) = 02 AND af = "sim", SUM(precototal), 0.00) AS fevaf,

            IF(MONTH(data_ini) = 03 AND af = "nao", SUM(precototal), 0.00) AS marnormal,
            IF(MONTH(data_ini) = 03 AND af = "sim", SUM(precototal), 0.00) AS maraf,

            IF(MONTH(data_ini) = 04 AND af = "nao", SUM(precototal), 0.00) AS abrnormal,
            IF(MONTH(data_ini) = 04 AND af = "sim", SUM(precototal), 0.00) AS abraf,

            IF(MONTH(data_ini) = 05 AND af = "nao", SUM(precototal), 0.00) AS mainormal,
            IF(MONTH(data_ini) = 05 AND af = "sim", SUM(precototal), 0.00) AS maiaf,

            IF(MONTH(data_ini) = 06 AND af = "nao", SUM(precototal), 0.00) AS junnormal,
            IF(MONTH(data_ini) = 06 AND af = "sim", SUM(precototal), 0.00) AS junaf,

            IF(MONTH(data_ini) = 07 AND af = "nao", SUM(precototal), 0.00) AS julnormal,
            IF(MONTH(data_ini) = 07 AND af = "sim", SUM(precototal), 0.00) AS julaf,

            IF(MONTH(data_ini) = 08 AND af = "nao", SUM(precototal), 0.00) AS agsnormal,
            IF(MONTH(data_ini) = 08 AND af = "sim", SUM(precototal), 0.00) AS agsaf,

            IF(MONTH(data_ini) = 09 AND af = "nao", SUM(precototal), 0.00) AS setnormal,
            IF(MONTH(data_ini) = 09 AND af = "sim", SUM(precototal), 0.00) AS setaf,

            IF(MONTH(data_ini) = 10 AND af = "nao", SUM(precototal), 0.00) AS outnormal,
            IF(MONTH(data_ini) = 10 AND af = "sim", SUM(precototal), 0.00) AS outaf,

            IF(MONTH(data_ini) = 11 AND af = "nao", SUM(precototal), 0.00) AS novnormal,
            IF(MONTH(data_ini) = 11 AND af = "sim", SUM(precototal), 0.00) AS novaf,

            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS deznormal,
            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS dezaf
        ')
        ->whereRaw('YEAR(data_ini) =  2023')
        ->groupBy('regional_id')
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();

// QUERYS COMPATÍVEIS
// Essa query em Mysql Puro
SELECT
        MONTH(data_ini),
        regional_id,
        regional_nome,
        IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
        IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf,

        IF(MONTH(data_ini) = 02 AND af = "nao", SUM(precototal), 0.00) AS fevnormal,
        IF(MONTH(data_ini) = 02 AND af = "sim", SUM(precototal), 0.00) AS fevaf,

        IF(MONTH(data_ini) = 03 AND af = "nao", SUM(precototal), 0.00) AS marnormal,
        IF(MONTH(data_ini) = 03 AND af = "sim", SUM(precototal), 0.00) AS maraf,

        IF(MONTH(data_ini) = 04 AND af = "nao", SUM(precototal), 0.00) AS abrnormal,
        IF(MONTH(data_ini) = 04 AND af = "sim", SUM(precototal), 0.00) AS abraf,

        IF(MONTH(data_ini) = 05 AND af = "nao", SUM(precototal), 0.00) AS mainormal,
        IF(MONTH(data_ini) = 05 AND af = "sim", SUM(precototal), 0.00) AS maiaf,

        IF(MONTH(data_ini) = 06 AND af = "nao", SUM(precototal), 0.00) AS junnormal,
        IF(MONTH(data_ini) = 06 AND af = "sim", SUM(precototal), 0.00) AS junaf,

        IF(MONTH(data_ini) = 07 AND af = "nao", SUM(precototal), 0.00) AS julnormal,
        IF(MONTH(data_ini) = 07 AND af = "sim", SUM(precototal), 0.00) AS julaf,

        IF(MONTH(data_ini) = 08 AND af = "nao", SUM(precototal), 0.00) AS agsnormal,
        IF(MONTH(data_ini) = 08 AND af = "sim", SUM(precototal), 0.00) AS agsaf,

        IF(MONTH(data_ini) = 09 AND af = "nao", SUM(precototal), 0.00) AS setnormal,
        IF(MONTH(data_ini) = 09 AND af = "sim", SUM(precototal), 0.00) AS setaf,

        IF(MONTH(data_ini) = 10 AND af = "nao", SUM(precototal), 0.00) AS outnormal,
        IF(MONTH(data_ini) = 10 AND af = "sim", SUM(precototal), 0.00) AS outaf,

        IF(MONTH(data_ini) = 11 AND af = "nao", SUM(precototal), 0.00) AS novnormal,
        IF(MONTH(data_ini) = 11 AND af = "sim", SUM(precototal), 0.00) AS novaf,

        IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS deznormal,
        IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS dezaf

    FROM `bigtable_data`
    WHERE YEAR(data_ini) = 2023
    GROUP BY regional_id, MONTH(data_ini)
    ORDER BY regional_nome

    // É compatível com essa QueryBuilder

    $regionais = DB::table('bigtable_data')
    ->selectRaw('
        MONTH(data_ini),
        regional_id AS id,
        regional_nome AS regional,

        IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
        IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf,

        IF(MONTH(data_ini) = 02 AND af = "nao", SUM(precototal), 0.00) AS fevnormal,
        IF(MONTH(data_ini) = 02 AND af = "sim", SUM(precototal), 0.00) AS fevaf,

        IF(MONTH(data_ini) = 03 AND af = "nao", SUM(precototal), 0.00) AS marnormal,
        IF(MONTH(data_ini) = 03 AND af = "sim", SUM(precototal), 0.00) AS maraf,

        IF(MONTH(data_ini) = 04 AND af = "nao", SUM(precototal), 0.00) AS abrnormal,
        IF(MONTH(data_ini) = 04 AND af = "sim", SUM(precototal), 0.00) AS abraf,

        IF(MONTH(data_ini) = 05 AND af = "nao", SUM(precototal), 0.00) AS mainormal,
        IF(MONTH(data_ini) = 05 AND af = "sim", SUM(precototal), 0.00) AS maiaf,

        IF(MONTH(data_ini) = 06 AND af = "nao", SUM(precototal), 0.00) AS junnormal,
        IF(MONTH(data_ini) = 06 AND af = "sim", SUM(precototal), 0.00) AS junaf,

        IF(MONTH(data_ini) = 07 AND af = "nao", SUM(precototal), 0.00) AS julnormal,
        IF(MONTH(data_ini) = 07 AND af = "sim", SUM(precototal), 0.00) AS julaf,

        IF(MONTH(data_ini) = 08 AND af = "nao", SUM(precototal), 0.00) AS agsnormal,
        IF(MONTH(data_ini) = 08 AND af = "sim", SUM(precototal), 0.00) AS agsaf,

        IF(MONTH(data_ini) = 09 AND af = "nao", SUM(precototal), 0.00) AS setnormal,
        IF(MONTH(data_ini) = 09 AND af = "sim", SUM(precototal), 0.00) AS setaf,

        IF(MONTH(data_ini) = 10 AND af = "nao", SUM(precototal), 0.00) AS outnormal,
        IF(MONTH(data_ini) = 10 AND af = "sim", SUM(precototal), 0.00) AS outaf,

        IF(MONTH(data_ini) = 11 AND af = "nao", SUM(precototal), 0.00) AS novnormal,
        IF(MONTH(data_ini) = 11 AND af = "sim", SUM(precototal), 0.00) AS novaf,

        IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS deznormal,
        IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS dezaf
    ')
    ->whereRaw('YEAR(data_ini) =  2023')
    ->groupBy('regional_id', 'MONTH(data_ini)')
    ->orderBy($columnName,$columnSortOrder)
    ->skip($start)
    ->take($rowperpage)
    ->get();

*************************************
  REQUISIÇÃO AJAX ORIGINAL COMPLETA
*************************************
public function ajaxgetRegionaisComprasMensais(Request $request){

    //$grupoRecebido = $request->grupoEnviado;
    //echo $request->grupoEnviado;
    //return response()->json($$request->grupoEnviado);
    //$compraspormes =  Monitor::comprasporgrupo();

    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value

    //$totalRecords = Regional::select('count(*) as allcount')->count();
    //$totalRecords = DB::table("bigtable_data")->select(DB::RAW('COUNT(DISTINCT(bigtable_data.regional_id)) as allcount'))->count();
    $totalRecords = DB::table("bigtable_data")->select('regional_id')->distinct('regional_id')->count();

    $totalRecordswithFilter = DB::table("bigtable_data")
        ->select(DB::RAW('regional_id AS id, regional_nome AS regional'))
        ->distinct('regional_id')
        ->where('regional_nome', 'like', '%' .$searchValue . '%')
        ->count();

    $regionais = DB::table('bigtable_data')
    ->selectRaw('
        MONTH(data_ini),
        regional_id AS id,
        regional_nome AS regional,

        IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
        IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf,

        IF(MONTH(data_ini) = 02 AND af = "nao", SUM(precototal), 0.00) AS fevnormal,
        IF(MONTH(data_ini) = 02 AND af = "sim", SUM(precototal), 0.00) AS fevaf,

        IF(MONTH(data_ini) = 03 AND af = "nao", SUM(precototal), 0.00) AS marnormal,
        IF(MONTH(data_ini) = 03 AND af = "sim", SUM(precototal), 0.00) AS maraf,

        IF(MONTH(data_ini) = 04 AND af = "nao", SUM(precototal), 0.00) AS abrnormal,
        IF(MONTH(data_ini) = 04 AND af = "sim", SUM(precototal), 0.00) AS abraf,

        IF(MONTH(data_ini) = 05 AND af = "nao", SUM(precototal), 0.00) AS mainormal,
        IF(MONTH(data_ini) = 05 AND af = "sim", SUM(precototal), 0.00) AS maiaf,

        IF(MONTH(data_ini) = 06 AND af = "nao", SUM(precototal), 0.00) AS junnormal,
        IF(MONTH(data_ini) = 06 AND af = "sim", SUM(precototal), 0.00) AS junaf,

        IF(MONTH(data_ini) = 07 AND af = "nao", SUM(precototal), 0.00) AS julnormal,
        IF(MONTH(data_ini) = 07 AND af = "sim", SUM(precototal), 0.00) AS julaf,

        IF(MONTH(data_ini) = 08 AND af = "nao", SUM(precototal), 0.00) AS agsnormal,
        IF(MONTH(data_ini) = 08 AND af = "sim", SUM(precototal), 0.00) AS agsaf,

        IF(MONTH(data_ini) = 09 AND af = "nao", SUM(precototal), 0.00) AS setnormal,
        IF(MONTH(data_ini) = 09 AND af = "sim", SUM(precototal), 0.00) AS setaf,

        IF(MONTH(data_ini) = 10 AND af = "nao", SUM(precototal), 0.00) AS outnormal,
        IF(MONTH(data_ini) = 10 AND af = "sim", SUM(precototal), 0.00) AS outaf,

        IF(MONTH(data_ini) = 11 AND af = "nao", SUM(precototal), 0.00) AS novnormal,
        IF(MONTH(data_ini) = 11 AND af = "sim", SUM(precototal), 0.00) AS novaf,

        IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS deznormal,
        IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS dezaf
    ')
    ->whereRaw('YEAR(data_ini) =  2023')
    ->groupBy('regional_id', 'MONTH(data_ini)')
    ->orderBy($columnName,$columnSortOrder)
    ->skip($start)
    ->take($rowperpage)
    ->get();


    /*
    SELECT
        regional_id,
        regional_nome,
        IF(MONTH(data_ini) = 01, SUM(IF(af = "sim", precototal, 0)), NULL) AS janaf,
        IF(MONTH(data_ini) = 01, SUM(IF(af = "nao", precototal, 0)), NULL) AS jannorm
    FROM `bigtable_data`
    WHERE YEAR(data_ini) = 2023
    GROUP BY regional_id, MONTH(data_ini);

    SELECT
        regional_id,
        regional_nome,
        IF(MONTH(data_ini) = 01, SUM(IF(af = "sim", precototal, 0)), NULL) AS janaf,
        IF(MONTH(data_ini) = 01, SUM(IF(af = "nao", precototal, 0)), NULL) AS jannormal,
        IF(MONTH(data_ini) = 02, SUM(IF(af = "sim", precototal, 0)), NULL) AS fevaf,
        IF(MONTH(data_ini) = 02, SUM(IF(af = "nao", precototal, 0)), NULL) AS fevnormal,
        IF(MONTH(data_ini) = 03, SUM(IF(af = "sim", precototal, 0)), NULL) AS maraf,
        IF(MONTH(data_ini) = 03, SUM(IF(af = "nao", precototal, 0)), NULL) AS marnormal
    FROM `bigtable_data`
    WHERE YEAR(data_ini) = 2023
    GROUP BY regional_id;
    */

    /*
    $regionais = DB::table('bigtable_data')
            ->selectRaw('data_ini, regional_id AS id, regional_nome AS regional,

                IF(MONTH(data_ini) = 01, SUM(IF(af = "nao", precototal, 0)) AS jannormal), NULL),
                IF(MONTH(data_ini) = 01, SUM(IF(af = "sim", precototal, 0)) AS janaf), NULL),

                IF(MONTH(data_ini) = 02, SUM(IF(af = "sim", precototal, 0)) AS fevaf), NULL),
                IF(MONTH(data_ini) = 02, SUM(IF(af = "nao", precototal, 0)) AS fevnormal), NULL),

                IF(MONTH(data_ini) = 03, SUM(IF(af = "sim", precototal, 0)) AS maraf), NULL),
                IF(MONTH(data_ini) = 03, SUM(IF(af = "nao", precototal, 0)) AS marnormal), NULL),

                IF(MONTH(data_ini) = 04, SUM(IF(af = "sim", precototal, 0)) AS abraf), NULL),
                IF(MONTH(data_ini) = 04, SUM(IF(af = "nao", precototal, 0)) AS abrnormal), NULL),

                IF(MONTH(data_ini) = 05, SUM(IF(af = "sim", precototal, 0)) AS maiaf), NULL),
                IF(MONTH(data_ini) = 05, SUM(IF(af = "nao", precototal, 0)) AS mainormal), NULL),

                IF(MONTH(data_ini) = 06, SUM(IF(af = "sim", precototal, 0)) AS junaf), NULL),
                IF(MONTH(data_ini) = 06, SUM(IF(af = "nao", precototal, 0)) AS junnormal), NULL),

                IF(MONTH(data_ini) = 07, SUM(IF(af = "sim", precototal, 0)) AS julaf), NULL),
                IF(MONTH(data_ini) = 07, SUM(IF(af = "nao", precototal, 0)) AS julnormal), NULL),

                IF(MONTH(data_ini) = 08, SUM(IF(af = "sim", precototal, 0)) AS agsaf), NULL),
                IF(MONTH(data_ini) = 08, SUM(IF(af = "nao", precototal, 0)) AS agsnormal), NULL),

                IF(MONTH(data_ini) = 09, SUM(IF(af = "sim", precototal, 0)) AS setaf), NULL),
                IF(MONTH(data_ini) = 09, SUM(IF(af = "nao", precototal, 0)) AS setnormal), NULL),

                IF(MONTH(data_ini) = 10, SUM(IF(af = "sim", precototal, 0)) AS outaf), NULL),
                IF(MONTH(data_ini) = 10, SUM(IF(af = "nao", precototal, 0)) AS outnormal), NULL),

                IF(MONTH(data_ini) = 11, SUM(IF(af = "sim", precototal, 0)) AS novaf), NULL),
                IF(MONTH(data_ini) = 11, SUM(IF(af = "sim", precototal, 0)) AS novnormal), NULL),

                IF(MONTH(data_ini) = 12, SUM(IF(af = "sim", precototal, 0)) AS dezaf), NULL),
                IF(MONTH(data_ini) = 12, SUM(IF(af = "nao", precototal, 0)) AS deznormal), NULL),

                WHERE YEAR(data_ini) = 2023')
            ->groupBy('regional_id')
            ->orderBy($columnName,$columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();
    */

    /*
    $regionais = DB::table("bigtable_data")
        ->select(DB::raw("SELECT data_ini, regional_id AS id, regional_nome AS regional,
            IF(MONTH(data_ini) = 01, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 01, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 02, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 02, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 03, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 03, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 04, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 04, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 05, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 05, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 06, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 06, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 07, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 07, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 08, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 08, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 09, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 09, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 10, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 10, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 11, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 11, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL),
            IF(MONTH(data_ini) = 12, SUM(IF(af = 'sim', precototal, 0)) AS janaf ), NULL),
            IF(MONTH(data_ini) = 12, SUM(IF(af = 'nao', precototal, 0)) AS jannormal ), NULL)
            GROUP BY regional_id
            WHERE YEAR(data_ini) = 2023"))
            ->orderBy($columnName,$columnSortOrder)
            ->skip($start)
            ->take($rowperpage)
            ->get();
    */


    /*
        QUERY ORIGINAL CORRETA
        $regionais = DB::table("bigtable_data")
        ->select(DB::RAW('regional_id AS id, regional_nome AS regional'))
        ->groupBy('regional_id')
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();
    */

    $data_arr = array();

    foreach($regionais as $regional){
        $id = $regional->id;
        $regional =  $regional->regional;

        // Testar se o valor vier null, atribuir 0.0, do tipo: $jannormal = $registro->jannormal != NULL ? $registro->janmnoram ; 0.00;
        $jannormal = 0.00;
        $janaf = 0.00;
        $fevnormal = 0.00;
        $fevaf = 0.00;
        $marnormal = 0.00;
        $maraf = 0.00;
        $abrnormal = 0.00;
        $abraf = 0.00;
        $mainormal = 0.00;
        $maiaf = 0.00;
        $junnormal = 0.00;
        $junaf = 0.00;
        $julnormal = 0.00;
        $julaf = 0.00;
        $agsnormal = 0.00;
        $agsaf = 0.00;
        $setnormal = 0.00;
        $setaf = 0.00;
        $outnormal = 0.00;
        $outaf = 0.00;
        $novnormal = 0.00;
        $novaf = 0.00;
        $deznormal = 0.00;
        $dezaf = 0.00;
        $totalnormal = 0.00;
        $totalaf = 0.00;
        $percentagemnormal = 0.00;
        $percentagemaf = 0.00;


        $data_arr[] = array(
            "id"                => $id,
            "regional"          => $regional,
            "jannormal"         => $jannormal,
            "janaf"             => $janaf,
            "fevnormal"         => $fevnormal,
            "fevaf"             => $fevaf,
            "marnormal"         => $marnormal,
            "maraf"             => $maraf,
            "abrnormal"         => $abrnormal,
            "abraf"             => $abraf,
            "mainormal"         => $mainormal,
            "maiaf"             => $maiaf,
            "junnormal"         => $junnormal,
            "junaf"             => $junaf,
            "julnormal"         => $julnormal,
            "julaf"             => $julaf,
            "agsnormal"         => $agsnormal,
            "agsaf"             => $agsaf,
            "setnormal"         => $setnormal,
            "setaf"             => $setaf,
            "outnormal"         => $outnormal,
            "outaf"             => $outaf,
            "novnormal"         => $novnormal,
            "novaf"             => $novaf,
            "deznormal"         => $deznormal,
            "dezaf"             => $dezaf,
            "totalnormal"       => $totalnormal,
            "totalaf"           => $totalaf,
            "percentagemnormal" => $percentagemnormal,
            "percentagemaf"     => $percentagemaf,
        );
    }

    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
}


**********
SUBQUERIES
**********
01--------
SELECT
	regional_id,
    regional_nome
FROM
	(
        SELECT
        	regional_id, regional_nome,
        	IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
        	IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf
        FROM
        	bigtable_data
        WHERE
        	YEAR(data_ini) = 2023
    ) AS valoresmeses

02----------
SELECT
	regional_id,
    regional_nome,
    IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
    IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf
FROM
	(
        SELECT
        	data_ini,
        	af,
        	precototal,
        	regional_id, regional_nome,
        	IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
        	IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf
        FROM
        	bigtable_data
        WHERE
        	YEAR(data_ini) = 2023
    ) AS valoresmeses

03------------
SELECT
	regional_id,
    regional_nome,
    jannormal, janaf, fevnormal, fevaf, marnormal, maraf, abrnormal, abrnormal, mainormal, maiaf, junnormal, junaf
    julnormal, julaf, agsnormal, agsaf, setnormal, setaf, outnormal, outaf, novnormal, novaf, deznormal, dezaf
FROM
	(
        SELECT
        	data_ini,
        	af,
        	precototal,
        	regional_id, regional_nome,
        	IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
        	IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf,

        	IF(MONTH(data_ini) = 02 AND af = "nao", SUM(precototal), 0.00) AS fevnormal,
        	IF(MONTH(data_ini) = 02 AND af = "sim", SUM(precototal), 0.00) AS fevaf,

            IF(MONTH(data_ini) = 03 AND af = "nao", SUM(precototal), 0.00) AS marnormal,
            IF(MONTH(data_ini) = 03 AND af = "sim", SUM(precototal), 0.00) AS maraf,

            IF(MONTH(data_ini) = 04 AND af = "nao", SUM(precototal), 0.00) AS abrnormal,
            IF(MONTH(data_ini) = 04 AND af = "sim", SUM(precototal), 0.00) AS abraf,

            IF(MONTH(data_ini) = 05 AND af = "nao", SUM(precototal), 0.00) AS mainormal,
            IF(MONTH(data_ini) = 05 AND af = "sim", SUM(precototal), 0.00) AS maiaf,

            IF(MONTH(data_ini) = 06 AND af = "nao", SUM(precototal), 0.00) AS junnormal,
            IF(MONTH(data_ini) = 06 AND af = "sim", SUM(precototal), 0.00) AS junaf,

            IF(MONTH(data_ini) = 07 AND af = "nao", SUM(precototal), 0.00) AS julnormal,
            IF(MONTH(data_ini) = 07 AND af = "sim", SUM(precototal), 0.00) AS julaf,

            IF(MONTH(data_ini) = 08 AND af = "nao", SUM(precototal), 0.00) AS agsnormal,
            IF(MONTH(data_ini) = 08 AND af = "sim", SUM(precototal), 0.00) AS agsaf,

            IF(MONTH(data_ini) = 09 AND af = "nao", SUM(precototal), 0.00) AS setnormal,
            IF(MONTH(data_ini) = 09 AND af = "sim", SUM(precototal), 0.00) AS setaf,

            IF(MONTH(data_ini) = 10 AND af = "nao", SUM(precototal), 0.00) AS outnormal,
            IF(MONTH(data_ini) = 10 AND af = "sim", SUM(precototal), 0.00) AS outaf,

            IF(MONTH(data_ini) = 11 AND af = "nao", SUM(precototal), 0.00) AS novnormal,
            IF(MONTH(data_ini) = 11 AND af = "sim", SUM(precototal), 0.00) AS novaf,

            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS deznormal,
            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS dezaf

        FROM
        	bigtable_data
        WHERE
        	YEAR(data_ini) = 2023
    ) AS valoresmeses
WHERE YEAR(data_ini) = 2023
GROUP BY regional_id

4 ------ PERFEITA
SELECT
	regional_id,
    regional_nome,
    jannormal, janaf, fevnormal, fevaf, marnormal, maraf, abrnormal, abrnormal, mainormal, maiaf, junnormal, junaf
    julnormal, julaf, agsnormal, agsaf, setnormal, setaf, outnormal, outaf, novnormal, novaf, deznormal, dezaf
FROM
	(
        SELECT
        	data_ini,
        	af,
        	precototal,
        	regional_id, regional_nome,
        	IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
        	IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf,

        	IF(MONTH(data_ini) = 02 AND af = "nao", SUM(precototal), 0.00) AS fevnormal,
        	IF(MONTH(data_ini) = 02 AND af = "sim", SUM(precototal), 0.00) AS fevaf,

            IF(MONTH(data_ini) = 03 AND af = "nao", SUM(precototal), 0.00) AS marnormal,
            IF(MONTH(data_ini) = 03 AND af = "sim", SUM(precototal), 0.00) AS maraf,

            IF(MONTH(data_ini) = 04 AND af = "nao", SUM(precototal), 0.00) AS abrnormal,
            IF(MONTH(data_ini) = 04 AND af = "sim", SUM(precototal), 0.00) AS abraf,

            IF(MONTH(data_ini) = 05 AND af = "nao", SUM(precototal), 0.00) AS mainormal,
            IF(MONTH(data_ini) = 05 AND af = "sim", SUM(precototal), 0.00) AS maiaf,

            IF(MONTH(data_ini) = 06 AND af = "nao", SUM(precototal), 0.00) AS junnormal,
            IF(MONTH(data_ini) = 06 AND af = "sim", SUM(precototal), 0.00) AS junaf,

            IF(MONTH(data_ini) = 07 AND af = "nao", SUM(precototal), 0.00) AS julnormal,
            IF(MONTH(data_ini) = 07 AND af = "sim", SUM(precototal), 0.00) AS julaf,

            IF(MONTH(data_ini) = 08 AND af = "nao", SUM(precototal), 0.00) AS agsnormal,
            IF(MONTH(data_ini) = 08 AND af = "sim", SUM(precototal), 0.00) AS agsaf,

            IF(MONTH(data_ini) = 09 AND af = "nao", SUM(precototal), 0.00) AS setnormal,
            IF(MONTH(data_ini) = 09 AND af = "sim", SUM(precototal), 0.00) AS setaf,

            IF(MONTH(data_ini) = 10 AND af = "nao", SUM(precototal), 0.00) AS outnormal,
            IF(MONTH(data_ini) = 10 AND af = "sim", SUM(precototal), 0.00) AS outaf,

            IF(MONTH(data_ini) = 11 AND af = "nao", SUM(precototal), 0.00) AS novnormal,
            IF(MONTH(data_ini) = 11 AND af = "sim", SUM(precototal), 0.00) AS novaf,

            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS deznormal,
            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS dezaf

        FROM
        	bigtable_data
        WHERE
        	YEAR(data_ini) = 2023
        GROUP BY regional_id, MONTH(data_ini)
        ORDER BY regional_nome
    ) AS valoresmeses
WHERE YEAR(data_ini) = 2023
GROUP BY regional_id


5 ------ PÓS PERFEITA
SELECT
	regional_id,
    regional_nome,
    jannormal, janaf, fevnormal, fevaf, marnormal, maraf, abrnormal, abrnormal, mainormal, maiaf, junnormal, junaf
    julnormal, julaf, agsnormal, agsaf, setnormal, setaf, outnormal, outaf, novnormal, novaf, deznormal, dezaf
FROM
	(
        SELECT
        	data_ini,
        	af,
        	precototal,
        	regional_id, regional_nome,
        	IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
        	IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf,

        	IF(MONTH(data_ini) = 02 AND af = "nao", SUM(precototal), 0.00) AS fevnormal,
        	IF(MONTH(data_ini) = 02 AND af = "sim", SUM(precototal), 0.00) AS fevaf,

            IF(MONTH(data_ini) = 03 AND af = "nao", SUM(precototal), 0.00) AS marnormal,
            IF(MONTH(data_ini) = 03 AND af = "sim", SUM(precototal), 0.00) AS maraf,

            IF(MONTH(data_ini) = 04 AND af = "nao", SUM(precototal), 0.00) AS abrnormal,
            IF(MONTH(data_ini) = 04 AND af = "sim", SUM(precototal), 0.00) AS abraf,

            IF(MONTH(data_ini) = 05 AND af = "nao", SUM(precototal), 0.00) AS mainormal,
            IF(MONTH(data_ini) = 05 AND af = "sim", SUM(precototal), 0.00) AS maiaf,

            IF(MONTH(data_ini) = 06 AND af = "nao", SUM(precototal), 0.00) AS junnormal,
            IF(MONTH(data_ini) = 06 AND af = "sim", SUM(precototal), 0.00) AS junaf,

            IF(MONTH(data_ini) = 07 AND af = "nao", SUM(precototal), 0.00) AS julnormal,
            IF(MONTH(data_ini) = 07 AND af = "sim", SUM(precototal), 0.00) AS julaf,

            IF(MONTH(data_ini) = 08 AND af = "nao", SUM(precototal), 0.00) AS agsnormal,
            IF(MONTH(data_ini) = 08 AND af = "sim", SUM(precototal), 0.00) AS agsaf,

            IF(MONTH(data_ini) = 09 AND af = "nao", SUM(precototal), 0.00) AS setnormal,
            IF(MONTH(data_ini) = 09 AND af = "sim", SUM(precototal), 0.00) AS setaf,

            IF(MONTH(data_ini) = 10 AND af = "nao", SUM(precototal), 0.00) AS outnormal,
            IF(MONTH(data_ini) = 10 AND af = "sim", SUM(precototal), 0.00) AS outaf,

            IF(MONTH(data_ini) = 11 AND af = "nao", SUM(precototal), 0.00) AS novnormal,
            IF(MONTH(data_ini) = 11 AND af = "sim", SUM(precototal), 0.00) AS novaf,

            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS deznormal,
            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS dezaf

        FROM
        	bigtable_data
        WHERE
        	YEAR(data_ini) = 2023
        GROUP BY regional_id, MONTH(data_ini)
        ORDER BY regional_nome
    ) AS valoresmeses
WHERE YEAR(data_ini) = 2023

6 ---- A MAIS PERFEITA DE TODAS
SELECT
	regional_id,
    regional_nome,
    SUM(jannormal), SUM(janaf), SUM(fevnormal), SUM(fevaf), SUM(marnormal), SUM(maraf), SUM(abrnormal), SUM(abraf), SUM(mainormal), SUM(maiaf), SUM(junnormal), SUM(junaf),
    SUM(julnormal), SUM(julaf), SUM(agsnormal), SUM(agsaf), SUM(setnormal), SUM(setaf), SUM(outnormal), SUM(outaf), SUM(novnormal), SUM(novaf), SUM(deznormal), SUM(dezaf)
FROM
	(
        SELECT
        	data_ini,
        	af,
        	precototal,
        	regional_id, regional_nome,
        	IF(MONTH(data_ini) = 01 AND af = "nao", SUM(precototal), 0.00) AS jannormal,
        	IF(MONTH(data_ini) = 01 AND af = "sim", SUM(precototal), 0.00) AS janaf,

        	IF(MONTH(data_ini) = 02 AND af = "nao", SUM(precototal), 0.00) AS fevnormal,
        	IF(MONTH(data_ini) = 02 AND af = "sim", SUM(precototal), 0.00) AS fevaf,

            IF(MONTH(data_ini) = 03 AND af = "nao", SUM(precototal), 0.00) AS marnormal,
            IF(MONTH(data_ini) = 03 AND af = "sim", SUM(precototal), 0.00) AS maraf,

            IF(MONTH(data_ini) = 04 AND af = "nao", SUM(precototal), 0.00) AS abrnormal,
            IF(MONTH(data_ini) = 04 AND af = "sim", SUM(precototal), 0.00) AS abraf,

            IF(MONTH(data_ini) = 05 AND af = "nao", SUM(precototal), 0.00) AS mainormal,
            IF(MONTH(data_ini) = 05 AND af = "sim", SUM(precototal), 0.00) AS maiaf,

            IF(MONTH(data_ini) = 06 AND af = "nao", SUM(precototal), 0.00) AS junnormal,
            IF(MONTH(data_ini) = 06 AND af = "sim", SUM(precototal), 0.00) AS junaf,

            IF(MONTH(data_ini) = 07 AND af = "nao", SUM(precototal), 0.00) AS julnormal,
            IF(MONTH(data_ini) = 07 AND af = "sim", SUM(precototal), 0.00) AS julaf,

            IF(MONTH(data_ini) = 08 AND af = "nao", SUM(precototal), 0.00) AS agsnormal,
            IF(MONTH(data_ini) = 08 AND af = "sim", SUM(precototal), 0.00) AS agsaf,

            IF(MONTH(data_ini) = 09 AND af = "nao", SUM(precototal), 0.00) AS setnormal,
            IF(MONTH(data_ini) = 09 AND af = "sim", SUM(precototal), 0.00) AS setaf,

            IF(MONTH(data_ini) = 10 AND af = "nao", SUM(precototal), 0.00) AS outnormal,
            IF(MONTH(data_ini) = 10 AND af = "sim", SUM(precototal), 0.00) AS outaf,

            IF(MONTH(data_ini) = 11 AND af = "nao", SUM(precototal), 0.00) AS novnormal,
            IF(MONTH(data_ini) = 11 AND af = "sim", SUM(precototal), 0.00) AS novaf,

            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS deznormal,
            IF(MONTH(data_ini) = 12 AND af = "nao", SUM(precototal), 0.00) AS dezaf

        FROM
        	bigtable_data
        WHERE
        	YEAR(data_ini) = 2023
        GROUP BY regional_id, MONTH(data_ini)
        ORDER BY regional_nome
    ) AS valoresmeses
WHERE YEAR(data_ini) = 2023
GROUP BY regional_id



// QUERY INTERNA DO SUBSELECT PERFEITA
SELECT
        	data_ini,
        	af,
        	precototal,
        	regional_id, regional_nome,

            SUM(IF(MONTH(data_ini) = 01 AND af = "nao", precototal, 0.00)) AS jannormal,
            SUM(IF(MONTH(data_ini) = 01 AND af = "sim", precototal, 0.00)) AS janaf,

            SUM(IF(MONTH(data_ini) = 02 AND af = "nao", precototal, 0.00)) AS fevnormal,
            SUM(IF(MONTH(data_ini) = 02 AND af = "sim", precototal, 0.00)) AS fevaf,

            SUM(IF(MONTH(data_ini) = 03 AND af = "nao", precototal, 0.00)) AS marnormal,
            SUM(IF(MONTH(data_ini) = 03 AND af = "sim", precototal, 0.00)) AS maraf,

            SUM(IF(MONTH(data_ini) = 04 AND af = "nao", precototal, 0.00)) AS abrnormal,
            SUM(IF(MONTH(data_ini) = 04 AND af = "sim", precototal, 0.00)) AS abraf,

            SUM(IF(MONTH(data_ini) = 05 AND af = "nao", precototal, 0.00)) AS mainormal,
            SUM(IF(MONTH(data_ini) = 05 AND af = "sim", precototal, 0.00)) AS maiaf,

            SUM(IF(MONTH(data_ini) = 06 AND af = "nao", precototal, 0.00)) AS junnormal,
            SUM(IF(MONTH(data_ini) = 06 AND af = "sim", precototal, 0.00)) AS junaf,

            SUM(IF(MONTH(data_ini) = 07 AND af = "nao", precototal, 0.00)) AS julnormal,
            SUM(IF(MONTH(data_ini) = 07 AND af = "sim", precototal, 0.00)) AS julaf,

            SUM(IF(MONTH(data_ini) = 08 AND af = "nao", precototal, 0.00)) AS agsnormal,
            SUM(IF(MONTH(data_ini) = 08 AND af = "sim", precototal, 0.00)) AS agsaf,

            SUM(IF(MONTH(data_ini) = 09 AND af = "nao", precototal, 0.00)) AS setnormal,
            SUM(IF(MONTH(data_ini) = 09 AND af = "sim", precototal, 0.00)) AS setaf,

            SUM(IF(MONTH(data_ini) = 10 AND af = "nao", precototal, 0.00)) AS outnormal,
            SUM(IF(MONTH(data_ini) = 10 AND af = "sim", precototal, 0.00)) AS outaf,

            SUM(IF(MONTH(data_ini) = 11 AND af = "nao", precototal, 0.00)) AS novnormal,
            SUM(IF(MONTH(data_ini) = 11 AND af = "sim", precototal, 0.00)) AS novaf,

            SUM(IF(MONTH(data_ini) = 12 AND af = "nao", precototal, 0.00)) AS deznormal,
            SUM(IF(MONTH(data_ini) = 12 AND af = "sim", precototal, 0.00)) AS dezaf
        FROM
        	bigtable_data
        WHERE
        	YEAR(data_ini) = 2023
        GROUP BY regional_id, MONTH(data_ini)
        ORDER BY regional_nome;


9 - A PERFEIÇÃO EM PESSOA
SELECT
	regional_id,
    regional_nome,
    SUM(jannormal), SUM(janaf), SUM(fevnormal), SUM(fevaf), SUM(marnormal), SUM(maraf), SUM(abrnormal), SUM(abraf), SUM(mainormal), SUM(maiaf), SUM(junnormal), SUM(junaf),
    SUM(julnormal), SUM(julaf), SUM(agsnormal), SUM(agsaf), SUM(setnormal), SUM(setaf), SUM(outnormal), SUM(outaf), SUM(novnormal), SUM(novaf), SUM(deznormal), SUM(dezaf)
FROM
	(
        SELECT
        	data_ini,
        	af,
        	precototal,
        	regional_id, regional_nome,

            SUM(IF(MONTH(data_ini) = 01 AND af = "nao", precototal, 0.00)) AS jannormal,
            SUM(IF(MONTH(data_ini) = 01 AND af = "sim", precototal, 0.00)) AS janaf,

            SUM(IF(MONTH(data_ini) = 02 AND af = "nao", precototal, 0.00)) AS fevnormal,
            SUM(IF(MONTH(data_ini) = 02 AND af = "sim", precototal, 0.00)) AS fevaf,

            SUM(IF(MONTH(data_ini) = 03 AND af = "nao", precototal, 0.00)) AS marnormal,
            SUM(IF(MONTH(data_ini) = 03 AND af = "sim", precototal, 0.00)) AS maraf,

            SUM(IF(MONTH(data_ini) = 04 AND af = "nao", precototal, 0.00)) AS abrnormal,
            SUM(IF(MONTH(data_ini) = 04 AND af = "sim", precototal, 0.00)) AS abraf,

            SUM(IF(MONTH(data_ini) = 05 AND af = "nao", precototal, 0.00)) AS mainormal,
            SUM(IF(MONTH(data_ini) = 05 AND af = "sim", precototal, 0.00)) AS maiaf,

            SUM(IF(MONTH(data_ini) = 06 AND af = "nao", precototal, 0.00)) AS junnormal,
            SUM(IF(MONTH(data_ini) = 06 AND af = "sim", precototal, 0.00)) AS junaf,

            SUM(IF(MONTH(data_ini) = 07 AND af = "nao", precototal, 0.00)) AS julnormal,
            SUM(IF(MONTH(data_ini) = 07 AND af = "sim", precototal, 0.00)) AS julaf,

            SUM(IF(MONTH(data_ini) = 08 AND af = "nao", precototal, 0.00)) AS agsnormal,
            SUM(IF(MONTH(data_ini) = 08 AND af = "sim", precototal, 0.00)) AS agsaf,

            SUM(IF(MONTH(data_ini) = 09 AND af = "nao", precototal, 0.00)) AS setnormal,
            SUM(IF(MONTH(data_ini) = 09 AND af = "sim", precototal, 0.00)) AS setaf,

            SUM(IF(MONTH(data_ini) = 10 AND af = "nao", precototal, 0.00)) AS outnormal,
            SUM(IF(MONTH(data_ini) = 10 AND af = "sim", precototal, 0.00)) AS outaf,

            SUM(IF(MONTH(data_ini) = 11 AND af = "nao", precototal, 0.00)) AS novnormal,
            SUM(IF(MONTH(data_ini) = 11 AND af = "sim", precototal, 0.00)) AS novaf,

            SUM(IF(MONTH(data_ini) = 12 AND af = "nao", precototal, 0.00)) AS deznormal,
            SUM(IF(MONTH(data_ini) = 12 AND af = "sim", precototal, 0.00)) AS dezaf
        FROM
        	bigtable_data
        WHERE
        	YEAR(data_ini) = 2023
        GROUP BY regional_id, MONTH(data_ini)
        ORDER BY regional_nome
    ) AS valoresmeses
WHERE YEAR(data_ini) = 2023
GROUP BY regional_id;


*************************************************************************************************
QUERY FUNCIONANDO PERFEITAMENTE SEM PAGINAÇÃO COM CÁLCULOS E FORMATAÇÃO AJUSTADAS DATA 27/10/2023
*************************************************************************************************
public function ajaxgetRegionaisComprasMensais(Request $request){

    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value

    $totalRecords = DB::table("bigtable_data")->select('regional_id')->distinct('regional_id')->count();

    $totalRecordswithFilter = DB::table("bigtable_data")
        ->select(DB::RAW('regional_id AS id, regional_nome AS regional'))
        ->distinct('regional_id')
        ->where('regional_nome', 'like', '%' .$searchValue . '%')
        ->count();


        /*
        QUERY COM RESULTADO SIMPLES (Só o id e o nome das regionais sem categorização mês a mês)
        $regionais = DB::table("bigtable_data")
        ->select(DB::RAW('regional_id AS id, regional_nome AS regional'))
        ->groupBy('regional_id')
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();
        */

        $ano = 2023;
        $records = DB::select(DB::raw("
            SELECT
                regional_id AS id, regional_nome AS regional,
                SUM(mesjannormal) AS jannormal, SUM(mesjanaf) AS janaf, SUM(mesfevnormal) AS fevnormal, SUM(mesfevaf) AS fevaf, SUM(mesmarnormal) AS marnormal, SUM(mesmaraf) AS maraf,
                SUM(mesabrnormal) AS abrnormal, SUM(mesabraf) AS abraf, SUM(mesmainormal) AS mainormal, SUM(mesmaiaf) AS maiaf, SUM(mesjunnormal) AS junnormal, SUM(mesjunaf) AS junaf,
                SUM(mesjulnormal) AS julnormal, SUM(mesjulaf) AS julaf, SUM(mesagsnormal) AS agsnormal, SUM(mesagsaf) AS agsaf, SUM(messetnormal) AS setnormal, SUM(messetaf) AS setaf,
                SUM(mesoutnormal) AS outnormal, SUM(mesoutaf) AS outaf, SUM(mesnovnormal) AS novnormal, SUM(mesnovaf) AS novaf, SUM(mesdeznormal) AS deznormal, SUM(mesdezaf) AS dezaf
            FROM
                (SELECT
                    data_ini, af, precototal, regional_id, regional_nome,
                    SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                    SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                    SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                    SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                    SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                    SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                    SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                    SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                    SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                    SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                    SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                    SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                    SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                    SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                    SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                    SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                    SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                    SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                    SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                    SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                    SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                    SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                    SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                    SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf
                FROM
                    bigtable_data
                    WHERE YEAR(data_ini) = $ano
                    GROUP BY regional_id, MONTH(data_ini)
                    ORDER BY regional_nome ) AS valoresmeses
            WHERE YEAR(data_ini) = $ano
            GROUP BY regional_id"));

    $data_arr = array();

    $linhatotalnormal = 0;
    $linhatotalaf = 0;
    $linhatotalgeral = 0;
    $linhapercentagemnormal = 0;
    $linhapercentagemaf = 0;
    $calculopercentagemnormal = 0;
    $calculopercentagemaf = 0;

    foreach($records as $record){
        // Transformando o valor retornado em float e aplicando a a formatação decimal.
        $id = $record->id;
        $regional =  $record->regional;
        $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
        $janaf = number_format(floatval($record->janaf), 2, ",", ".");
        $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
        $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
        $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
        $maraf = number_format(floatval($record->maraf), 2, ",", ".");
        $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
        $abraf = number_format(floatval($record->abraf), 2, ",", ".");
        $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
        $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
        $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
        $junaf = number_format(floatval($record->junaf), 2, ",", ".");
        $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
        $julaf = number_format(floatval($record->julaf), 2, ",", ".");
        $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
        $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
        $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
        $setaf = number_format(floatval($record->setaf), 2, ",", ".");
        $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
        $outaf = number_format(floatval($record->outaf), 2, ",", ".");
        $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
        $novaf = number_format(floatval($record->novaf), 2, ",", ".");
        $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
        $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

        //Soma dos valores normal e af de cada (linha)
        $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
        $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

        //Soma geral(total normal mais total af) de cada regional (linha)
        $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

        //Calculando percentagem normal e af de cada regional (linha)
        $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
        $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);



        $totalnormal = number_format($linhatotalnormal, 2, ",",".");
        $totalaf = number_format($linhatotalaf, 2, ",",".");
        $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
        $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
        $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


        $data_arr[] = array(
            "id"                => $id,
            "regional"          => $regional,
            "jannormal"         => $jannormal != 0 ? $jannormal : '',
            "janaf"             => $janaf != 0 ? $janaf : '',
            "fevnormal"         => $fevnormal != 0 ? $fevnormal : '',
            "fevaf"             => $fevaf != 0 ? $fevaf : '',
            "marnormal"         => $marnormal != 0 ? $marnormal : '',
            "maraf"             => $maraf != 0 ? $maraf : '',
            "abrnormal"         => $abrnormal != 0 ? $abrnormal : '',
            "abraf"             => $abraf != 0 ? $abraf : '',
            "mainormal"         => $mainormal != 0 ? $mainormal : '',
            "maiaf"             => $maiaf != 0 ? $maiaf : '',
            "junnormal"         => $junnormal != 0 ? $junnormal : '',
            "junaf"             => $junaf != 0 ? $junaf : '',
            "julnormal"         => $julnormal != 0 ? $julnormal : '',
            "julaf"             => $julaf != 0 ? $julaf : '',
            "agsnormal"         => $agsnormal != 0 ? $agsnormal : '',
            "agsaf"             => $agsaf != 0 ? $agsaf : '',
            "setnormal"         => $setnormal != 0 ? $setnormal : '',
            "setaf"             => $setaf != 0 ? $setaf : '',
            "outnormal"         => $outnormal != 0 ? $outnormal : '',
            "outaf"             => $outaf != 0 ? $outaf : '',
            "novnormal"         => $novnormal != 0 ? $novnormal : '',
            "novaf"             => $novaf != 0 ? $novaf : '',
            "deznormal"         => $deznormal != 0 ? $deznormal : '',
            "dezaf"             => $dezaf != 0 ? $dezaf : '',

            "totalnormal"       => $totalnormal != 0 ? $totalnormal : '',
            "totalaf"           => $totalaf != 0 ? $totalaf : '',
            "totalgeral"        => $linhatotalgeral != 0 ? $linhatotalgeral : '',
            "percentagemnormal" => $linhapercentagemnormal != 0 ? $linhapercentagemnormal : '',
            "percentagemaf"     => $linhapercentagemaf != 0 ? $linhapercentagemaf : '',
        );
    }

    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
}



*****************************
TENTATIVA DE EXECUTAR SUBQUERY A PARTIR DO SITE:
https://www.itsolutionstuff.com/post/laravel-how-to-make-subquery-in-select-statementexample.html?utm_source=pocket_saves
***********************************************
$ano = 2023;
$records = DB::table('bigtable_data')
->select("regional_id AS id, regional_nome AS regional,
SUM(mesjannormal) AS jannormal, SUM(mesjanaf) AS janaf, SUM(mesfevnormal) AS fevnormal, SUM(mesfevaf) AS fevaf, SUM(mesmarnormal) AS marnormal, SUM(mesmaraf) AS maraf,
SUM(mesabrnormal) AS abrnormal, SUM(mesabraf) AS abraf, SUM(mesmainormal) AS mainormal, SUM(mesmaiaf) AS maiaf, SUM(mesjunnormal) AS junnormal, SUM(mesjunaf) AS junaf,
SUM(mesjulnormal) AS julnormal, SUM(mesjulaf) AS julaf, SUM(mesagsnormal) AS agsnormal, SUM(mesagsaf) AS agsaf, SUM(messetnormal) AS setnormal, SUM(messetaf) AS setaf,
SUM(mesoutnormal) AS outnormal, SUM(mesoutaf) AS outaf, SUM(mesnovnormal) AS novnormal, SUM(mesnovaf) AS novaf, SUM(mesdeznormal) AS deznormal, SUM(mesdezaf) AS dezaf",
DB::raw("(SELECT data_ini, af, precototal, regional_id, regional_nome,
            SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
            SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
            SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
            SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
            SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
            SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
            SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
            SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
            SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
            SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
            SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
            SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
            SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
            SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
            SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
            SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
            SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
            SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
            SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
            SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
            SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
            SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
            SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
            SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf
            FROM
                bigtable_data
                WHERE YEAR(data_ini) = $ano
                GROUP BY regional_id, MONTH(data_ini)
                ORDER BY regional_nome) AS valoresmeses")
)->groupBy('regional_id')
->orderBy($columnName,$columnSortOrder)
->skip($start)
->take($rowperpage)
->get();


/*
SUBQUERY INCOMPLETA
$valoresmeses = DB::table('bigtable_data')
                ->select(DB::RAW("data_ini, af, precototal, regional_id, regional_nome,
                                    SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                                    SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                                    SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                                    SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                                    SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                                    SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                                    SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                                    SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                                    SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                                    SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                                    SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                                    SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                                    SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                                    SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                                    SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                                    SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                                    SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                                    SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                                    SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                                    SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                                    SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                                    SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                                    SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                                    SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf"
                                )
                        )
                ->whereRaw("YEAR(data_ini) = $ano")
                ->groupByRaw('regional_id, MONTH(data_ini)')
                ->orderBy("regional_nome");

$records =  DB::table('bigtable_data')->join($valoresmeses, 'aliasValoresMeses', function($join){
                $join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
            })->select(DB::raw("aliasValoresMeses.regional_id AS id, aliasValoresMeses.regional_nome AS regional,
                                SUM(aliasValoresMeses.mesjannormal) AS jannormal, SUM(aliasValoresMeses.mesjanaf) AS janaf, SUM(aliasValoresMeses.mesfevnormal) AS fevnormal, SUM(aliasValoresMeses.mesfevaf) AS fevaf, SUM(aliasValoresMeses.mesmarnormal) AS marnormal, SUM(aliasValoresMeses.mesmaraf) AS maraf,
                                SUM(aliasValoresMeses.mesabrnormal) AS abrnormal, SUM(aliasValoresMeses.mesabraf) AS abraf, SUM(aliasValoresMeses.mesmainormal) AS mainormal, SUM(aliasValoresMeses.mesmaiaf) AS maiaf, SUM(aliasValoresMeses.mesjunnormal) AS junnormal, SUM(aliasValoresMeses.mesjunaf) AS junaf,
                                SUM(aliasValoresMeses.mesjulnormal) AS julnormal, SUM(aliasValoresMeses.mesjulaf) AS julaf, SUM(aliasValoresMeses.mesagsnormal) AS agsnormal, SUM(aliasValoresMeses.mesagsaf) AS agsaf, SUM(aliasValoresMeses.messetnormal) AS setnormal, SUM(aliasValoresMeses.messetaf) AS setaf,
                                SUM(aliasValoresMeses.mesoutnormal) AS outnormal, SUM(aliasValoresMeses.mesoutaf) AS outaf, SUM(aliasValoresMeses.mesnovnormal) AS novnormal, SUM(aliasValoresMeses.mesnovaf) AS novaf, SUM(aliasValoresMeses.mesdeznormal) AS deznormal, SUM(aliasValoresMeses.mesdezaf) AS dezaf"
                            )
            )->groupBy("aliasValoresMeses.regional_id");

dd($records);
*/


$valoresmeses = DB::table('bigtable_data')
->select(DB::RAW("
        bigtable_data.data_ini, bigtable_data.af, bigtable_data.precototal, bigtable_data.regional_id, bigtable_data.regional_nome,
        SUM(IF(MONTH(bigtable_data.data_ini) = 01 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesjannormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 01 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesjanaf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 02 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesfevnormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 02 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesfevaf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 03 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesmarnormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 03 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesmaraf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 04 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesabrnormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 04 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesabraf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 05 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesmainormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 05 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesmaiaf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 06 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesjunnormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 06 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesjunaf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 07 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesjulnormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 07 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesjulaf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 08 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesagsnormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 08 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesagsaf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 09 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS messetnormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 09 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS messetaf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 10 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesoutnormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 10 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesoutaf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 11 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesnovnormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 11 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesnovaf,
        SUM(IF(MONTH(bigtable_data.data_ini) = 12 AND bigtable_data.af = 'nao', bigtable_data.precototal, 0.00)) AS mesdeznormal,
        SUM(IF(MONTH(bigtable_data.data_ini) = 12 AND bigtable_data.af = 'sim', bigtable_data.precototal, 0.00)) AS mesdezaf"
    )
)
->whereRaw("YEAR(bigtable_data.data_ini) = $ano")
->groupByRaw('bigtable_data.regional_id, MONTH(bigtable_data.data_ini)')
->orderBy("bigtable_data.regional_nome");


$records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
$join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
})->select(DB::raw("aliasValoresMeses.regional_id AS id, aliasValoresMeses.regional_nome AS regional,
                SUM(aliasValoresMeses.mesjannormal) AS jannormal, SUM(aliasValoresMeses.mesjanaf) AS janaf, SUM(aliasValoresMeses.mesfevnormal) AS fevnormal, SUM(aliasValoresMeses.mesfevaf) AS fevaf, SUM(aliasValoresMeses.mesmarnormal) AS marnormal, SUM(aliasValoresMeses.mesmaraf) AS maraf,
                SUM(aliasValoresMeses.mesabrnormal) AS abrnormal, SUM(aliasValoresMeses.mesabraf) AS abraf, SUM(aliasValoresMeses.mesmainormal) AS mainormal, SUM(aliasValoresMeses.mesmaiaf) AS maiaf, SUM(aliasValoresMeses.mesjunnormal) AS junnormal, SUM(aliasValoresMeses.mesjunaf) AS junaf,
                SUM(aliasValoresMeses.mesjulnormal) AS julnormal, SUM(aliasValoresMeses.mesjulaf) AS julaf, SUM(aliasValoresMeses.mesagsnormal) AS agsnormal, SUM(aliasValoresMeses.mesagsaf) AS agsaf, SUM(aliasValoresMeses.messetnormal) AS setnormal, SUM(aliasValoresMeses.messetaf) AS setaf,
                SUM(aliasValoresMeses.mesoutnormal) AS outnormal, SUM(aliasValoresMeses.mesoutaf) AS outaf, SUM(aliasValoresMeses.mesnovnormal) AS novnormal, SUM(aliasValoresMeses.mesnovaf) AS novaf, SUM(aliasValoresMeses.mesdeznormal) AS deznormal, SUM(aliasValoresMeses.mesdezaf) AS dezaf"
            )
)->groupBy("aliasValoresMeses.regional_id")->get();

//dd($records);



DANDO CERTO
FASE 01
$valoresmeses = DB::table('bigtable_data')
->select(DB::RAW("
        data_ini, af, precototal, regional_id, regional_nome,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf"
    )
)
->whereRaw("YEAR(data_ini) = $ano")
->groupByRaw("regional_id, MONTH(data_ini)")
->orderByRaw("regional_nome");


$records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
$join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
})->select(DB::raw("aliasValoresMeses.regional_id AS id, aliasValoresMeses.regional_nome AS regional,
                aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
            )
)
->whereRaw("YEAR(aliasValoresMeses.data_ini) = $ano")
->groupByRaw("bigtable_data.regional_id")
->get();



FASE 02
$valoresmeses = DB::table('bigtable_data')
->select(DB::RAW("
        data_ini, af, precototal, regional_id, regional_nome,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf"
    )
)
->whereRaw("YEAR(data_ini) = $ano")
->groupByRaw("regional_id, MONTH(data_ini)")
->orderByRaw("regional_nome");


$records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
$join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
})->select(DB::raw("aliasValoresMeses.regional_id AS id, aliasValoresMeses.regional_nome AS regional,
                aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
            )
)
->whereRaw("YEAR(aliasValoresMeses.data_ini) = $ano")
->groupByRaw("bigtable_data.regional_id")
->orderByRaw("bigtable_data.regional_nome")
->get();


FASE 03
$valoresmeses = DB::table('bigtable_data')
->select(DB::RAW("
        data_ini, af, precototal, regional_id, regional_nome,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf"
    )
)
->whereYear("data_ini", "=",  2024)
->groupByRaw("regional_id, MONTH(data_ini)")
->orderByRaw("regional_nome");


$records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
$join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
})->select(DB::raw("bigtable_data.regional_id AS id, bigtable_data.regional_nome AS regional, bigtable_data.data_ini,
                aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
            )
)
->whereRaw("YEAR(bigtable_data.data_ini) = $ano")
->groupBy("bigtable_data.regional_id")
->orderBy("bigtable_data.regional_nome")
->get();

FASE 04
$valoresmeses = DB::table('bigtable_data')
->select(DB::RAW("
        data_ini, af, precototal, regional_id, regional_nome,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf"
    )
)
->whereYear("data_ini", "=",  $ano)
->groupByRaw("regional_id, MONTH(data_ini)")
->orderByRaw("regional_nome");


$records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
$join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
})->select(DB::raw("bigtable_data.regional_id AS id, bigtable_data.regional_nome AS regional, bigtable_data.data_ini,
                aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
            )
)
->whereYear("bigtable_data.data_ini", "=",  $ano)
->groupBy("bigtable_data.regional_id")
->orderBy("bigtable_data.regional_nome")
->get();


FASE 05
$valoresmeses = DB::table('bigtable_data')
->select(DB::RAW("data_ini, af, precototal, regional_id, regional_nome,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf"
    )
)
->whereYear("data_ini", "=",  $ano)
->groupByRaw("regional_id")
->orderByRaw("regional_nome");


$records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
$join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
})->select(DB::raw("bigtable_data.regional_id AS id, bigtable_data.regional_nome AS regional, bigtable_data.data_ini,
                aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
            )
)
->whereYear("bigtable_data.data_ini", "=",  $ano)
->groupBy("bigtable_data.regional_id")
->orderBy("bigtable_data.regional_nome")
->get();


**********************************************
FASE 06 CORRESPONDÊNCIA PERFEITA COM PAGINAÇÃO
$ano = 2023;
/*
$records = DB::select(DB::raw("
    SELECT
        regional_id AS id, regional_nome AS regional,
        SUM(mesjannormal) AS jannormal, SUM(mesjanaf) AS janaf, SUM(mesfevnormal) AS fevnormal, SUM(mesfevaf) AS fevaf, SUM(mesmarnormal) AS marnormal, SUM(mesmaraf) AS maraf,
        SUM(mesabrnormal) AS abrnormal, SUM(mesabraf) AS abraf, SUM(mesmainormal) AS mainormal, SUM(mesmaiaf) AS maiaf, SUM(mesjunnormal) AS junnormal, SUM(mesjunaf) AS junaf,
        SUM(mesjulnormal) AS julnormal, SUM(mesjulaf) AS julaf, SUM(mesagsnormal) AS agsnormal, SUM(mesagsaf) AS agsaf, SUM(messetnormal) AS setnormal, SUM(messetaf) AS setaf,
        SUM(mesoutnormal) AS outnormal, SUM(mesoutaf) AS outaf, SUM(mesnovnormal) AS novnormal, SUM(mesnovaf) AS novaf, SUM(mesdeznormal) AS deznormal, SUM(mesdezaf) AS dezaf
    FROM
        (SELECT
            data_ini, af, precototal, regional_id, regional_nome,
            SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
            SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
            SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
            SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
            SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
            SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
            SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
            SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
            SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
            SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
            SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
            SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
            SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
            SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
            SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
            SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
            SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
            SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
            SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
            SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
            SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
            SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
            SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
            SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf
        FROM
            bigtable_data
            WHERE YEAR(data_ini) = $ano
            GROUP BY regional_id, MONTH(data_ini)
            ORDER BY regional_nome ) AS valoresmeses
    WHERE YEAR(data_ini) = $ano
    GROUP BY regional_id"));
*/


$valoresmeses = DB::table('bigtable_data')
->select(DB::RAW("data_ini, af, precototal, regional_id, regional_nome,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
        SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
        SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
        SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
        SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
        SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
        SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
        SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
        SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
        SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
        SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
        SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
        SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf"
    )
)
->whereYear("data_ini", "=",  $ano)
->groupByRaw("regional_id")
->orderByRaw("regional_nome");


$records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
$join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
})->select(DB::raw("bigtable_data.regional_id AS id, bigtable_data.regional_nome AS regional, bigtable_data.data_ini,
                aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
            )
)
->whereYear("bigtable_data.data_ini", "=",  $ano)
->groupBy("bigtable_data.regional_id")
//->orderBy("bigtable_data.regional_nome")
->orderBy($columnName,$columnSortOrder)
->skip($start)
->take($rowperpage)
->get();


************************************************************************
FASE 07 TODO O MÉTODO SEM PESQUISA E CLASSIFICAÇÃO DAS ÚLTIMAS 5 COLUNAS

public function ajaxgetRegionaisComprasMensais(Request $request){

    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value

    $totalRecords = DB::table("bigtable_data")->select('regional_id')->distinct('regional_id')->count();

    $totalRecordswithFilter = DB::table("bigtable_data")
        ->select(DB::RAW('regional_id AS id, regional_nome AS regional'))
        ->distinct('regional_id')
        ->where('regional_nome', 'like', '%' .$searchValue . '%')
        ->count();


        /*
        QUERY COM RESULTADO SIMPLES (Só o id e o nome das regionais sem categorização mês a mês)
        $regionais = DB::table("bigtable_data")
        ->select(DB::RAW('regional_id AS id, regional_nome AS regional'))
        ->groupBy('regional_id')
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();
        */

        $ano = 2023;
        /*
        $records = DB::select(DB::raw("
            SELECT
                regional_id AS id, regional_nome AS regional,
                SUM(mesjannormal) AS jannormal, SUM(mesjanaf) AS janaf, SUM(mesfevnormal) AS fevnormal, SUM(mesfevaf) AS fevaf, SUM(mesmarnormal) AS marnormal, SUM(mesmaraf) AS maraf,
                SUM(mesabrnormal) AS abrnormal, SUM(mesabraf) AS abraf, SUM(mesmainormal) AS mainormal, SUM(mesmaiaf) AS maiaf, SUM(mesjunnormal) AS junnormal, SUM(mesjunaf) AS junaf,
                SUM(mesjulnormal) AS julnormal, SUM(mesjulaf) AS julaf, SUM(mesagsnormal) AS agsnormal, SUM(mesagsaf) AS agsaf, SUM(messetnormal) AS setnormal, SUM(messetaf) AS setaf,
                SUM(mesoutnormal) AS outnormal, SUM(mesoutaf) AS outaf, SUM(mesnovnormal) AS novnormal, SUM(mesnovaf) AS novaf, SUM(mesdeznormal) AS deznormal, SUM(mesdezaf) AS dezaf
            FROM
                (SELECT
                    data_ini, af, precototal, regional_id, regional_nome,
                    SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                    SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                    SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                    SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                    SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                    SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                    SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                    SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                    SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                    SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                    SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                    SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                    SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                    SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                    SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                    SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                    SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                    SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                    SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                    SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                    SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                    SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                    SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                    SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf
                FROM
                    bigtable_data
                    WHERE YEAR(data_ini) = $ano
                    GROUP BY regional_id, MONTH(data_ini)
                    ORDER BY regional_nome ) AS valoresmeses
            WHERE YEAR(data_ini) = $ano
            GROUP BY regional_id"));
        */


        $valoresmeses = DB::table('bigtable_data')
        ->select(DB::RAW("data_ini, af, precototal, regional_id, regional_nome,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
                SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
                SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
                SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
                SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
                SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
                SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
                SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
                SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
                SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
                SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
                SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
                SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

            )
        )
        ->whereYear("data_ini", "=",  $ano)
        ->groupByRaw("regional_id")
        ->orderByRaw("regional_nome");


        $records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
        $join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
        })->select(DB::raw("bigtable_data.regional_id AS id, bigtable_data.regional_nome AS regional, bigtable_data.data_ini,
                        aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                        aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                        aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                        aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                    )
        )
        ->whereYear("bigtable_data.data_ini", "=",  $ano)
        ->groupBy("bigtable_data.regional_id")
        //->orderBy("bigtable_data.regional_nome")
        ->orderBy($columnName,$columnSortOrder)
        ->skip($start)
        ->take($rowperpage)
        ->get();


        //dd($records);


    $data_arr = array();

    $linhatotalnormal = 0;
    $linhatotalaf = 0;
    $linhatotalgeral = 0;
    $linhapercentagemnormal = 0;
    $linhapercentagemaf = 0;
    $calculopercentagemnormal = 0;
    $calculopercentagemaf = 0;

    foreach($records as $record){
        // Transformando o valor retornado em float e aplicando a a formatação decimal.
        $id = $record->id;
        $regional =  $record->regional;
        $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
        $janaf = number_format(floatval($record->janaf), 2, ",", ".");
        $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
        $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
        $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
        $maraf = number_format(floatval($record->maraf), 2, ",", ".");
        $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
        $abraf = number_format(floatval($record->abraf), 2, ",", ".");
        $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
        $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
        $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
        $junaf = number_format(floatval($record->junaf), 2, ",", ".");
        $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
        $julaf = number_format(floatval($record->julaf), 2, ",", ".");
        $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
        $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
        $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
        $setaf = number_format(floatval($record->setaf), 2, ",", ".");
        $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
        $outaf = number_format(floatval($record->outaf), 2, ",", ".");
        $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
        $novaf = number_format(floatval($record->novaf), 2, ",", ".");
        $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
        $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

        //Soma dos valores normal e af de cada (linha)
        $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
        $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

        //Soma geral(total normal mais total af) de cada regional (linha)
        $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

        //Calculando percentagem normal e af de cada regional (linha)
        //Evitando divisão por zero
        if($linhatotalgeral != 0){
            $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
            $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
        }else {
            $calculopercentagemnormal = 0;
            $calculopercentagemaf = 0;
        }



        $totalnormal = number_format($linhatotalnormal, 2, ",",".");
        $totalaf = number_format($linhatotalaf, 2, ",",".");
        $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
        $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
        $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


        $data_arr[] = array(
            "id"                => $id,
            "regional"          => $regional,
            "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
            "janaf"             => $janaf != '0,00' ? $janaf : '',
            "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
            "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
            "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
            "maraf"             => $maraf != '0,00' ? $maraf : '',
            "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
            "abraf"             => $abraf != '0,00' ? $abraf : '',
            "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
            "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
            "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
            "junaf"             => $junaf != '0,00' ? $junaf : '',
            "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
            "julaf"             => $julaf != '0,00' ? $julaf : '',
            "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
            "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
            "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
            "setaf"             => $setaf != '0,00' ? $setaf : '',
            "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
            "outaf"             => $outaf != '0,00' ? $outaf : '',
            "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
            "novaf"             => $novaf != '0,00' ? $novaf : '',
            "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
            "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
            "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
            "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
            "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
            "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
            "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

        );
    }

    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
}


**************** TODO O MÉTODO COM FILTER FUNCIONANDO PERFEITAMENTE  *******************
public function ajaxgetRegionaisComprasMensais(Request $request){

    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value

    $ano = 2023;

    /*
    $totalRecords = DB::table("bigtable_data")->select('regional_id')->distinct('regional_id')->count();
    $totalRecordswithFilter = DB::table("bigtable_data")
        ->select(DB::RAW('regional_id AS id, regional_nome AS regional'))
        ->distinct('regional_id')
        ->where('regional_nome', 'like', '%' .$searchValue . '%')
        ->count();
    */
    $totalRecords = DB::table("bigtable_data")->select('regional_id')->whereYear("data_ini", "=",  $ano)->distinct('regional_id')->count();
    
    //** BEGIN FILTER */
    $valoresmesesfilter = DB::table('bigtable_data')
    ->select(DB::RAW("data_ini, af, precototal, regional_id, regional_nome,
            SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
            SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
            SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
            SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
            SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
            SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
            SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
            SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
            SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
            SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
            SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
            SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
            SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
            SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
            SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
            SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
            SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
            SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
            SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
            SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
            SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
            SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
            SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
            SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

        )
    )
    ->whereYear("data_ini", "=",  $ano)
    ->groupByRaw("regional_id");
    //->orderByRaw("regional_nome");


    $totalRecordswithFilter =  DB::table('bigtable_data')->joinSub($valoresmesesfilter, 'aliasValoresMesesFilter', function($join){
        $join->on('bigtable_data.regional_id', '=', 'aliasValoresMesesFilter.regional_id');
    })->select("count(*) as allcount")
    ->distinct('bigtable_data.regional_id')
    ->where('bigtable_data.regional_nome', 'like', '%' .$searchValue . '%')
    ->count();

    //** END FILTER */
    
    $valoresmeses = DB::table('bigtable_data')
    ->select(DB::RAW("data_ini, af, precototal, regional_id, regional_nome,
            SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
            SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
            SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
            SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
            SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
            SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
            SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
            SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
            SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
            SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
            SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
            SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
            SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
            SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
            SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
            SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
            SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
            SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
            SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
            SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
            SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
            SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
            SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
            SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

        )
    )
    ->whereYear("data_ini", "=",  $ano)
    ->groupByRaw("regional_id")
    ->orderByRaw("regional_nome");


    $records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
    $join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
    })->select(DB::raw("bigtable_data.regional_id AS id, bigtable_data.regional_nome AS regional, bigtable_data.data_ini,
                    aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                    aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                    aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                    aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                )
    )
    ->whereYear("bigtable_data.data_ini", "=",  $ano)
    ->where('bigtable_data.regional_nome', 'like', '%' .$searchValue . '%')
    ->groupBy("bigtable_data.regional_id")
    //->orderBy("bigtable_data.regional_nome")
    ->orderBy($columnName,$columnSortOrder)
    ->skip($start)
    ->take($rowperpage)
    ->get();


    $data_arr = array();

    $linhatotalnormal = 0;
    $linhatotalaf = 0;
    $linhatotalgeral = 0;
    $linhapercentagemnormal = 0;
    $linhapercentagemaf = 0;
    $calculopercentagemnormal = 0;
    $calculopercentagemaf = 0;

    foreach($records as $record){
        // Transformando o valor retornado em float e aplicando a a formatação decimal.
        $id = $record->id;
        $regional =  $record->regional;
        $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
        $janaf = number_format(floatval($record->janaf), 2, ",", ".");
        $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
        $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
        $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
        $maraf = number_format(floatval($record->maraf), 2, ",", ".");
        $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
        $abraf = number_format(floatval($record->abraf), 2, ",", ".");
        $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
        $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
        $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
        $junaf = number_format(floatval($record->junaf), 2, ",", ".");
        $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
        $julaf = number_format(floatval($record->julaf), 2, ",", ".");
        $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
        $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
        $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
        $setaf = number_format(floatval($record->setaf), 2, ",", ".");
        $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
        $outaf = number_format(floatval($record->outaf), 2, ",", ".");
        $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
        $novaf = number_format(floatval($record->novaf), 2, ",", ".");
        $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
        $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

        //Soma dos valores normal e af de cada (linha)
        $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
        $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

        //Soma geral(total normal mais total af) de cada regional (linha)
        $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

        //Calculando percentagem normal e af de cada regional (linha)
        //Evitando divisão por zero
        if($linhatotalgeral != 0){
            $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
            $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
        }else {
            $calculopercentagemnormal = 0;
            $calculopercentagemaf = 0;
        }



        $totalnormal = number_format($linhatotalnormal, 2, ",",".");
        $totalaf = number_format($linhatotalaf, 2, ",",".");
        $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
        $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
        $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


        $data_arr[] = array(
            "id"                => $id,
            "regional"          => $regional,
            "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
            "janaf"             => $janaf != '0,00' ? $janaf : '',
            "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
            "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
            "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
            "maraf"             => $maraf != '0,00' ? $maraf : '',
            "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
            "abraf"             => $abraf != '0,00' ? $abraf : '',
            "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
            "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
            "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
            "junaf"             => $junaf != '0,00' ? $junaf : '',
            "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
            "julaf"             => $julaf != '0,00' ? $julaf : '',
            "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
            "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
            "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
            "setaf"             => $setaf != '0,00' ? $setaf : '',
            "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
            "outaf"             => $outaf != '0,00' ? $outaf : '',
            "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
            "novaf"             => $novaf != '0,00' ? $novaf : '',
            "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
            "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
            "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
            "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
            "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
            "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
            "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

        );
    }

    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
}


*********************************************
TODO O MÉTODO COM FILTER FUNCIONANDO E ENXUTO
*********************************************
public function ajaxgetRegionaisComprasMensais(Request $request){

    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value


    // Obtendo o ano de referência (ano atual)
    $anoRef = date("Y");

    // Obtendo o total de registros de acordo com os critérios de pesquia (fitro)
    $totalRecords = DB::table("bigtable_data")->select('regional_id')->whereYear("data_ini", "=",  $anoRef)->distinct('regional_id')->count();
    $totalRecordswithFilter =  DB::table('bigtable_data')
    ->select("count(*) as allcount")
    ->whereYear("data_ini", "=",  $anoRef)
    ->distinct('bigtable_data.regional_id')
    ->where('bigtable_data.regional_nome', 'like', '%' .$searchValue . '%')
    ->count();
    
    // Obtendo os valores das compras por mês (1 a 12), se da agricultura familiar ou não (normal ou af) no ano de referência
    // por meio de SUBQUERY utilizando a mesma tabela (bigtable_data) através do "joinSub"
    $valoresmeses = DB::table('bigtable_data')
    ->select(DB::RAW("data_ini, af, precototal, regional_id, regional_nome,
            SUM(IF(MONTH(data_ini) = 01 AND af = 'nao', precototal, 0.00)) AS mesjannormal,
            SUM(IF(MONTH(data_ini) = 01 AND af = 'sim', precototal, 0.00)) AS mesjanaf,
            SUM(IF(MONTH(data_ini) = 02 AND af = 'nao', precototal, 0.00)) AS mesfevnormal,
            SUM(IF(MONTH(data_ini) = 02 AND af = 'sim', precototal, 0.00)) AS mesfevaf,
            SUM(IF(MONTH(data_ini) = 03 AND af = 'nao', precototal, 0.00)) AS mesmarnormal,
            SUM(IF(MONTH(data_ini) = 03 AND af = 'sim', precototal, 0.00)) AS mesmaraf,
            SUM(IF(MONTH(data_ini) = 04 AND af = 'nao', precototal, 0.00)) AS mesabrnormal,
            SUM(IF(MONTH(data_ini) = 04 AND af = 'sim', precototal, 0.00)) AS mesabraf,
            SUM(IF(MONTH(data_ini) = 05 AND af = 'nao', precototal, 0.00)) AS mesmainormal,
            SUM(IF(MONTH(data_ini) = 05 AND af = 'sim', precototal, 0.00)) AS mesmaiaf,
            SUM(IF(MONTH(data_ini) = 06 AND af = 'nao', precototal, 0.00)) AS mesjunnormal,
            SUM(IF(MONTH(data_ini) = 06 AND af = 'sim', precototal, 0.00)) AS mesjunaf,
            SUM(IF(MONTH(data_ini) = 07 AND af = 'nao', precototal, 0.00)) AS mesjulnormal,
            SUM(IF(MONTH(data_ini) = 07 AND af = 'sim', precototal, 0.00)) AS mesjulaf,
            SUM(IF(MONTH(data_ini) = 08 AND af = 'nao', precototal, 0.00)) AS mesagsnormal,
            SUM(IF(MONTH(data_ini) = 08 AND af = 'sim', precototal, 0.00)) AS mesagsaf,
            SUM(IF(MONTH(data_ini) = 09 AND af = 'nao', precototal, 0.00)) AS messetnormal,
            SUM(IF(MONTH(data_ini) = 09 AND af = 'sim', precototal, 0.00)) AS messetaf,
            SUM(IF(MONTH(data_ini) = 10 AND af = 'nao', precototal, 0.00)) AS mesoutnormal,
            SUM(IF(MONTH(data_ini) = 10 AND af = 'sim', precototal, 0.00)) AS mesoutaf,
            SUM(IF(MONTH(data_ini) = 11 AND af = 'nao', precototal, 0.00)) AS mesnovnormal,
            SUM(IF(MONTH(data_ini) = 11 AND af = 'sim', precototal, 0.00)) AS mesnovaf,
            SUM(IF(MONTH(data_ini) = 12 AND af = 'nao', precototal, 0.00)) AS mesdeznormal,
            SUM(IF(MONTH(data_ini) = 12 AND af = 'sim', precototal, 0.00)) AS mesdezaf",

        )
    )
    ->whereYear("data_ini", "=",  $anoRef)
    ->groupByRaw("regional_id")
    ->orderByRaw("regional_nome");


    $records =  DB::table('bigtable_data')->joinSub($valoresmeses, 'aliasValoresMeses', function($join){
    $join->on('bigtable_data.regional_id', '=', 'aliasValoresMeses.regional_id');
    })->select(DB::raw("bigtable_data.regional_id AS id, bigtable_data.regional_nome AS regional, bigtable_data.data_ini,
                    aliasValoresMeses.mesjannormal AS jannormal, aliasValoresMeses.mesjanaf AS janaf, aliasValoresMeses.mesfevnormal AS fevnormal, aliasValoresMeses.mesfevaf AS fevaf, aliasValoresMeses.mesmarnormal AS marnormal, aliasValoresMeses.mesmaraf AS maraf,
                    aliasValoresMeses.mesabrnormal AS abrnormal, aliasValoresMeses.mesabraf AS abraf, aliasValoresMeses.mesmainormal AS mainormal, aliasValoresMeses.mesmaiaf AS maiaf, aliasValoresMeses.mesjunnormal AS junnormal, aliasValoresMeses.mesjunaf AS junaf,
                    aliasValoresMeses.mesjulnormal AS julnormal, aliasValoresMeses.mesjulaf AS julaf, aliasValoresMeses.mesagsnormal AS agsnormal, aliasValoresMeses.mesagsaf AS agsaf, aliasValoresMeses.messetnormal AS setnormal, aliasValoresMeses.messetaf AS setaf,
                    aliasValoresMeses.mesoutnormal AS outnormal, aliasValoresMeses.mesoutaf AS outaf, aliasValoresMeses.mesnovnormal AS novnormal, aliasValoresMeses.mesnovaf AS novaf, aliasValoresMeses.mesdeznormal AS deznormal, aliasValoresMeses.mesdezaf AS dezaf"
                )
    )
    ->whereYear("bigtable_data.data_ini", "=",  $anoRef)
    ->where('bigtable_data.regional_nome', 'like', '%' .$searchValue . '%')
    ->groupBy("bigtable_data.regional_id")
    //->orderBy("bigtable_data.regional_nome")
    ->orderBy($columnName,$columnSortOrder)
    ->skip($start)
    ->take($rowperpage)
    ->get();


    $data_arr = array();

    $linhatotalnormal = 0;
    $linhatotalaf = 0;
    $linhatotalgeral = 0;
    $linhapercentagemnormal = 0;
    $linhapercentagemaf = 0;
    $calculopercentagemnormal = 0;
    $calculopercentagemaf = 0;

    foreach($records as $record){
        // Transformando o valor retornado em float e aplicando a a formatação decimal.
        $id = $record->id;
        $regional =  $record->regional;
        $jannormal = number_format(floatval($record->jannormal), 2, ",", ".");
        $janaf = number_format(floatval($record->janaf), 2, ",", ".");
        $fevnormal = number_format(floatval($record->fevnormal), 2, ",", ".");
        $fevaf = number_format(floatval($record->fevaf), 2, ",", ".");
        $marnormal = number_format(floatval($record->marnormal), 2, ",", ".");
        $maraf = number_format(floatval($record->maraf), 2, ",", ".");
        $abrnormal = number_format(floatval($record->abrnormal), 2, ",", ".");
        $abraf = number_format(floatval($record->abraf), 2, ",", ".");
        $mainormal = number_format(floatval($record->mainormal), 2, ",", ".");
        $maiaf = number_format(floatval($record->maiaf), 2, ",", ".");
        $junnormal = number_format(floatval($record->junnormal), 2, ",", ".");
        $junaf = number_format(floatval($record->junaf), 2, ",", ".");
        $julnormal = number_format(floatval($record->julnormal), 2, ",", ".");
        $julaf = number_format(floatval($record->julaf), 2, ",", ".");
        $agsnormal = number_format(floatval($record->agsnormal), 2, ",", ".");
        $agsaf = number_format(floatval($record->agsaf), 2, ",", ".");
        $setnormal = number_format(floatval($record->setnormal), 2, ",", ".");
        $setaf = number_format(floatval($record->setaf), 2, ",", ".");
        $outnormal = number_format(floatval($record->outnormal), 2, ",", ".");
        $outaf = number_format(floatval($record->outaf), 2, ",", ".");
        $novnormal = number_format(floatval($record->novnormal), 2, ",", ".");
        $novaf = number_format(floatval($record->novaf), 2, ",", ".");
        $deznormal = number_format(floatval($record->deznormal), 2, ",", ".");
        $dezaf = number_format(floatval($record->dezaf), 2, ",", ".");

        //Soma dos valores normal e af de cada (linha)
        $linhatotalnormal = floatval($record->jannormal) + floatval($record->fevnormal) + floatval($record->marnormal) + floatval($record->abrnormal) + floatval($record->mainormal) + floatval($record->junnormal) + floatval($record->julnormal) + floatval($record->agsnormal) + floatval($record->setnormal) + floatval($record->outnormal) + floatval($record->novnormal) + floatval($record->deznormal);
        $linhatotalaf = floatval($record->janaf) + floatval($record->fevaf) + floatval($record->maraf) + floatval($record->abraf) + floatval($record->maiaf) + floatval($record->junaf) + floatval($record->julaf) + floatval($record->agsaf) + floatval($record->setaf) + floatval($record->outaf) + floatval($record->novaf) + floatval($record->dezaf);

        //Soma geral(total normal mais total af) de cada regional (linha)
        $linhatotalgeral = $linhatotalnormal + $linhatotalaf;

        //Calculando percentagem normal e af de cada regional (linha)
        //Evitando divisão por zero
        if($linhatotalgeral != 0){
            $calculopercentagemnormal = (($linhatotalnormal * 100)/$linhatotalgeral);
            $calculopercentagemaf = (($linhatotalaf * 100)/$linhatotalgeral);
        }else {
            $calculopercentagemnormal = 0;
            $calculopercentagemaf = 0;
        }



        $totalnormal = number_format($linhatotalnormal, 2, ",",".");
        $totalaf = number_format($linhatotalaf, 2, ",",".");
        $linhatotalgeral = number_format($linhatotalgeral, 2, ",",".");
        $linhapercentagemnormal = number_format($calculopercentagemnormal, 2, ",",".");
        $linhapercentagemaf = number_format($calculopercentagemaf, 2, ",", ".");


        $data_arr[] = array(
            "id"                => $id,
            "regional"          => $regional,
            "jannormal"         => $jannormal != '0,00' ? $jannormal : '',
            "janaf"             => $janaf != '0,00' ? $janaf : '',
            "fevnormal"         => $fevnormal != '0,00' ? $fevnormal : '',
            "fevaf"             => $fevaf != '0,00' ? $fevaf : '',
            "marnormal"         => $marnormal != '0,00' ? $marnormal : '',
            "maraf"             => $maraf != '0,00' ? $maraf : '',
            "abrnormal"         => $abrnormal != '0,00' ? $abrnormal : '',
            "abraf"             => $abraf != '0,00' ? $abraf : '',
            "mainormal"         => $mainormal != '0,00' ? $mainormal : '',
            "maiaf"             => $maiaf != '0,00' ? $maiaf : '',
            "junnormal"         => $junnormal != '0,00' ? $junnormal : '',
            "junaf"             => $junaf != '0,00' ? $junaf : '',
            "julnormal"         => $julnormal != '0,00' ? $julnormal : '',
            "julaf"             => $julaf != '0,00' ? $julaf : '',
            "agsnormal"         => $agsnormal != '0,00' ? $agsnormal : '',
            "agsaf"             => $agsaf != '0,00' ? $agsaf : '',
            "setnormal"         => $setnormal != '0,00' ? $setnormal : '',
            "setaf"             => $setaf != '0,00' ? $setaf : '',
            "outnormal"         => $outnormal != '0,00' ? $outnormal : '',
            "outaf"             => $outaf != '0,00' ? $outaf : '',
            "novnormal"         => $novnormal != '0,00' ? $novnormal : '',
            "novaf"             => $novaf != '0,00' ? $novaf : '',
            "deznormal"         => $deznormal != '0,00' ? $deznormal : '',
            "dezaf"             => $dezaf != '0,00' ? $dezaf : '',
            "totalnormal"       => $totalnormal != '0,00' ? $totalnormal : '',
            "totalaf"           => $totalaf != '0,00' ? $totalaf : '',
            "totalgeral"        => $linhatotalgeral != '0,00' ? $linhatotalgeral : '',
            "percentagemnormal" => $linhapercentagemnormal != '0,00' ? $linhapercentagemnormal : '',
            "percentagemaf"     => $linhapercentagemaf != '0,00' ? $linhapercentagemaf : '',

        );
    }

    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
    );

    echo json_encode($response);
    exit;
}


***********************************************************
Modificações no sede após o primeiro dia das minhas férias:
***********************************************************
0 - Acrescentei estas linhas neste arquivo: storage/lixo.blade.php

1 - No arquivo: resources/views/template/sidebar.blade.php
    Descomentei o link do menu Monitor na sidebar para que pudesse visualizá-lo

2 - Acrescentei o script abaio, no arquivo: resources/views/template/templateadmin.blade.php
    Para carregar as funções de butões no datatables
	<!-- INICIO BUTTONS PARA SEREM EXIBIDOS NOS DATATABLES-->
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <!-- FIM BUTTONS PARA SEREM EXIBIDOS NOS DATATABLES-->

3 - Acrescentei os scripts abaixo, no arquivo: resources/views/admin/monitor/index.blade.php
    para configurar fixação de cabeçalhos e colunas e exibição de botões
    //## Fixando colunas e cabeçalhos
    fixedColumns: {
        left: 2,
        //right: 5,
    },
    //paging: false,
    scrollCollapse: true,
    scrollY: '400px',
    scrollX: true,

    //## Exibindo button
    //dom: "Blfrtip",
    //    "buttons": [
    //        'copy', 'csv', 'excel', 'pdf', 'print'
    //    ],

4 -  Acrescentei os scripts abaixo, no arquivo:  resources/views/template/templateadmin.blade.php
    para fixaçãod e colunas e cabeçalho no datatables
    <!-- Styles personalizado para fixação de colunas e cabeçalhos em um datatable. Opera com a extensão javascript abaixo -->
    <link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet">
    ...
    <!-- Extensão javascript para fixação de colunas e cabeçalhos no DataTables. Opera em conjunto com o css acima -->
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>


5 - Comentei o trecho de código como abaixo, no arquivo: app/Http/Controllers/Admin/MonitorController.php
    public function index()
    {
        //$restaurantes = Restaurante::orderBy('identificacao', 'ASC')->get();
        //return view('admin.monitor.index', compact('restaurantes'));
        
        return view('admin.monitor.index');
    }
    
6 - Acrescentei as rotas abaixo, no arquivo: routes/web.php
    Route::get('ajaxgetRegionaisComprasMensais',[MonitorController::class,'ajaxgetRegionaisComprasMensais'])->name('admin.ajaxgetRegionaisComprasMensais')->middleware(['auth']);
    Route::get('ajaxgetMunicipiosComprasMensais',[MonitorController::class,'ajaxgetMunicipiosComprasMensais'])->name('admin.ajaxgetMunicipiosComprasMensais')->middleware(['auth']);

7 - Acrescentei os métodos abaixo, no arquivo: app/Http/Controllers/Admin/MonitorController.php
    public function ajaxgetRegionaisComprasMensais
    public function ajaxgetMunicipiosComprasMensais

8 - Alterei o arquivo: resources/views/admin/monitor/index.blade.php conforme abaixo@auth
     DE: <h5><strong>MONITOR</strong></h5>
     PARA <h5><strong>MONITOR DE COMPRAS</strong></h5>

    DE: <th rowspan="3" style="vertical-align: middle; text-align:center">Regionais</th>
    PARA: <th rowspan="3" style="vertical-align: middle; text-align:center" id="entidade">Regionais</th>

    DE: { data: 'reginonal' },
    PARA: { data: 'nomeentidade' },


9 - Acrescentei o código abaixo, no arquivo: resources/views/admin/monitor/index.blade.php conforme abaixo
    $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Compras por:</label>');
    $('#dataTableMonitor_length').append('<select id="selectGrupo" class="form-control input-sm" style="height: 36px;"><option value="regi">Regionais</option><option value="muni">Municipios</option><option value="rest">Restaurantes</option></select>');
    $("#selectGrupo").on('change', function(){
        //alert($(this).children("option:selected").text());
        //alert(oTable.ajax.data);
        var entidadeSelecionada = $(this).children("option:selected").text();
        var rotaAjax = "{{route('admin.ajaxgetMunicipiosComprasMensais')}}";
        switch (entidadeSelecionada){
            case "Regionais":
                rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
            break;
            case "Municipios":
                rotaAjax = "{{route('admin.ajaxgetMunicipiosComprasMensais')}}";
            break;
            case "Restaurantes":
                rotaAjax = "{{route('admin.ajaxgetRestaurantesComprasMensais')}}";
            break;
            default:
                rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";

        }
        $("#entidade").text(entidadeSelecionada);
        //oTable.ajax.url("{{route('admin.ajaxgetMunicipiosComprasMensais')}}");
        oTable.ajax.url(rotaAjax);
        oTable.ajax.reload();
    });



    <script>
    // https://stackoverflow.com/questions/66243388/how-to-reload-datatable-by-using-new-url-and-some-parameters-without-reinitializ?utm_source=pocket_reader

        $(document).ready(function() {
        
          // ajax for initial table creation:
          var requestUrl = "https://jsonplaceholder.typicode.com/posts";
          var requestData = { "name": "Abel", "location": "here" };
        
          var table = $('#example').DataTable( {
            ajax: {
              method: "GET",
              url: requestUrl,
              "data": function ( ) {
                return requestData;
              },
              dataSrc: "",  
            },
            "columns": [
              { "title": "User ID", "data": "userId" },
              { "title": "ID", "data": "id" },
              { "title": "Title", "data": "title" }
            ]
                    
          } );
          
          $("#button_one").click(function() {
            // subsequent ajax call, with button click:
            requestUrl = "https://jsonplaceholder.typicode.com/todos";
            requestData = { "name": "Charlie", "location": "there" };
            table.ajax.url( requestUrl ).load();
          });
          
        } );
        
        </script>

============ FINALIDADE ALCANÇADA, FALTA ORGANIZAR ==========
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){

        rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
        periodoAno = new Date().getFullYear();

        // DataTable. Aqui, estamos atribuindo todo o dataTable à uma variável, para posterior manipulação caso seja necessário
        var oTable = $('#dataTableMonitor').DataTable({
            //## Fixando colunas e cabeçalhos
            fixedColumns: {
                left: 2,
                //right: 5,
            },
            //paging: false,
            scrollCollapse: true,
            scrollY: '400px',
            scrollX: true,

            //## Exibindo button
            //dom: "Blfrtip",
            //    "buttons": [
            //        'copy', 'csv', 'excel', 'pdf', 'print'
            //    ],


            order: [[ 1, 'asc' ]],     // Exibe os registros em ordem decrescente pelo ID (coluna 0) (Regra de negócio: último registro cadastrado)

            columnDefs: [               // Impede que as colunas 3, 4, 5 e 6 sejam ordenadas pelo usuário
                { orderable: false, targets: [26, 27, 28, 29, 30] }
            ],

            lengthMenu: [10, 15, 20, 25, 30, 35, 40, 45, 50], //Configura o número de entra de registro a serem exibido por pagina
            // pageLength: 5, //Define a quantidade de registros a serem exibidos independente da escolha feita em: lengthMenu


            processing: true,   // Indicador de processamento
            serverSide: true,

            //ajax: "{{route('admin.ajaxgetRegionaisComprasMensais')}}", // Preenche a tabela automaticamente, a partir de uma requisição Ajax (pela rota nomeada)
            
            

            /* ajax: {
                url: "{{route('admin.ajaxgetRegionaisComprasMensais')}}",
                data: function(d){
                    //d.grupoEnviado = "Regionais";
                    d.periodo = $("#selectPeriodo").val();
                }
            }, 
            */

            ajax: {
                url: rotaAjax,
                data: function(d){
                    d.periodo = periodoAno;
                },
            },
            
            columns: [
                { data: 'id' },
                { data: 'nomeentidade' },
                { data: 'jannormal' },
                { data: 'janaf' },
                { data: 'fevnormal' },
                { data: 'fevaf' },
                { data: 'marnormal' },
                { data: 'maraf' },
                { data: 'abrnormal' },
                { data: 'abraf' },
                { data: 'mainormal' },
                { data: 'maiaf' },
                { data: 'junnormal' },
                { data: 'junaf' },
                { data: 'julnormal' },
                { data: 'julaf' },
                { data: 'agsnormal' },
                { data: 'agsaf' },
                { data: 'setnormal' },
                { data: 'setaf' },
                { data: 'outnormal' },
                { data: 'outaf' },
                { data: 'novnormal' },
                { data: 'novaf' },
                { data: 'deznormal' },
                { data: 'dezaf' },
                { data: 'totalnormal' },
                { data: 'totalaf' },
                { data: 'totalgeral' },
                { data: 'percentagemnormal' },
                { data: 'percentagemaf' },
            ],

            language: {
                "lengthMenu": "Mostrar _MENU_ registos",
                "search": "Procurar:",
                "info": "Mostrando os registros _START_ a _END_ num total de _TOTAL_",
                "infoFiltered":   "(Filtrados _TOTAL_ de um total de _MAX_ registros)",
                "paginate": {
                    "first": "Primeiro",
                    "previous": "Anterior",
                    "next": "Seguinte",
                    "last": "Último"
                },
                "zeroRecords": "Não foram encontrados resultados",
            },
            //pagingType: "simple_numbers",
            pagingType: "full_numbers", // Todos os links de paginação   "simple_numbers" // Sómente anterior; seguinte e os núemros da página:
            //scrollY: 450,

            // Quando a tabela estiver completamente inicializada(carregada), executa a função abaixo
            initComplete: function (settings, json) {
                /*
                // "#dataTableMonitor_length" é o nome atribuido dinamicamente à div onde está localizado o menu de 
                // de opçoes length. Nesse caso nesta div adicionando um select na toolbar do datatable
                $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Escolha</label>');
                $('#dataTableMonitor_length').append('<select id="selectGrupo" class="form-control input-sm" style="height: 36px;"><option value="regi">Regionais</option><option value="muni">Municipios</option><option value="rest">Restaurantes</option></select>');
                $("#selectGrupo").on('change', function(){
                    alert($(this).children("option:selected").text());
                    //alert(oTable.ajax.data);
                    //oTable.ajax.reload();
                    //oTable.draw();
                });
                */
                //$('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Período:</label>');
                //$('#dataTableMonitor_length').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px;"><option value="2023" selected>2023</option><option value="2024">2024</option><option value="2025">2025</option></select>');
            }

        });

        $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Compras por:</label>');
        $('#dataTableMonitor_length').append('<select id="selectGrupo" class="form-control input-sm" style="height: 36px;"><option value="regi">Regionais</option><option value="muni">Municipios</option><option value="rest">Restaurantes</option></select>');
        
        $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Período:</label>');
        $('#dataTableMonitor_length').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px;"><option value="2023" selected>2023</option><option value="2024">2024</option><option value="2025">2025</option></select>');
        
        $("#selectGrupo").on('change', function(){
            //alert($(this).children("option:selected").text());
            //alert(oTable.ajax.data);
            var entidadeSelecionada = $(this).children("option:selected").text();
            //var rotaAjax = "{{route('admin.ajaxgetMunicipiosComprasMensais')}}";
            periodoAno = $("#selectPeriodo").val();

            switch (entidadeSelecionada){
                case "Regionais":
                    rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
                break;
                case "Municipios":
                    rotaAjax = "{{route('admin.ajaxgetMunicipiosComprasMensais')}}";
                break;
                case "Restaurantes":
                    rotaAjax = "{{route('admin.ajaxgetRestaurantesComprasMensais')}}";
                break;
                default:
                    rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";

            }
            $("#entidade").text(entidadeSelecionada);
            //oTable.ajax.url("{{route('admin.ajaxgetMunicipiosComprasMensais')}}");
            oTable.ajax.url(rotaAjax).load();
            //oTable.ajax.reload();
        });
     });

</script>
@endsection


============= ORGANIZADO ====================
@extends('template.templateadmin')

@section('content-page')

<!-- Begin Page Content -->
<div class="container-fluid">

        <h5><strong>MONITOR</strong></h5>


    <!-- DataTales Example -->
    <div class="mb-4 shadow card">

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableMonitor" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="3" style="vertical-align: middle; text-align:center">Id</th>
                            <th rowspan="3" style="vertical-align: middle; text-align:center" id="entidade">Regionais</th>
                            <th colspan="24" style="vertical-align: middle; text-align:center" id="mesesdoano">COMPRAS POR REGIONAL EM @php echo date("Y") @endphp</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center">TOTAL<br>PARCIAL</th>
                            <th rowspan="3" style="vertical-align: middle; text-align:center">TOTAL<br>GERAL</th>
                            <th rowspan="2" colspan="2" style="vertical-align: middle; text-align:center">PERCENTAGEM</th>
                        </tr>
                        <tr>
                            <th colspan="2" style="text-align:center">JAN</th>
                            <th colspan="2" style="text-align:center">FEV</th>
                            <th colspan="2" style="text-align:center">MAR</th>
                            <th colspan="2" style="text-align:center">ABR</th>
                            <th colspan="2" style="text-align:center">MAI</th>
                            <th colspan="2" style="text-align:center">JUN</th>
                            <th colspan="2" style="text-align:center">JUL</th>
                            <th colspan="2" style="text-align:center">AGS</th>
                            <th colspan="2" style="text-align:center">SET</th>
                            <th colspan="2" style="text-align:center">OUT</th>
                            <th colspan="2" style="text-align:center">NOV</th>
                            <th colspan="2" style="text-align:center">DEZ</th>
                        </tr>
                        <tr>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>norm</th>
                            <th>af</th>
                            <th>NORMAL</th>
                            <th>AF</th>
                            <th>NORMAL</th>
                            <th>AF</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){

            rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
            periodoAno = new Date().getFullYear();
            
            // anospesquisa = "{$anospesquisa}"; // {variavel}, desta forma evita erro de htmlspecialchar
            var anoimplementacao = 2020;
            var anoatual = new Date().getFullYear();
            var anos = [];
            var anosexibicao = [];
            var qtdanosexibicao = 0;

            if(anoimplementacao >= anoatual){
                anosexibicao.push(anoatual);
            }else{
                qtdanosexibicao = anoatual -  anoimplementacao;
                for(var a = qtdanosexibicao; a >= 0; a-- ){
                    anos.push(anoatual - a);
                }
                anosexibicao = anos.reverse();
            }

            
            // DataTable. Aqui, estamos atribuindo todo o dataTable à uma variável, para posterior manipulação caso seja necessário
            var oTable = $('#dataTableMonitor').DataTable({
                //## Fixando colunas e cabeçalhos
                fixedColumns: {
                    left: 2,
                    //right: 5,
                },
                //paging: false,
                scrollCollapse: true,
                scrollY: '400px',
                scrollX: true,

                //## Exibindo button
                //dom: "Blfrtip",
                //    "buttons": [
                //        'copy', 'csv', 'excel', 'pdf', 'print'
                //    ],


                order: [[ 1, 'asc' ]],     // Exibe os registros em ordem decrescente pelo ID (coluna 0) (Regra de negócio: último registro cadastrado)

                columnDefs: [               // Impede que as colunas 3, 4, 5 e 6 sejam ordenadas pelo usuário
                    { orderable: false, targets: [26, 27, 28, 29, 30] }
                ],

                lengthMenu: [10, 15, 20, 25, 30, 35, 40, 45, 50], //Configura o número de entra de registro a serem exibido por pagina
                // pageLength: 5, //Define a quantidade de registros a serem exibidos independente da escolha feita em: lengthMenu


                processing: true,   // Indicador de processamento
                serverSide: true,

                //ajax: "{{route('admin.ajaxgetRegionaisComprasMensais')}}", // Preenche a tabela automaticamente, a partir de uma requisição Ajax (pela rota nomeada)
                /* ajax: {
                    url: "{{route('admin.ajaxgetRegionaisComprasMensais')}}",
                    data: function(d){
                        //d.grupoEnviado = "Regionais";
                        d.periodo = $("#selectPeriodo").val();
                    }
                }, 
                */

                ajax: {
                    url: rotaAjax,
                    data: function(d){
                        d.periodo = periodoAno;
                    },
                },
                
                columns: [
                    { data: 'id' },
                    { data: 'nomeentidade' },
                    { data: 'jannormal' },
                    { data: 'janaf' },
                    { data: 'fevnormal' },
                    { data: 'fevaf' },
                    { data: 'marnormal' },
                    { data: 'maraf' },
                    { data: 'abrnormal' },
                    { data: 'abraf' },
                    { data: 'mainormal' },
                    { data: 'maiaf' },
                    { data: 'junnormal' },
                    { data: 'junaf' },
                    { data: 'julnormal' },
                    { data: 'julaf' },
                    { data: 'agsnormal' },
                    { data: 'agsaf' },
                    { data: 'setnormal' },
                    { data: 'setaf' },
                    { data: 'outnormal' },
                    { data: 'outaf' },
                    { data: 'novnormal' },
                    { data: 'novaf' },
                    { data: 'deznormal' },
                    { data: 'dezaf' },
                    { data: 'totalnormal' },
                    { data: 'totalaf' },
                    { data: 'totalgeral' },
                    { data: 'percentagemnormal' },
                    { data: 'percentagemaf' },
                ],

                language: {
                    "lengthMenu": "Mostrar _MENU_ registos",
                    "search": "Procurar:",
                    "info": "Mostrando os registros _START_ a _END_ num total de _TOTAL_",
                    "infoFiltered":   "(Filtrados _TOTAL_ de um total de _MAX_ registros)",
                    "paginate": {
                        "first": "Primeiro",
                        "previous": "Anterior",
                        "next": "Seguinte",
                        "last": "Último"
                    },
                    "zeroRecords": "Não foram encontrados resultados",
                },
                //pagingType: "simple_numbers",
                pagingType: "full_numbers", // Todos os links de paginação   "simple_numbers" // Sómente anterior; seguinte e os núemros da página:
                //scrollY: 450,

                // Quando a tabela estiver completamente inicializada(carregada), executa a função abaixo
                initComplete: function (settings, json) {
                    /*
                    // "#dataTableMonitor_length" é o nome atribuido dinamicamente à div onde está localizado o menu de 
                    // de opçoes length. Nesse caso nesta div adicionando um select na toolbar do datatable
                    $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Escolha</label>');
                    $('#dataTableMonitor_length').append('<select id="selectGrupo" class="form-control input-sm" style="height: 36px;"><option value="regi">Regionais</option><option value="muni">Municipios</option><option value="rest">Restaurantes</option></select>');
                    $("#selectGrupo").on('change', function(){
                        alert($(this).children("option:selected").text());
                        //alert(oTable.ajax.data);
                        //oTable.ajax.reload();
                        //oTable.draw();
                    });
                    */
                    //$('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Período:</label>');
                    //$('#dataTableMonitor_length').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px;"><option value="2023" selected>2023</option><option value="2024">2024</option><option value="2025">2025</option></select>');
                }

            });

            $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Compras</label>');
            $('#dataTableMonitor_length').append('<select id="selectGrupo" class="form-control input-sm" style="height: 36px;"><option value="regi">Regionais</option><option value="muni">Municípios</option><option value="rest">Restaurantes</option></select>');
            
            $('#dataTableMonitor_length').append('<label style="margin-left:30px; margin-right:5px">Ano</label>');
            //$('#dataTableMonitor_length').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px;"><option value="2023" selected>2023</option><option value="2024">2024</option><option value="2025">2025</option></select>'); // OU
            $('#dataTableMonitor_length').append('<select id="selectPeriodo" class="form-control input-sm" style="height: 36px;"></select>');
            $.each(anosexibicao, function(indx, valorano) {
                    $('#selectPeriodo').append($('<option></option>').val(valorano).html(valorano));
            });

            
            $("#selectGrupo, #selectPeriodo").on('change', function(){
                //alert($(this).children("option:selected").text());
                //alert(oTable.ajax.data);
                var entidadeSelecionada = $("#selectGrupo").children("option:selected").text();
                periodoAno = $("#selectPeriodo").val();

                switch (entidadeSelecionada){
                    case "Regionais":
                        rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";
                    break;
                    case "Municípios":
                        rotaAjax = "{{route('admin.ajaxgetMunicipiosComprasMensais')}}";
                    break;
                    case "Restaurantes":
                        rotaAjax = "{{route('admin.ajaxgetRestaurantesComprasMensais')}}";
                    break;
                    default:
                        rotaAjax = "{{route('admin.ajaxgetRegionaisComprasMensais')}}";

                }
                $("#entidade").text(entidadeSelecionada);
                $("#mesesdoano").text("COMPRAS POR " + entidadeSelecionada.toUpperCase() + " EM " + periodoAno);
                //oTable.ajax.url("{{route('admin.ajaxgetMunicipiosComprasMensais')}}");
                //oTable.ajax.reload();
                oTable.ajax.url(rotaAjax).load();
            });
         });

    </script>
@endsection




        