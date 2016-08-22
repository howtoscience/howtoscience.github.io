/*******************************
howtoscience.net javascript

By David Allen
*******************************/

/*

Current functions:
1. To remove the annoyance of clicking on an image for a full-size
view, only to have it drop you at a dead-end page with nothing
but the image. Instead, use jQuery to generate an overlay and
display the image on that. One click anywhere removes the
overlay and brings the user straight back to where they were.

***Figure legend text rendering currently switched off. Displays
image only.

2. Show/hide the mobile site drop-down menu
Yes, this can be done using only CSS. No, I don't care. ;)

3. Do something that *should* be doable with CSS, but for some reason isn't:
  Style the 'next' and 'prev' buttons at the bottom of the page when they are
  activated by the user so they know they've pressed them correctly.
*/


/******************************
Image overlay functionality
*******************************/

//create overlay, figure to be displayed and figure legend as virtual DOM objects
var $overlay = $("<div id=\"overlay\"></div>");
var $figure = $("<img>");
//var $legend = $("<p></p>");
var $figureContainer = $("<div id=\"figureContainer\"></div>");

//append the figure and lengend objects to the overlay
$figureContainer.append($figure);
$overlay.append($figureContainer);
//$overlay.append($legend);

//then append the overlay to the body of the page
$("body").append($overlay);

//the 'on-click' functionality...
$(".figure_link").click(function(event) {
  //stop browser following link
  event.preventDefault();

  //get the file path for the image
  var imageLocation = $(this).attr("href");

  //get the text for the legend
  //var legendText = $(this).next(".legend").text();

  //alter the <img> src attribute to contain the image file path
  $figure.attr("src", imageLocation);

  //add the text from the legend to the <p> tags
  //$legend.text(legendText);

  //render the overlay
  $overlay.show();
});//end figure link click

//hide the overlay on user click anywhere on the page
$overlay.click(function (){
  $overlay.hide();
});//end overaly click



/******************************
Mobile device drop-down menu
*******************************/
//toggle the display of the drop-down menu via clicking
//it is hidden by default using JS code in the HTML source
$("#mainNav").click(function(event){
  $("#dropDown").toggle();
}); //end #mainNav click

/******************************
Prev, Next nav elements
*******************************/

/*This silly piece of code is required because the fontawesome chars in the 'next ->' and '<- previous' nav links at
the bottom of the page would not play nicely with the ordinary latin text in the anchor tag when setting the CSS *:active properties*/

$(".pageTurn").click(function(event){
  $(this).css("background-color", "#fffffc");
  $(this).css("color", "#122256");
  $(this).css("box-shadow", "0px 0px 0px 2px #122256 inset");
  $(this).css("text-shadow", "none");
    //notice the fontawesome chars have to be set separately because they fail to properly inherit their parent parameters! Most irritating!
  $(this).children().css("background", "inherit");
  $(this).children().css("color", "inherit");
  $(this).children().css("text-shadow", "inherit");
});//end .pageTurn click
