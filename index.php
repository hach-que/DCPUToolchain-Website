<?php

$ctx = stream_context_create(array('http' => array('timeout' => 2)));

// Get information.
$info = @file_get_contents("http://178.32.51.157/info.txt", false, $ctx);
if ($info != null) {
  $opts = explode("\n", $info);
  $i = 0;
  $experimental_version = $opts[$i++];
  $experimental_ahead = $opts[$i++];
  $stable_version = $opts[$i++];
  $stable_windows = $opts[$i++];
  $stable_mac = $opts[$i++];
  $stable_linux = $opts[$i++];
  $experimental_windows = $opts[$i++];
  $experimental_mac = $opts[$i++];
  $experimental_linux = $opts[$i++];
  $portable_windows = $opts[$i++];
  $portable_mac = $opts[$i++];
  $portable_linux = $opts[$i++];
}

// Function for displaying available downloads.
function display_downloads($type)
{
  $windows_type = $type . "_windows";
  $mac_type = $type . "_mac";
  $linux_type = $type . "_linux";
  global $$windows_type, $$mac_type, $$linux_type, $stable_version, $experimental_version;
  $i = 0;
  $buttons = "";
  if ($$windows_type != "") {
    $buttons = $buttons . '<a href="' . $$windows_type . '" class="btn btn-download"><img src="img/windows.png" />Windows</a> ';
    $i++;
  } else {
    $buttons = $buttons . '<a href="#" class="btn btn-download disabled"><img src="img/windows.png" />Windows</a> ';
  }
  if ($$mac_type != "") {
    $buttons = $buttons . '<a href="' . $$mac_type . '" class="btn btn-download-mac"><img src="img/mac.png" />Mac</a> ';
    $i++;
  } else {
    $buttons = $buttons . '<a href="#" class="btn btn-download-mac disabled"><img src="img/mac.png" />Mac</a> ';
  }
  if ($$linux_type != "") {
    $buttons = $buttons . '<a href="' . $$linux_type . '" class="btn btn-download"><img src="img/linux.png" />Linux</a> ';
    $i++;
  } else {
    $buttons = $buttons . '<a href="#" class="btn btn-download disabled"><img src="img/linux.png" />Linux</a> ';
  }
  if ($type == "stable")
    $version = $stable_version;
  else
    $version = $experimental_version;
  if ($i > 0) {
    print($buttons);
    print('<a href="#" data-placement="bottom" rel="tooltip" title="This is the current ' . $type . ' version." style="color: #666; font-size: 10px; line-height: 24px; margin-left: 20px;">#' . substr($version, 0, 9) . '</a>');
  } else {
    print('<a href="#" data-placement="left" rel="tooltip" title="Our build server does not appear to be producing any builds in this branch." style="color: #666; font-size: 10px; line-height: 24px;">There are currently no ' . $type . ' builds available.</a>');
  }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DCPU-16 Toolchain</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta name="description" content="DCPU-16 Toolchain including emulator, assembler, C compiler, standard library and kernel.">
  	<meta name="author" content="James Rhodes">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      html, body { height: 100%; margin: 0px; padding: 0px; }
      body {
        background: url(http://farm3.staticflickr.com/2387/3536246838_9775d1e118_o.jpg);
        background-color: rgba(255, 255, 255, 0.5);
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }

      /* Custom container */
      .container-narrow {
        margin: 0 auto;
        max-width: 760px;
        background-color: rgba(255, 255, 255, 0.95);
        padding-top: 20px;
        padding-left: 50px;
        padding-right: 50px;
        padding-bottom: 5px;
        border-left: #333 solid 1px;
        border-right: #666 solid 1px;
        min-height: 100%;
        box-sizing: border-box;
      }
      .container-narrow > hr {
        margin: 30px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 60px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 72px;
        line-height: 1;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }
      .marketing h4 {
        cursor: default;
      }

      .btn-download, .btn-download-mac {
        position: relative;
        padding-left: 42px;
        padding-right: 10px;
      }
      .btn-download img, .btn-download-mac img {
        position: absolute;
        width: 32px;
        height: 32px;
        top: -3px;
        left: 5px;
      }
      .btn-download-mac img {
        top: -4px;
      }
      .modal-body h4 {
        margin-top: 1em;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <!--<link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">-->
  </head>

  <body>

    <div class="container-narrow">

      <div class="masthead">
        <ul class="nav nav-pills pull-right">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="http://dms.dcputoolcha.in/human/tree/pretty">Modules</a></li>
          <li><a href="http://dcputoolcha.in/docs/">Documentation</a></li>
          <li><a href="https://github.com/DCPUTeam/DCPUToolchain">GitHub</a></li>
        </ul>
        <h3 class="muted">DCPU-16 Toolchain</h3>
      </div>

      <hr>

      <div class="jumbotron">
        <h1><em>The</em> open source toolchain for 0x10c</h1>
        <p class="lead">The full stack, from top to bottom.  Write, assemble, link and debug programs against any kernel, on any platform with the toolchain.</p>
        <a class="btn btn-large btn-success" href="#download" role="button" data-toggle="modal">Download now</a>
      </div>

      <hr>

      <div class="row-fluid marketing">
        <div class="span6">
          <h4 data-placement="left" rel="tooltip" title="An integrated development environment deals with building your code.">IDE</h4>
          <p>The toolchain's integrated development environment provides an easy-to-use GUI for writing DCPU-16 programs.</p>

          <h4 data-placement="left" rel="tooltip" title="A debugger assists in finding bugs or issues in your program.">Debugger</h4>
          <p>GDB-style debugging of DCPU programs.  Extended with modules to provide interrupt checking, stack verification and more.</p>
        </div>

        <div class="span6">
          <h4 data-placement="right" rel="tooltip" title="An assembler and linker turns your assembly (text) into a program.">Assembler and Linker</h4>
          <p>The most powerful tools for the DCPU.  Target every DCPU kernel, without rewriting or reassembling code.  <a href="http://0x10co.de/?assembler=dcputoolchain">Try it on 0x10code</a>.</p>

          <h4 data-placement="right" rel="tooltip" title="A compiler lets you use a high-level language and turn it to assembly.">C Compiler</h4>
          <p>Write ANSI C code and compile it for the DCPU.  Designed specifically to target the DCPU's limited environment.</p>
        </div>
      </div>

      <hr>

      <div class="footer">
        <p style="font-size: 10px;">Website maintained by <a href="http://twitter.com/hachque">James Rhodes</a>; project developed by the <a href="https://github.com/DCPUTeam">DCPU-16 Toolchain Team</a>.  This site is in no way affiliated or supported by Mojang.  Image of CPU by <a href="http://www.flickr.com/photos/pasukaru76/3536246838/">pasukaru76 on Flickr</a> licensed under Creative Commons.  Download icons by <a href="http://www.fatcow.com">FatCow</a> licensed under Creative Commons.</p>
      </div>

    </div> <!-- /container -->

    <div id="download" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="downloadLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="downloadLabel">Select download</h3>
      </div>
      <div class="modal-body">
        <p>The toolchain ships in a variety of different formats and versions so that 
        you can get the exact tools right for you.</p>
        <h4>Stable</h4>
        <p>These builds are considered to be stable and usable.  They might still contain minor issues,
        but nothing that will get in the way of every day development</p>
        <?php display_downloads("stable"); ?>
        <h4>Experimental</h4>
        <p>The latest and greatest.. and most likely to crash.  These are builds generated every time
        we change the source code, so they could be completely broken.</p>
        <?php display_downloads("experimental"); ?>
        <?php if ($experimental_ahead != "") { ?>
        <a href="#" data-placement="bottom" rel="tooltip"
           title="This indicates how many changes there have been since stable."
           style="color: #666; font-size: 10px; line-height: 24px; margin-left: 16px;">(<?php echo $experimental_ahead; ?> revisions ahead)</a>
        <?php } ?>
        <?php if ($stable_mac == "" && $experimental_mac == "" && $portable_mac != "") { ?>
        <p><br/><a href="#download-portable" role="button" data-toggle="modal" data-dismiss="modal">Looking for a portable or Mac version?</a></p>
        <?php } else { ?>
        <p><br/><a href="#download-portable" role="button" data-toggle="modal" data-dismiss="modal">Looking for a portable version?</a></p>
        <?php } ?>
      </div>
    </div>
    <div id="download-portable" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="downloadPortableLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 id="downloadPortableLabel">Select portable download</h3>
      </div>
      <div class="modal-body">
        <p>No installers, just ZIPs.  You'll need to set environment variables so the toolchain knows
        where things are in portable mode.  Built from experimental.</p>
        <p>The following environment variables are required for things to work:</p>
        <ul>
          <li><code>TOOLCHAIN_MODULES</code> - Path to the directory containing modules.</li>
          <li><code>TOOLCHAIN_KERNELS</code> - Path to the directory containing kernels.</li>
          <li><code>TOOLCHAIN_STDLIBS</code> - Path to the directory containing standard libraries.</li>
        </ul>
        <p>When you're all set:</p>
        <?php display_downloads("portable"); ?>
        <p><br/><a href="#download" role="button" data-toggle="modal" data-dismiss="modal">Looking for installers?</a></p>
      </div>
    </div>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
      var _gaq=[['_setAccount','UA-26597916-10'],['_trackPageview']];
      (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
      g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
      s.parentNode.insertBefore(g,s)}(document,'script'));
      
      $(function(){
        $('a[rel=tooltip]').tooltip();
        $('h4[rel=tooltip]').tooltip();
      });
    </script>
  </body>
</html>
