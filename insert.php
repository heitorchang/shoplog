<?php

require("db.php");
include("header.php");

session_start();
?>

<p>
    Use portugues, singular, letras minusculas, e sem acentos
</p>

<form action="insert_add.php" method="post" autocomplete="off">
    <table>
        <tr>
            <td>Data</td>
            <td><input type="date" name="event_date" autocomplete="off" id="datepicker"></td>
        </tr>
        <tr>
            <td>Produto</td>           
            <td>
                <div class="autocomplete" style="width: 300px;">
                    <input type="text" id="nameAC" name="name" autofocus>
                </div>
            </td>
        </tr>
        <tr>
            <td>Anotacoes</td>
            <td><input type="text" name="notes" autocomplete="off"></td>
        </tr>
        <tr>
            <td>Loja</td>
            <td>
                <div class="autocomplete" style="width: 300px;">
                    <input type="text" id="storeAC" name="store">
                </div>
            </td>
        </tr>
        <tr>
            <td>Qtde</td>
            <td><input type="text" name="qty" autocomplete="off"></td>
        </tr>
        <tr>
            <td>Unidade</td>
            <td>
                <select name="unit">
                    <option value="un" selected>un</option>
                    <option value="kg">kg</option>
                    <option value="l">l</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Preco</td>
            <td><input type="text" name="price" autocomplete="off"></td>
        </tr>
    </table>
    <input type="submit">
</form>

<p>
    Ultima compra
</p>

<?php 
$stmt = $dbh->query("select * from shoplog order by purchase_id desc limit 1");

foreach ($stmt as $purchase) {
?>
    <tr>
        <td>
            <?= $purchase['event_date'] ?>
        </td>
        <td>
            <?= $purchase['name'] ?>
        </td>
        <td>
            <?= $purchase['notes'] ?>
        </td>
        <td>
            <?= $purchase['store'] ?>
        </td>
        <td style="text-align: right;">
            <?= $purchase['qty'] ?>
        </td>
        <td>
            <?= $purchase['unit'] ?>
        </td>
        <td style="text-align: right;">
            <?= $purchase['price'] ?>
        </td>
        <td style="text-align: right;">
            <?= number_format($purchase['price'] / $purchase['qty'], 2) ?>
        </td>            
    </tr>        
<?php
}
?>

<?php
$names = json_encode($dbh->query("select distinct name from shoplog")->fetchAll());
$stores = json_encode($dbh->query("select distinct store from shoplog")->fetchAll());
?>

<script>
 document.getElementById("datepicker").valueAsDate = new Date();

 var namesJSON = <?= $names ?>;
 var storesJSON = <?= $stores ?>;

 var names = [];
 var stores = [];

 for (const n of namesJSON) {
     if (n['name'] !== undefined && n['name'].trim().length > 0) {
         names.push(n['name']);
     }
 }
 
 for (const s of storesJSON) {
     if (s['store'] !== undefined && s['store'].trim().length > 0) {
         stores.push(s['store']);
     }
 }
 
 function autocomplete(inp, arr) {
     /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
     var currentFocus;
     /*execute a function when someone writes in the text field:*/
     inp.addEventListener("input", function(e) {
         var a, b, i, val = this.value;
         /*close any already open lists of autocompleted values*/
         closeAllLists();
         if (!val) { return false;}
         currentFocus = -1;
         /*create a DIV element that will contain the items (values):*/
         a = document.createElement("DIV");
         a.setAttribute("id", this.id + "autocomplete-list");
         a.setAttribute("class", "autocomplete-items");
         /*append the DIV element as a child of the autocomplete container:*/
         this.parentNode.appendChild(a);
         /*for each item in the array...*/
         for (i = 0; i < arr.length; i++) {
             /*check if the item starts with the same letters as the text field value:*/
             if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                 /*create a DIV element for each matching element:*/
                 b = document.createElement("DIV");
                 /*make the matching letters bold:*/
                 b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                 b.innerHTML += arr[i].substr(val.length);
                 /*insert a input field that will hold the current array item's value:*/
                 b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                 /*execute a function when someone clicks on the item value (DIV element):*/
                 b.addEventListener("click", function(e) {
                     /*insert the value for the autocomplete text field:*/
                     inp.value = this.getElementsByTagName("input")[0].value;
                     /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                     closeAllLists();
                 });
                 a.appendChild(b);
             }
         }
     });
     /*execute a function presses a key on the keyboard:*/
     inp.addEventListener("keydown", function(e) {
         var x = document.getElementById(this.id + "autocomplete-list");
         if (x) x = x.getElementsByTagName("div");
         if (e.keyCode == 40) {
             /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
             currentFocus++;
             /*and and make the current item more visible:*/
             addActive(x);
         } else if (e.keyCode == 38) { //up
             /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
             currentFocus--;
             /*and and make the current item more visible:*/
             addActive(x);
         } else if (e.keyCode == 13) {
             /*If the ENTER key is pressed, prevent the form from being submitted,*/
             e.preventDefault();
             if (currentFocus > -1) {
                 /*and simulate a click on the "active" item:*/
                 if (x) x[currentFocus].click();
             }
         }
     });
     function addActive(x) {
         /*a function to classify an item as "active":*/
         if (!x) return false;
         /*start by removing the "active" class on all items:*/
         removeActive(x);
         if (currentFocus >= x.length) currentFocus = 0;
         if (currentFocus < 0) currentFocus = (x.length - 1);
         /*add class "autocomplete-active":*/
         x[currentFocus].classList.add("autocomplete-active");
     }
     function removeActive(x) {
         /*a function to remove the "active" class from all autocomplete items:*/
         for (var i = 0; i < x.length; i++) {
             x[i].classList.remove("autocomplete-active");
         }
     }
     function closeAllLists(elmnt) {
         /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
         var x = document.getElementsByClassName("autocomplete-items");
         for (var i = 0; i < x.length; i++) {
             if (elmnt != x[i] && elmnt != inp) {
                 x[i].parentNode.removeChild(x[i]);
             }
         }
     }
     /*execute a function when someone clicks in the document:*/
     document.addEventListener("click", function (e) {
         closeAllLists(e.target);
     });
 }function autocomplete(inp, arr) {
     /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
     var currentFocus;
     /*execute a function when someone writes in the text field:*/
     inp.addEventListener("input", function(e) {
         var a, b, i, val = this.value;
         /*close any already open lists of autocompleted values*/
         closeAllLists();
         if (!val) { return false;}
         currentFocus = -1;
         /*create a DIV element that will contain the items (values):*/
         a = document.createElement("DIV");
         a.setAttribute("id", this.id + "autocomplete-list");
         a.setAttribute("class", "autocomplete-items");
         /*append the DIV element as a child of the autocomplete container:*/
         this.parentNode.appendChild(a);
         /*for each item in the array...*/
         for (i = 0; i < arr.length; i++) {
             /*check if the item starts with the same letters as the text field value:*/
             if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                 /*create a DIV element for each matching element:*/
                 b = document.createElement("DIV");
                 /*make the matching letters bold:*/
                 b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                 b.innerHTML += arr[i].substr(val.length);
                 /*insert a input field that will hold the current array item's value:*/
                 b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                 /*execute a function when someone clicks on the item value (DIV element):*/
                 b.addEventListener("click", function(e) {
                     /*insert the value for the autocomplete text field:*/
                     inp.value = this.getElementsByTagName("input")[0].value;
                     /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                     closeAllLists();
                 });
                 a.appendChild(b);
             }
         }
     });
     /*execute a function presses a key on the keyboard:*/
     inp.addEventListener("keydown", function(e) {
         var x = document.getElementById(this.id + "autocomplete-list");
         if (x) x = x.getElementsByTagName("div");
         if (e.keyCode == 40) {
             /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
             currentFocus++;
             /*and and make the current item more visible:*/
             addActive(x);
         } else if (e.keyCode == 38) { //up
             /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
             currentFocus--;
             /*and and make the current item more visible:*/
             addActive(x);
         } else if (e.keyCode == 13) {
             /*If the ENTER key is pressed, prevent the form from being submitted,*/
             e.preventDefault();
             if (currentFocus > -1) {
                 /*and simulate a click on the "active" item:*/
                 if (x) x[currentFocus].click();
             }
         }
     });
     function addActive(x) {
         /*a function to classify an item as "active":*/
         if (!x) return false;
         /*start by removing the "active" class on all items:*/
         removeActive(x);
         if (currentFocus >= x.length) currentFocus = 0;
         if (currentFocus < 0) currentFocus = (x.length - 1);
         /*add class "autocomplete-active":*/
         x[currentFocus].classList.add("autocomplete-active");
     }
     function removeActive(x) {
         /*a function to remove the "active" class from all autocomplete items:*/
         for (var i = 0; i < x.length; i++) {
             x[i].classList.remove("autocomplete-active");
         }
     }
     function closeAllLists(elmnt) {
         /*close all autocomplete lists in the document,
            except the one passed as an argument:*/
         var x = document.getElementsByClassName("autocomplete-items");
         for (var i = 0; i < x.length; i++) {
             if (elmnt != x[i] && elmnt != inp) {
                 x[i].parentNode.removeChild(x[i]);
             }
         }
     }
     /*execute a function when someone clicks in the document:*/
     document.addEventListener("click", function (e) {
         closeAllLists(e.target);
     });
 }

 autocomplete(document.getElementById('nameAC'), names);
 autocomplete(document.getElementById('storeAC'), stores);

 console.log(names);
</script>
