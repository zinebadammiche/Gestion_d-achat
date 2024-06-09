<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFicheTechniquesTable extends Migration
{
    public function up()
    {
        Schema::create('fiche_techniques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id');
            $table->string('article');
            $table->text('caracteristique_technique');
            $table->integer('quantite');
            $table->timestamps();

            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('fiche_techniques');
    }
}
