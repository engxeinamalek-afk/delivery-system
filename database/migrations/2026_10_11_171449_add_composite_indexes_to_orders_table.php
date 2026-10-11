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
        Schema::table('orders', function (Blueprint $table) {

            //  اكتر الاستعلامات التي سيتم استخدامها خلال اليوم:
            // الاسناد التلقائي للسائق عند الطلب يستخدم فلترة الطلبات حسب الdriver_id , assigned_at
            // جلب السائق للطلبات المسندة له فلترة حسب driver_id, assigned_at, status
            // ايضا استعلام جلب الادمن لطلبات سائق معين فلترة حسب: driver_id , assignad_at
            $table->index(['driver_id', 'assigned_at', 'status'], 'orders_driver_assigned_status_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
