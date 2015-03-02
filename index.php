<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
<head>
<meta http-equiv='content-type' content='text/html; charset=utf-8' />
<meta name='MSSmartTagsPreventParsing' content='TRUE' />
<?php
$base = preg_replace(':.*/:', '', dirname($_SERVER['PHP_SELF']));
echo("<title>Index of $base</title>");
?>
<style type='text/css'>
body { font-family:sans-serif; }
.grey0 { background-color:#ddd; }
.grey1 { background-color:#bbb; }
.title { background-color:#eee; }
.footer { border-top:1px solid black; background-color:#eee; font-size:small; text-align:right; }
.symlink { font-style:italic; }
h1 { text-align:center; }
table { margin:0px; border:0px; padding:2px; border-spacing:0px; border:1px dashed #000; margin-left:auto; margin-right:auto; }
td { padding:.3em; }
a { text-decoration:none; }
a:hover { text-decoration:underline; }
.s0, .s1 { text-align:right; }
<?php
// generate style for order column hilighting
// sort column and order. Assume (n)ame and (a)scending if unset.
$sort = "n";
$order = "a";
if(array_key_exists('s', $_GET))
    $sort = $_GET['s'];
if($sort != "n" && $sort != "d" && $sort != "s")
    $sort = "n";
if(array_key_exists('o', $_GET))
    $order = $_GET['o'];
if($order != "a" && $order != "d")
    $order = "a";
echo("." . $sort . "0 { background-color:#ccc; }\n");
echo("." . $sort . "1 { background-color:#aaa; }\n");
?>
</style>
</head>
<body>

<?php
echo("<h1>Index of $base</h1>");

date_default_timezone_set("Europe/Berlin");

$icon_folder = "data:image/png;base64,"
."iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABHNCSVQICAgIfAhkiAAAAAlwSFlz"
."AAAN1wAADdcBQiibeAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAHCSURB"
."VDiNpZAxa5NRFIafc+9XLCni4BC6FBycMnbrLpkcgtDVX6C70D/g4lZX/4coxLlgxFkpiiSSUGm/"
."JiXfveee45AmNlhawXc53HvPee55X+l2u/yPqt3d3Tfu/viatwt3fzIYDI5uBJhZr9fr3TMzzAx3"
."B+D09PR+v98/7HQ6z5fNOWdCCGU4HH6s67oAVDlnV1UmkwmllBUkhMD29nYHeLuEAkyn06qU8qqu"
."64MrgIyqYmZrkHa73drc3KTVahFjJITAaDRiPB4/XFlQVVMtHH5IzJo/P4EA4MyB+erWPQB7++zs"
."7ccYvlU5Z08pMW2cl88eIXLZeDUpXzsBkNQ5eP1+p0opmaoCTgzw6fjs6gLLsp58FB60t0DcK1Ul"
."54yIEIMQ43Uj68pquDmCeJVztpwzuBNE2LgBoMVpslHMCUEAFgDVxQbzVAiA+aK5uGPmmDtZF3Vp"
."oUm2ArhqQaRiUjcMf81p1G60UEVhcjZfAFTVUkrgkS+jc06mDX9nvq4YhJ9nlxZExMwMEaHJRutO"
."dWuIIsJFUoBSuTvHJ4YIfP46unV4qdlsjsBRZRtb/XfHd5+C8+P7+J8BIoxFwovfRxYhnhxjpzEA"
."AAAASUVORK5CYII=";
$icon_file = "data:image/png;base64,"
."iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABmJLR0QA/wD/AP+gvaeTAAAACXBI"
."WXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH1QQWFA84umAmQgAAANpJREFUOMutkj1uhDAQhb8HSLtb"
."ISGfgZ+zbJkix0HmFhwhUdocBnMBGvqtTIqIFSReWKK8aix73nwzHrVt+zEMwwvH9FrX9TsA1trp"
."qKy10+yUzME4jnjvAZB0LzXHkojjmDRNVyh3A+89zrlVwlKSqKrqVy/J8lAUxSZBSMny4ZLgp54i"
."yPM8UPHGNJ2IomibAKDv+9VlWZbABbgB5/0WQgSSkC4PF2JF4JzbHN430c4vhAm0TyCJruuClefp"
."h4yCBCGT3T3Isoy/KDHGfDZNcz2SZIx547/0BVRRX7n8uT/sAAAAAElFTkSuQmCC";


$files = glob("*");

// add parent folder if it's readable.
if(is_readable("../")) {
    array_push($files, "..");
}

// create list of items.
$arr = array();
foreach($files as $item)
{
    // hide ourselves.
    if($item == basename($_SERVER['PHP_SELF']))
        continue;
    if($item == "index.txt")
        continue;
    $item_size = filesize($item);
    $item_date = date("Y-m-d H:i:s O", filemtime($item));
    $item_name = $item;

    if($sort == "d")
        $index = $item_date;
    else if($sort == "s")
        $index = $item_size;
    else
        $index = $item_name;

    $item_link = readlink($item);

    $arr[$index] = array("name" => $item_name, "size" => $item_size,
                         "date" => $item_date, "link" => $item_link);
}
// sort items
if(count($arr) > 0) {
    if($order == "d") {
        krsort($arr);
        $o = 'a';
    }
    else {
        ksort($arr);
        $o = 'd';
    }
}

// display table header
echo("<table>\n");
$g = 0;
echo("<tr class='title'>");
echo("<td>Name <a href='$_SERVER[PHP_SELF]?s=n&amp;o=a'>↑</a>"
    ."<a href='$_SERVER[PHP_SELF]?s=n&amp;o=d'>↓</a></td>");
echo("<td>Size <a href='$_SERVER[PHP_SELF]?s=s&amp;o=a'>↑</a>"
    ."<a href='$_SERVER[PHP_SELF]?s=s&amp;o=d'>↓</a></td>");
echo("<td>Date <a href='$_SERVER[PHP_SELF]?s=d&amp;o=a'>↑</a>"
    ."<a href='$_SERVER[PHP_SELF]?s=d&amp;o=d'>↓</a></td>");
echo("</tr>\n");
// display items.
$totalsize = 0;
if(count($arr) > 0) {
    foreach($arr as $item) {
        $totalsize += $item["size"];
        if($item["size"] > 1024) {
            $item["size"] = (int) ($item["size"] / 1024);
            $u = "kiB";
        }
        else {
            $u = "B";
        }
        if(is_dir($item["name"])) {
            $i = $icon_folder;
            $a = "[folder]";
        }
        else {
            $i = $icon_file;
            $a = "[file]";
        }
        echo("<tr class='grey$g'>");
        echo("<td class='n$g'><img src='$i' alt='$a'/>&nbsp;<a href='$item[name]'>");
        if(!is_string($item["link"])) {
            echo("$item[name]");
        }
        else {
            echo("<span class='symlink'>$item[name] → $item[link]</span>");
        }
        echo("</a></td>");
        echo("<td class='s$g'>$item[size] $u</td>");
        echo("<td class='d$g'>$item[date]</td>");
        echo("</tr>\n");
        $g ^= 1;
    }
}
// display footer
if($totalsize > 1024) {
    if($totalsize > (1024 * 1024)) {
        $total = (int) ($totalsize / (1024 * 1024));
        $u = "MiB";
    }
    else {
        $total = (int) ($totalsize / 1024);
        $u = "kiB";
    }
}
else {
    $total = $totalsize;
    $u = "B";
}
echo("<tr class='footer'>");
echo("<td class='footer'>" . count($arr) . " files</td>");
echo("<td class='footer'>$total $u</td>");
echo("<td class='footer'></td>");
echo("</tr>\n");
echo("</table>\n");

// check for a file index.txt. If it exists, add it to the output
@readfile("index.txt");

?>
</body>
</html>
