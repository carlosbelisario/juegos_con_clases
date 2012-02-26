<?php
try {
    spl_autoload_register(include 'autoload_function.php');
} catch (Exception $e) {
    $e->getMessage();
}
?>
