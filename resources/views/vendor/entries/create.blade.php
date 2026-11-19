@extends('layouts.portal')
@section('title', 'Border Tax Entry')
@section('content')

    <div class="entry-title">
        <h3>BORDER TAX ENTRY FOR <span>{{ strtoupper($state) }}</span></h3>
        <p>{{ $service }}</p>
    </div>

    @if (session('success'))
        <div class="flash">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="error">
            <strong>Please correct the following:</strong>
            <ul style="margin: 6px 0 0 18px;">
                @foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="panel">
        <div class="panel-head">Tax Entry Details</div>
        <div class="panel-body">
            <form id="entryForm" method="POST" action="{{ route('vendor.entries.store') }}">
                @csrf
                <input type="hidden" name="state" value="{{ $state }}">
                <input type="hidden" name="service" value="{{ $service }}">

                <div class="form-grid">

                    <div class="form-section">Vehicle Details</div>

                    <div class="field span-2">
                        <label for="vehicle_no">Vehicle No. *</label>
                        <div class="input-row">
                            <input type="text" id="vehicle_no" name="vehicle_no" value="{{ old('vehicle_no') }}" placeholder="e.g. RJ14XX1234" required>
                            <button type="button" class="btn" id="btnGet">Get Details</button>
                        </div>
                        <small id="getMsg" class="hint"></small>
                    </div>
                    <div class="field span-2"></div>

                    <div class="field span-2">
                        <label>Chassis No. *</label>
                        <input type="text" name="chassis_no" value="{{ old('chassis_no') }}" required>
                    </div>
                    <div class="field span-2">
                        <label>Owner Name *</label>
                        <input type="text" name="owner_name" value="{{ old('owner_name') }}" required>
                    </div>

                    <div class="field span-2">
                        <label>Mobile No. *</label>
                        <input type="text" name="mobile_no" value="{{ old('mobile_no') }}" maxlength="10" inputmode="numeric" required>
                    </div>
                    <div class="field span-2">
                        <label>From State *</label>
                        <select name="from_state" required>
                            <option value="">---Select State---</option>
                            @foreach (config('states') as $s)
                                <option value="{{ $s }}" @selected(old('from_state') === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label>Vehicle Type *</label>
                        <select name="vehicle_type" required>
                            <option value="">-- Select Vehicle Type --</option>
                            @foreach ($opt['vehicle_types'] as $o)
                                <option @selected(old('vehicle_type') === $o)>{{ $o }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Vehicle Class *</label>
                        <select name="vehicle_class" required>
                            <option value="">-- Select Vehicle Class --</option>
                            @foreach ($opt['vehicle_classes'] as $o)
                                <option @selected(old('vehicle_class') === $o)>{{ $o }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field span-2">
                        <label>Service Type</label>
                        <select name="service_type">
                            <option value="">-- Select Service Type --</option>
                            @foreach ($opt['service_types'] as $o)
                                <option @selected(old('service_type') === $o)>{{ $o }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label>Seating Capacity</label>
                        <input type="number" min="0" name="seating_capacity" value="{{ old('seating_capacity', 0) }}">
                    </div>
                    <div class="field">
                        <label>Sleeper Cap</label>
                        <input type="number" min="0" name="sleeper_cap" value="{{ old('sleeper_cap', 0) }}">
                    </div>
                    <div class="field">
                        <label>Owner Type *</label>
                        <div class="radio-row">
                            <label><input type="radio" name="owner_type" value="Individual" @checked(old('owner_type') === 'Individual') required> Individual</label>
                            <label><input type="radio" name="owner_type" value="Company" @checked(old('owner_type') === 'Company')> Company</label>
                        </div>
                    </div>
                    <div class="field">
                        <label>Maker Status *</label>
                        <div class="radio-row">
                            <label><input type="radio" name="maker_status" value="Indian" @checked(old('maker_status') === 'Indian') required> Indian</label>
                            <label><input type="radio" name="maker_status" value="Imported" @checked(old('maker_status') === 'Imported')> Imported</label>
                        </div>
                    </div>

                    <div class="form-section">Permit and Tax Period</div>

                    <div class="field">
                        <label>Permit Type *</label>
                        <select name="permit_type" required>
                            <option value="">---Select Permit Type---</option>
                            @foreach ($opt['permit_types'] as $o)
                                <option @selected(old('permit_type') === $o)>{{ $o }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Permit Upto *</label>
                        <input type="date" name="permit_upto" value="{{ old('permit_upto') }}" required>
                    </div>
                    <div class="field">
                        <label>Tax Mode *</label>
                        <select name="tax_mode" required>
                            <option value="">-- Select Tax Mode --</option>
                            @foreach ($opt['tax_modes'] as $o)
                                <option @selected(old('tax_mode') === $o)>{{ $o }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Barrier Name *</label>
                        <input type="text" name="barrier_name" value="{{ old('barrier_name') }}" required>
                    </div>

                    <div class="field">
                        <label>Permit No *</label>
                        <input type="text" name="permit_no" value="{{ old('permit_no') }}" required>
                    </div>
                    <div class="field">
                        <label>Issuing Authority *</label>
                        <input type="text" name="issuing_authority" value="{{ old('issuing_authority') }}" required>
                    </div>
                    <div class="field">
                        <label>Tax From Date *</label>
                        <input type="date" name="tax_from" value="{{ old('tax_from') }}" required>
                    </div>
                    <div class="field">
                        <label>Tax Upto Date *</label>
                        <input type="date" name="tax_upto" value="{{ old('tax_upto') }}" required>
                    </div>

                    <div class="form-section">Particulars</div>

                    <div class="span-4 table-wrap">
                        <table class="lines-table">
                            <thead>
                                <tr>
                                    <th style="width:60px">Sl. No.</th>
                                    <th>Particulars</th>
                                    <th>Tax From</th>
                                    <th>Tax Upto</th>
                                    <th>Amount</th>
                                    <th style="width:50px"></th>
                                </tr>
                            </thead>
                            <tbody id="lines"></tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-light" id="btnAddLine" style="margin-top:10px">+ Add Line</button>
                    </div>

                    <div class="field span-2">
                        <label>Tax Amount *</label>
                        <input type="text" id="tax_amount" value="0.00" readonly>
                    </div>
                    <div class="field span-2"></div>

                    <div class="form-section">Official Portal Details</div>

                    <div class="field">
                        <label>Receipt No. (from official portal) *</label>
                        <input type="text" name="receipt_no" value="{{ old('receipt_no') }}" required>
                    </div>
                    <div class="field">
                        <label>Paid On *</label>
                        <input type="date" name="paid_on" value="{{ old('paid_on', now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="field span-2">
                        <label>Notes</label>
                        <input type="text" name="notes" value="{{ old('notes') }}" maxlength="1000">
                    </div>
                </div>

                <div class="btn-row">
                    <button type="button" class="btn btn-light" id="btnCalc">Calculate Tax</button>
                    <button type="submit" class="btn btn-ok">Save Entry</button>
                    <a href="{{ route('vendor.entries.create', ['state' => $state, 'service' => $service]) }}" class="btn btn-light">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <p class="note">Note: Tax is paid only on the official government portal. Pay there first, then enter the receipt number here and save the entry.</p>

    <script>
        const tbody = document.getElementById('lines');
        const taxAmount = document.getElementById('tax_amount');
        const form = document.getElementById('entryForm');
        let idx = 0;

        function esc(v) {
            return String(v ?? '').replace(/&/g, '&amp;').replace(/"/g, '&quot;').replace(/</g, '&lt;');
        }

        function renumber() {
            tbody.querySelectorAll('tr').forEach((tr, i) => tr.querySelector('.sl').textContent = i + 1);
        }

        function calc() {
            let total = 0;
            tbody.querySelectorAll('.line-amt').forEach(i => total += parseFloat(i.value) || 0);
            taxAmount.value = total.toFixed(2);
        }

        function addLine(l = {}) {
            const i = idx++;
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td class="sl"></td>
                <td><input type="text" name="tax_lines[${i}][particulars]" value="${esc(l.particulars)}" required></td>
                <td><input type="date" name="tax_lines[${i}][from]" value="${esc(l.from)}"></td>
                <td><input type="date" name="tax_lines[${i}][upto]" value="${esc(l.upto)}"></td>
                <td><input type="number" step="0.01" min="0" class="line-amt" name="tax_lines[${i}][amount]" value="${esc(l.amount)}" required></td>
                <td><button type="button" class="btn btn-sm btn-danger rm">&times;</button></td>`;
            tbody.appendChild(tr);
            renumber();
        }

        tbody.addEventListener('input', calc);
        tbody.addEventListener('click', e => {
            if (e.target.classList.contains('rm') && tbody.children.length > 1) {
                e.target.closest('tr').remove();
                renumber();
                calc();
            }
        });
        document.getElementById('btnAddLine').addEventListener('click', () => addLine());
        document.getElementById('btnCalc').addEventListener('click', calc);

        // Pehle se bhari hui lines (validation error ke baad) ya ek khaali line
        const initial = Object.values(@json(old('tax_lines', [['particulars' => 'Border Tax']])));
        initial.forEach(l => addLine(l));
        calc();

        // Get Details: apni purani entries se bharta hai
        document.getElementById('btnGet').addEventListener('click', async () => {
            const msg = document.getElementById('getMsg');
            const no = document.getElementById('vehicle_no').value.trim();
            if (!no) { msg.textContent = 'Enter the vehicle number first.'; return; }
            msg.textContent = 'Searching...';
            try {
                const res = await fetch(`{{ route('vendor.entries.lookup') }}?vehicle_no=` + encodeURIComponent(no), {
                    headers: { 'Accept': 'application/json' }
                });
                const json = await res.json();
                if (!json.found) {
                    msg.textContent = 'No previous entry found for this vehicle. Please fill the details manually.';
                    return;
                }
                Object.entries(json.data).forEach(([k, v]) => {
                    const el = form.elements[k];
                    if (el) el.value = v ?? '';
                });
                msg.textContent = 'Details filled from your previous entry. Please check them.';
            } catch (err) {
                msg.textContent = 'Could not fetch details. Please try again.';
            }
        });
    </script>
@endsection