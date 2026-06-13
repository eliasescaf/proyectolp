<div id="breadcrumb" class="border-top border-white border-opacity-10 py-2 mb-2">
  <div class="container px-4 px-lg-5">
    <nav aria-label="breadcrumb">
      <ol id="ol-breadcrumb" class="breadcrumb mb-0">
        
        <?php 
        $pasos = $this->breadcrumb ?? ['Inicio' => null]; 
        
        foreach ($pasos as $label => $ruta) {
            if ($ruta === null) { 
        ?>
              <li class="breadcrumb-item active text-white fw-medium" aria-current="page">
                <?php echo $label; ?>
              </li>
        <?php 
            } else { 
        ?>
              <li class="breadcrumb-item">
                <a href="<?php echo $ruta; ?>" class="text-white-50 text-decoration-none link-light">
                    <?php echo $label; ?>
                </a>
              </li>
        <?php 
            } 
        } 
        ?>

      </ol>
    </nav>
  </div>
</div>