<nav class="navbar navbar-expand-lg bg-light my-4">
    <div class="container-xl">
        <a class="navbar-brand" href="/">
            <img src="/images/logo.png" alt="Logo" height="50" class="d-inline-block">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="/">Home</a>
                <a class="nav-link" href="/categoria/generale">Generale</a>  
                <a class="nav-link" href="/categoria/sport">Sport</a>   
                <a class="nav-link" href="/categoria/moda">Moda</a> 
                <a class="nav-link" href="/chisono">Chi Sono</a>             
            </div>
            <div class="navbar-nav">
                <?php
                    //Sezione link autenticazione
                    if (isset($_SESSION['loggedin'])) {
                        if(isset($_SESSION['isAdmin'])) {
                            echo('<a class="nav-link" href="/admin/index.php">Admin</a>');
    
                        }
                        echo '<a class="nav-link" href="/profilo"><i class="bi bi-person-circle"></i> Profilo</a>';
                        echo '<a class="nav-link" href="/auth/logout.php"><i class="bi bi-door-open"></i> Logout</a>';
                    } else {
                        echo '<a class="nav-link" href="/login">Login</a>';
                        echo '<a class="nav-link" href="/registrazione">Registrati</a>';
                    }
                ?>
            </div>
        </div>
    </div>
</nav>