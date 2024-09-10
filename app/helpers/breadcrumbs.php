<?php

function breadcrumbs($page = 'HOME')
{
    // This gets the REQUEST_URI (/path/to/file.php), splits the string (using '/') into an array, and then filters out any empty values
    $query = str_replace('url=', '/', $_SERVER['QUERY_STRING']);
    $cleaned_url = preg_replace('/&tab=.*$/', '', $query);
    $path = array_filter(explode('/', parse_url($cleaned_url, PHP_URL_PATH)));

    $home = '<i class="icon-home"></i>';

    // This will build our "base URL" ... Also accounts for HTTPS :)
    $base = URLROOT . '/'; //($_SERVER['HTTPS'] ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';

    // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
    $breadcrumbs = array("<a href=\"$base\">$home</a>");

    // Initialize crumbs to track path for proper link
    $crumbs = '';

    // Find out the index for the last value in our path array
     $last = (count($path)>1) ? end(array_keys($path)) : (array_keys($path));

    // Build the rest of the breadcrumbs
    foreach ($path as $x => $crumb) {
        // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
        $title = ucwords(str_replace(array('.php', '_', '%20'), array('', ' ', ' '), $crumb));

        // If we are not on the last index, then display an <a> tag
        if ($x != $last) {
            $breadcrumbs[] = "<a href=\"$base$crumbs$crumb\">$title</a>";
            $crumbs .= $crumb . '/';
        }
        // Otherwise, just display the title (minus)
        else {
            $breadcrumbs[] = $title;
        }
    }
    // Without format - Build our temporary array (pieces of bread) into one big string :)
    // return implode(' / ', $breadcrumbs)

    // With format Boostrap
    $htmlBreadCrumbs = '<div class="page-header">
              <h3 class="fw-bold mb-3">' . $page . '</h3>
              <ul class="breadcrumbs mb-3">';
    for ($i = 0; $i < count($breadcrumbs); $i++) {
        if ($i != 0) $htmlBreadCrumbs .= '<li class="separator"><i class="icon-arrow-right"></i></li>';
        $htmlBreadCrumbs .= '<li>' . $breadcrumbs[$i] . '</li>';
    }
    $htmlBreadCrumbs .= '</ul>
            </div>';

    return $htmlBreadCrumbs;
}
