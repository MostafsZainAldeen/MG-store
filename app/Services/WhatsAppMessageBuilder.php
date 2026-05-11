<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;

class WhatsAppMessageBuilder
{
    public function storeNumber(): string
    {
        $raw = (string) Setting::get('whatsapp_number', env('WHATSAPP_NUMBER', '966500000000'));

        return preg_replace('/\D+/', '', $raw) ?: '966500000000';
    }

    public function urlFromText(string $message): string
    {
        $phone = $this->storeNumber();

        return 'https://wa.me/'.$phone.'?text='.rawurlencode($message);
    }

    /** @param list<array{name: string, quantity: int, line_total: float}> $lines */
    public function cartMessage(?string $customerName, array $lines, float $total, ?string $currency, ?string $address = null, ?string $notes = null): string
    {
        $currency = $currency ?? (string) Setting::get('currency_code', 'ILS');
        $locale = app()->getLocale();
        $linesText = collect($lines)->map(function (array $line) use ($locale, $currency) {
            return ($locale === 'ar' ? '• ' : '- ').$line['name'].' × '.$line['quantity'].' — '.$line['line_total'].' '.$currency;
        })->implode("\n");

        $parts = [];
        $parts[] = $locale === 'ar' ? 'طلب من المتجر' : 'Order from MG Store';
        if ($customerName) {
            $parts[] = ($locale === 'ar' ? 'الاسم: ' : 'Name: ').$customerName;
        }
        $parts[] = ($locale === 'ar' ? 'المنتجات:' : 'Items:')."\n".$linesText;
        $parts[] = ($locale === 'ar' ? 'الإجمالي: ' : 'Total: ').$total.' '.$currency;
        if ($address) {
            $parts[] = ($locale === 'ar' ? 'العنوان: ' : 'Address: ').$address;
        }
        if ($notes) {
            $parts[] = ($locale === 'ar' ? 'ملاحظات: ' : 'Notes: ').$notes;
        }

        return implode("\n\n", array_filter($parts));
    }

    public function orderMessage(Order $order): string
    {
        $locale = app()->getLocale();
        $currency = $order->currency;
        $lines = $order->items->map(function ($item) use ($currency, $locale) {
            $name = $locale === 'ar' ? $item->name_ar : $item->name_en;

            return ($locale === 'ar' ? '• ' : '- ').$name.' × '.$item->quantity.' — '.$item->line_total.' '.$currency;
        })->implode("\n");

        $parts = [];
        $parts[] = $locale === 'ar' ? 'طلب جديد' : 'New order';
        $parts[] = ($locale === 'ar' ? 'رقم الطلب: ' : 'Order #: ').$order->order_number;
        $parts[] = ($locale === 'ar' ? 'الاسم: ' : 'Name: ').$order->full_name;
        $parts[] = ($locale === 'ar' ? 'الهاتف: ' : 'Phone: ').$order->phone;
        $parts[] = ($locale === 'ar' ? 'المدينة: ' : 'City: ').$order->city;
        $parts[] = ($locale === 'ar' ? 'العنوان: ' : 'Address: ').$order->address;
        $parts[] = ($locale === 'ar' ? 'المنتجات:' : 'Items:')."\n".$lines;
        $parts[] = ($locale === 'ar' ? 'الإجمالي: ' : 'Total: ').$order->total.' '.$currency;
        if ($order->notes) {
            $parts[] = ($locale === 'ar' ? 'ملاحظات: ' : 'Notes: ').$order->notes;
        }
        if ($order->delivery_details) {
            $parts[] = ($locale === 'ar' ? 'تفاصيل التوصيل: ' : 'Delivery: ').$order->delivery_details;
        }

        return implode("\n\n", array_filter($parts));
    }
}
