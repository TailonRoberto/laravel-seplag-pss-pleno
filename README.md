# laravel-seplag-pss
PSS 02/2025SEPLAG (Analista de TI - Sênior)

- **Nome:** Tatilon Roberto Lino de Souza
- **Cargo:** Desenvolvedor PHP 
- **Protocolo de Inscrição:** [Número do Protocolo]


//-- O sistema contempla todas as funcionalidades exigidas no Edital, bem como os requisitos essenciais para garantir seu pleno funcionamento, segurança, confiabilidade e escalabilidade.
//-- tambem estám disponiveis dois arquivos dentro da pasta ToolsTest (Projeto Seplag-Pss.postman_collection.json / cors-test.html)
//-- esses arquivos foram criados com o intuito de facilitar/adiantar os testes.

lista de funcionalidade Implementadas: 

- Autenticação com expiração e renovação de token (5 min)
- Restrições de CORS conforme especificado
- CRUD completo para:
  - Servidor Efetivo
  - Servidor Temporário
  - Unidade
  - Lotação
- Consulta por `unid_id` com nome, idade, unidade e fotografia
- Consulta de endereço funcional por parte do nome do servidor
- Upload de imagens para Min.IO
- Recuperação de imagens via links temporários com expiração de 5 minutos
- Paginação em todas as listagens
- Orquestração completa com Docker Compose

Tecnologias:

- PHP 8.2 (Laravel 12)
- PostgreSQL (última versão)
- Min.IO (S3-compatible object storage)
- Docker / Docker Compose

Requesitos para execução: 

- Docker
- Docker Compose

Executando: 
   
    1º  Clone o Repositório 
    2º  Execute o Comando: docker-compose up --build
    3º  Execute o Comando: docker-compose exec app php artisan key:generate
    4º  Execute o comando: docker-compose exec app php artisan migrate:fresh --seed

    5º Acesse o sistema:

        API Laravel: http://localhost:8000

        Min.IO: http://localhost:9000 (usuário: minioadmin, senha: minioadmin)

        Console Min.IO: http://localhost:9001

    6º Carregue o arquivo (Projeto Seplag-Pss.postman_collection.json) importando-o para o postman
      - ao importar o projeto você simplementente pode ir testando as todas pois os dados necessarios ja estaram preenchidos

    7º Caso não for utilizar o arquivo "Projeto Seplag-Pss.postman_collection.json" então vc terá que fazer o login para se autenticar usando essas credenciais 
      {
             "email": "admin@example.com",
                "password": "password"
      }

    8º Caso queria testar o Cors temos um comentário no "src\config\cors.php" e o arquivo (cors-test.html) que irá ajudar a fazer um teste pratico e rápido. 




       





