    <nav class="navbar navbar-expand-lg" style="background-color: #5B67A2;" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">FINTEC</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Consultas
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= BASE_URL ?>pages/tipo_despesa/index.php">Tipos de Despesas</a></li>
                <li><a class="dropdown-item" href="#">Forma de Pagamento</a></li>
                <li><a class="dropdown-item" href="#">Movimentação</a></li>
            </ul>
            </li>
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Cadastros
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= BASE_URL ?>pages/tipo_despesa/new.php">Tipos de Despesas</a></li>
                <li><a class="dropdown-item" href="#">Forma de Pagamento</a></li>
                <li><a class="dropdown-item" href="#">Movimentação</a></li>
            </ul>
            </li>            
        </ul>
        <form class="d-flex" role="search">
            <button class="btn btn-outline-info" type="submit">Sair</button>
        </form>
        </div>
    </div>
    </nav>
    <br/>