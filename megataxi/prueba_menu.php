<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>

#navbar {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
}

#navbar li {
    list-style: none;
    float: left; 
}

#navbar li a {
    display: block;
    padding: 3px 8px;
    text-transform: uppercase;
    text-decoration: none;
    color: #999;
    font-weight: bold; }
#navbar li a:hover {
    color: #000; }

#navbar li ul {
    display: none;  }
#navbar li:hover ul, #navbar li.hover ul {
    position: absolute;
    display: inline;
    left: 0;
    width: 100%;
    margin: 0;
    padding: 0; }


#navbar li:hover li, #navbar li.hover li {
    float: left; }
#navbar li:hover li a, #navbar li.hover li a {
    color: #000; }
#navbar li li a:hover {
    color: #357; }


</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<ul id="navbar">
 <li><a href="#">Item One</a><ul>
  <li><a href="#">Subitem One</a></li>
  <li><a href="#">Second Subitem</a></li>
  <li><a href="#">Numero Tres</a></li></ul>
 </li>
 <!-- ... and so on ... -->
</ul>

</body>
</html>
