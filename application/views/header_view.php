<!--Change the background class to alter background image, options are: benches, boots, buildings, city, metro -->
<!DOCTYPE html>
<html lang="en">
<head>
  <link href="<?php echo base_url('assets/lib/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">

</head>
<body>
<div id="background-wrapper" class="buildings" data-stellar-background-ratio="0.1">

<!-- ======== @Region: #navigation ======== -->
<div id="navigation" class="wrapper">
  <!--Hidden Header Region-->
  <div class="header-hidden collapse">
    <div class="header-hidden-inner container">
      <div class="row">
        <div class="col-md-3">
          <h3>
              About Us
            </h3>
          <p>Flexor is a super flexible responsive theme with a modest design touch.</p>
          <a href="about.html" class="btn btn-more"><i class="fa fa-plus"></i> Learn more</a>
        </div>
        <div class="col-md-3">
          <!--@todo: replace with company contact details-->
          <h3>
              Contact Us
            </h3>
          <address>
              <strong>Flexor Bootstrap Theme Inc</strong>
              <abbr title="Address"><i class="fa fa-pushpin"></i></abbr>
              Sunshine House, Sunville. SUN12 8LU.
              <br>
              <abbr title="Phone"><i class="fa fa-phone"></i></abbr>
              019223 8092344
              <br>
              <abbr title="Email"><i class="fa fa-envelope-alt"></i></abbr>
              info@flexorinc.com
            </address>
        </div>
        <div class="col-md-6">
          <!--Colour & Background Switch for demo - @todo: remove in production-->
          <h3>
              Theme Variations
            </h3>
          <div class="switcher">
            <div class="cols">
              Backgrounds:
              <br>
              <a href="#benches" class="background benches active" title="Benches">Benches</a> <a href="#boots" class="background boots " title="Boots">Boots</a> <a href="#buildings" class="background buildings " title="Buildings">Buildings</a>
              <a
                href="#city" class="background city " title="City">City</a> <a href="#metro" class="background metro " title="Metro">Metro</a>
            </div>
            <div class="cols">
              Colours:
              <br>
              <a href="#orange" class="colour orange active" title="Orange">Orange</a> <a href="#green" class="colour green " title="Green">Green</a> <a href="#blue" class="colour blue " title="Blue">Blue</a> <a href="#lavender" class="colour lavender "
                title="Lavender">Lavender</a>
            </div>
          </div>
          <p>
            <small>Selection is not persistent.</small>
          </p>
        </div>
      </div>
    </div>
  </div>
  <!--Header & navbar-branding region-->
  <div class="header">
    <div class="header-inner container">
      <div class="row">
        <div class="col-md-8">
          <!--navbar-branding/logo - hidden image tag & site name so things like Facebook to pick up, actual logo set via CSS for flexibility -->
          <a class="navbar-brand" href="index.html" title="Home">
            <h1 class="hidden">
                <img src="img/logo.png" alt="Flexor Logo">
                Flexor
              </h1>
          </a>
          <div class="navbar-slogan">
            Responsive HTML Theme
            <br> By BootstrapMade.com
          </div>
        </div>
        <!--header rightside-->
        <div class="col-md-4">
          <!--user menu-->
          <ul class="list-inline user-menu pull-right">
            
        <?php 
        if (isset($this->session->userdata['loged_in'])) { ?>
             <li class="user-register"><i class="glyphicon glyphicon-user"></i> <a href= "<?php echo base_url('index.php/ProfileController')?>" class="text-uppercase">
            <?php $session_data = $this->session->userdata('loged_in');
                      echo $session_data['fName']." ".$session_data['lName'] ;
               ?>
          
          </a></li>

          <li>
          <?php $session_data = $this->session->userdata('loged_in');
                      echo "<b>| cash : </b>".$session_data['cash'] ;
               ?>
        </li>

          <li class="user-logout"><i class="fa fa-fw fa-lock"></i> <a href="<?php echo base_url('index.php/HomeController/logout')?>" class="text-uppercase">Log out</a></li>
        <?php }  ?>
           
          <?php if(!isset($this->session->userdata['loged_in'])) { ?>
          
            <li class="user-register"><i class="fa fa-edit text-primary "></i> <a href="<?php echo base_url('index.php/RegisterController')?>" class="text-uppercase">Register</a></li>
            <li class="user-login"><i class="fa fa-sign-in text-primary"></i> <a href="<?php echo base_url('index.php/LoginController')?>" class="text-uppercase">Login</a></li>
          <?php }
         ?>
          </ul>



          
        </div>
      </div>
    </div>
  </div>
  <div class="container">
  <div class ="row">
  <form accept-charset="UTF-8" role="form" action = "<?php echo base_url('index.php/BookController'); ?>" method="POST" enctype="multipart/form-data">
    <div class ="col-md-2 col-md-offset-8" style="margin-left:77%">
      <div class = "form-group">
        <input type="text" name="name" class ="form-control" id="name" placeholder ="search" />
      </div>
    </div>
    <div class = "col-md-1" style = "margin-left:-2%">
      <input id="send" class="btn btn-info" type="submit" value="Search">   
    </div>
  </form>
  </div>
    <div class="navbar navbar-default">
      <!--mobile collapse menu button-->
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <!--social media icons-->
      <div class="navbar-text social-media social-media-inline pull-right">
        <!--@todo: replace with company social media details-->
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-google-plus"></i></a>
      </div>
      <!--everything within this div is collapsed on mobile-->
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav" id="main-menu">
          <li class="icon-link">
            <a href="<?php echo base_url('index.php/HomeController') ?>"><i class="fa fa-home"></i></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Books<b class="caret"></b></a>
            <!-- Dropdown Menu -->
            <ul class="dropdown-menu">
              <li class="dropdown-header">Book types</li>
              <?php 
                foreach ($bookTypes as $key => $type) { ?> 
                  <li><a href="<?php echo base_url('index.php/BookTypeController/getByType/'.$type['type_ID']) ?>" tabindex="-1" class="menu-item"><?php echo $type['typeName']?></a></li>
              <?php } ?> 
              <li class="dropdown-footer">End types</li>
            </ul>
          </li>
          <li><a href="<?php echo base_url('index.php/PromotionController')?>">Promotion</a></li>
          <li class="dropdown dropdown-mm">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reader<b class="caret"></b></a>
            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-mm dropdown-menu-persist">
              <li class="row">
                <ul class="col-md-6">
                  <li class="dropdown-header">Websites and Apps</li>
                  <li><a href="<?php echo base_url('index.php/ProfileController')?>">Profile</a></li>
                  <li><a href="<?php echo base_url('index.php/LibraryController')?>">My Library</a></li>
                  <li><a href="<?php echo base_url('index.php/HistoryPurchaseController') ?>">History purchase</a></li>
                  <li><a href="<?php echo base_url('index.php/HistoryTopUpController')?>">History top-up</a></li>
                  <li><a href="#">Favorite</a></li>
                  <li><a href="<?php echo base_url('index.php/TopUpController')?>">Top-up</a></li>
                </ul>
                <ul class="col-md-6">
                  <li class="dropdown-header">Enterprise solutions</li>
                  <li><a href="#">Business Analysis</a></li>
                  <li><a href="#">Custom UX Consulting</a></li>
                  <li><a href="#">Quality Assurance</a></li>
                </ul>
              </li>
              <li class="dropdown-footer">Dropdown footer</li>
            </ul>
          </li>
          <li>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Writer & Publisher<b class="caret"></b></a>
            <ul class="dropdown-menu dropdown-menu-mm dropdown-menu-persist">
              <li class="row">
                <ul class="col-md-6">
                  <li class="dropdown-header">Websites and Apps</li>
                  <li><a href="#">Profile</a></li>
                  <li><a href="<?php echo base_url('index.php/LibraryController')?>">My Library</a></li>                      
                  <li><a href="#">Upload book</a></li>
                  <li><a href="#">Add promotion</a></li>
                  <li><a href="#">Total sale</a></li>
                </ul>
                <ul class="col-md-6">
                  <li class="dropdown-header">Enterprise solutions</li>
                  <li><a href="#">Business Analysis</a></li>
                  <li><a href="#">Custom UX Consulting</a></li>
                  <li><a href="#">Quality Assurance</a></li>
                </ul>
              </li>
              <li class="dropdown-footer">Dropdown footer</li>
            </ul>
          </li>
          <li><a href="#">User Guide</a></li>
        </ul>
      </div>
      <!--/.navbar-collapse -->
    </div>
  </div>
</div>
</div>
</body>
</html>

