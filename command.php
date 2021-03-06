<?php

if ( ! class_exists( 'WP_CLI' ) ) {
	return;
}
require_once('lib/helpers.php');
require_once('lib/chunker.php');

global $chunker;
$chunker = new CM_CLI_Chunker;

require_once('lib/Post.php');
require_once('lib/Taxonomy.php');
require_once('lib/Menu.php');
require_once('lib/ImageSize.php');
require_once('lib/PageTemplate.php');
require_once('lib/LocalConfig.php');
require_once('lib/CoreConfig.php');
require_once('lib/OptimalSetup.php');
require_once('lib/DummyContent.php');
require_once('lib/Theme.php');
