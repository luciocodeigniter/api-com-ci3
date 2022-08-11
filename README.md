
# API Rest com Codeigniter 3 na versão 3.1.13

### Esse é um pequeno projeto realizado com Codeigniter 3 na versão 3.1.13, com o propósito de criar uma API Rest para a Gestão de Impressoras.

*******************
### Requerimentos do servidor
*******************

- PHP versão 5.6 ou mais recente é recomendado. Testado na versão PHP 8.1.4.
- MySQL (5.1+) Testado na versão 5.7.33


*********
### Para as coisas funcionarem adequadamente, vamos seguir alguns passos:
*********

1. Abra o arquivo ```application/config/config.php``` e altere as propriedades conforme a seguir:

        
        $config['base_url'] = 'http://seu-site-lindo/';
        $config['index_page'] = '';
        

2. Crie seu banco de dados no seu servidor local (XAMP, Laragon, etc).

3. Após acriação, abra o arquivo ```application/config/database.php``` e coloque as informações do seu banco de dados.

        
        'hostname' => 'localhost',
        'username' => 'seu-usuario',  
        'password' => 'sua-senha',  
        'database' => 'seu-banco',  
        
        

4. Precisamos criar no seu banco de dados as tabelas ```migrations e printers```, portanto, execute a seguinte URL no seu navegador:

        http://seu-site-lindo/migrate
        

5. PRONTO! Já estamos prontos para consumir os endpoints da API.


*********
### Consumindo os endpoints. Por favor tenha em mente que as rotas da API foram criadas para dar suporte ao roteamento REST-ful. Para enviar requisições ```POST, PUT ou DELETE```, você poderá utilizar o [Postman](https://www.postman.com/downloads/).
*********


Para listar as impressoras - faça uma requisição ```GET``` para a seguinte rota:

```sh
http://seu-site-lindo/api/printers
```


Para recuperar uma determinada impressora - faça uma requisição ```GET``` para a seguinte rota:

```sh
http://seu-site-lindo/api/printers/1
```

Para criar uma impressora - faça uma requisição ```POST``` para a seguinte rota:

```sh
http://seu-site-lindo/api/printers
```

Para atualizar uma determinada impressora - faça uma requisição ```PUT``` para a seguinte rota:

```sh
http://seu-site-lindo/api/printers/1
```

Para excluir uma determinada impressora - faça uma requisição ```DELETE``` para a seguinte rota:

```sh
http://seu-site-lindo/api/printers/1
```

