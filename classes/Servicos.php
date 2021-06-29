
<?php

require_once('database/Connection.php');

class Servicos{

  public function cadastrar(){
    $obDatabase = new Database('servicos');
    $dados = isset($_POST['dados']) ? $_POST['dados'] : null;
    if ($dados) {
      $dados = json_decode($dados, true);
    }
    if (!$dados) {
      $dados = json_decode(file_get_contents('php://input'), true);
      $dados = $dados['dados'];
    }
    
    return $obDatabase->insert($dados);
  }

  public function atualizar(){
    $dados = isset($_POST['dados']) ? $_POST['dados'] : null;
    $dados = json_decode($dados, true);

    return (new Database('servicos'))->update('id = '.$dados['id'], $dados);
  }

  public function excluir(){
    $parametro = isset($_POST['dados']) ? $_POST['dados'] : null;
    $parametro = json_decode($parametro, true);
    $chave = array_keys($parametro)[0];

    return (new Database('servicos'))->delete($chave.'= '.$parametro[$chave]);
  }

  public static function getAll($where = null, $order = null, $limit = null){
    return (new Database('servicos'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  public static function get(){
    $parametro = isset($_POST['dados']) ? $_POST['dados'] : null;
    $parametro = json_decode($parametro, true);
    $chave = array_keys($parametro)[0];

    return (new Database('servicos'))->select($chave.'= '.$parametro[$chave])
                                  ->fetchObject(self::class);
  }

}