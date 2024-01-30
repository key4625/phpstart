</body>
    <footer class="bg-light p-5 text-center">
        Questo è il footer
        <?php
            if (isset($_SESSION['loggedin'])) {
                printf("%s", '<a class="nav-link" href="/auth/logout.php"><i class="bi bi-door-open"></i></a>');
            } else {
                echo '<a class="nav-link" href="/admin/index.php"><i class="bi bi-key" style="font-size: 1.5rem; "></i></a>';
            }
        ?>
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script> 
<script src="/js/script.js" type="text/javascript" ></script>
<?= isset($add_script) ? $add_script : "" ; ?>
</html>