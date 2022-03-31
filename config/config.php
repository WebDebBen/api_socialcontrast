<?php
    if ($_SERVER["SERVER_NAME"] == "api.demosocial.com"){
        define("DB_HOST", "localhost");
        define("DB_USER", "root");
        define("DB_PASSWORD", "");
        define("DB_NAME", "gevorestposdemodb" );
        define("API_DB_NAME", "gevorestposdemodb");
    }else{
        define("DB_HOST", "https://demo.socialcontrast.com/");
        define("DB_USER", "root");
        define("DB_PASSWORD", "");
        define("DB_NAME", "gevorestposdemodb" );	
        define("API_DB_NAME", "gevorestposdemodb");
    }

    define("PLUGIN_PATH", "plugin_product_catalog");
?>