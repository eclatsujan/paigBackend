<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string("property_id",50);
            $table->string("parent_property_id",50)->nullable();
            $table->string("project_development_id",50)->nullable();;
            $table->string("strategy_type",255)->nullable();;
            $table->string("property_type",50)->nullable();;
            $table->string("title",255)->nullable();;
            $table->text("description")->nullable();;
            $table->string("land_area",50)->nullable();;
            $table->string("land_area_metric",50)->nullable();;
            $table->string("street_number",50)->nullable();;
            $table->string("unit_number",50)->nullable();;
            $table->string("street_address",255)->nullable();;
            $table->string("land_width",50)->nullable();;
            $table->string("land_width_metric",50)->nullable();;
            $table->string("land_length",50)->nullable();;
            $table->string("land_length_metric",50)->nullable();;
            $table->string("orientation",50)->nullable();;
            $table->string("land_reg_date",50)->nullable();;
            $table->string("land_price",50)->nullable();;
            $table->string("build_price",50)->nullable();;
            $table->string("build_price_unit",50)->nullable();;
            $table->string("build_price_metric",50)->nullable();;
            $table->string("completion_date",50)->nullable();;
            $table->string("developer",100)->nullable();;
            $table->text("developer_land",255)->nullable();;
            $table->string("storey_type",50)->nullable();;
            $table->string("floor_area",50)->nullable();;
            $table->string("floor_area_metric",50)->nullable();;
            $table->string("build_length",50)->nullable();;
            $table->string("build_length_metric")->nullable();;
            $table->string("build_width",50)->nullable();;
            $table->string("build_width_metric",50)->nullable();;
            $table->string("build_contract_type",50)->nullable();;
            $table->string("build_contract_upgrade",50)->nullable();;
            $table->string("min_width_land",50)->nullable();;
            $table->string("min_width_land_metric",50)->nullable();;
            $table->string("min_length_land",50)->nullable();;
            $table->string("min_length_land_metric",50)->nullable();;
            $table->string("yield_gross",50)->nullable();;
            $table->string("strata_title",255)->nullable();;
            $table->string("contract_type",50)->nullable();;
            $table->string("builder_wholesale",255)->nullable();;
            $table->string("builder_retail",50)->nullable();;
            $table->string("builder_aggregator",50)->nullable();;
            $table->string("investor_name",50)->nullable();;
            $table->string("acquisition_type",50)->nullable();;
            $table->string("street_type",50)->nullable();;
            $table->string("suburb",50)->nullable();;
            $table->string("postcode",50)->nullable();;
            $table->string("state",50)->nullable();;
            $table->string("region",50)->nullable();;
            $table->string("country",50)->nullable();;
            $table->string("bedroom",50)->nullable();;
            $table->string("bathroom",50)->nullable();;
            $table->string("garage",50)->nullable();;
            $table->string("price",50)->nullable();;
            $table->double("to_price",50)->nullable();;
            $table->string("display_price",50)->nullable();;
            $table->string("display_price_text",50)->nullable();;
            $table->string("date_listed",50)->nullable();;
            $table->string("tax_rate",50)->nullable();;
            $table->string("water_rate",50)->nullable();;
            $table->string("condo_strata_fee",50)->nullable();
            $table->string("condo_strata_fee_period",50)->nullable();
            $table->string("deposit",50)->nullable();
            $table->string("estimate_rental_return",50)->nullable();
            $table->string("estimate_rental_return_period",50)->nullable();
            $table->string("per_month_rent",50)->nullable();
            $table->string("per_week_rent",50)->nullable();
            $table->string("price_period",50)->nullable();
            $table->string("build_contract_pricing",50)->nullable();
            $table->string("status",50)->nullable();
            $table->string("paig_status",50)->nullable();
            $table->string("other_status",50)->nullable();
            $table->string("hide_listing",50)->nullable();
            $table->string("promote_listing",50)->nullable();
            $table->string("business_name",255)->nullable();
            $table->text("address",255)->nullable();
            $table->string("contact",50)->nullable();
            $table->string("url",255)->nullable();
            $table->double("from_price",25)->nullable();
            $table->string("location",255)->nullable();
            $table->text("attachments",255)->nullable();
            $table->string("display_id",50)->nullable();
            $table->string("b2b_partner",50)->nullable();
            $table->string("team_member",50)->nullable();

            // $table->
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('properties');
    }
}
