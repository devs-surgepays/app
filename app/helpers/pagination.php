<?php

function paginateRead($reload, $page, $tpages, $adjacents, $ArrayCampos, $example_length, $camposAscDesc,$billTo=1)
{
    $ArrayCampos = json_encode($ArrayCampos);
    $camposAscDesc = json_encode($camposAscDesc);

    $prevlabel = "&lsaquo;";
    $nextlabel = "&rsaquo;";
    $out = '<ul class="pagination pg-primary">';

    // previous label
    if ($page == 1) {
        $out .= "<li class='page-item disabled'><a class='page-link'>$prevlabel</a></li>";
    } else if ($page == 2) {
        $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='readData(1," . $ArrayCampos . "," . $example_length . "," . $camposAscDesc . ",".$billTo.")'>$prevlabel</a></li>";
    } else {
        $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='readData(" . ($page - 1) . ",$ArrayCampos,$example_length,$camposAscDesc,$billTo)'>$prevlabel</a></li>";
    }

    // first label
    if ($page > ($adjacents + 1)) {
        $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='readData(1," . $ArrayCampos . "," . $example_length . "," . $camposAscDesc . ",".$billTo.")'>1</a></li>";
    }
    // interval
    if ($page > ($adjacents + 2)) {
        $out .= "<li class='page-item'><a class='page-link'>...</a></li>";
    }
    // pages
    $pmin = ($page > $adjacents) ? ($page - $adjacents) : 1;
    $pmax = ($page < ($tpages - $adjacents)) ? ($page + $adjacents) : $tpages;

    for ($i = $pmin; $i <= $pmax; $i++) {
        if ($i == $page) {
            $out .= "<li class='page-item active'><a class='page-link'>$i</a></li>";
        } else if ($i == 1) {
            $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='readData(1," . $ArrayCampos . "," . $example_length . "," . $camposAscDesc . ",".$billTo.")'>$i</a></li>";
        } else {
            $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='readData(" . $i . ",$ArrayCampos,$example_length,$camposAscDesc,$billTo)'>$i</a></li>";
        }
    }
    // interval
    if ($page < ($tpages - $adjacents - 1)) {
        $out .= "<li class='page-item'><a class='page-link'>...</a></li>";
    }

    // last
    if ($page < ($tpages - $adjacents)) {
        $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='readData($tpages," . $ArrayCampos . "," . $example_length . "," . $camposAscDesc . ",".$billTo.")'>$tpages</a></li>";
    }
    // next
    if ($page < $tpages) {
        $out .= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='readData(" . ($page + 1) . ",$ArrayCampos,$example_length,$camposAscDesc,$billTo)'>$nextlabel</a></li>";
    } else {
        $out .= "<li class='page-item disabled'><a class='page-link'>$nextlabel</a></li>";
    }
    $out .= "</ul>";
    return $out;
}


?>