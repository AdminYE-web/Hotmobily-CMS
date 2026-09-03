<?php

/**
 * DB-based price calculation module for Printed Rubber Coaster (印刷ラバーコースター) products.
 * Pattern mirrors rubbercoaster_db_price.php but adapted for printed coaster-specific logic.
 *
 * Differences from rubbercoaster:
 * - Product name: 印刷ラバーコースター
 * - Has MoldPrice/special_shape_fee (¥9,350 for オリジナル shape)
 * - Has ItemShape (丸型/四角/オリジナル), ItemPrint, ItemColor fields
 * - Uses price_printed_rubber_coaster_standard/rush tiers
 * - Silk print = fixed 33/unit (not tier-based)
 * - All prices returned pre-tax (no VAT multiplication)
 */

if (!function_exists('prc_num_norm')) {
    function prc_num_norm($value): float
    {
        if ($value === null || $value === '') {
            return 0.0;
        }
        return (float)str_replace(',', '', (string)$value);
    }
}

if (!function_exists('prc_is_checked_value')) {
    function prc_is_checked_value($value): bool
    {
        $value = trim((string)$value);
        return $value !== '' && !in_array($value, ['なし', '不要', '0', 'false', 'off'], true);
    }
}

if (!function_exists('prc_contains_any')) {
    function prc_contains_any(string $haystack, array $needles): bool
    {
        foreach ($needles as $needle) {
            if ($needle !== '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('prc_normalize_request')) {
    function prc_normalize_request(array $input): array
    {
        $qty = (int)prc_num_norm($input['numberOf'] ?? $input['qty'] ?? 0);
        if ($qty <= 0) {
            $qty = 1;
        }

        $itemType = trim((string)($input['ItemType'] ?? '印刷ラバーコースター'));
        $itemPcs = trim((string)($input['ItemPCS'] ?? 'スタンダード'));

        // Printed rubber coaster only has standard and speed
        $productCode = 'printedrubbercoaster_standard';
        if (prc_contains_any($itemPcs, ['スピード'])) {
            $productCode = 'printedrubbercoaster_speed';
        }

        return [
            'item_type' => $itemType,
            'item_pcs' => $itemPcs,
            'product_code' => $productCode,
            'qty' => $qty,
            'silk_print' => trim((string)($input['silk_print'] ?? '印刷なし')),
            'coating' => trim((string)($input['coating'] ?? '汚れ防止加工なし')),
            'item_material' => trim((string)($input['ItemMaterial'] ?? '特殊素材なし')),
            'design_variation' => trim((string)($input['ItemDesignVariation'] ?? '1種類')),
            'paper' => (function($inp) {
                $ps = trim((string)($inp['paper_select'] ?? ''));
                $pp = trim((string)($inp['paper'] ?? ''));
                if ($ps === 'なし' || $ps === '不要') return 'なし';
                if ($ps !== '') return $ps;
                if ($pp !== '') return $pp;
                return 'なし';
            })($input),
            'prototype' => $input['SendPrototype'] ?? 'なし',
            'trace' => $input['DeFormat'] ?? 'なし',
            'item_shape' => trim((string)($input['ItemShape'] ?? '')),
            'item_print' => trim((string)($input['ItemPrint'] ?? '')),
            'item_color' => trim((string)($input['ItemColor'] ?? '')),
        ];
    }
}

if (!function_exists('prc_pick_tier_price')) {
    function prc_pick_tier_price(array $tiers, int $qty): int
    {
        if ($qty <= 0 || empty($tiers)) {
            return 0;
        }

        usort($tiers, function ($a, $b) {
            return ((int)($a['rate'] ?? $a['num'] ?? 0)) <=> ((int)($b['rate'] ?? $b['num'] ?? 0));
        });

        $picked = null;
        foreach ($tiers as $tier) {
            $rate = (int)($tier['rate'] ?? $tier['num'] ?? 0);
            if ($rate <= $qty) {
                $picked = $tier;
            }
        }
        if ($picked === null) {
            $picked = $tiers[0];
        }

        return (int)floor(prc_num_norm($picked['unit_price'] ?? $picked['price'] ?? 0));
    }
}

if (!function_exists('prc_static_unit_price')) {
    function prc_static_unit_price(string $productCode, int $qty): int
    {
        $tiers = [
            'printedrubbercoaster_standard' => [
                ['rate' => 1, 'unit_price' => 410],
                ['rate' => 10, 'unit_price' => 315],
                ['rate' => 30, 'unit_price' => 300],
                ['rate' => 50, 'unit_price' => 289],
                ['rate' => 100, 'unit_price' => 277],
                ['rate' => 300, 'unit_price' => 233],
                ['rate' => 500, 'unit_price' => 219],
                ['rate' => 1000, 'unit_price' => 197],
            ],
            'printedrubbercoaster_speed' => [
                ['rate' => 1, 'unit_price' => 457],
                ['rate' => 10, 'unit_price' => 350],
                ['rate' => 30, 'unit_price' => 334],
                ['rate' => 50, 'unit_price' => 320],
                ['rate' => 100, 'unit_price' => 308],
                ['rate' => 300, 'unit_price' => 235],
            ],
        ];

        return prc_pick_tier_price($tiers[$productCode] ?? [], $qty);
    }
}

if (!function_exists('prc_fetch_product_id_by_code')) {
    function prc_fetch_product_id_by_code(mysqli $db, string $code): ?int
    {
        $stmt = $db->prepare("SELECT id FROM product_master WHERE code = ? LIMIT 1");
        if (!$stmt) {
            throw new RuntimeException('Prepare product lookup failed: ' . $db->error);
        }
        $stmt->bind_param("s", $code);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $row ? (int)$row['id'] : null;
    }
}

if (!function_exists('prc_fetch_tiers')) {
    function prc_fetch_tiers(mysqli $db, int $itemType, $itemId, string $unitText = 'yen'): array
    {
        $stmt = $db->prepare("
            SELECT rate, unit_price, tax
              FROM item_price_master
             WHERE item_type = ?
               AND item_id = ?
               AND unit_text = ?
             ORDER BY rate ASC
        ");
        if (!$stmt) {
            throw new RuntimeException('Prepare price lookup failed: ' . $db->error);
        }
        $itemId = (int)$itemId;
        $stmt->bind_param("iis", $itemType, $itemId, $unitText);
        $stmt->execute();
        $result = $stmt->get_result();
        $tiers = [];
        while ($row = $result->fetch_assoc()) {
            $tiers[] = $row;
        }
        $stmt->close();

        return $tiers;
    }
}

if (!function_exists('prc_find_part_id')) {
    function prc_find_part_id(mysqli $db, string $partName): ?int
    {
        $partName = trim($partName);
        if ($partName === '' || $partName === 'なし' || $partName === '不要') {
            return null;
        }
        $stmt = $db->prepare("SELECT id FROM part_master WHERE name = ? OR code = ? LIMIT 1");
        if (!$stmt) {
            throw new RuntimeException('Prepare part lookup failed: ' . $db->error);
        }
        $stmt->bind_param("ss", $partName, $partName);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $row ? (int)$row['id'] : null;
    }
}

if (!function_exists('prc_find_service_id')) {
    function prc_find_service_id(mysqli $db, array $needles): ?int
    {
        foreach ($needles as $needle) {
            $like = '%' . $needle . '%';
            $stmt = $db->prepare("SELECT id FROM additional_service WHERE code = ? OR name LIKE ? LIMIT 1");
            if (!$stmt) {
                throw new RuntimeException('Prepare service lookup failed: ' . $db->error);
            }
            $stmt->bind_param("ss", $needle, $like);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            if ($row) {
                return (int)$row['id'];
            }
        }

        return null;
    }
}

if (!function_exists('prc_service_total')) {
    function prc_service_total(mysqli $db, array $needles, int $qty, int $multiplier = 1): int
    {
        $serviceId = prc_find_service_id($db, $needles);
        if (!$serviceId) {
            return 0;
        }
        $unit = prc_pick_tier_price(prc_fetch_tiers($db, 4, $serviceId), $qty);
        return $unit * max(1, $multiplier);
    }
}

if (!function_exists('prc_design_variation_count')) {
    function prc_design_variation_count(string $value): int
    {
        if (preg_match('/(\d+)/u', $value, $matches)) {
            return max(1, (int)$matches[1]);
        }
        return 1;
    }
}

if (!function_exists('prc_calculate_price')) {
    /**
     * Calculate all price components for Printed Rubber Coaster.
     * All returned values are PRE-TAX (no VAT included).
     */
    function prc_calculate_price(mysqli $db, array $input): array
    {
        $normalized = prc_normalize_request($input);
        $qty = $normalized['qty'];

        $productId = prc_fetch_product_id_by_code($db, $normalized['product_code']);
        $jpUnit = 0;
        $cnUnit = 0;
        if ($productId) {
            $jpUnit = prc_pick_tier_price(prc_fetch_tiers($db, 1, $productId, 'yen'), $qty);
            $cnUnit = prc_pick_tier_price(prc_fetch_tiers($db, 1, $productId, 'usd'), $qty);
        }
        if ($jpUnit <= 0) {
            $jpUnit = prc_static_unit_price($normalized['product_code'], $qty);
        }
        if ($jpUnit <= 0) {
            throw new RuntimeException('printed rubber coaster unit price was not found.');
        }

        // StrapPrice = unit * qty (pre-tax)
        $strapPrice = $jpUnit * $qty;

        // MoldPrice / special_shape_fee (for オリジナル shape only)
        $moldPrice = 0;
        if ($normalized['item_shape'] === 'オリジナル') {
            $moldPrice = 8500; // Fixed ¥8,500 pre-tax
        }

        // Silk/back print — printed coaster uses fixed 33/unit
        $silkPrint = 0;
        if (mb_strpos($normalized['silk_print'], 'あり') !== false) {
            $silkPrint = 33 * $qty; // pre-tax
        }

        // Coating — 70/unit pre-tax
        $coatingPrice = 0;
        if (mb_strpos($normalized['coating'], 'あり') !== false) {
            $coatingPrice = 70 * $qty; // pre-tax
        }

        // Special material — 30/unit pre-tax
        $materialCharge = 0;
        if (mb_strpos($normalized['item_material'], 'あり') !== false) {
            $materialCharge = 30 * $qty; // pre-tax
        }

        // Design variation — flat fee pre-tax
        $designCount = prc_design_variation_count($normalized['design_variation']);
        $designsCharge = 0;
        if ($designCount >= 2) $designsCharge = 3000;
        if ($designCount >= 3) $designsCharge = 6000;
        if ($designCount >= 4) $designsCharge = 9000;

        // Printed coaster has no part/attachment
        $partPrice = 0;

        // Paper price
        $paperPrice = 0;
        $paperUnit = 0;
        $paperUnitCn = 0;
        $paperVal = trim($normalized['paper'] ?? '');
        if ($paperVal !== '' && $paperVal !== 'なし' && $paperVal !== '不要' && $paperVal !== '??') {
            $serviceId = 6;
            if (mb_strpos($paperVal, 'A-1') !== false) {
                $serviceId = 7;
            } elseif (mb_strpos($paperVal, 'A-2') !== false) {
                $serviceId = 8;
            }
            $paperUnit = prc_pick_tier_price(prc_fetch_tiers($db, 4, $serviceId, 'yen'), $qty);
            $paperUnitCn = prc_pick_tier_price(prc_fetch_tiers($db, 4, $serviceId, 'usd'), $qty);
            $paperPrice = $paperUnit * $qty;
        }

        // Prototype — flat 8000 pre-tax
        $proShipping = prc_is_checked_value($normalized['prototype']) ? 8000 : 0;

        // Trace — flat 8000 pre-tax
        $traceCharge = prc_is_checked_value($normalized['trace']) ? 8000 : 0;

        // Calculate totals
        $discount = 0;
        $beforeTax = $strapPrice + $moldPrice + $silkPrint + $coatingPrice + $partPrice + $paperPrice
                   + $proShipping + $traceCharge + $designsCharge + $materialCharge;
        $subtotal = max(0, $beforeTax - $discount);
        $tax = (int)floor($subtotal * 0.10);
        $grandTotal = $subtotal + $tax;

        return [
            'normalized' => $normalized,
            'unit_price' => $jpUnit,
            'unit_price_cn' => $cnUnit,
            'components' => [
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
            ],
            'paper_unit_price' => $paperUnit,
            'paper_unit_price_cn' => $paperUnitCn,
            'BeforeTax' => $subtotal,
            'Tax' => $tax,
            'grandTotal' => $grandTotal,
        ];
    }
}

if (!function_exists('prc_apply_price_to_post')) {
    function prc_apply_price_to_post(array $post, array $price): array
    {
        $post['unit_price'] = (string)(int)$price['unit_price'];
        foreach ($price['components'] as $key => $value) {
            $post[$key] = (string)(int)$value;
        }
        $post['BeforeTax'] = (string)(int)$price['BeforeTax'];
        $post['Tax'] = (string)(int)$price['Tax'];
        $post['grandTotal'] = (string)(int)$price['grandTotal'];
        $post['prc_db_priced'] = '1';
        $post['prc_unit_price_cn'] = (string)(int)$price['unit_price_cn'];
        $post['prc_paper_unit_price'] = (string)(int)$price['paper_unit_price'];
        $post['prc_paper_unit_price_cn'] = (string)(int)$price['paper_unit_price_cn'];

        return $post;
    }
}

if (!function_exists('prc_is_printed_coaster_payload')) {
    function prc_is_printed_coaster_payload(array $payload): bool
    {
        $itemType = (string)($payload['ItemType'] ?? $payload['product_name'] ?? '');
        return prc_contains_any($itemType, [
            '印刷ラバーコースター',
            'printedrubbercoaster',
            'printed rubber coaster',
        ]);
    }
}
