<?php

namespace ExceptionExample;

require_once 'bootstrap.php';

use App\Exception\Product;
use Exception;

$productId = '1';
$productName = 'foo';

try {
    try {
        $cat = new Product($productId, $productName);
    } catch (IntegerException $e) {
        throw new Exception($e->getMessage());
    } catch (StringException $e) {
        throw new Exception($e->getMessage());
    } finally {
        echo sprintf(
            'Someone tried creating a new product with %s %s.',
            $productId,
            $productName
        );
    }
} catch(Exception $e) {
    echo sprintf(
        PHP_EOL . 'But something went wrong %s',
        $e->getMessage()
    );
}