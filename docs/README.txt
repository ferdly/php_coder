The point of this module is to show the basics of writing Drupal code for the Drush UI.

But not really. The main point of this module is to show how a very simple Drupal Module with Drush is a fantastic way to Develop PHP Code.

 Specifically, rather than teach PHP with Code that has to echoed to HTML and only displays with a Screen Refresh in a browser, you can write direct php code and use the "drush_print($string)" command to see what you are doing. You use to place little messages to yourself that includes the file, the function and the line number of your message either with sophistocated 'thrown error' mechanism, or brute force ("$status = 'Within . __FUNCTION__ . ' on line ' . __LINE__ . '[file: ' . basename(__FILE__) . ']'" thus, after composing a message to yourself in $string you can use "drush_print($string . $status)"). Further, you can combine the print_r() function with drush_print() to output sophisticated data structure as "drush_print(print_r($object, TRUE))" (NOTE: this is the most useful way that "echo() and "print_r()" are different. With "print_r()"" you can pass the option boolean as TRUE that will package the output so that it can be assigned to a variable and later output within another function).

 The structure of this module is that you will always gather the git repository where the code is in its original 'inert' state. (NOTE: each state in single quotes is a zVERSIONEDx branch that you can check-out. This way you can -- if you would like to see it grow as PHP code --  you can. Also, you can see the drush module expand as you continue. The main reason is so that the code is as simple as it can be at the outset ('Hello World!' doesn't even work yet), and as you checkout the next version, the additional code should be easier to digest.

 Also, you can (right away, or after poking around the branches) append the code that would serve the next branch as an Exercise for yourself, you can even save your work as a zVERSIONz that as its own branch and run a git diff between the 'official' and your version -- yours might be better!

 To that point. This is not a module where I am attempting to show how complex I can write the code. Indeed, I will purposely be very procedural in ways that are easier to follow -- and easier for mere mortals to write and test as they go. I am sure there are 'Mozarts' among us that use the most complex possible sintax as our first draft, however, most of us end up exploding complex calculation into a dozen procedural steps to debug where our complex calculation has gone wrong. Inded, this is a great moment for teaching encapsulation: write the dozen procedural steps for debugging, then combine them all into the single complex line when you know it works. Moreover, I am personally a believer that it might be better to leave your dozen procedural steps, but encapsulate them into a user defined function so that if it needs debugging later, or just so that mere mortals can read it; it is there. This also offers the possibility of teaching 'true' encapsulation. Take the surface area of a cylindar: when you realize that the surface area of the top & bottom are each the area of the circle, you can call that (encapsulated) function, then the surface area of the remainder is a recatangle 'wrapped around' the cylindar, then you can gather the 'base' of the rectangle by calling the circumfrence() function and then feeding that into the rectangle() function as so:
existing functions you may have already written:
circle_circumfrence ($radius) {$circumfrence = 2 * M_PI * $radius; return $circumfrence;}
circle_area ($radius) {$area = M_PI * $radius ** 2; return $area;}
rectangle_area ($base, $height) {$area = $base * $height; return $area;}

Then you could write your function for the surface area of a cylindar as so:
cylindar_surface_area ($radius, $height) {
    $surface_area = 2;
    $surface_area = $surface_area * circle_area($radius);
    $surface_area = rectangle_area (circle_circumfrence($radius), $hieght) + $surface_area;
    return $surface_area;
}

Indeed, the function above could take a few more lines if you needed to test intermediary calculations:
cylindar_surface_area ($radius, $height) {
  $top_area =  circle_area($radius);
  $bottom_area =  circle_area($radius);
  $cylindar_circumfrence = circle_circumfrence($radius);
  $wrap_around_cylindar_area = rectangle_area($cylindar_circumfrence, $hieght);
  $cylindar_surface_area = $top_area + $bottom_area + $wrap_around_cylindar_area;
  return $cylindar_surface_area;
}
(This is another great thing about encapsulation: all 'Validation' -- wich anyone that has coded knows can take a LOT of time and effort -- can be cumulative. That is, if you wrote the existing function with full validation, you only need leverage that validation in order to validate your new function.)