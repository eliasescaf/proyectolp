<!DOCTYPE html>
<html lang="es">
<head>
    <?php
        require_once APP_DIR_TEMPLATE . 'includes/head.php';

        if(isset($this->scripts) && is_array($this->scripts)){
            foreach($this->scripts as $script){
                echo '<script defer src="' . APP_URL . $script . '"></script>';
            }
        }

        if(isset($this->modules) && is_array($this->modules)){
            foreach($this->modules as $module){
                echo '<script type="module" src="' . APP_URL . $module . '"></script>';
            }
        }
    ?>
</head>
<body data-bs-theme="light" class="bg-body-secondary bg-gradient">
    <header>
        <h1>HEADER DE LA PLANTILLA</h1>
        <?php
            // require_once APP_DIR_TEMPLATE . "includes/menu.php";
            // require_once APP_DIR_TEMPLATE . "includes/breadcrumb.php";
        ?>
    </header>
    <main>
        <div class="bg-body bg-gradient text-center m-1 m-md-3 py-3 px-1 px-lg-3 px-xxl-5 border rounded">
        <?php
            require_once APP_DIR_VIEWS . $this->view;
        ?>
        </div>
    </main>
    <footer>
        <h4>FOOTER DE LA PLANTILLA</h4>
        <?php
            // require_once APP_DIR_TEMPLATE . "includes/footer.php";
        ?>
    </footer>
    <section>
    <?php
        // require_once APP_DIR_TEMPLATE . 'includes/modals.php';

        // if(isset($this->modals) && is_array($this->modals)){
        //     foreach($this->modals as $modal){
        //         require_once $modal;
        //     }
        // }
    ?>
    </section>
</body>
</html>