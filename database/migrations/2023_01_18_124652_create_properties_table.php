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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->integer('userid');
            $table->string('PropertyAddress')->nullable();
            $table->string('PropertyCity')->nullable();
            $table->string('PropertyState')->nullable();
            $table->string('PropertyZipCode')->nullable();
            $table->string('OwnerName')->nullable();
            $table->string('OwnerEmailAddress')->nullable();
            $table->string('OwnerPhoneNumber')->nullable();
            $table->string('MailingAddress')->nullable();
            $table->string('MailingCity')->nullable();
            $table->string('MailingState')->nullable();
            $table->string('MailingZipCode')->nullable();
            $table->string('DateAddedToList')->nullable();
            $table->timestamps();
        });

        /*$excelToColMapping = [
            'Property Address'      => 'PropertyAddress',
            'Property City'         => 'PropertyCity',
            'Property State'        => 'PropertyState',
            'Property Zip Code'     => 'PropertyZipCode',
            'Owner Name 1'          => 'OwnerName1',
            'Owner Name 2'          => 'OwnerName2',
            'Owner Email Address 1' => 'OwnerEmailAddress1',
            'Owner Email Address 2' => 'OwnerEmailAddress2',
            'Owner Phone Number 1'  => 'OwnerPhoneNumber1',
            'Owner Phone Number 2'  => 'OwnerPhoneNumber2',
            'Mailing Address'       => 'MailingAddress',
            'Mailing City'          => 'MailingCity',
            'Mailing State'         => 'MailingState',
            'Mailing Zip Code'      => 'MailingZipCode',
            'Date Added To List'    => 'DateAddedToList',

        ];*/
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
};
