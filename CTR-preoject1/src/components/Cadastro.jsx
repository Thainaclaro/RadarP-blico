
 import "../style/Cadastro.css";

function Cadastro() {
  return (
    <div className="cadastro-container">

      <div className="cadastro-card">

        <h1>Cadastro</h1>

        <form method="Post" action={""}>

          <input type="text" placeholder="Nome completo" required/>

          <input type="email"placeholder="Digite seu e-mail"required/>

          <input type="password" placeholder="Digite sua senha" required/>

          <input type="password" placeholder="Confirme sua senha" required/>
         
          <input id="button" type="submit" value="Enviar" />
        </form>

        <a href="/" className="voltar">Já tenho uma conta</a>

      </div>

    </div>
  );
}

export default Cadastro;
