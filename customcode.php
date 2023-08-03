<?php
require_once('polyfill.php');
require_once(INCLUDE_DIR . 'class.plugin.php');		
require_once(INCLUDE_DIR . 'class.osticket.php');
require_once('config.php');

class CustomCodePlugin extends Plugin {
    var $config_class = "CustomCodePluginConfig";

    function bootstrap() {

        $filepath = INCLUDE_DIR . "client/header.inc.php";
        $contents = file_get_contents($filepath);
        $tag_start = "<!-- start custom code -->";

        if (!str_contains($contents, $tag_start)){
            //Add custom code. It's been removed for some reason, maybe an upgrade?
            $this->InsertCustomCode();
        }

        // staff side
        $filepath = INCLUDE_DIR . "staff/header.inc.php";
        $contents = file_get_contents($filepath);
        $tag_start = "<!-- start custom code -->";

        if (!str_contains($contents, $tag_start)){
            //Add custom code. It's been removed for some reason, maybe an upgrade?
            $this->InsertCustomStaffCode();
        }
        
    }

    function InsertCustomCode() {      
        try {
            $config = $this->getConfig();

            $filepath = INCLUDE_DIR . "client/header.inc.php";

            //Place it all just before the </head>, its just a reference point
            $find = "</head>";

            $tag_start = "<!-- start custom code -->";
            $tag_end = "<!-- end custom code-->";

            $contents = file_get_contents($filepath);

            $css = $config->get('custom-code-css');
            $js = $config->get('custom-code-js');

            $replace = $tag_start;
            $replace .= "<style>" . $css . "</style>";
            $replace .= "<script>" . $js . "</script>";
            $replace .= $tag_end;
            $replace .= "</head>"; //don't forget to put it back

            $contents = str_replace($find, $replace, $contents);

            file_put_contents($filepath, $contents);

       } catch(Exception $e) {
            //maybe log this?
            error_log($e->getMessage(), 0); 
       }
    }

    function InsertCustomStaffCode() {
        try {
            $config = $this->getConfig();

            $filepath = INCLUDE_DIR . "staff/header.inc.php";

            //Place it all just before the </head>, its just a reference point
            $find = "</head>";

            $tag_start = "<!-- start custom code -->";
            $tag_end = "<!-- end custom code-->";

            $contents = file_get_contents($filepath);

            $css = $config->get('custom-staff-code-css');
            $js = $config->get('custom-staff-code-js');

            $replace = $tag_start;
            $replace .= "<style>" . $css . "</style>";
            $replace .= "<script>" . $js . "</script>";
            $replace .= $tag_end;
            $replace .= "</head>"; //don't forget to put it back

            $contents = str_replace($find, $replace, $contents);

            file_put_contents($filepath, $contents);

       } catch(Exception $e) {
            //maybe log this?
            error_log($e->getMessage(), 0); 
       }
    }
}