
<?php

require_once('database/Connection.php');

class Funcionarios{

  public function cadastrar(){
    $obDatabase = new Database('funcionarios');
    $dados = isset($_POST['dados']) ? $_POST['dados'] : null;
    $dados = json_decode($dados, true);
    
    return $obDatabase->insert($dados);
  }

  public function atualizar(){
    $dados = isset($_POST['dados']) ? $_POST['dados'] : null;
    $dados = json_decode($dados, true);

    return (new Database('funcionarios'))->update('id = '.$dados['id'], $dados);
  }

  public function excluir(){
    $parametro = isset($_POST['dados']) ? $_POST['dados'] : null;
    $parametro = json_decode($parametro, true);
    $chave = array_keys($parametro)[0];

    return (new Database('funcionarios'))->delete($chave.'= '.$parametro[$chave]);
  }

  public static function getAll($where = null, $order = null, $limit = null){
    return (new Database('funcionarios'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  public static function get(){
    $parametro = isset($_POST['dados']) ? $_POST['dados'] : null;
    $parametro = json_decode($parametro, true);
    $chave = array_keys($parametro)[0];

    return (new Database('funcionarios'))->select($chave.'= '.$parametro[$chave])
                                  ->fetchObject(self::class);
  }

}