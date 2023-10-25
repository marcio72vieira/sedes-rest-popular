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
