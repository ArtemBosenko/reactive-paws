<?php

namespace WpAiIntegration\Admin;

use WpAiIntegration\View\View;

class Page {

	/**
	 * The page title.
	 *
	 * @var string
	 */
	protected string $page_title;

	/**
	 * The page slug.
	 *
	 * @var string
	 */
	protected string $slug;

	/**
	 * The page request key.
	 *
	 * @var string
	 */
	protected string $request_key = 'page';

	/**
	 * The page arguments.
	 *
	 * @var array
	 */
	protected array $args;

	/**
	 * The nonce wp validator.
	 *
	 * @var string
	 */
	protected string $nonce;
	public function __construct( string $page_title, string $slug, array $args = array() ) {
		$this->page_title = $page_title;
		$this->slug       = $slug;
		$this->set_nonce( md5( $slug . sanitize_title( _truncate_post_slug( $this->page_title ) ) ) );
		$defaults   = array(
			'page' => array(
				'slug'        => $this->slug,
				'nonce'       => $this->get_nonce(),
				'template'    => 'main',
				'request_key' => $this->request_key,
			),
			'menu' => array(
				'enabled'    => true,
				'parent'     => null,
				'page_title' => $this->page_title,
				'menu_title' => $this->page_title,
				'capability' => 'manage_options',
				'menu_slug'  => $this->slug,
				'callback'   => array( $this, 'render' ),
				'position'   => null,
			),
		);
		$this->args = wp_parse_args( $args, $defaults );

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 5 );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

	/**
	 * To generate the menu link for the page.
	 *
	 * @return void
	 */
	public function admin_menu() {
		$menu = ! empty( $this->args ) && isset( $this->args['menu'] ) && $this->args['menu']['enabled'] ? $this->args['menu'] : null;
		if ( $menu ) {
			extract( $menu );
			if ( ! $parent ) {
				add_options_page( $page_title, $menu_title, $capability, $menu_slug, $callback, $position );
			} else {
				add_submenu_page( $parent, $page_title, $menu_title, $capability, $menu_slug, $callback, $position );
			}
		}
	}

	/**
	 * Admin init hook for custom page preprocessing.
	 *
	 * @return void
	 */
	public function admin_init() {
		$asdfadsf = '';
		// if ( isset($_SESSION['wai-config-page_rendered']) ) {
		// $_SESSION['wai-config-page_rendered'] = true;
		// if ( ! headers_sent() ) {
		// $admin_url = self::get_url( 'init' );
		// wp_safe_redirect( $admin_url );
		// }
		// }
	}

	/**
	 * To check whether the page is loaded.
	 *
	 * @return bool
	 */
	public function is_current() {
		return ! empty( $_SERVER['REQUEST_URI'] ) && $this->get_uri() === $_SERVER['REQUEST_URI'];
	}

	/**
	 * To get the page URL.
	 *
	 * @return string
	 */
	public function get_url() {
		return add_query_arg( array( $this->args['page']['request_key'] => $this->slug ), menu_page_url( $this->slug, false ) );
	}

	/**
	 * To get the page URI.
	 *
	 * @return string
	 */
	public function get_uri() {
		return add_query_arg( array( $this->args['page']['request_key'] => $this->slug ) );
	}

	/**
	 * To render page template.
	 *
	 * @return void
	 */
	public function render() {
		View::render( $this->args['page']['template'], $this->args );
	}

	public function get_nonce(): string {
		return $this->nonce;
	}

	public function set_nonce( string $nonce ): void {
		$this->nonce = $nonce;
	}

	public function get_slug(): string {
		return $this->slug;
	}

	public function set_slug( string $slug ): void {
		$this->slug = $slug;
	}

}
