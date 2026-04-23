<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Dummy data for demonstration - in real app this would come from database
        $orders = [
            [
                'id' => 'ORD-001',
                'name' => 'Siti Dewi',
                'type' => 'Pelanggan',
                'status' => 'Selesai',
                'payment' => 'Lunas',
                'total' => 150000,
                'date' => '2024-01-15',
                'products' => [
                    ['name' => 'Roti Tawar', 'quantity' => 2, 'price' => 25000],
                    ['name' => 'Croissant', 'quantity' => 3, 'price' => 15000]
                ]
            ],
            [
                'id' => 'ORD-002',
                'name' => 'Bambang Wirawan',
                'type' => 'Karyawan',
                'status' => 'Menunggu',
                'payment' => 'Belum Lunas',
                'total' => 275000,
                'date' => '2024-01-16',
                'products' => [
                    ['name' => 'Cake', 'quantity' => 1, 'price' => 75000],
                    ['name' => 'Donut', 'quantity' => 5, 'price' => 12000],
                    ['name' => 'Bread Roll', 'quantity' => 10, 'price' => 8000]
                ]
            ],
            [
                'id' => 'ORD-003',
                'name' => 'Rina Putri',
                'type' => 'Pelanggan',
                'status' => 'Diproses',
                'payment' => 'Lunas',
                'total' => 95000,
                'date' => '2024-01-17',
                'products' => [
                    ['name' => 'Croissant', 'quantity' => 4, 'price' => 15000],
                    ['name' => 'Donut', 'quantity' => 3, 'price' => 12000]
                ]
            ],
            [
                'id' => 'ORD-004',
                'name' => 'Hendra Sutrisno',
                'type' => 'Karyawan',
                'status' => 'Dikonfirmasi',
                'payment' => 'Belum Lunas',
                'total' => 320000,
                'date' => '2024-01-18',
                'products' => [
                    ['name' => 'Cake', 'quantity' => 2, 'price' => 75000],
                    ['name' => 'Roti Tawar', 'quantity' => 3, 'price' => 25000],
                    ['name' => 'Bread Roll', 'quantity' => 5, 'price' => 8000]
                ]
            ],
            [
                'id' => 'ORD-005',
                'name' => 'Ahmad Nur',
                'type' => 'Pelanggan',
                'status' => 'Selesai',
                'payment' => 'Lunas',
                'total' => 200000,
                'date' => '2024-01-19',
                'products' => [
                    ['name' => 'Roti Tawar', 'quantity' => 4, 'price' => 25000],
                    ['name' => 'Cake', 'quantity' => 1, 'price' => 75000]
                ]
            ]
        ];

        return view('orders', compact('orders'));
    }

    public function getDashboardData()
    {
        // Get orders data (in real app, this would query the database)
        $orders = $this->getOrdersData();

        // Calculate dashboard statistics
        $totalOrders = count($orders);
        $unpaidOrders = count(array_filter($orders, function($order) {
            return $order['payment'] === 'Belum Lunas';
        }));
        $totalRevenue = array_sum(array_column($orders, 'total'));

        return response()->json([
            'totalOrders' => $totalOrders,
            'unpaidOrders' => $unpaidOrders,
            'totalRevenue' => $totalRevenue,
            'lastUpdated' => now()->toISOString()
        ]);
    }

    public function getOrderDetail($orderId)
    {
        $orders = $this->getOrdersData();

        $order = array_filter($orders, function($order) use ($orderId) {
            return $order['id'] === $orderId;
        });

        if (empty($order)) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        return response()->json(array_values($order)[0]);
    }

    private function getOrdersData()
    {
        // Dummy data - in real app this would come from database
        return [
            [
                'id' => 'ORD-001',
                'name' => 'Siti Dewi',
                'type' => 'Pelanggan',
                'status' => 'Selesai',
                'payment' => 'Lunas',
                'total' => 150000,
                'date' => '2024-01-15',
                'products' => [
                    ['name' => 'Roti Tawar', 'quantity' => 2, 'price' => 25000],
                    ['name' => 'Croissant', 'quantity' => 3, 'price' => 15000]
                ]
            ],
            [
                'id' => 'ORD-002',
                'name' => 'Bambang Wirawan',
                'type' => 'Karyawan',
                'status' => 'Menunggu',
                'payment' => 'Belum Lunas',
                'total' => 275000,
                'date' => '2024-01-16',
                'products' => [
                    ['name' => 'Cake', 'quantity' => 1, 'price' => 75000],
                    ['name' => 'Donut', 'quantity' => 5, 'price' => 12000],
                    ['name' => 'Bread Roll', 'quantity' => 10, 'price' => 8000]
                ]
            ],
            [
                'id' => 'ORD-003',
                'name' => 'Rina Putri',
                'type' => 'Pelanggan',
                'status' => 'Diproses',
                'payment' => 'Lunas',
                'total' => 95000,
                'date' => '2024-01-17',
                'products' => [
                    ['name' => 'Croissant', 'quantity' => 4, 'price' => 15000],
                    ['name' => 'Donut', 'quantity' => 3, 'price' => 12000]
                ]
            ],
            [
                'id' => 'ORD-004',
                'name' => 'Hendra Sutrisno',
                'type' => 'Karyawan',
                'status' => 'Dikonfirmasi',
                'payment' => 'Belum Lunas',
                'total' => 320000,
                'date' => '2024-01-18',
                'products' => [
                    ['name' => 'Cake', 'quantity' => 2, 'price' => 75000],
                    ['name' => 'Roti Tawar', 'quantity' => 3, 'price' => 25000],
                    ['name' => 'Bread Roll', 'quantity' => 5, 'price' => 8000]
                ]
            ],
            [
                'id' => 'ORD-005',
                'name' => 'Ahmad Nur',
                'type' => 'Pelanggan',
                'status' => 'Selesai',
                'payment' => 'Lunas',
                'total' => 200000,
                'date' => '2024-01-19',
                'products' => [
                    ['name' => 'Roti Tawar', 'quantity' => 4, 'price' => 25000],
                    ['name' => 'Cake', 'quantity' => 1, 'price' => 75000]
                ]
            ]
        ];
    }
}
