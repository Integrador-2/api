
<?php

require_once('database/Connection.php');

class Clientes{

  public function cadastrar(){
    $obDatabase = new Database('clientes');
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
    if ($dados) {
      $dados = json_decode($dados, true);
    }
    if (!$dados) {
      $dados = json_decode(file_get_contents('php://input'), true);
      $dados = $dados['dados'];
    }

    return (new Database('clientes'))->update('id = '.$dados['id'], $dados);
  }

  public function excluir(){
    $parametro = isset($_POST['dados']) ? $_POST['dados'] : null;
    if ($parametro) {
      $parametro = json_decode($parametro, true);
    }
    if (!$parametro) {
      $parametro = json_decode(file_get_contents('php://input'), true);
      $parametro = $parametro['dados'];
    }

    return (new Database('produtos'))->delete('id = '.$parametro);
  }

  public static function getAll($where = null, $order = null, $limit = null){
    return (new Database('clientes'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  public static function get(){
    $parametro = isset($_POST['dados']) ? $_POST['dados'] : null;
    $parametro = json_decode($parametro, true);
    $chave = array_keys($parametro)[0];

    return (new Database('clientes'))->select($chave.'= '.$parametro[$chave])
                                  ->fetchObject(self::class);
  }

  public static function getById() {
    $parametro = isset($_POST['dados']) ? $_POST['dados'] : null;
    $parametro = json_decode($parametro, true);
    if (!$parametro) {
      $parametro = json_decode(file_get_contents('php://input'), true);
      $parametro = $parametro['dados'];
    }    
    return (new Database('produtos'))->select('id = '.$parametro)
                                  ->fetchObject(self::class);
  }

}