<?php

namespace App\Services;

use App\Models\Pesanan;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\InvoiceApi;

class XenditService
{
    protected InvoiceApi $invoiceApi;

    public function __construct()
    {
        Configuration::setXenditKey(config('xendit.secret_key'));
        $this->invoiceApi = new InvoiceApi();
    }

    public function createInvoice(Pesanan $pesanan, array $customerData, array $items): array
    {
        $itemDetails = [];
        foreach ($items as $item) {
            $itemDetails[] = [
                'name' => $item['nama_produk'],
                'price' => (int) $item['harga_produk'],
                'quantity' => (int) ($item['quantity'] ?? 1),
            ];
        }

        if ($pesanan->ongkir > 0) {
            $itemDetails[] = [
                'name' => 'Ongkos Kirim',
                'price' => (int) $pesanan->ongkir,
                'quantity' => 1,
            ];
        }

        $externalId = 'BAKERY-' . $pesanan->id_pesanan . '-' . time();

        $pesanan->update(['catatan_pesanan' => trim(($pesanan->catatan_pesanan ?? '') . ' | Xendit External ID: ' . $externalId)]);

        $request = new CreateInvoiceRequest([
            'external_id' => $externalId,
            'description' => 'Pembayaran Pesanan #' . $pesanan->id_pesanan,
            'amount' => (int) $pesanan->total_bayar,
            'payer_email' => $customerData['email'] ?? '',
            'payer_phone' => $customerData['phone'] ?? '',
            'customer' => [
                'given_names' => $customerData['name'] ?? 'Pelanggan',
                'email' => $customerData['email'] ?? '',
                'mobile_number' => $customerData['phone'] ?? '',
            ],
            'customer_notification_preference' => [
                'invoice_paid' => ['email', 'whatsapp'],
            ],
            'success_redirect_url' => url('/xendit/success?external_id=' . $externalId),
            'failure_redirect_url' => url('/xendit/failed?external_id=' . $externalId),
            'currency' => 'IDR',
            'items' => $itemDetails,
        ]);

        $invoice = $this->invoiceApi->createInvoice($request);

        return [
            'invoice_url' => $invoice->getInvoiceUrl(),
            'external_id' => $invoice->getExternalId(),
            'invoice_id' => $invoice->getId(),
        ];
    }

    public function getInvoice(string $invoiceId): ?\Xendit\Invoice\Invoice
    {
        try {
            return $this->invoiceApi->getInvoices(null, $invoiceId);
        } catch (\Exception $e) {
            return null;
        }
    }
}
