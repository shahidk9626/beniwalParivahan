<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BorderTaxEntryController extends Controller
{
    private const SERVICES = [
        'Vehicle Tax Collection (Other State)',
        'Vehicle Tax Collection (NCR)',
    ];

    public function create(Request $request)
    {
        $data = $request->validate([
            'state'   => ['required', Rule::in(config('states'))],
            'service' => ['required', Rule::in(self::SERVICES)],
        ]);

        return view('vendor.entries.create', $data + ['opt' => config('entry_options')]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'state'             => ['required', Rule::in(config('states'))],
            'service'           => ['required', Rule::in(self::SERVICES)],
            'service_type'      => ['nullable', 'string', 'max:100'],
            'vehicle_no'        => ['required', 'string', 'max:20'],
            'chassis_no'        => ['required', 'string', 'max:100'],
            'owner_name'        => ['required', 'string', 'max:150'],
            'mobile_no'         => ['required', 'digits:10'],
            'from_state'        => ['required', Rule::in(config('states'))],
            'vehicle_type'      => ['required', 'string', 'max:100'],
            'vehicle_class'     => ['required', 'string', 'max:100'],
            'seating_capacity'  => ['nullable', 'integer', 'min:0', 'max:999'],
            'sleeper_cap'       => ['nullable', 'integer', 'min:0', 'max:999'],
            'owner_type'        => ['required', Rule::in(['Individual', 'Company'])],
            'maker_status'      => ['required', Rule::in(['Indian', 'Imported'])],
            'permit_type'       => ['required', 'string', 'max:100'],
            'permit_no'         => ['required', 'string', 'max:100'],
            'permit_upto'       => ['required', 'date'],
            'issuing_authority' => ['required', 'string', 'max:150'],
            'tax_mode'          => ['required', 'string', 'max:50'],
            'barrier_name'      => ['required', 'string', 'max:150'],
            'tax_from'          => ['required', 'date'],
            'tax_upto'          => ['required', 'date', 'after_or_equal:tax_from'],
            'tax_lines'                => ['required', 'array', 'min:1'],
            'tax_lines.*.particulars'  => ['required', 'string', 'max:150'],
            'tax_lines.*.from'         => ['nullable', 'date'],
            'tax_lines.*.upto'         => ['nullable', 'date'],
            'tax_lines.*.amount'       => ['required', 'numeric', 'min:0'],
            'receipt_no'        => ['required', 'string', 'max:100'],
            'paid_on'           => ['required', 'date'],
            'notes'             => ['nullable', 'string', 'max:1000'],
        ]);

        $data['vehicle_no'] = strtoupper(preg_replace('/\s+/', '', $data['vehicle_no']));
        $data['tax_lines']  = array_values($data['tax_lines']);
        $data['amount']     = collect($data['tax_lines'])->sum('amount'); // total server khud nikalta hai

        $request->user()->borderTaxEntries()->create($data);

        return redirect()
            ->route('vendor.entries.create', ['state' => $data['state'], 'service' => $data['service']])
            ->with('success', 'Entry saved successfully.');
    }

    // "Get Details": vendor ki apni purani entries se details laata hai
    public function lookup(Request $request)
    {
        $no = strtoupper(preg_replace('/\s+/', '', (string) $request->query('vehicle_no')));

        $entry = $request->user()->borderTaxEntries()->where('vehicle_no', $no)->latest()->first();

        if (! $entry) {
            return response()->json(['found' => false]);
        }

        $data = $entry->only([
            'chassis_no', 'owner_name', 'mobile_no', 'vehicle_type', 'vehicle_class',
            'seating_capacity', 'sleeper_cap', 'owner_type', 'maker_status',
            'permit_type', 'permit_no', 'issuing_authority',
        ]);
        $data['permit_upto'] = optional($entry->permit_upto)->format('Y-m-d');

        return response()->json(['found' => true, 'data' => $data]);
    }
}