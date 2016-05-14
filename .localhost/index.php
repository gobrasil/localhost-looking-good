<?php

require_once( 'config.php' );

$files           = array();
$directories     = array();
$sites_available = array();
$sites_enabled   = array();

/** Support for subdirectories */
if ( empty( $_SERVER['REQUEST_URI'] ) )
	$subdir = '/';
else
	$subdir = trim( $_SERVER['REQUEST_URI'] );

/** To ignore hidden things */
$pattern = '/^\./';

/** Stores the name of the files */
foreach ( glob( PROJECTS_DIR . $subdir . '/*' ) as $file_name )
	if ( ! in_array( basename( $file_name ), $ignore ) ) {
		$files[] = basename( $file_name );
		if ( is_dir( $file_name ) )
			$directories[] = basename( $file_name ) ;
	}

/** Stores the sites available */
foreach ( glob( APACHE_DIR . '/sites-available/*' ) as $conf_file )
	if ( ! in_array( basename( $conf_file ), $ignore ) )
		$sites_available[] = basename( $conf_file );

/** Stores the sites enabled */
foreach( glob( APACHE_DIR . '/sites-enabled/*' ) as $conf_file )
	if ( ! in_array( basename( $conf_file ), $ignore ) )
		$sites_enabled[] = basename( $conf_file );

require_once( 'header.php' );

?>
<div class="column">
	<div class="panel">
		<div class="panel-heading">
			<?php if ( '/' !== $subdir ) : ?>
				<a class="btn-back" href="<?php echo HOME_URL . dirname( $subdir ); ?>"></a>
				<h3><?php echo ucfirst( basename( $subdir ) ); ?></h3>
			<?php else : ?>
				<h3>Projects</h3>
			<?php endif; ?>
		</div><!-- .panel-heading -->
		<div class="panel-body">
			<div class="list-group">
				<?php if ( empty( $files ) ) : ?>
					<p class="list-group-item">No Files</p>
				<?php else : ?>
					<?php foreach ( $files as $file ) : ?>
						<?php if ( in_array( $file, $directories ) ) : ?>
							<a class="list-group-item is-dir" href="<?php echo HOME_URL . $subdir . $file; ?>">
								<h4><?php echo $file; ?></h4>
							</a>
						<?php else : ?>
							<a class="list-group-item is-file" href="<?php echo HOME_URL . $subdir . $file; ?>">
								<h4><?php echo $file; ?></h4>
							</a>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div><!-- .list-group -->
		</div><!-- .panel-body -->
	</div><!-- .panel -->
</div><!-- .column -->

<div class="column">
	<div class="panel">
		<div class="panel-heading">
			<h3>Virtual Hosts</h3>
		</div><!-- .panel-heading -->
		<div class="panel-body">
			<div class="list-group">
				<?php if ( empty( $sites_available ) ) : ?>
					<p class="list-group-item">No Virtual Hosts</p>
				<?php else : ?>
					<?php foreach ( $sites_available as $site ) : ?>
						<?php

						/** Reads entire file into an array */
						$vh = file( APACHE_DIR . "/sites-available/{$site}" );
						foreach ( $vh as $line ) {

							/** Search for the line with the ServerName */
							preg_match( '/ServerName\s+(.*)\n/', $line, $server_name);
							if ( isset( $server_name[1] ) ) {
								$url = "http://{$server_name[1]}";
								break;
							}
						}

						/** If there's no ServerName, set a common URL */
						if ( ! isset( $url ) )
							$url = HOME_URL . "/{$site}";

						/** Verify if the virtual host configuration is enabled */
						$label_type = ( in_array( $site, $sites_enabled ) ) ? 'success' : 'danger';

						?>
						<a class="list-group-item" href="<?php echo $url; ?>">
							<h4><?php echo $site; ?></h4>
							<span class="label <?php echo "label-{$label_type}"; ?>"></span>
							<p><?php echo $url; ?></p>
						</a><!-- .list-group-item -->
					<?php endforeach; ?>
				<?php endif; ?>
			</div><!-- .list-group -->
		</div><!-- .panel-body -->
	</div><!-- .panel -->
</div><!-- .column -->

<?php require_once( 'footer.php' ); ?>
