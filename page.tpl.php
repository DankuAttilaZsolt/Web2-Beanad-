<!DOCTYPE html>
<html>
<head>
  <meta name="keywords" content="Web-programozás II.">
  <meta charset="utf-8">
  <title><?php echo $page->GetPageTitle(); ?> Danku Attial Beadandó</title>
  <link rel="stylesheet" type="text/css" href="style/style.css" media="screen">
  <link rel="stylesheet" type="text/css" href="style/superfish.css" media="screen">
  <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
  <script type="text/javascript" src="js/superfish.js"></script>
  <script type="text/javascript">
    // initialise plugins
    jQuery(function(){
      jQuery('ul.sf-menu').superfish();
    });
  </script>
</head>
<body>
  <div id="wrapper">
    <div id="header-wrapper">
      <div id="header">
        <div id="logo">
          <h1><a href="."><span>Vape </span></a></h1>
          <p>"Elektromos cigaretta"</p>
          <p> design by <a href="http://templated.co/">templated</a></p>
        </div>
        <div id="menu">
          <?php
            echo $page->GetPageMenu();
          ?>
        </div>
      </div>
    </div>
    <!-- end #header -->
    <div id="page">
      <div id="page-bgtop">
        <div id="page-bgbtm">
          <div id="content">
            <?php
              include("content/".$pid.".php");
            ?>
            <div style="clear: both;">&nbsp;</div>
          </div>
          <!-- end #content -->
          <div id="sidebar">
            <ul>
              <li>
                <div id="search" >
                  <form method="get" action="#">
                    <div>
                      <input type="text" name="s" id="search-text" value="" />
                      <input type="submit" id="search-submit" value="Keres" />
                    </div>
                  </form>
                </div>
                <div style="clear: both;">&nbsp;</div>
              </li>
              <?php
                echo $page->GetSidebarMenu();
              ?>
            </ul>
          </div>
          <!-- end #sidebar -->
          <div style="clear: both;">&nbsp;</div>
        </div>
      </div>
    </div>
    <!-- end #page -->
  </div>
  <div id="footer">
    <p>&copy; 2018. Danku Attila Zsolt / Design by <a href="http://templated.co/">templated</a>.</p>
  </div>
  <!-- end #footer -->
</body>
</html>
