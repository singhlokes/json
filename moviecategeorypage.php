<?php
/* Template Name: Movies Categories Template */ 
?>
<?php get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <?php
            $MovieCatTerms = get_terms( array(
            'taxonomy' => 'MovieCategory',
            'hide_empty' => false,
            ));
            // echo "<pre>";
            // print_r($MovieCatTerms);
            // echo "</pre>";
          if(!empty($MovieCatTerms)){
                    foreach ($MovieCatTerms as  $MovieCatValue) {
                        $MoviesCatId = $MovieCatValue->term_id;
                        $term_link = get_term_link( $MovieCatValue ); ?>
                        <a href="#" id="<?php echo $MoviesCatId; ?>" class="moviecat"><?php echo $MovieCatValue->name; ?></a>
                    <?php
                    }
                }
            ?>        
        </main><!-- .site-main -->
</div><!-- .content-area -->

<div class="allmobies">
    
    
</div>
<?php get_footer(); ?>                                             
