<?php

namespace WpAiIntegration\View;

use WpAiIntegration\Plugin\Plugin;

class View {
	public static function render( $name, array $args = array() ) {
		$args = apply_filters( 'wai_render_args', $args, $name );

		foreach ( $args as $key => $val ) {
			$$key = $val;
		}

		$file = Plugin::get_plugin_dir() . 'templates/' . $name . '.php';

		if ( ! file_exists( $file ) ) {
			return false;
		}
		include $file;
	}
}
