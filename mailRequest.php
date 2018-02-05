<?php
/* Template Name: mailRequest */
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$busName = $_POST['busName'];
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$street = $_POST['street'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$comments = filter_var($_POST['comments'], FILTER_UNSAFE_RAW, 'FILTER_FLAG_HIGH');
$to = 'zack@zackglaserlegal.com';
$subject = 'Zack Glaser Legal Request';
$from = $email;
$message = "Name: " . $fName . " " . $lName . "\r\n Business: " . $busName . "\r\n Street: " . $street . "\r\n City, ST, Zip: " . $city . ", " . $state . ", " . $zip . "\r\n Comments: " . $comments;


 $is_not_home = ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) );

 if ( $is_not_home ) :
  get_header();

 $left_sidebar   = onetone_option('left_sidebar_blog_archive','');
 $right_sidebar  = onetone_option('right_sidebar_blog_archive','');
 $aside          = 'no-aside';
 if( $left_sidebar !='' )
 $aside          = 'left-aside';
 if( $right_sidebar !='' )
 $aside          = 'right-aside';
 if(  $left_sidebar !='' && $right_sidebar !='' )
 $aside          = 'both-aside';

 ?>
   <section class="page-title-bar title-left no-subtitle">
     <div class="container">
       <hgroup class="page-title">
         <h1>
         <?php
 		 $blog_title = get_the_title( get_option('page_for_posts', true) );
 		 echo $blog_title;
 		?>
         </h1>
       </hgroup>



  <?php onetone_get_breadcrumb(array("before"=>"<div class=''>","after"=>"</div>","show_browse"=>false,"separator"=>'','container'=>'div'));?>
       <div class="clearfix"></div>
     </div>
   </section>
 <div class="post-wrap">
             <div class="container">
                 <div class="post-inner row <?php echo $aside; ?>">
                     <div class="col-main">
                         <section class="post-main" role="main" id="content">
                             <article class="page type-page" role="article">
                               <?php
                               if (mail ($to , $subject , $message, $from, '-fzack@zackglaserlegal.com')) {
                                         echo "<div class='col-md-12 text-center'>
                                                 <h3>Thank you for your interest. Your request was sent successfully. Our office will contact you shortly to set-up a consultation.</h3>
                                                  </div>";
                                       } else {
                                         echo "<div class='col-md-12 text-center'>Something went wrong. Please send your request again. If you continue to have trouble, please contact our office directly.</div>";
                                       };?>
                             <?php if (have_posts()) :?>
                                 <!--blog list begin-->
                                 <div class="blog-list-wrap">

                                 <?php while ( have_posts() ) : the_post();?>
                                 <?php get_template_part("content",get_post_format()); ?>
                                 <?php endwhile;?>
                                 </div>
                                 <?php endif;?>
                                 <!--blog list end-->
                                 <!--list pagination begin-->
                                 <nav class="post-list-pagination" role="navigation">
                                     <?php if(function_exists("onetone_native_pagenavi")){onetone_native_pagenavi("echo",$wp_query);}?>
                                 </nav>
                                 <!--list pagination end-->
                             </article>
                             <div class="post-attributes"></div>
                         </section>
                     </div>
                     <?php if( $left_sidebar !='' ):?>
                     <div class="col-aside-left">
                         <aside class="blog-side left text-left">
                             <div class="widget-area">
                                 <?php get_sidebar('archiveleft');?>
                             </div>
                         </aside>
                     </div>
                     <?php endif; ?>
                     <?php if( $right_sidebar !='' ):?>
                     <div class="col-aside-right">
                        <?php get_sidebar('archiveright');?>
                     </div>
                     <?php endif; ?>

                 </div>
             </div>
         </div>
 <?php get_footer();?>
 <?php
   else:
 ?>
 <?php get_template_part('template','home');?>
 <?php endif;?>
