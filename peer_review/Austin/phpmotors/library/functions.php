<?php



// This function checks for valid email addresses
function checkEmail($clientEmail){
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
   }

// This function ensures that passwords meet requirements.
// It returns a "1" if it's okay, or a "0" if it's bad.
   function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
   }

   // This function builds the Navbar and is called by all of the controllers
   function buildNavbar($classifications){
      $navList = '<ul>';
      $navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
      foreach ($classifications as $classification) {
      $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] lineup of vehicles'>$classification[classificationName]</a></li>";
      }
      $navList .= '</ul>';
      return $navList;
   }
            // Old Navlist href
         /* <a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a> */


   // Build the classifications select list
function buildClassificationList($classifications){
   $classificationList = '<select name="classificationId" id="classificationList">';
   $classificationList .= "<option>Choose a Classification</option>";
   foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
   }
   $classificationList .= '</select>';
   return $classificationList;
  }

// this function builds a display of vehicles in an unordered list
  function buildVehiclesDisplay($vehicles){
   $dv = '<ul id="inv-display">';
   foreach ($vehicles as $vehicle) {
    $dv .= '<li>';
    $dv .= '<div class="vehicleInfoDisplayImgDiv">';
    $dv .= "<img src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'>";
    $dv .= '</div>';
    $dv .= '<hr>';
    $dv .= "<h2><a href='/phpmotors/vehicles/?action=vehicleInfo&invId=" .urlencode($vehicle['invId'])."'>$vehicle[invMake] $vehicle[invModel]</a></h2>";
    $dv .= "<span class='vehiclePriceSpan'>$$vehicle[invPrice]</span>";
    $dv .= '</li>';
   }
   $dv .= '</ul>';
   return $dv;
  }

  function buildVehicleInfoDisplay($vehicleInfo) {
   $vid = '<div id="vehicleDisplayMain">';
      $vid .= '<div id="vehicleTop-LeftDiv">';
   foreach ($vehicleInfo as $zero){
      $vid .= "<h1 id='vehicleTitle'>$zero[invMake] $zero[invModel]</h1>";
         $vid .= '<div id="vehicleInfoImgDiv">';
         $vid .= "<img src='$zero[invImage]' alt='Image of $zero[invMake] $zero[invModel] on phpmotors.com'>";
         $vid .= "</div>";
         $vid .= "<br><p>Price: $$zero[invPrice]</p><br>";
      $vid .= '</div>';
         $vid .= '<div id="vehicleBottom-RightDiv">';
         $vid .= "<h2>$zero[invMake] $zero[invModel] Details</h2>";
         $vid .= "<br><p class='vehicleInfoGrayBackground'>$zero[invDescription]</p>";
         $vid .= "<h3>Color: $zero[invColor]</h3>";
         $vid .= "<h3 class='vehicleInfoGrayBackground'># in Stock: $zero[invStock]</h3>";
      $vid .= '</div>';
      $vid .= '</div>';
   }

   return $vid;
  }


  function buildReviewInfoDisplay($reviewInfo) {

     // $screenName1 = strtoupper(substr($_SESSION['clientData']['clientFirstName'],0,1)) . strtoupper(substr($_SESSION['clientData']['clientLastName'],0,1)) . substr($_SESSION['clientData']['clientLastName'],1,14);
      // we need client first and last name based off clientid HERE
     //$screenName = strtoupper(substr($clientFullName['clientFirstname'],0,1)) . strtoupper(substr($clientFullName['clientLastname'],0,1)) . substr($clientFullName['clientFirstname'],1,14));
     //$NAME = substr($clientFullName['clientFirstname'],0,1) . substr($clientFullName['clientLastname'],0,1 ) . substr($clientFullName['clientLastname'],1,14);
     $vid = '<div id="reviewDisplayMain">';
     //$clientArray = getClientNamebyId($zero['clientId']);
     //echo $clientArray['clientFirstname'];
     $screenName = "dfad";
      foreach ($reviewInfo as $zero){
      $clientFullName = getClientNamebyId($zero['clientId']);
      $NAME = substr($clientFullName['clientFirstname'],0,1) . substr($clientFullName['clientLastname'],0,1 ) . substr($clientFullName['clientLastname'],1,14);
         //make a call to a reviews-model file to get full name based off of the clientId you have in $zero ???
      $vid .= '<div class="reviewDisplayIndividual">';
      $vid .= "<p class='reviewPoster'>$NAME wrote on ";
      $vid .= date("d, F Y", (strtotime($zero['reviewDate'])));
      $vid .= ":</p>";
      $vid .= '<p class="reviewBody">' . $zero['reviewText'];
      $vid .= '</p>';
      $vid .= '</div>'; // end of review INDIVIDUAL div
   }
   $vid .= '</div>'; // end of review MAIN div
   return $vid;
  }


