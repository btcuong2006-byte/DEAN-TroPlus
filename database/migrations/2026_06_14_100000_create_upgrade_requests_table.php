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
        Schema::create('upgrade_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Thông tin cá nhân (tuân thủ quy định pháp luật Việt Nam - Nghị định 72/2013/NĐ-CP và Luật An ninh mạng)
            $table->string('full_name');
            $table->string('identity_number'); // Số CCCD/CMND
            $table->date('identity_date'); // Ngày cấp
            $table->string('identity_place'); // Nơi cấp
            $table->string('phone');
            $table->string('business_license')->nullable(); // Mã số đăng ký hộ kinh doanh/DN (nếu có)
            
            // Thông tin phòng cho thuê đầu tiên để duyệt tin đăng kèm theo
            $table->string('property_name');
            $table->decimal('property_price', 15, 2);
            $table->integer('property_acreage');
            $table->string('property_city');
            $table->string('property_address');
            $table->text('property_description')->nullable();
            $table->string('property_photo')->nullable(); // Giấy phép hoặc ảnh phòng
            
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upgrade_requests');
    }
};
