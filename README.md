# Vitor de Sousa da Silva
#### Linkedin: [https://www.linkedin.com/in/vitorssilva/](https://www.linkedin.com/in/vitorssilva/) |  Github: [https://www.github.com/vitordesousa](https://www.github.com/vitordesousa)

## Processo Seletivo | Desenvolvedor ALFASOFT


### Descrição do Projeto
Este projeto é uma aplicação web desenvolvida para o processo seletivo da ALFASOFT, utilizando a linguagem de programação PHP e o framework Laravel (na versão disponibilizada 10.x). 
A aplicação tem como objetivo fornecer uma plataforma para gerenciamento de contatos, onde os usuários podem listar, criar, visualizar, editar e excluir seus contatos.
A listagem de contatos fica vísivel para o usuário sem a necessidade de login, mas a criação, edição e exclusão fica disponível apenas para usuários autenticados.


### Funcionalidades
- Listar contatos: Os usuários podem visualizar uma lista de contatos cadastrados, exibindo informações como nome, email e telefone.
- Criar contato: Os usuários autenticados podem adicionar novos contatos à lista, fornecendo informações como nome, email e telefone.
- Visualizar contato: Os usuários podem clicar em um contato para visualizar detalhes adicionais, como endereço e data de nascimento.
- Editar contato: Os usuários autenticados podem editar as informações de um contato existente, atualizando os campos necessários.
- Excluir contato: Os usuários autenticados podem excluir um contato da lista, removendo-o permanentemente do sistema.


### Bônus/Features
1. Criei a funcionalidade de buscar contatos apenas para usuários logados
2. Implementei Throttle para os requests da listagem de contatos, limitando a 10 requisições por minuto para os visitantes para evitar sobrecarga no servidor.
3. Criei Eventos e Listeners do CRUD de contatos para que se for de interesse seja enviado por exemplo para o CRM (fictício) através de filas a criação/edição/exclusão de um contato, ou para o Log do sistema 
4. Implementei testes unitários para as funcionalidades de criação, edição e exclusão de contatos, garantindo a qualidade e estabilidade do código.
5. Utilizei o recurso de Eloquent ORM do Laravel para facilitar a manipulação dos dados e garantir uma estrutura de banco de dados eficiente.
6. Queries de Manipulação de dados foram feitas dentro do Repository, seguindo o padrão de projeto Repository para separar a lógica de acesso a dados da lógica de negócios.
7. Implementei Actions para não deixar os Controllers inchados, seguindo o princípio de responsabilidade única e mantendo o código mais organizado e fácil de manter.
8. Implementei DTOs para criação e edição de contatos, garantindo uma estrutura de dados clara e consistente para as operações de criação e edição de contatos.
9. Implementei Logs de erros para as operações de criação, edição e exclusão de contatos, registrando informações relevantes para monitoramento em caso de falhas ou problemas no sistema.
10. Conforme solicitado, utilizei autenticação de usuários para o CRUD de contatos e também usei Form Requests para validar os dados de entrada, garantindo que apenas usuários autenticados possam realizar operações de criação e edição, e que os dados fornecidos sejam válidos antes de serem processados pelo sistema.
