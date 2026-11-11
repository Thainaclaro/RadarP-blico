
import { useNavigate } from 'react-router-dom';
import '../style/Home.css';

export function Home() {
  const navigate = useNavigate();

  return (
    <div className="home-container">

      <aside className="menu-lateral">
        <div className="logo">
          <h2>RADAR<span> PÚBLICO</span></h2>
          <small>PLATAFORMA DE CONCURSOS</small>
        </div>

        <nav className="menu-navegacao">
          <span className="menu-titulo">MENU PRINCIPAL</span>

          <button className="menu-item ativo">
            <span>01</span>
            Início
          </button>

          <button
            className="menu-item"
            onClick={() => navigate('/Concursos')}
          >
            <span>02</span>
            Concursos
          </button>

          <button
            className="menu-item"
            onClick={() => navigate('/Favoritos')}
          >
            <span>03</span>
            Favoritos
          </button>

          <span className="menu-titulo">MINHA CONTA</span>

          <button
            className="menu-item"
            onClick={() => navigate('/Perfil')}
          >
            <span>04</span>
            Meu perfil
          </button>
        </nav>

        <button
          className="sair-btn"
          onClick={async () => {
            try {
              await fetch(
                'http://localhost:8000/api/usuarios/logout.php',
                {
                  method: 'POST',
                  credentials: 'include'
                }
              );
            } finally {
              navigate('/');
            }
          }}
        >
          Sair da conta
        </button>
      </aside>

      <main className="home-conteudo">

        <header className="home-header">
          <div>
            <span className="pagina-identificacao">
              PAINEL DO USUÁRIO
            </span>

            <h1>Visão geral</h1>

            <p>
              Acompanhe oportunidades e organize sua busca por concursos.
            </p>
          </div>

          <button
            className="perfil-header"
            onClick={() => navigate('/Perfil')}
          >
            Meu perfil
          </button>
        </header>

        <section className="boas-vindas">
          <div>
            <span>RADAR PÚBLICO</span>

            <h2>Seu próximo objetivo começa aqui.</h2>

            <p>
              Consulte concursos públicos, acompanhe editais
              e encontre oportunidades de acordo com seu perfil.
            </p>

            <button onClick={() => navigate('/Concursos')}>
              Explorar concursos
            </button>
          </div>
        </section>

        <section className="indicadores">
          <article className="indicador-card">
            <span>CONCURSOS DISPONÍVEIS</span>
            <strong>0</strong>
            <p>Oportunidades cadastradas</p>
          </article>

          <article className="indicador-card">
            <span>MEUS FAVORITOS</span>
            <strong>0</strong>
            <p>Concursos salvos por você</p>
          </article>

          <article className="indicador-card">
            <span>MEU PERFIL</span>
            <strong>01</strong>
            <p>Perfil cadastrado</p>
          </article>
        </section>

        <section className="secao-concursos">
          <div className="secao-header">
            <div>
              <span className="pagina-identificacao">
                OPORTUNIDADES
              </span>
              <h2>Concursos recentes</h2>
            </div>

            <button
              className="ver-todos"
              onClick={() => navigate('/Concursos')}
            >
              Ver todos
            </button>
          </div>

          <div className="estado-vazio">
            <div className="estado-linha"></div>

            <h3>Nenhum concurso disponível no momento</h3>

            <p>
              Assim que novos concursos forem cadastrados,
              eles aparecerão nesta área.
            </p>

            <button onClick={() => navigate('/Concursos')}>
              Consultar concursos
            </button>
          </div>
        </section>

      </main>
    </div>
  );
}

