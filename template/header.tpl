<html lang="en">

<head>
    <base href="{BASE_URL}">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <div class="padre">

        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-primary mb-3">
                <a class="navbar-brand" href="home">News</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                {foreach from=$category item=$cate}
                                    {if $cate->category != 'Undefined'}
                                        <a class="dropdown-item" href="filter/{$cate->category}">{$cate->category}</a>
                                    {/if}
                                {/foreach}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Ups!</a>
                            </div>
                        </li>
                        
                        {if isset($smarty.session.user_id)}
                         <li class="nav-item"><a class="nav-link" href="admin">Admin</a></li>
                         <li class="nav-item"><a class="btn btn-primary" href = "sing-off">Sign off</a></li>
                        {else}
                            <li class="nav-item"><a class="nav-link" href="login">Login</a></li>
                            <li class="nav-item"><a class="nav-link" href="register">Register</a></li>
                        {/if}
                    </ul>
                     {if isset($smarty.session.user_id)}
                       <ul class="navbar-nav ">
                        <!--TP-2 PARA CONFIGURACION DE USUARIO.-->
                            <li class="nav-item"><a class="nav-link" href="admin">Welcome {$smarty.session.name} {$smarty.session.surname}</a></li>
                        </ul>
                     {/if}
                </div>
            </nav>
        </header>
