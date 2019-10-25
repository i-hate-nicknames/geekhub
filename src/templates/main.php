<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #333;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
<h1>Welcome to this store</h1>
<table>
    <tr><th>Category name</th><th>Product id</th><th>Product name</th><th>Price</th><th>Quantity</th></tr>
    <?php foreach ($data['productsGrouped'] as $categoryName => $products): ?>
    <tr><td rowspan="<?= count($products)+1?>"><?= $categoryName ?></td></tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product->getId() ?></td>
            <td><?= $product->getName() ?></td>
            <td><?= $product->getPrice() ?></td>
            <td><?= $product->getQty() ?></td>
        </tr>
    <?php endforeach; ?>
    <?php endforeach; ?>
</table>



</body>
</html>