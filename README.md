# api
Api para requisição dos dados do banco de dados

--Como usar a api:

1. Criar o banco conforme o arquivo database.txt
2. Fazer um GET ou POST para a tabela e ação desejada. Exemplo:
  -http://localhost/api/entidades/getAll
  
  -O exemplo acima irá retornar todos os registros da tabela entidades
  -No caso de insert/update, os dados devem ser passados no body da requisicao em formato JSON
  
 *Consultar as classes para ver todos os métodos disponíveis
