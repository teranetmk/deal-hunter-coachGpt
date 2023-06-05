<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lists_tags_assocs', function (Blueprint $table) {
            $table->id();
            $table->integer('list_id');
            $table->integer('tag_id');
            $table->timestamps();
        });

       /* // get all properties with tag Vacant
        $sql = "select * from properties p
    left join lists_properties_assocs lpa on p.id = lpa.property_id
    left join lists_tags_assocs lta on lpa.list_id = lta.list_id
    left join motivation_tags mt on lta.tag_id=mt.id
         where p.userid=1 and mt.tag_name='Vacant'";

        // list all properties with all tags for a list*/

    }
    /*
     * find
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lists_tags_assocs');
    }
};
