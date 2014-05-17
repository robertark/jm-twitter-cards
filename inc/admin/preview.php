<?php
if ( ! defined( 'JM_TC_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if( class_exists('JM_TC_Options') ) {


	class JM_TC_Preview extends JM_TC_Options {
		
		
		function show_preview($post_ID){
			
			/* most important meta */
			$cardType_arr 		= parent::cardType( $post_ID ) ;
			$creator_arr 		= parent::creatorUsername( true ) ;
			$site_arr			= parent::siteUsername() ;
			$title_arr 			= parent::title( $post_ID );
			$description_arr 	= parent::description( $post_ID );
			$img_arr 			= parent::image( $post_ID );
			
			
			/* secondary meta */
			$product_arr 	= parent::product( $post_ID );
			$player_arr  	= parent::player( $post_ID );
			
			// default 
			$app 			= '';
			$size 			= 16;
			$class  		= 'featured-image';
			$tag			= 'img';
			$close_tag 		= '';
			$src			= 'src';
			$product_meta 	= '';
			$styles			= '';
			$floatleft      = 'float:left;';
			$position		= 'position:relative;';
			$hide			= '';
			$img  			= ''; 
			$gallery_meta   = '';
			
			// particular cases
			if( in_array('summary_large_image', $cardType_arr ) ) {
				
				$styles = "width:100%;";
				$img	= $img_arr['image:src'];
				$size   = "100%";	
			}
			
			elseif( in_array('photo', $cardType_arr ) ) {
				
				$styles = "width:100%;";
				$img	= $img_arr['image:src'];
				$size   = "100%";
				
			}

			elseif( in_array('player', $cardType_arr) ) {
				
				$styles 	= "width:100%;";
				$img	    = $img_arr['image:src'];
				$src		= "controls poster";
				$tag    	= "video";
				$close_tag 	= "</video>";
				$size   	= "100%";
				
			}
			
			elseif( in_array('gallery', $cardType_arr) ) {
			
				$hide = "hide";
				$gallery_meta  = '<div class="gallery-meta-container">';
				
				$i = 0;
				
				foreach($img_arr as $name => $url) $gallery_meta .= '<img class="tile" src="'.$url.'" alt="" />';
				
				$i++;
				if ($i > 3) break;
				
				$gallery_meta .= '</div>';
				
			}
			
			elseif( in_array('summary', $cardType_arr) ) {
				
				$styles    = "width: 60px; height: 60px; margin-left:.6em;";
				$size      = 60;
				$img       = $img_arr['image:src'];
				
			}
			
			elseif( in_array( 'product', $cardType_arr) ) {
			
				$hide = "hide";
				
				$product_meta  = '<div class="product-view" style="position:relative;">';
				$product_meta .= '<span class="bigger"><strong>'.$product_arr['data1'].'</strong></span>';
				$product_meta .= '<span>'.$product_arr['label1'].'</span>';
				$product_meta .= '<span class="bigger"><strong>'.$product_arr['data2'].'</strong></span>';
				$product_meta .= '<span>'.$product_arr['label2'].'</span>';
				$product_meta .= '</div>';
				

				$styles 	   = "float:left; width: 120px; height: 120px; margin-right:.6em;";
				$img           = $img_arr['image:src'];
				$size   	   = 120;
			}
			
			elseif( in_array('app', $cardType_arr) ) {
				
				$hide = "hide";
				$app  = '<div class="gray" style="postion:relative;">Get app</div>';
			}
			
			else {
				
				$styles = "position: absolute; width: 120px; height: 120px; left: 0px; top: 0px;";
			}
			
			
			$output  = '<div class="fake-twt" style="">';
			$output .= '<div class="e-content">
							<div style="'.$floatleft.'">
							'.get_avatar( false, 16 ).'	
							
							<span>'.__('Name associated with ','jm-tc').$site_arr['site'].'</span>
							
							<div style="'.$floatleft.'" class="'.$hide.'">
								<'.$tag.' class="'.$class.'" width="'.$size.'" height="'.$size.'" style="'.$styles.' -webkit-user-drag: none; " '.$src.'="'.$img.'">'.$close_tag.'
							
							'.$product_meta.'
							</div>
							</div>
							
							'.$gallery_meta.'
									
							<div style="'.$floatleft.'">
							<div><strong>'.$title_arr['title'].'</strong></div>
							<div><em>By '.__('Name associated with ','jm-tc').$creator_arr['creator'].'</em></div><div>'.$description_arr['description'].'</div>
							</div>
							
							'
			.$app.
			'
							<div style="float:left;" class="gray"><strong>'.__('View on the web','jm-tc').'<strong></div>
						
						</div>';
			
			$output .= '</div>';
			
			return $output;
			
		}
		
		
	}
	
	
}