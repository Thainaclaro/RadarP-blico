
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import "../style/Concursos.css";

export default function Concursos() {
  const navigate = useNavigate();

  const [pesquisa, setPesquisa] = useState("");
  const [escolaridade, setEscolaridade] = useState("");
  const [estado, setEstado] = useState("");
  const [status, setStatus] = useState("");

  const [concursos, setConcursos] = useState([]);
  const [carregando, setCarregando] = useState(true);
  const [erro, setErro] = useState("");

  // Buscar concursos no banco de dados
  useEffect(() => {
    async function buscarConcursos() {
      try {
        const resposta = await fetch(
          "http://localhost:8000/api/listar_concursos.php",
          {
            method: "GET",
            credentials: "include"
          }
        );

        const dados = await resposta.json();

        if (!resposta.ok || dados.status !== "sucesso") {
          throw new Error("Não foi possível carregar os concursos.");
        }

        setConcursos(dados.concursos || []);

      } catch (error) {
        setErro(error.message);
      } finally {
        setCarregando(false);
      }
    }

    buscarConcursos();
  }, []);

  // Filtrar concursos
  const concursosFiltrados = concursos.filter((concurso) => {
    const termo = pesquisa.toLowerCase();

    const correspondePesquisa =
      (concurso.titulo || "").toLowerCase().includes(termo) ||
      (concurso.orgao || "").toLowerCase().includes(termo) ||
      (concurso.cargo || "").toLowerCase().includes(termo);

    return (
      correspondePesquisa &&
      (escolaridade === "" || concurso.escolaridade === escolaridade) &&
      (estado === "" || concurso.estado === estado) &&
      (status === "" || concurso.status === status)
    );
  });

  // Formatar salário
  function formatarSalario(valor) {
    if (valor === null || valor === undefined || valor === "") {
      return "Não informado";
    }

    return Number(valor).toLocaleString("pt-BR", {
      style: "currency",
      currency: "BRL"
    });
  }

  // Formatar data
  function formatarData(data) {
    if (!data) {
      return "Não informado";
    }

    const [ano, mes, dia] = data.split("-");
    return `${dia}/${mes}/${ano}`;
  }

  return (
    <div className="concursos-container">

      {/* MENU LATERAL */}
      <aside className="concursos-sidebar">

        <div className="concursos-logo">
          <h2>RADAR <span>PÚBLICO</span></h2>
          <small>PLATAFORMA DE CONCURSOS</small>
        </div>

        <nav>
          <button onClick={() => navigate("/Home")}>
            Início
          </button>

          <button className="selecionado">
            Concursos
          </button>

          <button onClick={() => navigate("/Favoritos")}>
            Favoritos
          </button>

          <button onClick={() => navigate("/Perfil")}>
            Meu perfil
          </button>
        </nav>

        <button
          className="concursos-sair"
          onClick={async () => {
            try {
              await fetch(
                "http://localhost:8000/api/usuarios/logout.php",
                {
                  method: "POST",
                  credentials: "include"
                }
              );
            } finally {
              navigate("/");
            }
          }}
        >
          Sair da conta
        </button>

      </aside>

      {/* CONTEÚDO PRINCIPAL */}
      <main className="concursos-main">

        <header className="concursos-header">
          <div>
            <span>OPORTUNIDADES</span>
            <h1>Concursos públicos</h1>
            <p>
              Encontre oportunidades e acompanhe processos seletivos.
            </p>
          </div>

          <button onClick={() => navigate("/Home")}>
            Voltar ao início
          </button>
        </header>

        {/* PESQUISA */}
        <section className="concursos-pesquisa">

          <label htmlFor="pesquisa">
            Pesquisar concurso, órgão ou cargo
          </label>

          <input
            id="pesquisa"
            type="text"
            placeholder="Digite o nome do concurso, órgão ou cargo..."
            value={pesquisa}
            onChange={(e) => setPesquisa(e.target.value)}
          />

        </section>

        {/* FILTROS */}
        <section className="concursos-filtros">

          <div>
            <label htmlFor="escolaridade">
              Escolaridade
            </label>

            <select
              id="escolaridade"
              value={escolaridade}
              onChange={(e) => setEscolaridade(e.target.value)}
            >
              <option value="">Todas</option>
              <option value="Fundamental">Fundamental</option>
              <option value="Médio">Médio</option>
              <option value="Técnico">Técnico</option>
              <option value="Superior">Superior</option>
            </select>
          </div>

          <div>
            <label htmlFor="estado">
              Estado
            </label>

            <select
              id="estado"
              value={estado}
              onChange={(e) => setEstado(e.target.value)}
            >
              <option value="">Todos</option>
              <option value="SP">São Paulo</option>
              <option value="RJ">Rio de Janeiro</option>
              <option value="MG">Minas Gerais</option>
              <option value="PR">Paraná</option>
            </select>
          </div>

          <div>
            <label htmlFor="status">
              Situação
            </label>

            <select
              id="status"
              value={status}
              onChange={(e) => setStatus(e.target.value)}
            >
              <option value="">Todas</option>
              <option value="aberto">Inscrições abertas</option>
              <option value="previsto">Previstos</option>
              <option value="encerrado">Encerrados</option>
            </select>
          </div>

        </section>

        {/* RESULTADOS */}
        <section className="concursos-resultados">

          <div className="resultados-titulo">
            <h2>Oportunidades encontradas</h2>

            <span>
              {concursosFiltrados.length} resultados
            </span>
          </div>

          {carregando && (
            <div className="concursos-vazio">
              <p>Carregando concursos...</p>
            </div>
          )}

          {!carregando && erro && (
            <div className="concursos-vazio">
              <h3>Não foi possível carregar os concursos</h3>
              <p>{erro}</p>
            </div>
          )}

          {!carregando && !erro && concursosFiltrados.length === 0 && (
            <div className="concursos-vazio">
              <h3>Nenhum concurso encontrado</h3>
              <p>
                Ainda não existem oportunidades cadastradas
                ou os filtros não encontraram resultados.
              </p>
            </div>
          )}

          {!carregando && !erro && concursosFiltrados.length > 0 && (
            <div className="lista-concursos">

              {concursosFiltrados.map((concurso) => (
                <article
                  className="concurso-card"
                  key={concurso.id}
                >

                  <h3>{concurso.titulo}</h3>

                  <p><strong>Órgão:</strong> {concurso.orgao}</p>

                  <p><strong>Cargo:</strong> {concurso.cargo || "Não informado"}</p>

                  <p><strong>Banca:</strong> {concurso.banca || "Não informada"}</p>

                  <p><strong>Escolaridade:</strong> {concurso.escolaridade || "Não informada"}</p>

                  <p><strong>Estado:</strong> {concurso.estado || "Não informado"}</p>

                  <p><strong>Vagas:</strong> {concurso.quantidade_vagas ?? "Não informado"}</p>

                  <p><strong>Salário:</strong> {formatarSalario(concurso.salario)}</p>

                  <p>
                    <strong>Fim das inscrições:</strong>{" "}
                    {formatarData(concurso.inscricao_fim)}
                  </p>

                  <p>
                    <strong>Situação:</strong>{" "}
                    {concurso.status === "aberto"
                      ? "Inscrições abertas"
                      : concurso.status === "previsto"
                      ? "Previsto"
                      : "Encerrado"}
                  </p>

                  {concurso.edital_url && (
                    <a
                      href={concurso.edital_url}
                      target="_blank"
                      rel="noopener noreferrer"
                    >
                      Consultar edital
                    </a>
                  )}

                </article>
              ))}

            </div>
          )}

        </section>

      </main>
    </div>
  );
}

