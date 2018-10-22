<?php

namespace MWW\Frontend;

class Assets
{
    /**
    *   Enqueues Theme Styles
    */
    public function enqueueStyles()
    {
        $this->enqueueStyle('style.css');
    }

    /**
    *   Enqueues Theme JavaScript
    */
    public function enqueueJavascripts()
    {
        $this->enqueueJavascript('main.js', ['jquery']);
    }

    /**
    *   Enqueues a Single CSS
    *   https://developer.wordpress.org/reference/functions/wp_enqueue_style/
    *
    *   @param string $file      Name of the file
    *   @param array $dependency Will load after selected handlers
    *   @param string $path       Path to load from, starting from MWT_PATH
    */
    private function enqueueStyle(
        string $file,
        array $dependency = array(),
        string $path = '/public/css/'
    ) {
        wp_enqueue_style(
            $file,
            get_mwt_url() . $path . $file,
            $dependency,
            filemtime(get_mwt_path() . $path . $file)
        );
    }

    /**
    *   Enqueues a Single Remote CSS
    *   https://developer.wordpress.org/reference/functions/wp_enqueue_style/
    *
    *   @param string $name      Name of the handler, example: bootstrap
    *   @param string $url       URL of the remote resource
    *   @param array $dependency Will load after selected handlers
    */
    private function enqueueRemoteStyle(
        string $name,
        string $url,
        array $dependency = array()
    ) {
        wp_enqueue_style(
            $name,
            $url,
            $dependency
        );
    }

    /**
    *   Enqueues a Single Javascript
    *   https://developer.wordpress.org/reference/functions/wp_enqueue_script/
    *
    *   @param string $file       Name of the file
    *   @param array $dependency  Will load after selected handlers
    *   @param string $path       Path to load from, starting from MWT_PATH
    *   @param boolean $in_footer Wether to load the script in the footer or not
    */
    private function enqueueJavascript(
        string $file,
        array $dependency = array(),
        string $path = '/public/js/',
        bool $in_footer = true
    ) {
        wp_enqueue_script(
            $file == 'jquery.min.js' ? 'jquery' : $file,
            get_mwt_url() . $path . $file,
            $dependency,
            filemtime(get_mwt_path() . $path . $file),
            $in_footer
        );
    }

    /**
    *   Enqueues a Remote Javascript
    *   @param string $file       Name of the handler, example: bootstrap-js
    *   @param string $url        URL of the remote resource
    *   @param boolean $in_footer Wether to load the script in the footer or not
    *   @param array $dependency  Will load after selected handlers
    */
    private function enqueueRemoteJavascript(
        string $name,
        string $url,
        array $dependency = array(),
        bool $in_footer = true
    ) {
        wp_enqueue_script(
            $name,
            $url,
            $dependency,
            null,
            $in_footer
        );
    }

    /**
     * Removes WordPress emojis
     * https://wordpress.stackexchange.com/a/185578/27278
     */
    public static function removeEmojis()
    {
          // all actions related to emojis
          remove_action('admin_print_styles', 'print_emoji_styles');
          remove_action('wp_head', 'print_emoji_detection_script', 7);
          remove_action('admin_print_scripts', 'print_emoji_detection_script');
          remove_action('wp_print_styles', 'print_emoji_styles');
          remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
          remove_filter('the_content_feed', 'wp_staticize_emoji');
          remove_filter('comment_text_rss', 'wp_staticize_emoji');

          // Remove DNS prefetch
          add_filter('emoji_svg_url', '__return_false');
    }

    /**
    *   Enables and registers custom image sizes
    */
    public static function registerCustomImageSizes()
    {
        add_theme_support('post-thumbnails');

        add_image_size('col-12', 1170, 9999, false);
        add_image_size('col-12-crop', 1170, 9999, true);

        add_image_size('col-6', 585, 9999, false);
        add_image_size('col-6-crop', 585, 9999, true);

        add_image_size('col-4', 390, 9999, false);
        add_image_size('col-4-crop', 390, 9999, true);

        add_image_size('col-3', 292, 9999, false);
        add_image_size('col-3-crop', 292, 9999, true);
    }
}
