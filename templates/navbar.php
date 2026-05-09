<!-- Inclusão de Ícones do Bootstrap (Colocado aqui para carregar em todas as páginas) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- ESTILOS EXTRAS PARA O EFEITO MOBILE (BOTTOM BAR) -->
<style>
    /* Dá um espaço no rodapé apenas em telas pequenas para a Bottom Bar não cobrir o conteúdo */
    @media (max-width: 991.98px) {
        body {
            padding-bottom: 80px; 
        }
    }
    
    /* Hover sutil nos links da navbar no Desktop */
    .navbar-nav .nav-link {
        transition: all 0.2s ease-in-out;
    }
    .navbar-nav .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* Cores ajustadas para os dropdowns combinarem com sua cor principal */
    .dropdown-menu-custom {
        background-color: #4A5485;
        border: none;
    }
    .dropdown-menu-custom .dropdown-item {
        color: rgba(255,255,255,0.85);
        transition: 0.2s;
    }
    .dropdown-menu-custom .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: #fff;
    }
</style>

<!-- ==========================================
     NAVBAR PRINCIPAL (TOPO)
=========================================== -->
<nav class="navbar navbar-expand-lg sticky-top shadow-sm py-2" style="background-color: #5B67A2;" data-bs-theme="dark">
    <div class="container"> <!-- 'container' em vez de 'fluid' para não esticar demais no monitor -->
        
        <!-- LOGO -->
        <a class="navbar-brand fw-bold tracking-wide" href="<?= BASE_URL ?>pages/dashboard/index.php">
            <i class="bi bi-wallet2 me-2 text-info"></i>FINTEC
        </a>
        
        <!-- BOTÃO MENU HAMBÚRGUER (MOBILE) -->
        <button class="navbar-toggler border-0 shadow-none px-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-1 mt-3 mt-lg-0">
                
                <!-- HOME -->
                <li class="nav-item">
                    <a class="nav-link rounded px-3" aria-current="page" href="<?= BASE_URL ?>pages/dashboard/index.php">
                        <i class="bi bi-house-door me-1"></i> Dashboard
                    </a>
                </li>
                
                <!-- CONSULTAS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle rounded px-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-view-list me-1"></i> Consultas
                    </a>
                    <ul class="dropdown-menu dropdown-menu-custom shadow-lg mt-2">
                        <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>pages/movimentacao/index.php"><i class="bi bi-arrow-down-up me-2 text-info"></i>Movimentações</a></li>
                        <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>pages/tipo_despesa/index.php"><i class="bi bi-tags me-2 text-warning"></i>Tipos de Despesas</a></li>
                        <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>pages/forma_pagamento/index.php"><i class="bi bi-credit-card me-2 text-success"></i>Formas de Pagamento</a></li>
                    </ul>
                </li>
                
                <!-- CADASTROS -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle rounded px-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-plus-circle me-1"></i> Cadastros
                    </a>
                    <ul class="dropdown-menu dropdown-menu-custom shadow-lg mt-2">
                        <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>pages/movimentacao/new.php"><i class="bi bi-cash-coin me-2 text-info"></i>Nova Movimentação</a></li>
                        <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>pages/tipo_despesa/new.php"><i class="bi bi-tag me-2 text-warning"></i>Nova Categoria</a></li>
                        <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>pages/forma_pagamento/new.php"><i class="bi bi-credit-card-2-front me-2 text-success"></i>Nova Forma de Pagamento</a></li>
                    </ul>
                </li>
                
            </ul>
            
            <!-- BOTÃO SAIR -->
            <form class="d-flex mt-3 mt-lg-0" action="logout.php" method="POST"> <!-- Ajuste o action para sua rota real de logout -->
                <button class="btn btn-outline-light rounded-pill px-4 w-100" type="submit">
                    <i class="bi bi-box-arrow-right me-1"></i> Sair
                </button>
            </form>
            
        </div>
    </div>
</nav>


<!-- ==========================================
     BOTTOM APP BAR (APENAS MOBILE)
=========================================== -->
<nav class="navbar fixed-bottom bg-white border-top shadow-lg d-block d-lg-none pb-2 pt-2 pb-sm-3">
    <div class="container-fluid px-1">
        <ul class="nav nav-pills nav-justified w-100 align-items-center mb-0" style="font-size: 0.75rem; font-weight: 500;">
            
            <!-- HOME -->
            <li class="nav-item">
                <a href="<?= BASE_URL ?>pages/dashboard/index.php" class="nav-link text-secondary px-0 d-flex flex-column align-items-center">
                    <i class="bi bi-house-door fs-4 mb-1 text-dark"></i>
                    <span>Início</span>
                </a>
            </li>
            
            <!-- EXTRATO (MOVIMENTAÇÕES) -->
            <li class="nav-item">
                <a href="<?= BASE_URL ?>pages/movimentacao/index.php" class="nav-link text-secondary px-0 d-flex flex-column align-items-center">
                    <i class="bi bi-card-list fs-4 mb-1 text-dark"></i>
                    <span>Extrato</span>
                </a>
            </li>
            
            <!-- BOTÃO CENTRAL DESTACADO (NOVO LANÇAMENTO) -->
            <li class="nav-item position-relative" style="top: -20px;">
                <a href="<?= BASE_URL ?>pages/movimentacao/new.php" class="nav-link text-white bg-success rounded-circle shadow-lg d-inline-flex justify-content-center align-items-center border border-white border-4" style="width: 60px; height: 60px;">
                    <i class="bi bi-plus-lg fs-1"></i>
                </a>
            </li>
            
            <!-- CATEGORIAS -->
            <li class="nav-item">
                <a href="<?= BASE_URL ?>pages/tipo_despesa/index.php" class="nav-link text-secondary px-0 d-flex flex-column align-items-center">
                    <i class="bi bi-tags fs-4 mb-1 text-dark"></i>
                    <span>Categorias</span>
                </a>
            </li>
            
            <!-- MENU EXPANSÍVEL (Abre a navbar do topo) -->
            <li class="nav-item">
                <a href="#" class="nav-link text-secondary px-0 d-flex flex-column align-items-center" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false" aria-controls="navbarSupportedContent">
                    <i class="bi bi-list fs-4 mb-1 text-dark"></i>
                    <span>Menu</span>
                </a>
            </li>

        </ul>
    </div>
</nav>