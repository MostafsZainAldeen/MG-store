<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Session\SessionManager;

class CartService
{
    private const SESSION_KEY = 'store_cart';

    public function __construct(
        private SessionManager $session
    ) {}

    /** @return array<int, int> product_id => quantity */
    public function items(): array
    {
        return $this->session->get(self::SESSION_KEY.'.items', []);
    }

    public function count(): int
    {
        return (int) array_sum($this->items());
    }

    public function add(int $productId, int $quantity = 1): void
    {
        $items = $this->items();
        $items[$productId] = ($items[$productId] ?? 0) + $quantity;
        $this->session->put(self::SESSION_KEY.'.items', $items);
    }

    public function update(int $productId, int $quantity): void
    {
        $items = $this->items();
        if ($quantity <= 0) {
            unset($items[$productId]);
        } else {
            $items[$productId] = $quantity;
        }
        $this->session->put(self::SESSION_KEY.'.items', $items);
    }

    public function remove(int $productId): void
    {
        $items = $this->items();
        unset($items[$productId]);
        $this->session->put(self::SESSION_KEY.'.items', $items);
    }

    public function clear(): void
    {
        $this->session->forget(self::SESSION_KEY);
    }

    public function couponCode(): ?string
    {
        return $this->session->get(self::SESSION_KEY.'.coupon');
    }

    public function setCoupon(?string $code): void
    {
        if ($code === null || $code === '') {
            $this->session->forget(self::SESSION_KEY.'.coupon');

            return;
        }
        $this->session->put(self::SESSION_KEY.'.coupon', strtoupper(trim($code)));
    }

    public function resolveCoupon(): ?Coupon
    {
        $code = $this->couponCode();
        if (! $code) {
            return null;
        }
        $coupon = Coupon::query()->where('code', $code)->first();
        if (! $coupon || ! $coupon->isValid()) {
            return null;
        }

        return $coupon;
    }

    /** @return array{subtotal: float, lines: list<array{product: \App\Models\Product, quantity: int, line_total: float}>} */
    public function linesWithProducts(): array
    {
        $items = $this->items();
        if ($items === []) {
            return ['subtotal' => 0.0, 'lines' => []];
        }
        $products = Product::query()
            ->with(['images', 'brand'])
            ->whereIn('id', array_keys($items))
            ->get()
            ->keyBy('id');

        $lines = [];
        $subtotal = 0.0;
        foreach ($items as $productId => $qty) {
            $product = $products->get($productId);
            if (! $product) {
                continue;
            }
            $qty = (int) $qty;
            $lineTotal = round($product->currentPrice() * $qty, 2);
            $subtotal += $lineTotal;
            $lines[] = [
                'product' => $product,
                'quantity' => $qty,
                'line_total' => $lineTotal,
            ];
        }

        return ['subtotal' => round($subtotal, 2), 'lines' => $lines];
    }

    public function totals(): array
    {
        $bundle = $this->linesWithProducts();
        $subtotal = $bundle['subtotal'];
        $discount = 0.0;
        $coupon = $this->resolveCoupon();
        if ($coupon) {
            $discount = round($coupon->discountForAmount($subtotal), 2);
        }
        $total = max(0, round($subtotal - $discount, 2));

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total,
            'coupon' => $coupon,
            'lines' => $bundle['lines'],
        ];
    }
}
