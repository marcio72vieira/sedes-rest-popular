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
