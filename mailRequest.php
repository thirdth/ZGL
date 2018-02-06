<?php
/* Template Name: mailRequest */


/*Gather and prepare POST variables from the forms*/
$formName = $_POST['formName'];
$fName = filter_var($_POST['fName'], FILTER_SANITIZE_STRING);
$lName = filter_var($_POST['lName'], FILTER_SANITIZE_STRING);
$busName = filter_var($_POST['busName'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$street = filter_var($_POST['street'], FILTER_SANITIZE_STRING);
$city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
$zip = filter_var($_POST['zip'], FILTER_SANITIZE_STRING);
$comments = filter_var($_POST['comments'], FILTER_UNSAFE_RAW, 'FILTER_FLAG_HIGH');
$to = 'zack@zackglaserlegal.com';
$subject = "ZGL Req from: " . $fName . " " . $lName . " " . $busName;
$from = $email;
$message = " Form: " . $formName . "\r\n Name: " . $fName . " " . $lName . "\r\n Business: " . $busName . "\r\n Street: " . $street . "\r\n City, ST, Zip: " . $city . ", " . $state . ", " . $zip . "\r\n Comments: " . $comments;

/*Check for required fields*/
if ($_POST['email'] == '')  {
  header("Location: /" . $formName);
  die();
}

/*Check for CAPTCHA*/
if(isset($_POST['g-recaptcha-response'])) {
  $captcha=$_POST['g-recaptcha-response'];
}
if(!$captcha){
  header("Location: /" . $formName);
  die();
}

/* Start Page Template */
get_header();
$display_breadcrumb = 'yes';


$sidebar                   = isset($page_meta['page_layout'])?$page_meta['page_layout']:'none';
$left_sidebar              = isset($page_meta['left_sidebar'])?$page_meta['left_sidebar']:'';
$right_sidebar             = isset($page_meta['right_sidebar'])?$page_meta['right_sidebar']:'';
$full_width                = isset($page_meta['full_width'])?$page_meta['full_width']:'no';
$display_breadcrumb        = isset($page_meta['display_breadcrumb'])?$page_meta['display_breadcrumb']:$display_breadcrumb;
$display_title             = isset($page_meta['display_title'])?$page_meta['display_title']:'yes';
$padding_top               = isset($page_meta['padding_top'])?$page_meta['padding_top']:'';
$padding_bottom            = isset($page_meta['padding_bottom'])?$page_meta['padding_bottom']:'';

if( $full_width  == 'no' )
 $container = 'container';
else
 $container = 'container-fullwidth';

$aside          = 'no-aside';
if( $sidebar =='left' )
$aside          = 'left-aside';
if( $sidebar =='right' )
$aside          = 'right-aside';
if(  $sidebar =='both' )
$aside          = 'both-aside';

$container_css = '';
if( $padding_top )
$container_css .= 'padding-top:'.$padding_top.';';
if( $padding_bottom )
$container_css .= 'padding-bottom:'.$padding_bottom.';';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

 <?php if (  $display_breadcrumb == 'yes' ): ?>


  <section class="page-title-bar title-left no-subtitle" style="">
    <div class="container">
      <hgroup class="page-title">
        <h1>
          <?php the_title();?>
        </h1>
      </hgroup>


   <?php onetone_get_breadcrumb(array("before"=>"<div class=''>","after"=>"</div>","show_browse"=>false,"separator"=>'','container'=>'div'));?>

      <div class="clearfix"></div>
    </div>
  </section>

  <?php endif;?>

  <div class="post-wrap">
    <div class="<?php echo $container;?>">
      <div class="post-inner row <?php echo $aside; ?>" style=" <?php echo $container_css;?>">
        <div class="col-main">
          <section class="post-main" role="main" id="content">
            <?php while ( have_posts() ) : the_post(); ?>
            <article class="post type-post" role="article">
              <?php if (  has_post_thumbnail() ): ?>
              <div class="feature-img-box">
                <div class="img-box">
                  <?php the_post_thumbnail();?>
                </div>
              </div>
              <?php endif;?>
              <div class="entry-main">

                <div class="entry-content">
                  <?php
                  if (mail ($to , $subject , $message, $from, '-fzack@zackglaserlegal.com')) {
                            echo "<div class='col-md-12 text-center'>
                                    <h3>Thank you for your interest. Your request was sent successfully. Our office will contact you shortly to set-up a consultation.</h3>
                                     </div>";
                          } else {
                            echo "<div class='col-md-12 text-center'>Something went wrong. Please send your request again. If you continue to have trouble, please contact our office directly.</div>";
                          };
                  ?>
                  <?php the_content();?>
                  <?php
				wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'onetone' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
				?>
                </div>

              </div>
            </article>
            <div class="post-attributes">
              <!--Comments Area-->
              <div class="comments-area text-left">
                <?php
					  // If comments are open or we have at least one comment, load up the comment template
					  if ( comments_open()  ) :
						  comments_template();
					  endif;
				  ?>
              </div>
              <!--Comments End-->
            </div>
            <?php endwhile; // end of the loop. ?>
          </section>
        </div>
        <?php if(  $sidebar =='left' || $sidebar =='both' ):?>
        <div class="col-aside-left">
          <aside class="blog-side left text-left">
            <div class="widget-area">
              <?php get_sidebar('pageleft');?>
            </div>
          </aside>
        </div>
        <?php endif; ?>
        <?php if(  $sidebar =='right' || $sidebar =='both' ):?>
        <div class="col-aside-right">
          <?php get_sidebar('pageright');?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</article>
<?php get_footer();
