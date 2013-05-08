<?php

	function nhop_page_header() {
?>
		<div id="c_page_header" class="page_header_page">
			<div class="page_header">
				<?php exit_logo(); ?>
				<div class="page_intro">
					<?php thematic_postheader(); ?>
				</div>
				<?php
					if (has_post_thumbnail()) {
				?>
						<div class="page_ill">
				<?php
							the_post_thumbnail();
				?>
						</div>
				<?php
					}
				?>
			</div>
		</div>
<?php
	}
	add_action('thematic_belowheader','nhop_page_header');
	
    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();

?>

	<div id="container">
		<div id="content">

            <?php
        
            // calling the widget area 'page-top'
            get_sidebar('page-top');

            the_post();
        
            ?>
            
			<div id="post-<?php the_ID(); ?>" class="<?php thematic_post_class() ?>">
            
				<div class="entry-content">

                    <?php
                    
                    the_content();
                    
                    wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'thematic'), "</div>\n", 'number');
                    
                    edit_post_link(__('Edit', 'thematic'),'<span class="edit-link">','</span>') ?>

				</div>
			</div><!-- .post -->

        <?php
        
        if ( get_post_custom_values('comments') ) 
            thematic_comments_template(); // Add a key/value of "comments" to enable comments on pages!
        
        // calling the widget area 'page-bottom'
        get_sidebar('page-bottom');
        
        ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php 

    // action hook for placing content below #container
    thematic_belowcontainer();

    // calling the standard sidebar 
    //thematic_sidebar();
    
    // calling footer.php
    get_footer();

?>