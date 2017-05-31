<?php

class CM_CLI_Helper{
    public static function directory_builder($dir, $destination){
    	$files = scandir($dir);
    	if(!empty($files)){
    		foreach($files as $file){
    			if($file === '.' || $file === '..'){
    				//do nothing
    			}elseif(is_file($dir . '/' . $file)){
    				CM_CLI_Helper::copy("$dir/$file", "$destination/$file");
    			}else{
    				mkdir("$destination/$file");
                    if($file === 'templates_c' || $file === 'cache'){
                        chmod("$destination/$file", 0777);
                    }
    				CM_CLI_Helper::directory_builder("$dir/$file", "$destination/$file");
    			}
    		}
    	}
    }

    public static function reward(){
    	$rewards[] = "a tea! 🍵";
    	$rewards[] = "a cookie! 🍪";
    	$rewards[] = "a doughnut! 🍩";
    	$rewards[] = "ice cream! 🍦";
    	$rewards[] = "a treat! 🍧";
    	$rewards[] = "a fish cake! 🍥";
    	$rewards[] = "a fried shrimp! 🍤";
    	$rewards[] = "a roasted sweet potatoe! 🍠";
    	$rewards[] = "fries! 🍟";
    	$rewards[] = "(mom's) spaghetti! 🍝";
    	$rewards[] = "rice! 🍚";
    	$rewards[] = "a drumstick! 🍗";
    	$rewards[] = "a beer! 🍺";
    	$rewards[] = "two beer! 🍻";
    	$rewards[] = "meat! 🍖";
    	return "All Done! Good Work! You deserve " . $rewards[mt_rand(0,14)];
    }

    public static function copy($source, $destination, $vars = array()){
        global $chunker;

        $contents = file_get_contents($source);

        $basename = basename($source);
        if($basename === 'style.css' || $basename == 'translations.php'){
            $contents = CM_CLI_Helper::prepare_theme_meta($contents);
        }
        $contents = $chunker->replacer($contents, $vars);
        $contents = $chunker->chunk($source, $contents);

        file_put_contents($destination, $contents);
    }

    public function prepare_theme_meta($contents){
        global $template_vars;

        foreach($template_vars as $key => $value){
            $contents = str_replace("[[$key]]", $value, $contents);
        }

        return $contents;
    }

    public static function get_active_theme(){
        global $active_theme_dir;
        $active_theme_dir = null;
        $command_response = WP_CLI::runcommand(
			'theme list --format=json',
			array('return' => 'all')
		);

		$themes = json_decode($command_response->stdout);

		if(!empty($themes)){
            foreach($themes as $theme){
                if($theme->status === 'active'){
                    // do stuff here
                    $command_response = WP_CLI::runcommand(
        				'theme get ' . $theme->name . ' --fields=template_dir,title --format=json',
        				array('return' => 'all')
        			);
                    $theme_fields = json_decode($command_response->stdout);
                    if($theme_fields->template_dir){
                        $active_theme_dir = $theme_fields->template_dir;
                    }
                }
            }
        }
    }

    public static function active_theme_dir(){
        global $active_theme_dir;
        if(!$active_theme_dir){
            CM_CLI_Helper::get_active_theme();
        }
        return $active_theme_dir;
    }
}
