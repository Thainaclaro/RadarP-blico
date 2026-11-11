
import { useEffect, useState } from "react";
import "../style/Perfil.css";

function Perfil() {
  const [usuario, setUsuario] = useState(null);
  const [carregando, setCarregando] = useState(true);

  useEffect(() => {
    fetch("http://localhost:8000/api/usuarios/verificar_sessao.php", {
      method: "GET",
      credentials: "include"
    })
      .then((resposta) => {
        if (!resposta.ok) {
          throw new Error("Sessão não encontrada");
        }

        return resposta.json();
      })
      .then((dados) => {
        setUsuario(dados.usuario);
      })
      .catch(() => {
        window.location.href = "/";
      })
      .finally(() => {
        setCarregando(false);
      });
  }, []);

  function sair() {
    fetch("http://localhost:8000/api/usuarios/logout.php", {
      method: "POST",
      credentials: "include"
    }).then(() => {
      window.location.href = "/";
    });
  }

  if (carregando) {
    return <p>Carregando perfil...</p>;
  }

  if (!usuario) {
    return null;
  }

  return (
    <div className="perfil-container">
      <div className="perfil-card">

        <div className="perfil-icon">👤</div>

        <h1>Meu Perfil</h1>

        <div className="perfil-info">

          <div className="campo-perfil">
            <span>Nome</span>
            <p>{usuario.nome}</p>
          </div>

          <div className="campo-perfil">
            <span>E-mail</span>
            <p>{usuario.email}</p>
          </div>

          <div className="campo-perfil">
            <span>Tipo de conta</span>
            <p>Usuário</p>
          </div>

        </div>

        <button className="editar-btn">
          Editar perfil
        </button>

        <button className="editar-btn" onClick={sair}>
          Sair da conta
        </button>

        <a href="/" className="voltar">
          Voltar
        </a>

      </div>
    </div>
  );
}

export default Perfil;

