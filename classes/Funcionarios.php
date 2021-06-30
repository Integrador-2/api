
<?php

require_once('database/Connection.php');

class Funcionarios{

  public function cadastrar(){
    $obDatabase = new Database('funcionarios');
    $dados = isset($_POST['dados']) ? $_POST['dados'] : null;
    
    if ($dados) {
      $dados = json_decode($dados, true);
    }
    if (!$dados) {
      $dados = json_decode(file_get_contents('php://input'), true);
      $dados = $dados['dados'];
    }

    $dados['senha'] = md5($dados['senha']);
    
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

    return (new Database('funcionarios'))->update('id = '.$dados['id'], $dados);
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
    return (new Database('funcionarios'))->select($where,$order,$limit)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  public static function getAllComEntidades(){
    $query = "SELECT * FROM funcionarios as f, entidades as e WHERE f.registro_entidade = e.id";
    return (new Database('funcionarios'))->selectLivre($query)
                                  ->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  public static function get(){
    $parametro = isset($_POST['dados']) ? $_POST['dados'] : null;
    $parametro = json_decode($parametro, true);
    $chave = array_keys($parametro)[0];

    return (new Database('funcionarios'))->select($chave.'= '.$parametro[$chave])
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

  public static function validaLogin() {
    $dados = isset($_POST['dados']) ? $_POST['dados'] : null;
    
    if ($dados) {
      $dados = json_decode($dados, true);
    }
    if (!$dados) {
      $dados = json_decode(file_get_contents('php://input'), true);
      $dados = $dados['dados'];
    }

    $func = (new Database('funcionarios'))->select('usuario= "' . $dados['usuario'] . '"')
                                          ->fetchObject(self::class);
    $func = json_decode(json_encode($func), true);

    if(md5($dados['senha']) === $func['senha'])
      return array("login" => true, "usuario" => $dados['usuario']);

    return array("login" => false);
  }
}