<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Session\SessionManager;
use Illuminate\Support\Collection;

class WishlistService
{
    private const KEY = 'store_wishlist';

    public function __construct(
        private SessionManager $session
    ) {}

    /** @return list<int> */
    public function ids(): array
    {
        return array_values(array_unique(array_map('intval', $this->session->get(self::KEY, []))));
    }

    public function count(): int
    {
        return count($this->ids());
    }

    public function has(int $productId): bool
    {
        return in_array($productId, $this->ids(), true);
    }

    public function toggle(int $productId): bool
    {
        $ids = $this->ids();
        if (($k = array_search($productId, $ids, true)) !== false) {
            unset($ids[$k]);
            $this->session->put(self::KEY, array_values($ids));

            return false;
        }
        $ids[] = $productId;
        $this->session->put(self::KEY, $ids);

        return true;
    }

    public function remove(int $productId): void
    {
        $ids = array_values(array_filter($this->ids(), fn (int $id) => $id !== $productId));
        $this->session->put(self::KEY, $ids);
    }

    /** @return Collection<int, Product> */
    public function products(): Collection
    {
        $ids = $this->ids();
        if ($ids === []) {
            return collect();
        }

        return Product::query()
            ->with(['images', 'brand'])
            ->whereIn('id', $ids)
            ->get();
    }
}
