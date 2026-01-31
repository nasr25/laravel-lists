@extends('layouts.app')

@section('title', 'Data List')

@push('styles')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    tr:hover {
        background-color: #f5f5f5;
    }
    .status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .status-active {
        background-color: #d4edda;
        color: #155724;
    }
    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
    }
    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }
    .count-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 14px;
        display: inline-block;
        margin-bottom: 20px;
    }
    h2 {
        color: #333;
        margin-bottom: 10px;
    }
</style>
@endpush

@section('content')
    <h2>Sample Items</h2>
    <span class="count-badge">Total: {{ count($items) }} items</span>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>
                        @php
                            $statusClass = match(strtolower($item->status)) {
                                'active' => 'status-active',
                                'inactive' => 'status-inactive',
                                'pending' => 'status-pending',
                                default => ''
                            };
                        @endphp
                        <span class="status {{ $statusClass }}">{{ $item->status }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" style="text-align: center; color: #666;">No data found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
