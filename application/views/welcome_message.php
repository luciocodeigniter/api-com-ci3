<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>API Rest com Codeigniter 3</title>

    <style type="text/css">
    ::selection {
        background-color: #E13300;
        color: white;
    }

    ::-moz-selection {
        background-color: #E13300;
        color: white;
    }

    body {
        background-color: #fff;
        margin: 40px;
        font: 13px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
    }

    a {
        color: #003399;
        background-color: transparent;
        font-weight: normal;
        text-decoration: none;
    }

    a:hover {
        color: #97310e;
    }

    h1,
    h2,
    h3 {
        color: #444;
        background-color: transparent;
        border-bottom: 1px solid #D0D0D0;
        font-size: 19px;
        font-weight: normal;
        margin: 0 0 14px 0;
        padding: 14px 15px 10px 15px;
    }

    code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 12px;
        background-color: #f9f9f9;
        border: 1px solid #D0D0D0;
        color: #002166;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
    }

    #body {
        margin: 0 15px 0 15px;
        min-height: 96px;
    }

    p {
        margin: 0 0 10px;
        padding: 0;
    }

    p.footer {
        text-align: right;
        font-size: 11px;
        border-top: 1px solid #D0D0D0;
        line-height: 32px;
        padding: 0 10px 0 10px;
        margin: 20px 0 0 0;
    }

    #container {
        margin: 10px;
        border: 1px solid #D0D0D0;
        box-shadow: 0 0 8px #D0D0D0;
    }
    </style>
</head>

<body>

    <div id="container">
        <h1>API Rest com Codeigniter 3 na versão <strong><?php echo CI_VERSION ?></strong>!</h1>

        <div id="body">
            <p>Esse é um pequeno projeto realizado com Codeigniter 3 na versão
                <strong><?php echo CI_VERSION ?></strong>, com o propósito de criar um API Rest para a Gestão de
                Impressoras.
            </p>
            <h2>Para as coisas funcionarem adequadamente, vamos seguir alguns passos:</h2>
            <ul>
                <li><strong>1 - passo</strong> - Crie seu banco de dados no seu servidor local (XAMP, Laragon, etc)</li>
                <li><strong>2 - passo</strong> - Após acriação, abra o arquivo:
                    <code>application\config\database.php</code> e coloque as informações confome a seguir:
                    <code>
				///...<br>
				'hostname' => 'localhost',<br>
				'username' => 'seu-usuario',<br>
				'password' => 'sua-senha',<br>
				'database' => 'seu-banco',<br>
				///...<br>
				</code>
                </li>
                <li><strong>3 - passo</strong> - execute no seu navegador a seguinte URL: <code>http://seu-site-lindo/migrate</code>
                    A URL acima criará no seu banco de dados as tabelas <code>migrations e printers</code></li>
                <li><strong>PRONTO!</strong> - Isso é tudo que precisa fazer!</li>
            </ul>

            <hr>
            <h3>
                Consumindo os endpoints. Por favor tenha em mente que as rotas da API foram criadas para dar suporte ao
                roteamento <strong>REST-ful</strong>.
                Para enviar requisições <strong>POST, PUT ou DELETE</strong>, você poderá utilizar o <a
                    href="https://www.postman.com/downloads/">Postman</a>
            </h3>
            <ul>

                <li>
                    <strong>Para listar as impressoras</strong> - faça uma requisição <strong>GET</strong> para a
                    seguinte rota:
                    <code>http://seu-site-lindo/api/printers</code>
                </li>

                <li>
                    <strong>Para recuperar uma determinada impressora</strong> - faça uma requisição
                    <strong>GET</strong> para a seguinte rota:
                    <code>http://seu-site-lindo/api/printers/1</code>
                </li>

                <li>
                    <strong>Para criar uma impressora</strong> - faça uma requisição <strong>POST</strong> para a
                    seguinte rota:
                    <code>http://seu-site-lindo/api/printers</code>
                </li>

                <li>
                    <strong>Para atualizar uma determinada impressora</strong> - faça uma requisição
                    <strong>PUT</strong> para a seguinte rota:
                    <code>http://seu-site-lindo/api/printers/1</code>
                </li>

                <li>
                    <strong>Para excluir uma determinada impressora</strong> - faça uma requisição
                    <strong>DELETE</strong> para a seguinte rota:
                    <code>http://seu-site-lindo/api/printers/1</code>
                </li>


            </ul>

        </div>

        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.
            <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
        </p>
    </div>

</body>

</html>