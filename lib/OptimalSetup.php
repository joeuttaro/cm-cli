<?php
class CM_CLI_OptimalSetup{
	/**
	 * Setup some ideal environment settings, such as gitignore, htaccess, and xmlrpc
	 *
	 * ## OPTIONS
	 *
	 * [--skip-gitignore]
	 * : Don't bother with gitignore file
     *
	 * [--skip-htaccess]
	 * : Don't both with htaccess
     *
	 * [--keep-xmlrpc]
	 * : Don't disable XMLRPC (XMLRPC gets disabled because it is rarely used and often the source of security issues)
	 *
	 *
	 * ## EXAMPLES
	 *
	 *     wp cm optimal-setup
	 *
	 * @when before_wp_load
	 */
	public function __invoke($args, $assoc_args){

        $messages = array();
        $source = dirname(dirname(__FILE__));
        $destination = ABSPATH;

        if(!isset($assoc_args['skip-gitignore'])){
            CM_CLI_Helper::copy("$source/optimal-setup/gitignore", "$destination/.gitignore");
            $messages[] = '.gitignore copied';
        }

        if(!isset($assoc_args['skip-htaccess'])){
            CM_CLI_Helper::copy("$source/optimal-setup/htaccess", "$destination/.htaccess");
            $messages[] = '.htaccess copied';
        }

        if(!isset($assoc_args['keep-xmlrpc'])){
            if(chmod("$destination/xmlrpc.php", 0000)){
                $messages[] = 'xmlrpc disabled';
            }else{
                WP_CLI::error( "Could not disable xmlrpc.php. You could manually delete it or chmod it to 000." );
            }
        }

        if(!empty($messages)){
            WP_CLI::success( "The following operations were completed: " . implode(', ', $messages) );
        }
	}

}
WP_CLI::add_command( 'cm optimal-setup', 'CM_CLI_OptimalSetup');
