<?php
require_once('polyfill.php');
require_once INCLUDE_DIR . 'class.plugin.php';

class CustomCodePluginConfig extends PluginConfig {

    // Provide compatibility function for versions of osTicket prior to
    // translation support (v1.9.4)
    function translate() {
        if (!method_exists('Plugin', 'translate')) {
            return array(
                function($x) { return $x; },
                function($x, $y, $n) { return $n != 1 ? $y : $x; },
            );
        }
        return Plugin::translate('customcode');
    }

    function getOptions() {
        list($__, $_N) = self::translate();        
        return array(
            'customcodeHeading' => new SectionBreakField(array(
                'label' => $__('Enter your custom code below')
            )),
            'custom-code-css' => new TextareaField(array(
                'label' => $__('Custom Client CSS'),
                'configuration' => array('rows'=>10, 'cols'=>80, 'html'=>false),                
            )),
            'custom-code-js' => new TextareaField(array(
                'label' => $__('Custom Client JS'),
                'configuration' => array('rows'=>10, 'cols'=>80, 'html'=>false),                
            )),
            'custom-staff-code-css' => new TextareaField(array(
                'label' => $__('Custom Staff CSS'),
                'configuration' => array('rows'=>10, 'cols'=>80, 'html'=>false),                
            )),
            'custom-staff-code-js' => new TextareaField(array(
                'label' => $__('Custom Staff JS'),
                'configuration' => array('rows'=>10, 'cols'=>80, 'html'=>false),                
            )),
        );
    }

    function pre_save(&$config, &$errors) {
         try {

            $filepath = INCLUDE_DIR . "client/header.inc.php";

            $find = "</head>";
            $tag_start = "<!-- start custom code -->";
            $tag_end = "<!-- end custom code-->";

            $contents = file_get_contents($filepath);

            //clean contents up
            $contents = preg_replace("#" . $tag_start ."(.*?)" . $tag_end . "#s", "", $contents);
            $contents = str_replace($tag_start, "", $contents);
            $contents = str_replace($tag_end, "", $contents);

            $css = $config['custom-code-css'];
            $js = $config['custom-code-js'];

            $replace = $tag_start;
            $replace .= "<style>" . $css . "</style>";
            $replace .= "<script>" . $js . "</script>";
            $replace .= $tag_end;
            $replace .= "</head>";

            $contents = str_replace($find, $replace, $contents);

            file_put_contents($filepath, $contents);

            //staff code
            $filepath = INCLUDE_DIR . "staff/header.inc.php";

            $find = "</head>";
            $tag_start = "<!-- start custom code -->";
            $tag_end = "<!-- end custom code-->";

            $contents = file_get_contents($filepath);

            //clean contents up
            $contents = preg_replace("#" . $tag_start ."(.*?)" . $tag_end . "#s", "", $contents);
            $contents = str_replace($tag_start, "", $contents);
            $contents = str_replace($tag_end, "", $contents);

            $css = $config['custom-staff-code-css'];
            $js = $config['custom-staff-code-js'];

            $replace = $tag_start;
            $replace .= "<style>" . $css . "</style>";
            $replace .= "<script>" . $js . "</script>";
            $replace .= $tag_end;
            $replace .= "</head>";

            $contents = str_replace($find, $replace, $contents);

            file_put_contents($filepath, $contents);

        } catch(Exception $e) {
            error_log($e->getMessage());
        }
        return true;
     }
}