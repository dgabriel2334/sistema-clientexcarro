# Teste técnico JN2
Crud com REST api
Steps for executing :

1. Após baixar/clonar o repositório.

2. Altere as variáveis de ambiente do MySQL no arquivo docker-compose.yml, se necessário.


3. Abra o terminal e vá para o diretório onde o docker-compose.yml está localizado e execute o comando abaixo:

   docker-compose up -d --build

4. O passo 3 irá baixar todas as dependências, instalá-lo e configurar o container docker. Depois de executar o comando na etapa 3, ele iniciaria 3 contêineres. Um para MySQL outro para o CRUD e outro para o phpmyadmin. Também criaria o banco de dados CRUD no MySQL.


5. Execute o comando abaixo para obter a lista de contêineres em execução:

docker ps

6. Depois de executar as etapas acima com sucesso, abra o navegador e execute o URL abaixo:

http://localhost:8000/

7. Após isso você poderá usar o CRUD 
