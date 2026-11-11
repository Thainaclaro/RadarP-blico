🔎 Radar Público

Plataforma de busca e organização de concursos públicos

📌 Sobre o projeto

O Radar Público é uma aplicação desenvolvida com o objetivo de facilitar a busca, organização e consulta de informações sobre concursos públicos.

A plataforma busca centralizar informações de diferentes publicações oficiais, permitindo que os usuários encontrem oportunidades de acordo com seus interesses e perfil profissional.

O projeto surgiu da necessidade de tornar a busca por concursos públicos mais organizada, acessível e prática, reduzindo o trabalho de procurar informações manualmente em diferentes fontes.

🎯 Objetivo

Desenvolver uma plataforma capaz de coletar, armazenar e disponibilizar informações sobre concursos públicos, proporcionando uma experiência de pesquisa mais eficiente e personalizada.

⚙️ Funcionalidades desenvolvidas

- Cadastro de usuários.
- Login e autenticação por sessão.
- Verificação de sessão ativa.
- Encerramento de sessão.
- Conexão com banco de dados.
- Coleta de publicações do Diário Oficial da União (DOU).
- Extração de informações das publicações.
- Identificação e classificação de publicações relacionadas a concursos.
- Identificação de possíveis novos editais.
- Prevenção de registros duplicados por identificador de publicação.

🛠️ Tecnologias utilizadas

Tecnologia| Aplicação
PHP| Desenvolvimento do backend e APIs
React| Desenvolvimento da interface
JavaScript| Funcionalidades do frontend
MariaDB| Armazenamento de informações
MySQL / PDO| Conexão e manipulação do banco de dados
HTML5| Estrutura das páginas
CSS3| Estilização da interface
Git e GitHub| Versionamento e documentação

🏗️ Arquitetura do projeto

O projeto foi organizado em duas partes principais:

Backend

- Responsável pela comunicação com o banco de dados.
- Processamento das requisições.
- Autenticação de usuários.
- Coleta e extração de publicações oficiais.

Frontend

- Interface desenvolvida com React.
- Componentes para login, cadastro, perfil e visualização de concursos.
- Comunicação com os serviços do backend.

📂 Estrutura do projeto

RadarP-blico/
│
├── backend/
│   ├── api/
│   │   ├── usuarios/
│   │   ├── health.php
│   │   ├── listar_concursos.php
│   │   └── cadastrar_concurso.php
│   │
│   ├── config/
│   │   └── database.php
│   │
│   └── coleta/
│       ├── buscar_concursos.php
│       ├── extrair_resultados.php
│       └── arquivos de coleta
│
├── src/
│   ├── components/
│   └── App.jsx
│
├── public/
│
├── package.json
└── README.md

🗄️ Banco de dados

O projeto utiliza MariaDB para armazenar informações dos usuários e concursos públicos.

A tabela de concursos contempla informações como:

- Identificador da publicação.
- Título do edital.
- Órgão responsável.
- Cargo.
- Banca organizadora.
- Escolaridade.
- Área de atuação.
- Estado e cidade.
- Quantidade de vagas.
- Salário.
- Período de inscrições.
- Link do edital.
- Status do concurso.

📚 Aprendizados

Durante o desenvolvimento, foram trabalhados conceitos importantes de Desenvolvimento de Sistemas:

- Desenvolvimento de aplicações com PHP.
- Integração entre frontend e backend.
- Manipulação de banco de dados relacionais.
- Utilização de PDO e consultas preparadas.
- Autenticação e gerenciamento de sessões.
- Consumo e processamento de informações.
- Manipulação de arquivos e dados JSON.
- Versionamento de código com Git e GitHub.

🚀 Possíveis melhorias futuras

- Aprimorar a extração automática de informações dos editais.
- Implementar filtros personalizados de concursos.
- Desenvolver um painel administrativo.
- Integrar recursos de inteligência artificial para interpretação de editais.
- Implementar notificações de novas oportunidades.

👩‍💻 Desenvolvedora

Projeto desenvolvido por Thaina, como parte dos estudos e da prática em Desenvolvimento de Sistemas.

---

Projeto: Radar Público
Categoria: Desenvolvimento Web / Sistema de Informação
Status: Protótipo desenvolvido.
