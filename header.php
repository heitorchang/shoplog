<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">
        <title>My Title</title>
        <style>
         * { box-sizing: border-box; }
         body {
             font: 16px Arial;
         }
         .autocomplete {
             /*the container must be positioned relative:*/
             position: relative;
             display: inline-block;
         }
         input, select {
             border: 1px solid transparent;
             background-color: #f1f1f1;
             padding: 10px;
             font-size: 16px;
         }
         input[type=text] {
             background-color: #f1f1f1;
             width: 100%;
         }
         input[type=submit] {
             background-color: DodgerBlue;
             color: #fff;
         }
         .autocomplete-items {
             position: absolute;
             border: 1px solid #d4d4d4;
             border-bottom: none;
             border-top: none;
             z-index: 99;
             /*position the autocomplete items to be the same width as the container:*/
             top: 100%;
             left: 0;
             right: 0;
         }
         .autocomplete-items div {
             padding: 10px;
             cursor: pointer;
             background-color: #fff;
             border-bottom: 1px solid #d4d4d4;
         }
         .autocomplete-items div:hover {
             /*when hovering an item:*/
             background-color: #e9e9e9;
         }
         .autocomplete-active {
             /*when navigating through the items using the arrow keys:*/
             background-color: DodgerBlue !important;
             color: #ffffff;
         }
         table td {
             padding: 0.5em 0.4em;
         }
         body {
             margin: 2em;
         }
         a {
             font-size: 1.4em;
         }
        </style>
    </head>
    <body>
        <a href="index.php">New</a>
        | <a href="select.php">Select</a>
