<?php
/**
 * Ajax endpoint for real-time price calculation of Printed Rubber Coaster products.
 * Called from renew-calculater.js when user changes options.
 * Returns JSON with all price components (all pre-tax).
 *
 * POST parameters:
 *   ItemType, ItemPCS, numberOf, silk_print, coating,
 *   ItemMaterial, ItemDesignVariation, paper_select, SendPrototype, DeFormat, ItemShape
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, must-revalidate');
if (function_exists('opcache_reset')) { opcache_reset(); }

// Require the DB pricing module
require_once __DIR__ . '/../../connect_db/Control_Connect_PO.php';
require_once __DIR__ . '/printedrubbercoaster_db_price.php';

try {
    if (!$conn_po || !($conn_po instanceof mysqli)) {
        throw new RuntimeException('Database connection failed');
    }

    // Check if this is a printed rubber coaster product
    $itemType = trim((string)($_POST['ItemType'] ?? ''));
    if (!function_exists('prc_is_printed_coaster_payload') || !prc_is_printed_coaster_payload($_POST)) {
        throw new RuntimeException('Invalid product type: ' . $itemType);
    }

    // Calculate price using DB pricing module (all pre-tax)
    $price = prc_calculate_price($conn_po, $_POST);

    // Extract components
    $strapPrice = (int)floor($price['components']['StrapPrice'] ?? 0);
    $moldPrice = (int)floor($price['components']['MoldPrice'] ?? 0);
    $silkPrint = (int)floor($price['components']['SilkPrint'] ?? 0);
    $coatingPrice = (int)floor($price['components']['coatingPrice'] ?? 0);
    $partPrice = (int)floor($price['components']['PartPrice'] ?? 0);
    $paperPrice = (int)floor($price['components']['PaperPrice'] ?? 0);
    $proShipping = (int)floor($price['components']['ProShipping'] ?? 0);
    $traceCharge = (int)floor($price['components']['TraceCharge'] ?? 0);
    $designsCharge = (int)floor($price['components']['DesignsCharge'] ?? 0);
    $materialCharge = (int)floor($price['components']['MaterialCharge'] ?? 0);
    $discount = (int)floor($price['components']['discount'] ?? 0);

    // All components are pre-tax; VAT is computed from subtotal
    $beforeTax = $strapPrice + $moldPrice + $silkPrint + $coatingPrice + $partPrice + $paperPrice
               + $proShipping + $traceCharge + $designsCharge + $materialCharge;
    $subtotal = max(0, $beforeTax - $discount);
    $tax = (int)floor($subtotal * 0.10);
    $grandTotal = $subtotal + $tax;

    $response = [
        'success' => true,
        'StrapPrice' => $strapPrice,
        'MoldPrice' => $moldPrice,
        'SilkPrint' => $silkPrint,
        'coatingPrice' => $coatingPrice,
        'PartPrice' => $partPrice,
        'PaperPrice' => $paperPrice,
        'ProShipping' => $proShipping,
        'TraceCharge' => $traceCharge,
        'DesignsCharge' => $designsCharge,
        'MaterialCharge' => $materialCharge,
        'discount' => $discount,
        'BeforeTax' => $subtotal,
        'Tax' => $tax,
        'grandTotal' => $grandTotal,
        'unit_price' => (int)($price['unit_price'] ?? 0),
    ];

    file_put_contents(__DIR__ . '/log.txt', print_r($_POST, true) . "\nResponse: " . json_encode($response));

    echo json_encode($response);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ]);
}
