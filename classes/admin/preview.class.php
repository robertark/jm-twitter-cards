<?php
if (!defined('JM_TC_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

if ( ! class_exists('JM_TC_Preview') ) {

    class JM_TC_Preview{
        /**
         * output cards preview
         * @param WP_Post $post
         * @return string
         */
        public static function show_preview(WP_Post $post){

            $options = new JM_TC_Options;
            $opts = jm_tc_get_options();

            $is_og = $opts['twitterCardOg'];

            /* most important meta */
            $cardType_arr = $options->cardType($post);
            $creator_arr = $options->creatorUsername(true, $post);
            $site_arr = $options->siteUsername();
            $title_arr = $options->title($post);
            $description_arr = $options->description($post);
            $img_arr = $options->image($post);


            /* secondary meta */
            $product_arr = $options->product($post);

            // default
            $app = '';
            $size = 16;
            $class = 'featured-image';
            $tag = 'img';
            $img = '';
            $close_tag = '';
            $src = 'src';
            $product_meta = '';
            $styles = '';
            $hide = '';

            if( isset($img_arr['image'],$img_arr['image:src'])) {
                $img = ('yes' === $is_og) ? $img_arr['image'] : $img_arr['image:src'];
            }

            $img_summary = '';
            $gallery_meta = '';

            // particular cases
            if (in_array('summary_large_image', $cardType_arr)) {

                $styles = "width:100%;";
                $size = "100%";
            } elseif (in_array('photo', $cardType_arr)) {

                $styles = "width:100%;";
                $size = "100%";

            } elseif (in_array('player', $cardType_arr)) {

                $styles = "width:100%;";
                $img = ($is_og == 'yes') ? $img_arr['image'] : $img_arr['image:src'];
                $src = "controls poster";
                $tag = "video";
                $close_tag = "</video>";
                $size = "100%";

            } elseif (in_array('gallery', $cardType_arr)) {

                $hide = 'hide';
                $gallery_meta = '<div class="gallery-meta-container">';

                if (is_array($img_arr)) {

                    $i = 0;

                    foreach ($img_arr as $name => $url) {
                        $gallery_meta .= '<img class="tile" src="' . $url . '" alt="" />';

                        $i++;

                        if ($i > 3) break;

                    }
                }

                $gallery_meta .= '</div>';

            } elseif (in_array('summary', $cardType_arr)) {

                $styles = 'width: 60px; height: 60px; margin-left:.6em;';
                $size = 60;
                $hide = 'hide';
                $class = 'summary-image';
                $img_summary = '<img class="' . $class . '" width="' . $size . '" height="' . $size . '" style="' . $styles . ' -webkit-user-drag: none; " ' . $src . '="' . $img . '">';

            } elseif (in_array('product', $cardType_arr)) {

                $product_meta = '<div class="product-view" style="position:relative;">';
                $product_meta .= '<span class="bigger"><strong>' . $product_arr['data1'] . '</strong></span>';
                $product_meta .= '<span>' . $product_arr['label1'] . '</span>';
                $product_meta .= '<span class="bigger"><strong>' . $product_arr['data2'] . '</strong></span>';
                $product_meta .= '<span>' . $product_arr['label2'] . '</span>';
                $product_meta .= '</div>';

                $styles = 'float:left; width: 120px; height: 120px; margin-right:.6em;';
                $size = 120;
            } elseif (in_array('app', $cardType_arr)) {

                $hide = 'hide';
                $class = 'bg-opacity';
                $app = '<div class="app-view" style="float:left;">';
                $app .= '<strong>' . __('Preview for app cards is not available yet.', JM_TC_TEXTDOMAIN) . '</strong>';
                $app .= '</div>';
            } else {

                $styles = "float:none;";
            }


            $output = '<div class="fake-twt">';
            $output .= $app;
            $output .= '<div class="e-content ' . $class . '">
							<div style="float:left;">
							' . get_avatar(false, 16) . '
							
							<span>' . __('Name associated with ', JM_TC_TEXTDOMAIN) . $site_arr['site'] . '</span>
							
							<div style="float:left;" class="' . $hide . '">
								<' . $tag . ' class="' . $class . '" width="' . $size . '" height="' . $size . '" style="' . $styles . ' -webkit-user-drag: none; " ' . $src . '="' . $img . '">' . $close_tag . '
							
							' . $product_meta . '
							</div>
							</div>
							
							' . $gallery_meta . '
									
							<div style="float:left;">
							<div><strong>' . $title_arr['title'] . '</strong></div>
							<div><em>By ' . __('Name associated with ', JM_TC_TEXTDOMAIN) . $creator_arr['creator'] . '</em></div>
							<div>' . $description_arr['description'] . '</div>
							</div>
							'
                . $img_summary .
                '
							
							<div style="float:left;" class="gray"><strong>' . __('View on the web', JM_TC_TEXTDOMAIN) . '<strong></div>
						
						</div></div>';

            $output .= '</div>';

            return $output;

        }
    }
}