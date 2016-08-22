<?php
  //Generates the HTML that surrounds the content on each page. Keeps all the common code in one place for easier maintainance


  /*generateMenu() generates the menu structure used on the page.
  Takes arguments for what page is selected (used by main.css for styling) and which menu type is to be generated.
  $type = 0 for desktop version. $type = 1 for mobile*/
  function generateMenu($selected, $type) {
    $selected .= '.php';
    $menuHTML = '';
    //array of menu options associated with urls to those pages
    $menuEntries = [
      'index.php' => 'Home',
      'getStart.php' => 'Getting Started',
      'intro.php' => 'Introduction',
      'aims.php' => 'Aims',
      'results.php' => 'Results',
      'discussion.php' => 'Discussion',
      'conclusion.php' => 'Conclusions',
      'refs.php' => 'Referencing'
    ];

    /*If $type == 0, produce the desktop version, else, produce the mobile version of the menu struct.
    The difference is the mobile version has (for historical reasons) class="selected" in the <li> rather than <a> tags*/
    if($type == 0) {
      //begin the HTML as a string
      $menuHTML = '<ul id="menuActual">';
      //loop through the array looking for the url that matches $selected and apply 'class="selected"' addition to the relevant tag
      foreach($menuEntries as $url => $label) {
        $classHTML = ($selected == $url) ? 'class="selected"' : '';
        //add the current array elements to the growing string of HTML
        $menuHTML .= '<li><a href="/'.$url.'" '.$classHTML.'>'.$label.'</a></li>';
      }
    } else {
      $menuHTML = '<ul id="dropDown">';
      foreach($menuEntries as $url => $label) {
        $classHTML = ($selected == $url) ? 'class="selected"' : '';
        $menuHTML .= '<li '.$classHTML.'><a href="/'.$url.'">'.$label.'</a></li>';
      }
    }
    //close the tag and return the HTML string
    $menuHTML .= '</ul>';
    return $menuHTML;
  }


/*generateHeader returns the main HTML head code required by each page along with the menu HTML produced by generateMenu()*/
function generateHeader($selected) {
  $header = '<head>
      <meta charset="utf-8">
      <meta name="author" content="David L. Allen">
      <meta name="description" content="How to write scientific papers and reports">
      <meta name="keywords" content="science, writing, journal, paper, report, article, how">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>How to Science: Writing Papers</title>
      <link rel="stylesheet" type="text/css" href="/css/main.css">
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Vollkorn:400,400italic,700">
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Ubuntu:400,700">
      <script type="text/javascript" src="https://use.fontawesome.com/0523816ffe.js"></script>
      <link rel="icon" type="image/ico" href="/img/favicon.ico">
    </head>
    <body>
      <header>
        <ul id="masthead">
          <li><noscript><p id="jsDisabled">Hey, JavaScript is disabled. That\'s cool, it\'s not really required, but the site is easier to navigate with it turned on.</p></noscript></li>
          <li><a href="index.php"><h1 class="main-heading">www.howtoscience.net</h1></a></li>
          <li><a href="index.php"><h2>A de-mystifying guide to the scientific writing process</h2></a></li>
        </ul>
        <nav id="menu">
          <ul id="menuDrop">
            <li id="mainNav"><a href="#"><i class="fa fa-bars" aria-hidden="true"></i> Navigation</a>'.
              generateMenu($selected, 1).
            '</li>
            <li id="home"><a href="/"><i class="fa fa-home" aria-hidden="false"></i><noscript>&#9750;</noscript></a></li>
          </ul>'.
            generateMenu($selected, 0).
        '</nav>
      </header>
      <script type="text/javascript">document.getElementById("dropDown").style.display = "none";</script>';
  return $header;
}

//generates and returns HTML string for the pageTurn nav section
function generatePageTurn($selected) {
  //start of the string HTML nav construct
  $html = '<nav id="pageTurnNav"><ul>';
  $nextText = 'Next ';
  $nextClass = '';
  $selected .= '.php';

  //associated arrays for storing which page points where
  $next = [
    'index.php' => 'getStart.php',
    'getStart.php' => 'intro.php',
    'intro.php' => 'aims.php',
    'aims.php' => 'results.php',
    'results.php' => 'discussion.php',
    'discussion.php' => 'conclusion.php',
    'conclusion.php' => 'refs.php',
    'refs.php' => NULL
  ];

  $previous = [
    'index.php' => NULL,
    'getStart.php' => 'index.php',
    'intro.php' => 'getStart.php',
    'aims.php' => 'intro.php',
    'results.php' => 'aims.php',
    'discussion.php' => 'results.php',
    'conclusion.php' => 'discussion.php',
    'refs.php' => 'conclusion.php'
  ];

  //special case. Only the index page has a different label for the 'next' link
  if($selected == 'index.php') {
    $nextText = 'Get Started! ';
    $nextClass = 'class="next"';
  }

  //generate the HTML for the 'previous' link
  foreach($previous as $current => $linkTo) {
    if($selected == $current && $linkTo != NULL) {
      $html .= '<li><a href="'.$linkTo.'" class="pageTurn"><i class="fa fa-arrow-left" aria-hidden="true"></i><noscript>&#9664;</noscript> Previous</a></li>';
      break;
    }
  }
  //generate the HTML for the 'next' link
  foreach($next as $current => $linkTo) {
    if($selected == $current && $linkTo != NULL) {
      $html .= '<li '.$nextClass.'><a href="'.$linkTo.'" class="pageTurn">'.$nextText.'<i class="fa fa-arrow-right" aria-hidden="true"></i><noscript>&#9654;</noscript></a></li>';
      break;
    }
  }
  //complete the string and return it
  $html .= '</ul></nav>';
  return $html;
}

/*Generates the footer code of the page. The javascript functionality halts loading of non-critical
JS resources until the page has been rendered. It creates two new <script> elements and points them to the
resources, then listens to make sure the page has loaded before appending them, speeding load time by
removing unecessary HTTP requests from the render pipeline*/
function generateFooter($selected) {
  return generatePageTurn($selected).'<footer>
    <p>&copy; 2016 D. Allen</p>
  </footer>
  <script type="text/javascript">
    function loadScriptPostRender() {
      var element = document.createElement("script");
      element.src = "http://code.jquery.com/jquery-1.11.0.min.js";
      element.type = "text/javascript";
      element.async = false;
      document.body.appendChild(element);
      element = document.createElement("script");
      element.src = "/js/howtoscience.js";
      element.type = "text/javascript";
      element.async = false;
      document.body.appendChild(element);
    }
    if (window.addEventListener)
      window.addEventListener("load", loadScriptPostRender, false);
    else if (window.attachEvent)
      window.attachEvent("onload", loadScriptPostRender);
    else window.onload = loadScriptPostRender;
  </script>';
}
?>
