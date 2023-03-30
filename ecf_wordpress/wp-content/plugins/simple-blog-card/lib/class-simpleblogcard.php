<?php
/**
 * Simple Blog Card
 *
 * @package    Simple Blog Card
 * @subpackage SimpleBlogCard Main Functions
/*
	Copyright (c) 2019- Katsushi Kawamori (email : dodesyoswift312@gmail.com)
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; version 2 of the License.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

$simpleblogcard = new SimpleBlogCard();

/** ==================================================
 * Main Functions
 */
class SimpleBlogCard {

	/** ==================================================
	 * Construct
	 *
	 * @since   1.00
	 */
	public function __construct() {

		add_action( 'init', array( $this, 'simpleblogcard_block_init' ) );
		add_action( 'wp_footer', array( $this, 'load_style' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_style' ) );

	}

	/** ==================================================
	 * Attribute block
	 *
	 * @since 1.00
	 */
	public function simpleblogcard_block_init() {

		$asset_file = include( plugin_dir_path( __DIR__ ) . 'block/dist/simpleblogcard-block.asset.php' );

		wp_register_script(
			'simpleblogcard-block',
			plugins_url( 'block/dist/simpleblogcard-block.js', dirname( __FILE__ ) ),
			$asset_file['dependencies'],
			$asset_file['version'],
			true
		);

		wp_localize_script(
			'simpleblogcard-block',
			'simpleblogcard_text',
			array(
				'dessize' => __( 'Description length', 'simple-blog-card' ),
				'imgsize' => __( 'Image sizes' ),
				'color_width' => __( 'Color width', 'simple-blog-card' ),
				'title' => __( 'Title' ),
				't_line_height' => __( 'Title line height', 'simple-blog-card' ),
				'description' => __( 'Description' ),
				'd_line_height' => __( 'Description line height', 'simple-blog-card' ),
				'target_blank' => __( 'Open in new tab', 'simple-blog-card' ),
				'color' => __( 'Color' ),
				'white' => __( 'White' ),
				'black' => __( 'Black' ),
				'red' => __( 'Red' ),
				'yellow' => __( 'Yellow' ),
				'blue' => __( 'Blue' ),
			)
		);

		$simpleblogcard_settings = get_option(
			'simpleblogcard_settings',
			array(
				'url' => null,
				'dessize' => 90,
				'imgsize' => 100,
				'color' => '#7db4e6',
				'color_width' => 5,
				'title' => null,
				't_line_height' => 120,
				'description' => null,
				'd_line_height' => 120,
				'target_blank' => false,
			)
		);
		/* 'target_blank' from ver 1.08 */
		if ( ! array_key_exists( 'target_blank', $simpleblogcard_settings ) ) {
			$simpleblogcard_settings['target_blank'] = false;
		}

		register_block_type(
			'simple-blog-card/simpleblogcard-block',
			array(
				'editor_script'   => 'simpleblogcard-block',
				'render_callback' => array( $this, 'simpleblogcard_func' ),
				'attributes'      => array(
					'url'         => array(
						'type'    => 'string',
						'default' => $simpleblogcard_settings['url'],
					),
					'dessize' => array(
						'type'    => 'number',
						'default' => $simpleblogcard_settings['dessize'],
					),
					'imgsize' => array(
						'type'    => 'number',
						'default' => $simpleblogcard_settings['imgsize'],
					),
					'color'   => array(
						'type'    => 'string',
						'default' => $simpleblogcard_settings['color'],
					),
					'color_width' => array(
						'type'    => 'number',
						'default' => $simpleblogcard_settings['color_width'],
					),
					'title'   => array(
						'type'    => 'string',
						'default' => $simpleblogcard_settings['title'],
					),
					't_line_height' => array(
						'type'    => 'number',
						'default' => $simpleblogcard_settings['t_line_height'],
					),
					'description'  => array(
						'type'      => 'string',
						'default'   => $simpleblogcard_settings['description'],
					),
					'd_line_height' => array(
						'type'    => 'number',
						'default' => $simpleblogcard_settings['d_line_height'],
					),
					'target_blank' => array(
						'type'      => 'boolean',
						'default'   => $simpleblogcard_settings['target_blank'],
					),
				),
			)
		);

		add_shortcode( 'simpleblogcard', array( $this, 'simpleblogcard_func' ) );

	}

	/** ==================================================
	 * Short code
	 *
	 * @param array  $atts  attributes.
	 * @param string $content  contents.
	 * @return string $content  contents.
	 * @since 1.00
	 */
	public function simpleblogcard_func( $atts, $content = null ) {

		$a = shortcode_atts(
			array(
				'url'     => '',
				'dessize' => '',
				'imgsize' => '',
				'color'   => '',
				'color_width' => '',
				'title' => '',
				't_line_height' => '',
				'description' => '',
				'd_line_height' => '',
				'target_blank' => '',
			),
			$atts
		);

		$settings_tbl = get_option(
			'simpleblogcard_settings',
			array(
				'url' => null,
				'dessize' => 90,
				'imgsize' => 100,
				'color' => '#7db4e6',
				'color_width' => 5,
				'title' => null,
				't_line_height' => 120,
				'description' => null,
				'd_line_height' => 120,
				'target_blank' => false,
			)
		);

		foreach ( $settings_tbl as $key => $value ) {
			$shortcodekey = strtolower( $key );
			if ( empty( $a[ $shortcodekey ] ) ) {
				if ( 'dessize' === $key || 'imgsize' === $key ) {
					if ( is_numeric( $a[ $shortcodekey ] ) ) {
						$a[ $shortcodekey ] = 0;
					} else {
						$a[ $shortcodekey ] = $value;
					}
				} else {
					$a[ $shortcodekey ] = $value;
				}
			} else {
				if ( strtolower( $a[ $shortcodekey ] ) === 'false' ) {
					$a[ $shortcodekey ] = null;
				}
			}
		}

		return do_shortcode( $this->simpleblogcard( $a ) );

	}

	/** ==================================================
	 * Simple Blog Card
	 *
	 * @param array $settings  settings.
	 * @return string $content  contents.
	 * @since 1.00
	 */
	private function simpleblogcard( $settings ) {

		$contents = null;

		if ( $settings['url'] ) {
			$url = $settings['url'];
			$post_id = url_to_postid( $settings['url'] );
			if ( get_transient( 'simple_blog_card_' . esc_url( $url ) ) ) {
				/* Get cache */
				$call_site = get_transient( 'simple_blog_card_' . esc_url( $url ) );

				$title = $call_site['title'];
				$custom_title = $call_site['custom_title'];
				$description = $call_site['description'];
				$custom_description = $call_site['custom_description'];
				$dessize = $call_site['dessize'];
				$imgsize = $call_site['imgsize'];
				$img_url = $call_site['img_url'];
				$img = $call_site['img'];
				$img_width = $call_site['img_width'];
				$img_height = $call_site['img_height'];
				if ( $imgsize <> $settings['imgsize'] || $dessize <> $settings['dessize'] ||
						$custom_title <> $settings['title'] || $custom_description <> $settings['description'] ) {
					if ( 0 < $post_id ) {
						$html = 'inside';
					} else {
						$html = $this->get_contents_curl( $settings['url'] );
					}
					list( $title, $description, $img, $img_url, $img_width, $img_height ) = $this->re_generate( $settings, $html, $post_id );
				}
			} else {
				if ( 0 < $post_id ) {
					$html = 'inside';
				} else {
					$html = $this->get_contents_curl( $settings['url'] );
				}
				list( $title, $description, $img, $img_url, $img_width, $img_height ) = $this->re_generate( $settings, $html, $post_id );
			}
			$host = null;
			if ( 0 == $post_id ) {
				$host = parse_url( $url, PHP_URL_HOST );
			}
			$contents .= '<div class="simpleblogcard_wrap">';
			if ( $settings['target_blank'] ) {
				$contents .= '<a style="text-decoration: none;" href="' . $url . '" target="_blank" rel="noopener">';
			} else {
				$contents .= '<a style="text-decoration: none;" href="' . $url . '">';
			}
			if ( $img ) {
				$contents .= '<div style="float: right; padding: 10px;">';
				$contents .= '<img style="border-radius: 5px; width: ' . $img_width . 'px; height: ' . $img_height . 'px;" src="' . $img_url . '" alt="' . $title . '" />';
				$contents .= '</div>';
			}
			$contents .= '<div class="simpleblogcard_inner">';
			$contents .= '<div class="simpleblogcard_border" style="border-left: solid ' . $settings['color_width'] . 'px ' . $settings['color'] . '; ">';
			$contents .= $host;
			$contents .= '<div class="simpleblogcard_title" style="line-height: ' . $settings['t_line_height'] . '%;">' . $title . '</div>';
			if ( $settings['dessize'] > 0 ) {
				$contents .= '<div class="simpleblogcard_description" style="line-height: ' . $settings['d_line_height'] . '%;">' . $description . '</div>';
			}
			$contents .= '</div>';
			$contents .= '</div>';
			$contents .= '<div style="clear: both;"></div>';
			$contents .= '</a>';
			$contents .= '</div>';
		} else {
			$contents .= '<div style="text-align: center;">';
			$contents .= '<div><strong><span class="dashicons dashicons-share-alt2" style="position: relative; top: 5px;"></span>Simple Blog Card</strong></div>';
			/* translators: Input URL */
			$contents .= sprintf( __( 'Please input "%1$s".', 'simple-blog-card' ), 'URL' );
			$contents .= '</div>';
		}

		return $contents;

	}

	/** ==================================================
	 * Re Generate
	 *
	 * @param array  $settings  settings.
	 * @param string $html  html.
	 * @param int    $post_id  post_id.
	 * @return array $title $description $img $img_url $img_width $img_height
	 * @since 1.04
	 */
	private function re_generate( $settings, $html, $post_id ) {

		$title = null;
		$description = null;
		$img_url = null;
		$img = false;
		$img_width = 0;
		$img_height = 0;
		$url = $settings['url'];
		if ( $html ) {
			if ( 'inside' === $html ) {
				$title = get_the_title( $post_id );
				$description = strip_shortcodes( get_post( $post_id )->post_content );
				$img_url = get_the_post_thumbnail_url( $post_id );
				if ( ! $img_url ) {
					if ( get_option( 'site_icon' ) ) {
						$siteicon_id = get_option( 'site_icon' );
						$img_url = wp_get_attachment_url( $siteicon_id );
					} else {
						$img_url = includes_url() . 'images/w-logo-blue.png';
					}
				}
			} else {
				$page = $this->parse( $html );
				if ( array_key_exists( 'title', $page->_values ) ) {
					$title = $page->_values['title'];
				}
				if ( array_key_exists( 'description', $page->_values ) ) {
					$description = $page->_values['description'];
				}
				if ( array_key_exists( 'image', $page->_values ) ) {
					$img_url = $page->_values['image'];
				}
			}

			if ( ! empty( $settings['title'] ) ) {
				$title = $settings['title'];
			}
			if ( ! empty( $settings['description'] ) ) {
				$description = $settings['description'];
			}

			$plus_str = null;
			if ( function_exists( 'mb_substr' ) ) {
				if ( $settings['dessize'] < mb_strlen( $description ) ) {
					$plus_str = '...';
				}
				$description = mb_substr( wp_strip_all_tags( $description, true ), 0, $settings['dessize'] ) . $plus_str;
			} else {
				if ( $settings['dessize'] < strlen( $description ) ) {
					$plus_str = '...';
				}
				$description = substr( wp_strip_all_tags( $description, true ), 0, $settings['dessize'] ) . $plus_str;
			}

			/* thumbnail */
			if ( $img_url && $settings['imgsize'] > 0 ) {
				$imagesize = @getimagesize( $img_url );
				if ( $imagesize ) {
					$img = true;
					$ratio = $imagesize[1] / $imagesize[0];
					$img_width = $settings['imgsize'];
					$img_height = intval( $settings['imgsize'] * $ratio );
				}
			}

			/* Set cache */
			$call_site = array(
				'title' => $title,
				'custom_title' => $settings['title'],
				'description' => $description,
				'custom_description' => $settings['description'],
				'dessize' => $settings['dessize'],
				'imgsize' => $settings['imgsize'],
				'img_url' => $img_url,
				'img' => $img,
				'img_width' => $img_width,
				'img_height' => $img_height,
			);
			set_transient( 'simple_blog_card_' . esc_url( $url ), $call_site, 86400 * 14 );

		} else {
			if ( $settings['title'] ) {
				$title = $settings['title'];
			} else {
				$title = $settings['url'];
			}
			$description = $settings['description'];
		}

		return array( $title, $description, $img, $img_url, $img_width, $img_height );

	}

	/** ==================================================
	 * Get contents
	 *
	 * @param string $url  url.
	 * @return string $html  html.
	 * @since 1.01
	 */
	private function get_contents_curl( $url ) {

		if ( is_admin() ) {
			$timeout = get_option( 'simpleblogcard_timeout', 10 );
		} else {
			$timeout = 3;
		}

		$option = array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => $timeout,
		);

		$ch = curl_init( $url );
		curl_setopt_array( $ch, $option );

		$html    = curl_exec( $ch );
		$info    = curl_getinfo( $ch );
		$errorno = curl_errno( $ch );

		if ( CURLE_OK !== $errorno ) {
			return null;
		}

		if ( 200 !== $info['http_code'] ) {
			return null;
		}

		return $html;

	}

	/** ==================================================
	 * Parse
	 *
	 * @param string $html  html.
	 * @return object $page  page.
	 * @since 1.02
	 */
	private function parse( $html ) {

		if ( function_exists( 'mb_convert_encoding' ) ) {
			$html = mb_convert_encoding( $html, 'HTML-ENTITIES', 'ASCII, JIS, UTF-8, EUC-JP, SJIS' );
		}

		$dom_document = new DOMDocument();
		libxml_use_internal_errors( true );
		$dom_document->loadHTML( $html );
		libxml_clear_errors();

		$tags = $dom_document->getElementsByTagName( 'meta' );
		if ( ! $tags || 0 === $tags->length ) {
			return false;
		}

		$page = new self();

		$non_og_description = null;

		foreach ( $tags as $tag ) {
			if ( $tag->hasAttribute( 'property' ) &&
				strpos( $tag->getAttribute( 'property' ), 'og:' ) === 0 ) {
				$key = strtr( substr( $tag->getAttribute( 'property' ), 3 ), '-', '_' );
				$page->_values[ $key ] = $tag->getAttribute( 'content' );
			}
			if ( $tag->hasAttribute( 'value' ) && $tag->hasAttribute( 'property' ) &&
				strpos( $tag->getAttribute( 'property' ), 'og:' ) === 0 ) {
				$key = strtr( substr( $tag->getAttribute( 'property' ), 3 ), '-', '_' );
				$page->_values[ $key ] = $tag->getAttribute( 'value' );
			}
			if ( $tag->hasAttribute( 'name' ) && $tag->getAttribute( 'name' ) === 'description' ) {
				$non_og_description = $tag->getAttribute( 'content' );
			}
		}

		$titles = $dom_document->getElementsByTagName( 'title' );
		if ( isset( $page->_values['title'] ) ) {
			if ( $titles->length > 0 ) {
				if ( strlen( $page->_values['title'] ) < $titles->item( 0 )->textContent ) {
					$page->_values['title'] = esc_html( $titles->item( 0 )->textContent );
				}
			}
		} else {
			if ( $titles->length > 0 ) {
				$page->_values['title'] = esc_html( $titles->item( 0 )->textContent );
			}
		}

		if ( isset( $page->_values['description'] ) ) {
			if ( $non_og_description ) {
				if ( strlen( $page->_values['description'] ) < strlen( $non_og_description ) ) {
					$page->_values['description'] = esc_html( $non_og_description );
				}
			}
		} else {
			if ( $non_og_description ) {
				$page->_values['description'] = esc_html( $non_og_description );
			}
		}

		if ( ! isset( $page->values['image'] ) ) {
			$domxpath = new DOMXPath( $dom_document );
			$elements = $domxpath->query( "//link[@rel='image_src']" );

			if ( $elements->length > 0 ) {
				$domattr = $elements->item( 0 )->attributes->getNamedItem( 'href' );
				if ( $domattr ) {
					$page->_values['image'] = $domattr->value;
					$page->_values['image_src'] = $domattr->value;
				}
			}
		}

		if ( empty( $page->_values ) ) {
			return false;
		}

		return $page;

	}

	/** ==================================================
	 * Load Style
	 *
	 * @since 1.15
	 */
	public function load_style() {

		wp_enqueue_style( 'simple-blog-card', plugin_dir_url( __DIR__ ) . 'css/simpleblogcard.css', array(), '1.00' );
		wp_add_inline_style( 'simple-blog-card', get_option( 'simpleblogcard_css', '.simpleblogcard_wrap { border: 1px solid #ddd; word-wrap: break-word; max-width: 100%; border-radius: 5px; margin: 30px; } .simpleblogcard_inner { line-height: 120%; padding: 10px; } .simpleblogcard_border { padding: 0.25em 0.25em; color: #494949; background: transparent; } .simpleblogcard_title { font-weight: bold; display: block; } .simpleblogcard_description { color: #333; }' ) );

	}

}


