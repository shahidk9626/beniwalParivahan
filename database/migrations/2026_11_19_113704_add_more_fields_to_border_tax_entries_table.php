<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('border_tax_entries', function (Blueprint $table) {
        $table->string('service_type')->nullable()->after('service');
        $table->unsignedSmallInteger('seating_capacity')->nullable()->after('vehicle_class');
        $table->unsignedSmallInteger('sleeper_cap')->nullable()->after('seating_capacity');
        $table->string('owner_type', 20)->nullable()->after('sleeper_cap');   // Individual / Company
        $table->string('maker_status', 20)->nullable()->after('owner_type');  // Indian / Imported
        $table->date('permit_upto')->nullable()->after('permit_no');
        $table->string('issuing_authority')->nullable()->after('permit_upto');
        $table->string('tax_mode')->nullable()->after('issuing_authority');
        $table->string('barrier_name')->nullable()->after('tax_mode');
        $table->json('tax_lines')->nullable()->after('tax_upto'); // particulars table ki rows
    });
}

public function down(): void
{
    Schema::table('border_tax_entries', function (Blueprint $table) {
        $table->dropColumn([
            'service_type', 'seating_capacity', 'sleeper_cap', 'owner_type', 'maker_status',
            'permit_upto', 'issuing_authority', 'tax_mode', 'barrier_name', 'tax_lines',
        ]);
    });
}
};
