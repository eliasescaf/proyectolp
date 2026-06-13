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
    ?>
</head>
<body data-bs-theme="light" class="bg-light vh-100 w-100 d-flex align-items-center p-0 m-0">
        <?php
            require_once APP_DIR_VIEWS . $this->view;
        ?>
</body>
</html>