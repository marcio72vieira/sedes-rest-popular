<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Produto;
use App\Http\Requests\ProdutoCreateRequest;
use App\Http\Requests\ProdutoUpdateRequest;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;

use File;

class ProdutoController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware(['auth', 'can:adm']);
    }


    public function index()
    {
        /*
        Exemplo rústico de registro de log.
        $data = json_encode([time(),'produto','lista', session('idUsuarioLogado'), session('nameUsuarioLogado')]);
        $file = time() .rand(). '_file.json';
        $destinationPath=public_path()."/upload/";
        if (!is_dir($destinationPath)) {  mkdir($destinationPath,0777,true);  }
        File::put($destinationPath.$file,$data);
        //return response()->download($destinationPath.$file);
        */

        $produtos = Produto::all();
        return view('admin.produto.index', compact('produtos'));
    }


    public function create()
    {
        $categorias = Categoria::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        return view('admin.produto.create', compact('categorias'));
    }


    public function store(ProdutoCreateRequest $request)
    {
        Produto::create($request->all());

        $request->session()->flash('sucesso', 'Registro incluído com sucesso!');

        return redirect()->route('admin.produto.index');
    }


    public function show($id)
    {
        $categorias = Categoria::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();
        $produto = Produto::findOrFail($id);

        return view('admin.produto.show', compact('categorias', 'produto'));
    }


    public function edit($id)
    {
        $produto = Produto::findOrFail($id);
        $categorias = Categoria::where('ativo', '=', '1')->orderBy('nome', 'ASC')->get();

        return view('admin.produto.edit', compact('categorias', 'produto'));
    }


    public function update($id, ProdutoUpdateRequest $request)
    {
        $produto = Produto::findOrFail($id);

        // Validação unique
        Validator::make($request->all(), [
            'nome' => [
                'required',
                Rule::unique('produtos')->ignore($produto->id),
            ],
        ]);

        $produto->update($request->all());

        // Alterando dados na bigtable_data, se além do nome do produto for alterado sua categoria de origem.
        if($request->categoria_id != $request->categoria_id_old_hidden){
            $nova_categoria = Categoria::findOrFail($request->categoria_id);
            $novo_nome_categoria = $nova_categoria->nome;                     // Recupera o nome da categoria
            
            $affected = DB::table('bigtable_data')->where('produto_id', '=',  $id)->update(['produto_nome' => $produto->nome, 'categoria_id' => $produto->categoria_id, 'categoria_nome' => $novo_nome_categoria]);
        } else {
            $affected = DB::table('bigtable_data')->where('produto_id', '=',  $id)->update(['produto_nome' => $produto->nome]);
        }

        // $request->session()->flash('sucesso', "$affected Registro atualizado com sucesso!");
        $request->session()->flash('sucesso', 'Registro atualizado com sucesso!');

        return redirect()->route('admin.produto.index');
    }


    public function destroy($id, Request $request)
    {
        Produto::destroy($id);

        $request->session()->flash('sucesso', 'Registro excluído com sucesso!');

        return redirect()->route('admin.bairro.index');

    }



    /***************************************/
    /*    RELATÓRIOS PDF's, Excel e CSV    */
    /***************************************/

    public function relpdfproduto()
    {
        // Obtendo os dados
        $produtos =  Produto::with('categoria')->orderBy('nome', 'ASC')->get();

        // Definindo o nome do arquivo a ser baixado
        $fileName = ('Produtos_lista.pdf');

        // Invocando a biblioteca mpdf e definindo as margens do arquivo
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 32,
            'margin_bottom' => 15,
            'margin-header' => 10,
            'margin_footer' => 5
        ]);

        // Configurando o cabeçalho da página
        $mpdf->SetHTMLHeader('
            <table style="width:717px; border-bottom: 1px solid #000000; margin-bottom: 3px;">
                <tr>
                    <td style="width: 83px">
                        <img src="images/logo-ma.png" width="80"/>
                    </td>
                    <td style="width: 282px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                        Governo do Estado do Maranhão<br>
                        Secretaria de Governo<br>
                        Secreatia Adjunta de Tecnologia da Informação/SEATI<br>
                        Secretaria do Estado de Desenvolvimento Social/SEDES
                    </td>
                    <td style="width: 352px;" class="titulo-rel">
                        PRODUTOS
                    </td>
                </tr>
            </table>
            <table style="width:717px; border-collapse: collapse;">
                <tr>
                    <td width="50px" class="col-header-table">ID</td>
                    <td width="276px" class="col-header-table">NOME</td>
                    <td width="275px" class="col-header-table">CATEGORIA</td>
                    <td width="115px" class="col-header-table">ATIVO</td>
                </tr>
            </table>
        ');

        // Configurando o rodapé da página
        $mpdf->SetHTMLFooter('
            <table style="width:717px; border-top: 1px solid #000000; font-size: 10px; font-family: Arial, Helvetica, sans-serif;">
                <tr>
                    <td width="239px">São Luis(MA) {DATE d/m/Y}</td>
                    <td width="239px" align="center"></td>
                    <td width="239px" align="right">{PAGENO}/{nbpg}</td>
                </tr>
            </table>
        ');


        // Definindo a view que deverá ser renderizada como arquivo .pdf e passando os dados da pesquisa
        $html = \View::make('admin.produto.pdf.pdfproduto', compact('produtos'));
        $html = $html->render();

        // Definindo o arquivo .css que estilizará o arquivo blade na view ('admin.produto.pdf.pdfproduto')
        $stylesheet = file_get_contents('pdf/mpdf.css');
        $mpdf->WriteHTML($stylesheet, 1);

        // Transformando a view blade em arquivo .pdf e enviando a saida para o browse (I); 'D' exibe e baixa para o pc
        $mpdf->WriteHTML($html);
        $mpdf->Output($fileName, 'I');

        //return view('admin.produto.pdf.pdfproduto', compact('produtos'));
    }



}
