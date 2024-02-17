<?php

namespace WpAiIntegration\Plugin;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use WpAiIntegration\Admin\Page;

/**
 * The Plugin class.
 */
class Plugin {

    /**
     * @var Plugin
     */
    protected static Plugin $instance;

    /**
     * @var string
     */
    protected static string $plugin_dir;

    /**
     * @var string
     */
    protected static string $plugin_file;

    /**
     * @var string
     */
    protected static string $plugin_textdomain = 'wp-ai-integration';

    /**
     * To get the plugin instance.
     *
     * @return Plugin
     */
    public static function get_instance(): Plugin {
        if ( empty( self::$instance ) ) {
            self::$instance = new static();
        }
        self::$instance->init();
        return self::$instance;
    }

    /**
     * The plugin init method.
     *
     * @return void
     */
    protected function init(): void {
        self::$plugin_dir = empty( self::$plugin_dir ) ?
            plugin_dir_path( dirname( dirname(__FILE__ ) ) ) :
            self::$plugin_dir;
        self::$plugin_file = empty( self::$plugin_file ) ? self::$plugin_dir . basename( self::$plugin_dir ) . '.php' : self::$plugin_file;

        $this->autoload_src( self::get_plugin_dir() . 'src' );

//        TODO: make factory
        new Page( __( 'WP AI integration', 'wp-ai-integration' ) , 'wp-ai-integration-start-page' );

        add_action(
            'init',
            function (){
                if ( is_admin() ) {
                    load_plugin_textdomain( $this::get_plugin_textdomain() );
                }
            }
        );

    }

    /**
     * To get the plugins file path.
     *
     * @return string
     */
    public static function get_plugin_file(): string
    {
        return self::$plugin_file;
    }

    /**
     * To get plugins directory.
     *
     * @return string
     */
    public static function get_plugin_dir(): string
    {
        return self::$plugin_dir;
    }

    /**
     * To get the plugin textdomain.
     *
     * @return string
     */
    public static function get_plugin_textdomain(): string
    {
        return self::$plugin_textdomain;
    }

    /**
     * To set plugins texdomain.
     *
     * @param $domain
     * @return void
     */
    public static function set_plugin_textdomain( $domain ): void
    {
        self::$plugin_textdomain = $domain;
    }

    public function autoload_src( $directory ) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ( $iterator as $filename ) {
            if ( pathinfo($filename, PATHINFO_EXTENSION) === "php" && $filename->getPathname() !== __FILE__ ) {
                require_once $filename;
            }
        }
    }

    /**
     * Blocked the class clone method, it's a Singleton.
     *
     * @return void
     */
    protected function __clone(){}

    /**
     * Blocked the class constructor, it's a Singleton.
     *
     * @return void
     */
    protected function __construct(){}

    /**
     * Blocked the class wakeup, it's a Singleton.
     *
     * @return void
     * @throws \Exception
     */
    public function __wakeup(){
        throw new \Exception("Cannot unserialize a singleton.");
    }

}
