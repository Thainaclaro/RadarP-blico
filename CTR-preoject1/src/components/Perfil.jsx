import "../style/Perfil.css";

function Perfil() {
  return (
    <div className="perfil-container">

      <div className="perfil-card">

        <div className="perfil-icon">
          👤
        </div>

        <h1>Meu Perfil</h1>

        <div className="perfil-info">
          <div className="campo-perfil">
            <span>Nome</span>
            <p>Seu nome</p>
          </div>

          <div className="campo-perfil">
            <span>Sobrenome</span>
            <p>Seu sobrenome</p>
          </div>

          <div className="campo-perfil">
            <span>Interesse</span>
            <p>Concursos Públicos</p>
          </div>

          <div className="campo-perfil">
            <span>Data de nascimento</span>
            <p>00/00/0000</p>
          </div>

          <div className="campo-perfil">
            <span>Escolaridade</span>
            <p>Ensino Médio</p>
          </div>

          <div className="campo-perfil">
            <span>Tipo de concurso</span>
            <p>Escolha seu interesse</p>
          </div>
        </div>

        <button className="editar-btn">
          Editar perfil
        </button>

        <a href="/" className="voltar">
          Voltar
        </a>

      </div>

    </div>
  );
}

export default Perfil;