<?php

use App\Models\Business;
use App\Models\NotificationTemplate;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $businesses = Business::get();

        $notification_template_data = [];
        foreach ($businesses as $business) {
            $notification_templates = NotificationTemplate::defaultNotificationTemplates($business->id);
            NotificationTemplate::insert($notification_templates);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
