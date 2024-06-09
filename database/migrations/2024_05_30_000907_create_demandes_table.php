<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandesTable extends Migration
{
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Chef de division qui a créé la demande
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('sous_module_id');
            $table->unsignedBigInteger('departement_id'); // Ensure this field is placed with the other unsignedBigInteger fields
            $table->unsignedBigInteger('service_id'); // Ajout du champ service_id
            $table->text('detail');
            $table->text('justification');
            $table->string('status')->default('created');
            $table->string('validation')->default('false');
            $table->string('pdf_path')->nullable(); // Pièce jointe PDF
            $table->date('date_de_livraison_souhaite')->nullable(); // Date de livraison souhaitée
            $table->decimal('credit_estimatif', 10, 2)->nullable(); // Crédit estimatif
            $table->date('date_de_creation_demande')->default(DB::raw('CURRENT_DATE'))->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('sous_module_id')->references('id')->on('sous_modules')->onDelete('cascade');
            $table->foreign('departement_id')->references('id')->on('departements')->onDelete('cascade'); // Ensure this foreign key constraint is correct
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade'); // Ensure this foreign key constraint is correct
       
        
        });
    }

    public function down()
    {
        Schema::dropIfExists('demandes');
    }
}
