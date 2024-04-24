<?php
session_start();

require '../functions.php';

if (!isset($_SESSION['data'])) {
    header("Location: ../auth/login.php");
    exit();
}

$supplier = dataSupplier();
$item = dataItem();

if (isset($_POST['ADDNEWPO'])) {
    newPurchaseOrder($_POST);
    echo "<script>alert('Success! Has been created new purchase order.');window.location.href='purchaseOrder.php'</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Purchase Order Management System</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- NAVBAR -->
    <?php include 'templates/navbar.php' ?>

    <!-- SIDEBAR -->
    <?php include 'templates/sidebar.php' ?>

    <!-- CONTETNT -->
    <div class="content text-center">
        <div class="card">
            <h1>New Purchase Order</h1>
            <a href="purchaseOrder.php" class="buttonLink">Purchase Order List</a>
            <form action="" method="post">
                <label for="supplier">Supplier</label>
                <select name="supplier" id="supplier" required>
                    <?php foreach ($supplier as $s) { ?>
                        <option value=""></option>
                        <option value="<?= $s['name'] ?>"><?= $s['name'] ?></option>
                    <?php } ?>
                </select>
                <table id="itemTable">
                    <thead>
                        <tr>
                            <th>Act</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Item</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <button type="button" onclick="deleteRow(this)">Delete List</button>
                            </td>
                            <td>
                                <input type="number" name="qty[]" required autocomplete="off">
                            </td>
                            <td>
                                <input type="text" name="unit[]" required autocomplete="off">
                            </td>
                            <td>
                                <select name="item[]" required>
                                    <option value=""></option>
                                    <?php foreach ($item as $item) { ?>
                                        <option value="<?= $item['name'] ?>"><?= $item['name'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>

                            <td>
                                <input type="text" name="description[]" required>
                            </td>
                            <td>
                                <input type="number" name="price[]" required>
                            </td>
                            <td>
                                <input type="number" name="total[]" required>
                            </td>
                        </tr>
                    </tbody>
                    <tr>
                        <td colspan="6" style="text-align: right;">Sub Total</td>
                        <td>
                            <input type="number" readonly name="subTotal" id="subTotal" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right;">
                            Discount (%)
                        </td>
                        <td><input type="number" name="percentDiscount" id="percentDiscount" required></td>
                        <td>
                            <input type="number" readonly name="priceDiscount" id="priceDiscount" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: right;">
                            Tax Inclusive (%)
                        </td>
                        <td><input type="number" name="percentTaxInclusive" id="percentTaxInclusive" required></td>
                        <td>
                            <input type="number" readonly name="priceTaxInclusive" id="priceTaxInclusive" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" style="text-align: right;">Total</td>
                        <td>
                            <input type="number" readonly name="totalAll" id="totalAll" required>
                        </td>
                    </tr>
                </table>
                <button type="button" onclick="addRow()">Add List</button>
                <br>
                <label for="note">Notes</label>
                <textarea name="note" id="note" cols="30" rows="10"></textarea>
                <br><br>
                <button type="submit" class="submitBtn" name="ADDNEWPO" id="ADDNEWPO">Save</button>
            </form>
        </div>
    </div>

    <!-- SIDEBAR -->
    <script>
        // Get the sidebar and content elements
        const sidebar = document.querySelector('.sidebar');
        const content = document.querySelector('.content');
        const sidebarCollapse = document.getElementById('sidebarCollapse');

        // Toggle sidebar and content when button is clicked
        sidebarCollapse.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        });
    </script>

    <!-- LIST ITEM -->
    <script>
        function addRow() {
            var table = document.getElementById("itemTable").getElementsByTagName('tbody')[0];
            var lastRow = table.rows[table.rows.length - 1];
            var newRow = lastRow.cloneNode(true);
            table.appendChild(newRow);
            resetInputs(newRow);
            addEventListeners(newRow); // Tambahkan event listener pada elemen baru
        }

        function deleteRow(btn) {
            var table = document.getElementById('itemTable').getElementsByTagName('tbody')[0];
            var row = btn.parentNode.parentNode;
            if (table.rows.length > 1) {
                row.parentNode.removeChild(row);
            }
        }

        function resetInputs(row) {
            var inputs = row.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = '';
            }
            var selects = row.getElementsByTagName('select');
            for (var i = 0; i < selects.length; i++) {
                selects[i].selectedIndex = 0;
            }
            var textarea = row.getElementsByTagName('textarea')[0];
            textarea.value = '';
        }

        function addEventListeners(row) {
            var item = row.querySelector('select[name="item[]"]');
            var priceInput = row.querySelector('input[name="price[]"]');
            item.addEventListener('change', function() {
                var selectedItem = this.value;
                if (selectedItem !== '') {
                    getPrice(selectedItem, function(price) {
                        priceInput.value = price;
                        var textarea = item.parentNode.parentNode.querySelector('textarea');
                        getDescription(selectedItem, function(description) {
                            textarea.value = description;
                        });
                        calculateTotal(row); // Hitung total setelah mendapatkan harga
                    });
                } else {
                    priceInput.value = '';
                    var textarea = item.parentNode.parentNode.querySelector('textarea');
                    textarea.value = '';
                    calculateTotal(row); // Reset total jika item kosong
                }
            });

            var qtyInput = row.querySelector('input[name="qty[]"]');
            qtyInput.addEventListener('input', function() {
                calculateTotal(row); // Hitung ulang total saat nilai qty berubah
            });

            var priceInput = row.querySelector('input[name="price[]"]');
            priceInput.addEventListener('input', function() {
                calculateTotal(row); // Hitung ulang total saat nilai price berubah
            });
        }


        function getDescription(itemName, callback) {
            // Kirim permintaan AJAX ke server untuk mendapatkan deskripsi item berdasarkan itemName
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_description.php?itemName=' + itemName, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;
                    callback(response);
                }
            };
            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan event listener pada elemen pertama saat halaman dimuat
            addEventListeners(document.querySelector('tbody tr'));
        });

        function getPrice(itemName, callback) {
            // Kirim permintaan AJAX ke server untuk mendapatkan harga item berdasarkan itemName
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_price.php?itemName=' + itemName, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;
                    callback(response);
                }
            };
            xhr.send();
        }

        function calculateTotal(row) {
            var qty = parseFloat(row.querySelector('input[name="qty[]"]').value);
            var price = parseFloat(row.querySelector('input[name="price[]"]').value);
            var totalInput = row.querySelector('input[name="total[]"]');
            if (!isNaN(qty) && !isNaN(price)) {
                var total = qty * price;
                totalInput.value = total.toFixed(2);
            } else {
                totalInput.value = '';
            }

            // Hitung ulang subtotal
            var subtotal = 0;
            var totalInputs = document.querySelectorAll('input[name="total[]"]');
            totalInputs.forEach(function(input) {
                if (input.value !== '') {
                    subtotal += parseFloat(input.value);
                }
            });
            document.getElementById('subTotal').value = subtotal.toFixed(2);
        }

        function calculateDiscount() {
            var subTotal = parseFloat(document.getElementById('subTotal').value);
            var percentDiscount = parseFloat(document.getElementById('percentDiscount').value);
            var priceDiscountInput = document.getElementById('priceDiscount');
            if (!isNaN(subTotal) && !isNaN(percentDiscount)) {
                var priceDiscount = (percentDiscount / 100) * subTotal;
                priceDiscountInput.value = priceDiscount.toFixed(2);
            } else {
                priceDiscountInput.value = '';
            }
        }

        document.getElementById('percentDiscount').addEventListener('input', calculateDiscount);

        // Panggil calculateDiscount() saat halaman dimuat untuk mengisi priceDiscount jika percentDiscount sudah terisi
        document.addEventListener('DOMContentLoaded', function() {
            calculateDiscount();
        });

        function calculateTaxInclusive() {
            var subTotal = parseFloat(document.getElementById('subTotal').value);
            var percentTaxInclusive = parseFloat(document.getElementById('percentTaxInclusive').value);
            var priceDiscount = parseFloat(document.getElementById('priceDiscount').value);
            var priceTaxInclusiveInput = document.getElementById('priceTaxInclusive');
            if (!isNaN(subTotal) && !isNaN(percentTaxInclusive) && !isNaN(priceDiscount)) {
                var priceTaxInclusive = (subTotal - priceDiscount) * percentTaxInclusive / 100;
                priceTaxInclusiveInput.value = priceTaxInclusive.toFixed(2);
            } else {
                priceTaxInclusiveInput.value = '';
            }
        }

        document.getElementById('percentTaxInclusive').addEventListener('input', calculateTaxInclusive);

        // Panggil calculateTaxInclusive() saat halaman dimuat untuk mengisi priceTaxInclusive jika percentTaxInclusive sudah terisi
        document.addEventListener('DOMContentLoaded', function() {
            calculateTaxInclusive();
        });

        function calculateTotalAll() {
            var subTotal = parseFloat(document.getElementById('subTotal').value);
            var priceDiscount = parseFloat(document.getElementById('priceDiscount').value);
            var priceTaxInclusive = parseFloat(document.getElementById('priceTaxInclusive').value);
            var totalAllInput = document.getElementById('totalAll');
            if (!isNaN(subTotal) && !isNaN(priceDiscount) && !isNaN(priceTaxInclusive)) {
                var totalAll = subTotal - priceDiscount + priceTaxInclusive;
                totalAllInput.value = totalAll.toFixed(2);
            } else {
                totalAllInput.value = '';
            }
        }

        document.getElementById('percentTaxInclusive').addEventListener('input', function() {
            calculateTaxInclusive();
            calculateTotalAll();
        });

        document.getElementById('priceDiscount').addEventListener('input', function() {
            calculateTotalAll();
        });

        document.getElementById('subTotal').addEventListener('input', function() {
            calculateTotalAll();
        });

        document.getElementById('totalAll').addEventListener('input', function() {
            calculateTotalAll();
        });
    </script>


</body>

</html>