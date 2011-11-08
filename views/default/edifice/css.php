<!-- topbar link -->

#edifice_topbar {
float:left;
margin-top:-3px;
}
#showcolor{
	width: 100px;
	border: 1px solid #CCCCCC;
    color: #666666;
    font: 120% Arial,Helvetica,sans-serif;
    padding: 5px;
    display:block;
}
.input-color{
	display:inline;
	width:auto;
}
<!-- sidebar list -->

#edifice_sidebar {
}

#edifice_sidebar ul {
list-style:none;
}

#edifice_sidebar ul li {
}

#edifice_sidebar ul li img {
vertical-align:middle;
}

<!-- manger page -->
.edifice .input-checkboxes {
	padding:0;
	margin:2px 5px 0 0;
}
.edifice label {
	font-size: 100%;
	line-height:1.2em;
}

#two_column_left_sidebar_maincontent .contentWrapper h2.edificetitle {
	padding: 0 0 3px 0;
	margin:0;
	font-size:120%;
	color:#333333;
}
#two_column_left_sidebar_maincontent .contentWrapper .edifice {
	border:1px solid #CCCCCC;
	-webkit-border-radius: 4px; 
	-moz-border-radius: 4px;
	padding:5px;
	margin:0 0 15px 0;	
}
#two_column_left_sidebar_maincontent .contentWrapper .edifice p {
	margin:0;	
}
#two_column_left_sidebar_maincontent .contentWrapper .blog_post .edifice {
	border:none;
	margin:0;
	padding:0;
}

#two_column_left_sidebar .blog_edifice {
	background:white;
	-webkit-border-radius: 8px; 
	-moz-border-radius: 8px;
padding:10px;
margin:0 10px 10px 10px;
}
#two_column_left_sidebar .blog_edifice h2 {
	background:none;
	border-top:none;
	margin:0;
	padding:0 0 5px 0;
	font-size:1.25em;
	line-height:1.2em;
	color:#0054A7;
}
#two_column_left_sidebar .blog_edifice ul {
	color:#0054A7;
	margin:5px 0 0 0;
}




.category_wrapper {
width:100%;
}

#category_bar {
border:1px solid #e8e8e8;
margin-top:4px;
}

#category_bar .left_side {
width:70%;
float:left;
text-align:left;
margin:6px;
}

#category_bar img {
float:left;
}
.categoryicon {
float:left;
}



a.category_title {
font-size:12px;
font-weight:bolder;
text-transform:lowercase;
color:white;
line-height:14px;
margin-left:10px;
display:block;
float:left;
}

#category_bar .right_side {
width:25%;
float:right;
text-align:right;
margin:5px;
}

a.edit_button {
height:10px;
width:10px;
background:transparent url(<?php echo $vars['url'] ?>mod/edifice/graphics/edifice/ui/toggle_yellow.png) no-repeat;
display:block;
float:right;
margin-right:3px;
}

a.delete_button {
height:10px;
width:10px;
background:transparent url(<?php echo $vars['url'] ?>mod/edifice/graphics/edifice/ui/toggle_red.png) no-repeat;
display:block;
float:right;
margin-right:3px;
}

a.subcategories_button {
height:10px;
width:10px;
background:transparent url(<?php echo $vars['url'] ?>mod/edifice/graphics/edifice/ui/toggle_purple.png) no-repeat;
display:block;
float:right;
margin-right:6px;
}

a.category_owner {
height:16px;
width:16px;
display:block;
float:right;
margin-right:6px;
}

a.category_container {
height:16px;
width:16px;
display:block;
float:right;
margin-right:15px;
}

a.category_owner {
height:16px;
width:16px;
display:block;
float:right;
margin-right:6px;
}

a.category_access {
height:16px;
width:32px;
display:block;
float:right;
margin-right:15px;
}

#formWrapper {
margin:10px;
}

.category_iconWrapper {
border: 1px solid #E8E8E8;
float: right;
margin: 5px 10px;
padding: 5px;
}
.category_descriptionWrapper {

}

.category_summary {
background: #F4F4F4;
border: 1px solid #E8E8E8;
padding: 5px 10px;
margin:5px 0;
}

.category_summary h2 {
font-size:1.3em;
color:white;
}

.category_summary h2 a {
color:white;
}

.categories_breadcrumbs {
border-bottom: 2px solid #E8E8E8;
font-weight: bold;
margin-bottom: 10px;
padding: 10px;
}

a.new_category_title {
color:green;
font-weight:bold;
}

#ajax_result {
padding:10px;
}

.categories_list {
}

.subcategoryWrapper {
    border: 1px solid #E8E8E8;
    float: left;
    padding: 10px;
    width: 40%;
}

.subcategory_header {
    border-bottom: 2px solid #E8E8E8;
    font-weight: bold;
    margin-bottom: 10px;
    padding-bottom: 5px;
}

.subcategory_list ul {
list-style:none;
}

.category_filed_items h2 {
    padding:5px;
    border-bottom: 2px solid #e8e8e8;
    margin-bottom:5px;
}

<!-- Categories Drop-Down Panel -->

#menuLog { font-size:1.4em; margin:20px; }
.hidden { position:absolute; top:0; left:-9999px; width:1px; height:1px; overflow:hidden; }

.fg-button { clear:left; margin:10px 0 0 0; padding: .4em 1em; text-decoration:none !important; cursor:pointer; position: relative; text-align: center; zoom: 1; }
.fg-button .ui-icon { position: absolute; top: 50%; margin-top: -8px; left: 50%; margin-left: -8px; }
a.fg-button { float:left;  }
button.fg-button { width:auto; overflow:visible; } /* removes extra button width in IE */

.fg-button-icon-left { padding-left: 2.1em; }
.fg-button-icon-right { padding-right: 2.1em; }
.fg-button-icon-left .ui-icon { right: auto; left: .2em; margin-left: 0; }
.fg-button-icon-right .ui-icon { left: auto; right: .2em; margin-left: 0; }
.fg-button-icon-solo { display:block; width:8px; text-indent: -9999px; }	 /* solo icon buttons must have block properties for the text-indent to work */

.fg-button.ui-state-loading .ui-icon { background: url(spinner_bar.gif) no-repeat 0 0; }