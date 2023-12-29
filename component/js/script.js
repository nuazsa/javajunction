var keywordProducts = document.getElementById('keyword-products');
var keywordOrders = document.getElementById('keyword-orders');
var board = document.getElementById('board');

// tambahkan event ketika keyword products diketik
keywordProducts.addEventListener('keyup', function() {
    // buat object ajax untuk products.php
    var xhrProducts = new XMLHttpRequest();
    // cek kesiapan ajax
    xhrProducts.onreadystatechange = function(){
        if( xhrProducts.readyState == 4 && xhrProducts.status == 200 ) {
           board.innerHTML = xhrProducts.responseText;
        }
    }
    // eksekusi ajax untuk products.php
    xhrProducts.open('GET', '../../component/ajax/products.php?keyword=' + keywordProducts.value, true);
    xhrProducts.send();
});

// tambahkan event ketika keyword orders diketik
keywordOrders.addEventListener('keyup', function() {
    // buat object ajax untuk orders.php
    var xhrOrders = new XMLHttpRequest();
    // cek kesiapan ajax
    xhrOrders.onreadystatechange = function(){
        if( xhrOrders.readyState == 4 && xhrOrders.status == 200 ) {
           board.innerHTML = xhrOrders.responseText;
        }
    }
    // eksekusi ajax untuk orders.php
    xhrOrders.open('GET', '../../component/ajax/orders.php?keyword=' + keywordOrders.value, true);
    xhrOrders.send();
});
