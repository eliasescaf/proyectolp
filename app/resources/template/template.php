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
<body data-bs-theme="light" class="d-flex flex-column min-vh-100">
    <header>
        <?php
            require_once APP_DIR_TEMPLATE . "includes/menu.php";
            require_once APP_DIR_TEMPLATE . "includes/breadcrumb.php";
        ?>
    </header>
    <main class="flex-grow-1 w-100 position-relative">
        <?php
            require_once APP_DIR_VIEWS . $this->view;
        ?>
    </main>
    <footer>
        <?php
            require_once APP_DIR_TEMPLATE . "includes/footer.php";
        ?>
    </footer>
    <?php if (isset($this->modals) && is_array($this->modals)){ ?>
        <section>
            <?php
                foreach($this->modals as $modal){
                    require_once $modal;
                }
            ?>
        </section>
    <?php } ?>
</body>
</html>